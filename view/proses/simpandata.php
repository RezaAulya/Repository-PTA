<?php
if (!isset($_SESSION)) {
	session_start();
}

if (isset($_SESSION['iduserkaryawan']))
{
	$iduser=$_SESSION['iduserkaryawan'];
	$akses=$_SESSION['iduserkaryawan'];
} 
else 
{
	$iduser='';
	$akses='';
}

include ("../config/conn.php");

function generateRandomString($length = 10) {
    return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
}
if (isset($_GET["kode"]))
{
	$kode=$_GET["kode"];	
}
else
{
	$kode=$_POST["kode"];	
}

if ($kode=='masterclass')
{	
	//if (isset($_GET['idcustomer'])) {$id=$_GET['idcustomer'];} else {$id='';}
	$id_master_unit=$_GET['id_master_unit'];
	$class=$_GET['class'];
	$id=$_GET['id'];
	if ($id=='')
	{
		$sql="insert into master_class(id_master_unit,class) values ('".$id_master_unit."','".$class."')";
	}
	else
	{
		$sql="update master_class set class='".$class."', id_master_unit='".$id_master_unit."'  where id_master_class='".$id."'";
	}
	//echo $sql;
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}
	
}
elseif ($kode=='masterangkatan')
{	
	//if (isset($_GET['idcustomer'])) {$id=$_GET['idcustomer'];} else {$id='';}
	$id_master_unit=$_GET['id_master_unit'];
	$angkatan=$_GET['angkatan'];
	$id=$_GET['id'];
	if ($id=='')
	{
		$sql="insert into master_angkatan(id_master_unit,angkatan) values ('".$id_master_unit."','".$angkatan."')";
	}
	else
	{
		$sql="update master_angkatan set angkatan='".$angkatan."', id_master_unit='".$id_master_unit."'  where id_angkatan='".$id."'";
	}
	//echo $sql;
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}
	
}

elseif ($kode=='masterunit')  //digunakan untuk simpan dan update prodi
{	

	$unit=$_GET['unit'];
	$kaprodi=$_GET['kaprodi'];
	$wakaprodi=$_GET['wakaprodi'];
	$id=$_GET['id'];
	if ($id=='')
	{
		$sql="insert into master_unit(unit) values ('".$unit."')";
	}
	else
	{
		$sql="update master_unit set unit='".$unit."' where id_master_unit='".$id."'";
	}
	//echo $sql;
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}
	
}


elseif ($kode=='masteruser') //digunakan untuk simpan user dan update data user
{	

	$idusernya=$_GET['iduser'];
	$username=$_GET['username'];
	$passedit=$_GET['password'];
	$namadepan=$_GET['namadepan'];
	$idlevel=$_GET['idlevel'];
	$angkatan=$_GET['angkatan'];
	$idstatus=$_GET['statusid'];
	$prodi=$_GET['prodi'];

	if ($idusernya=='')
	{
		$sql="insert into master_user(u_username,u_password,u_first_name,angkatan,user_level,prodi,u_sys_created_by,u_sys_created_date,active) 
			  values ('".$username."',SHA1('".$passedit."'),'".$namadepan."','".$angkatan."','".$idlevel."','".$prodi."','".$iduser."',NOW(),'".$idstatus."')";
	}
	else
	{
		$sql="update master_user set u_username='".$username."',u_first_name='".$namadepan."', angkatan='".$angkatan."', user_level='".$idlevel."',prodi='".$prodi."',u_password=SHA1('".$passedit."'),u_sys_modified_by='".$iduser."',u_sys_modified_date=NOW(),active='".$idstatus."' where u_id='".$idusernya."'";
	}
	//echo $sql;
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}	
}
elseif ($kode=='mastertahunajaran')
{	
	//if (isset($_GET['idcustomer'])) {$id=$_GET['idcustomer'];} else {$id='';}
	$nama_tahun_ajaran=$_GET['nama_tahun_ajaran'];
	$id=$_GET['id'];
	$aktif=$_GET['active'];
	if ($aktif=='1')
	{
		$sqlcekv="select count(*) as jml from master_tahun_ajaran where active='1'";
		$stmtcekv = $koneksi->prepare($sqlcekv);
		$stmtcekv->execute();
		$hasilcekv=$stmtcekv->fetch();
		$jml=$hasilcekv['jml'];			
		if ($jml>0)
		{
			$sqlrbh="update master_tahun_ajaran set active='0'";	
			$stmtrbh = $koneksi->prepare($sqlrbh);
			$stmtrbh->execute(); 			
		}			
	}
	if ($id=='')
	{
		$sql="insert into master_tahun_ajaran(nama_tahun_ajaran,active) values ('".$nama_tahun_ajaran."','".$aktif."')";
	}
	else
	{
		$sql="update master_tahun_ajaran set active='".$aktif."',nama_tahun_ajaran='".$nama_tahun_ajaran."'  where id_tahun_ajaran='".$id."'";
	}
	echo $sql;
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}
	
}
elseif ($kode=='judultugas')
{	

	$id=$_POST['id'];
	$nama=$_POST['nama'];
	$nim=$_POST['nim'];
	$prodi = $_POST['prodi'];
	$angkatan = $_POST['angkatan'];
	$user= $_POST['user'];
	$judul = $_POST['judul'];

	$uploaddir='../../upload/';

	if ($_FILES['filenya']['size'] != 0)
	{
		$fileSize = $_FILES['filenya']['size'];
		$fileType = $_FILES['filenya']['type'];
		$filename = $_FILES['filenya']['name'];
		$xextension=explode(".", $filename);
		$extension=end($xextension);
		$filenamesjobdesk='FINAL_PROJECT_'.strtoupper(str_replace("","",$nim)).'.'.$extension;
		$uploadakta=move_uploaded_file($_FILES['filenya']['tmp_name'], ''.$uploaddir.''.$filenamesjobdesk);			
	}
	else
	{
		$filenamesjobdesk='';
	}

	if ($id=='')
	{
		$sql="insert into master_upload_data(id_nama,nim,id_unit,id_angkatan,judul_tugas,id_user,data) values ('".$nama."','".$nim."','".$prodi."','".$angkatan."','".$judul."','".$user."','".$filenamesjobdesk."')";
	}
	//echo $sql;
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';		
	}
}


elseif ($kode=='simpansiswa')
{	

	$id=$_GET['id'];
	$nama=$_GET['nama'];
	$nim=$_GET['nim'];
	$prodi=$_GET['prodi'];
	$kelas=$_GET['kelas'];
	$angkatan=$_GET['angkatan'];
	$keterangan= $_GET['keterangan'];

	if ($id=='')
	{
		$sql="insert into master_mahasiswa(nim,nama_mahasiswa,id_unit,id_class,id_angkatan,keterangan) values ('".$nim."','".$nama."','".$prodi."','".$kelas."','".$angkatan."','".$keterangan."')";
	}
	else
	{
		$sql="update master_mahasiswa set nim='".$nim."',nama_mahasiswa='".$nama."',id_unit='".$prodi."', id_class='".$kelas."', id_angkatan='".$angkatan."', keterangan='".$keterangan."' where id_mahasiswa='".$id."'";
	}
	echo $sql;
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';		
	}
	
}
?>