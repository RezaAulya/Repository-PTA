<?php 
if (!isset($_SESSION)) {
	session_start();
}
include ("../config/conn.php");
if (isset($_SESSION['iduserkaryawan']))
{
$iduser=$_SESSION['iduserkaryawan'];
} 
else 
{$iduser='';}
if(isset($_SESSION['iduserkaryawan']) )
{
	$stmt = $koneksi->prepare("update data_karyawan set online_status=0 where id_karyawan='".$iduser."'");
    $stmt->execute();	
	unset($_SESSION['iduserkaryawan']);
	unset($_SESSION['namakaryawan']);
	unset($_SESSION['nmlevelkaryawan']);
	unset($_SESSION['levelkaryawan']);
	unset($_SESSION['namajabatankaryawan']);
	unset($_SESSION['atasankaryawan']);
	session_destroy(); 
    session_unset(); 
	
	if (isset($_GET['msg']))
	{
		$msg="expired";
	}
	else
	{
		$msg="logout";
	}
	

	header('Location:../../index.php?msg=' . urlencode(base64_encode($msg)));

}

?>