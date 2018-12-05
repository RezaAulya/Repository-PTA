<?php
error_reporting(0);
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION['iduserkaryawan']))
{
	$iduser=$_SESSION['iduserkaryawan'];
	$nama=$_SESSION['namakaryawan'];
	$email=$_SESSION['emailkaryawan'];
	$yuyu=$_SESSION['yuyu21'];
	
} else {$iduser='';}

if (isset($_GET['menuid'])) {$menuid=$_GET['menuid'];}
?>

	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<!--<img src="../assets/images/" alt="" style="padding:4px;margin:0	 0 0 10px" width="100%">-->
			<h4 style="padding:4px;margin:10px 0 0 10px" width="100%">e-Repository Politeknik Aceh</h4>
			<ul class="nav navbar-nav visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
				<li><a class="sidebar-mobile-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
	                                        <?php
						if ($akses=='admin')
						{ ?>	
			<ul class="nav navbar-nav" style="margin-left: -10px;margin-top: 5px;">
				<li><a class="sidebar-control sidebar-main-toggle hidden-xs"><i class="icon-paragraph-justify3"></i></a></li>
			</ul>
                        <?php } ?>

			<ul class="nav navbar-nav navbar-right" style="margin-top: 10px;">
						
			<?php 
				if ($akses=='member')
					{ ?>
						<li><a href="?menuid=dash"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
						<li><a href="?menuid="><i class="icon-home4"></i> <span>Dashboard</span></a></li>
			<?php if ($otoatasan=='1'){?>
					<li><a href="?menuid=21"><i class="icon icon-vcard"></i> <span>Requests Verification</span></a></li>		
			<?php } ?>
				
				
			
				<?php }else {} ?>
				<li class="dropdown dropdown-user">
					<a class="dropdown-toggle" data-toggle="dropdown">
					
						<span><?php echo $nama; ?></span>
						<i class="caret"></i>
					</a>

					<ul class="dropdown-menu dropdown-menu-right">
						<?php 
						if ($akses=='member')
						{ ?>
						<li><a href="?menuid=72&id=<?php echo $iduser; ?>" ><i class="icon-user-plus"></i> My Profile</a></li>
						<li><a href="?menuid=77&id=<?php echo $iduser; ?>" ><i class="icon-user-plus"></i> My Job Profile</a></li>
						<?php }else { ?>
						<!--<li><a href="?menuid=72&useridnya=<?php echo $iduser; ?>" ><i class="icon-user-plus"></i> My Profile</a></li>-->
						<?php } ?>
						<li class="divider"></li>
						<li><a href="?menuid=153&id=<?php echo $yuyu; ?>"><i class="icon-cog5"></i> Change Password</a></li>
						<li><a href="./login/logout.php"><i class="icon-switch2"></i> Logout</a></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
	<!-- /main navbar -->

