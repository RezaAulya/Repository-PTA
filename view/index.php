<?php
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION['iduserkaryawan']))
{
 include ('mainhead.php');
 include ('mainavbar.php');
 include ('sidebar.php');
 include ('footer.php');
}
else
{
	echo "<script language='javascript'>window.location.href='../';</script>";
}
 
 
?>