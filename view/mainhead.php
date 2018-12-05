<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Repository</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="../assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="../assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
	<link rel="icon" href="../assets/images/tabaki.png" type="image/gif" sizes="16x16"> 
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	
	<script type="text/javascript" src="../assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="../assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="../assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/loaders/blockui.min.js"></script>
	<script type="text/javascript" src="../assets/js/plugins/extensions/session_timeout.min.js"></script>
	
<?php
if (!isset($_SESSION)) {
	session_start();
}
include ("config/conn.php");


if(isset($_SESSION['iduserkaryawan']) )
$iduser=$_SESSION['iduserkaryawan'];
{
	$lvl=$_SESSION['levelkaryawan'];
	if (isset($_GET['menuid']))
	{
		if ($_GET['menuid']=='dash')
		{
			require ('dashboard/pagejs.php');
		}
		else
		{
			$sqlmain="SELECT  menu_uri,menu_nama,folder,main_menu FROM `master_menu` 
					  WHERE menu_id = '". $_GET['menuid'] ."'";
			//echo $sqlmain;		  
			$stmtmain = $koneksi->prepare($sqlmain);
			$stmtmain->execute(); 
			$result = $stmtmain->fetch();
			$mainmenu=$result["main_menu"];	
			if ($mainmenu=='0')
			{
				$menu=$result["menu_uri"];	
				//$namamainmenu=$result["nama_menu"];	
				$namamenu=$result["menu_nama"];			
				$namafolder=$result["folder"];	
				require (''.$namafolder.'/pagejs.php');
			}
			else
			{
				$sql3="SELECT  a.nama_menu,b.menu_uri,b.menu_nama,b.folder FROM `master_main_menu` a,`master_menu` b 
					   WHERE a.main_id=b.main_menu and b.menu_id = '". $_GET['menuid'] ."'";
				$stmt3 = $koneksi->prepare($sql3);
				$stmt3->execute(); 		
				$result = $stmt3->fetch();
				$total=$stmt3 -> rowCount();
				$menu=$result["menu_uri"];	
				$namamainmenu=$result["nama_menu"];	
				$namamenu=$result["menu_nama"];			
				$namafolder=$result["folder"];	
				require (''.$namafolder.'/pagejs.php');
			}
		}		
	}	
	else
	{
		require ('dashboard/pagejs.php');
	}
}
?>	
	</head>
	<script type="text/javascript">
/*$(function() {

    // Session timeout
    $.sessionTimeout({
        heading: 'h5',
        title: 'Session Timeout',
        message: 'Your session is about to expire. Do you want to stay connected?',
        ignoreUserActivity: true,
		warnAfter: 600000, //10 minutes
		redirAfter: 900000, //15 minutes	
        //warnAfter: 10000,
        //redirAfter: 30000,		
        keepAliveUrl: '/',
        redirUrl: 'login/logout.php?msg=expired',
        logoutUrl: 'login/logout.php?msg=expired'
    });
    
});*/
</script>

<body>