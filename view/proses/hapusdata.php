<?php
if (!isset($_SESSION)) {
	session_start();
}
$iduser=$_SESSION['iduserlibrary'];
include ("../config/conn.php");

$kode=$_GET["kode"];


if ($kode=='hapusmasterclass')
{	
	$id=$_GET['id'];
	$sql="delete from master_class where id_master_class='".$id."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}	
}


//hapus user
if ($kode=='hapusmasteruser')
{	
	$idusernya=$_GET['iduser'];
	$sql="DELETE FROM master_user WHERE master_user.u_id ='".$idusernya."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}	
}
if ($kode=='hapusta')
{	
	$id=$_GET['id'];
	
	$sql="DELETE FROM master_upload_data WHERE master_upload_data.id_upload ='".$id."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}	
}

//hapus jurusan
if ($kode=='hapusmasterunit')
{	
	$id=$_GET['id'];
	$sql="delete from master_unit where id_master_unit='".$id."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}	
}

//hapus tahun ajaran
if ($kode=='hapusmastertahunajaran')
{	
	$id=$_GET['id'];
	$sql="delete from master_tahun_ajaran where id_tahun_ajaran='".$id."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}	
}

//hapusangkatan
if ($kode=='hapusangkatan')
{	
	$id=$_GET['id'];
	$sql="delete from master_angkatan where id_angkatan='".$id."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}	
}
if ($kode=='hapussiswa')
{	
	$id=$_GET['id'];
	$sql="delete from master_mahasiswa where id_mahasiswa='".$id."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute(); 
	if ($stmt)
	{
		echo '{"success":true}';			
	}	
}

?>