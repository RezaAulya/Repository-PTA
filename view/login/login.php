<?php
if (!isset($_SESSION)) {
	session_start();
}
include ("../config/conn.php");

if ((!empty($_GET['username'])) && ((!empty($_GET['password'])))) 
{
	$username=$_GET['username'];
	$password=$_GET['password'];
	$stmt = $koneksi->prepare("select count(*) as jml from master_user where u_username='".$username."' and u_password=SHA1('".$password."') and active='1'"); 
	$stmt->execute(); 
	$result = $stmt->fetch();
	$jml=$result["jml"];
	if ($jml <= 0 )
	{
		$stmt = $koneksi->prepare("select count(*) as jml from data_karyawan where username='".$username."' and password=SHA1('".$password."') and active='1'"); 		
		$stmt->execute(); 
		$result = $stmt->fetch();
		$jml=$result["jml"];		
		if ($jml <= 0 )
		{	
			echo '{"success":false}';				  
		}
		else
		{
			$sql ="select *,'Member' as level_nama,IFNULL((select atasan from master_jabatan where  master_jabatan.id_jabatan=a.recent_jabatan),0) as atasan from data_karyawan a 
			where username='".$username."' and password=SHA1('".$password."') and active='1'"; 
			
			foreach ($koneksi->query($sql) as $row)
			{
$tes=time();
				$stmtlst = $koneksi->prepare("update data_karyawan set online_status=1,last_login=NOW(),time='".$tes."'  where id_karyawan='".$row['id_karyawan']."'"); 
				$stmtlst->execute(); 			
				
				$_SESSION['iduserkaryawan']=$row['id_karyawan'];
				$_SESSION['namakaryawan']=$row['nama'];
				$_SESSION['nmlevelkaryawan']=$row['level_nama'];
				$_SESSION['emailkaryawan']=$row['email'];
				$_SESSION['levelkaryawan']='3';
				$_SESSION['akseskaryawan']='member';
				$_SESSION['atasankaryawan']=$row['atasan'];
				$_SESSION['login_time'] = time();
			}				
			echo '{"success":true}';			
		}
	}
	else
	{
		$sql ="select *,(select b.level_nama from master_level b where a.user_level=b.level_id) as level_nama from master_user a 
		where u_username='".$username."' and u_password=SHA1('".$password."') and active='1'"; 
		
		foreach ($koneksi->query($sql) as $row)
		{
			$stmtlst = $koneksi->prepare("update master_user set u_sys_lastlogin_date=NOW() where u_id='".$row['u_id']."'"); 
			$stmtlst->execute(); 			
			
			$iduser=$row['u_id'];
			$nama=$row['u_username'];
			$namalevel=$row['level_nama'];
			$angkatan1=$row['angkatan'];
			$yuyu=$row['u_first_name'];
			$jurusan = $row['prodi'];
			
			$_SESSION['iduserkaryawan']=$row['u_id'];
			$_SESSION['yuyu21']=$row['u_first_name'];
			$_SESSION['namakaryawan']=$row['u_username'];
			$_SESSION['nmlevelkaryawan']=$row['level_nama'];
			$_SESSION['levelkaryawan']=$row['user_level'];
			$_SESSION['jurusankaryawan']=$row['prodi'];
			$_SESSION['angkatankaryawan']=$row['angkatan'];
			$_SESSION['akseskaryawan']='admin';
			$_SESSION['atasankaryawan']='0';
			$_SESSION['login_time'] = time();
		}				
		echo '{"success":true}';
	}
} 


?>	