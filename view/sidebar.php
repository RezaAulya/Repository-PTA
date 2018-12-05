<?php
if (!isset($_SESSION)) {
	session_start();
}
	if (isset($_SESSION['iduserkaryawan']))
{
	$iduser=$_SESSION['iduserkaryawan'];
	$dia=$_SESSION['namakaryawan'];
	$angkatan1=$_SESSION['angkatankaryawan'];
	$yuyu=$_SESSION['yuyu21'];
	$jurusan=$_SESSION['jurusankaryawan'];

} else {$iduser='';}
//if (isset($_GET['menuid'])) {$menuid=$_GET['menuid'];}
?>

	<!-- Page container -->
	<div class="page-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main sidebar -->
			<?php //if ($akses=='admin') { ?>
			<div class="sidebar sidebar-main">
				<div class="sidebar-content">
					<!-- User menu -->
					<div class="sidebar-user">
						<div class="category-content" style="padding: 10px 10px 5px 20px;">
							<div class="media">
								<div class="media-body">
									<?php if ($akses=='admin') { ?>
									<h4></h4>
									<?php } else {?>
									<h4></h4>
									<?php } ?>
								</div>

								
							</div>
						</div>
					</div>
					<!-- /user menu -->


					<!-- Main navigation -->
					<div class="sidebar-category sidebar-category-visible">
						<div class="category-content no-padding">
							<ul class="navigation navigation-main navigation-accordion">  
								
								<?php
								if (isset($_GET['menuid']))
								{
									$menuidnya=$_GET['menuid'];
									if ($menuidnya=='dash') {
										$activmenu='';
									?>		
									<li class="active"><a href="?menuid=dash"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>
									<?php
									}
									else
									{
										$sql3="SELECT  main_menu FROM `master_menu` WHERE menu_id = '". $_GET['menuid'] ."'";
										$stmt3 = $koneksi->prepare($sql3);
										$stmt3->execute(); 		
										$result = $stmt3->fetch();
										$activmenu=$result["main_menu"];	
										?>
										<li><a href="?menuid=dash"><i class="icon icon-home"></i> <span>Dashboard</span></a> </li>			
									<?php
									}
								}
								else 
								{
									$activmenu='';
									?><li><a href="?menuid=dash"><i class="icon-home4"></i> <span>Dashboard</span></a></li>
									<?php 
								}
								
								//Sql cek
								$sqlmain="SELECT  `menu_nama` as text,menu_id as id,folder,child,induk,icon FROM `master_menu` WHERE main_menu='0' 
										  and menu_allowed like '%".$lvl."%'";
								//echo $sqlmain;		  
								$stmtmain = $koneksi->prepare($sqlmain);
								$stmtmain->execute(); 		
								while ($arrmain = $stmtmain->fetch(PDO::FETCH_ASSOC)) {?>
									<li><a href="?menuid=<?php echo $arrmain['id']; ?>"><i class="<?php echo $arrmain['icon']; ?>"></i><span><?php echo $arrmain['text'];  ?></span></a></li>
								<?php 
								}

										

									$sql1 = "SELECT  `nama_menu`,main_id,icon FROM `master_main_menu` 
											 WHERE main_id in (select main_menu from master_menu where menu_allowed like '%".$lvl."%')
											 ";
									$stmt1 = $koneksi->prepare($sql1);
									$stmt1->execute();
									?>	
									
									<?php
									while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
											if ($arr2['main_id']==$activmenu)
											{ ?>
											<li class="submenu active"> <a href="#"><i class="icon <?php echo $arr2['icon'];?>"></i> <span><?php echo $arr2['nama_menu'];?></span> </a>		
											<?php
											} else {
											?>
											<li class="submenu"> <a href="#"><i class="icon <?php echo $arr2['icon'];?>"></i> <span><?php echo $arr2['nama_menu'];?></span> </a>	
											<?php } ?>
											<ul>
											<?php
											$sql2="SELECT  `menu_nama` as text,menu_id as id,folder,child,induk FROM `master_menu` 
												   WHERE main_menu = '". $arr2['main_id'] ."' and menu_allowed like '%".$lvl."%' 
												   order by menu_id";
											$stmt2 = $koneksi->prepare($sql2);
											$stmt2->execute(); 		
											while ($arr3 = $stmt2->fetch(PDO::FETCH_ASSOC)) {
												if ($arr3['child']!=0)
												{
												?>
													<li><a href="#"><?php echo $arr3['text'];  ?></a>	
													<ul>													
												<?php
													$sql3="SELECT  `menu_nama` as text,menu_id as id,folder,child,induk FROM `master_menu` 
													WHERE main_menu = '". $arr2['main_id'] ."' and menu_allowed like '%".$lvl."%' and induk='".$arr3['id']."'
													order by menu_id";
													$stmt3 = $koneksi->prepare($sql3);
													$stmt3->execute(); 		
													while ($arr4 = $stmt3->fetch(PDO::FETCH_ASSOC)) {	?>											
													<li><a href="?menuid=<?php echo $arr4['id']; ?>"><?php echo $arr4['text'];  ?></a></li>
													<?php
													}
													?>
													</ul></li>
												<?php
												}
												elseif ($arr3['induk']==0)
												{
												?>
												<li><a href="?menuid=<?php echo $arr3['id']; ?>"><?php echo $arr3['text'];  ?></a></li>
											<?php
												}
											}
										?>
										</ul>		
									<?php
									}	if ($akses=='admin') { 
								
								?>
								</li> 
								
									<?php
									}
									?>
							</ul>
						</div>
					</div>
					<!-- /main navigation -->
				</div>
			</div>
			
			<?php
			//}
			?>
			<!-- /main sidebar -->


			<!-- Main content -->
			<div class="content-wrapper">
			<?php 
			if (isset($_GET['menuid']))
			{
				if ($_GET['menuid']=='dash')
				{
					?>
					<div class="page-header"style="margin: 0 0 5px 0;">
						<div class="page-header-content">
							<div class="page-title" style="padding: 10px 36px 10px 0;">
								<h4><span class="text-semibold"></span>Dashboard</h4>
							</div>
							<!--<div class="heading-elements">
								<div class="heading-btn-group">
									<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
									<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
									<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
								</div>
							</div>-->
						</div>

						
					</div>						
					<?php	
					require('dashboard/dashboard.php');
					/*
					if ($akses=='admin') {require('dashboard/dashboard.php');}
					elseif ($akses=='member'){require('dashboard/dashboardmember.php');}
					elseif ($akses=='ba'){require('dashboard/dashboardba.php');}*/
				}
				elseif ($_GET['menuid']=='profile')
				{
					?>
					<div class="page-header" style="margin: 0 0 5px 0;">
						<div class="page-header-content">
							<div class="page-title" style="padding: 10px 36px 10px 0;">
								<h4>Profile</h4>
							</div>
							<!--<div class="heading-elements">
								<div class="heading-btn-group">
									<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
									<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
									<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
								</div>
							</div>-->
						</div>

						
					</div>												
				<?php	
					require('login/profile.php'); 	
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
						$namamenu=$result["menu_nama"];			
					}
					else
					{				
						$sql3="SELECT  a.nama_menu,b.menu_uri,b.menu_nama FROM `master_main_menu` a,`master_menu` b 
							   WHERE a.main_id=b.main_menu and b.menu_id = '". $_GET['menuid'] ."'";
						$stmt3 = $koneksi->prepare($sql3);
						$stmt3->execute(); 		
						$result = $stmt3->fetch();
						$menu=$result["menu_uri"];	
						$namamainmenu=$result["nama_menu"];	
						$namamenu=$result["menu_nama"];	
					}
				?>
				<div class="page-header" style="margin: 0 0 5px 0;">
					<div class="page-header-content">
						<div class="page-title" style="padding: 10px 36px 10px 0;">
							<h4><span class="text-semibold"></span> <?php echo $namamenu;?></h4>
						</div>
						<!--<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
							</div>
						</div>-->
					</div>

					
				</div>										
				<?php
				require(''.$menu.''); 
				}
			}
			elseif(isset($_GET['profile']))
			{
				?>
					<div class="page-header" style="margin: 0 0 5px 0;">
						<div class="page-header-content">
							<div class="page-title" style="padding: 10px 36px 10px 0;">
								<h4><span class="text-semibold"></span> Profile</h4>
							</div>
							<!--<div class="heading-elements">
								<div class="heading-btn-group">
									<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
									<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
									<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
								</div>
							</div>-->
						</div>

						
					</div>					
				<?php  
				require('login/profile.php'); 	
			}
			else
			{
				?>
				<div class="page-header" style="margin: 0 0 5px 0;">
					<div class="page-header-content">
						<div class="page-title" style="padding: 10px 36px 10px 0;">
							<h4>Dashboard</h4>
						</div>
						<!--<div class="heading-elements">
							<div class="heading-btn-group">
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-bars-alt text-primary"></i><span>Statistics</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calculator text-primary"></i> <span>Invoices</span></a>
								<a href="#" class="btn btn-link btn-float has-text"><i class="icon-calendar5 text-primary"></i> <span>Schedule</span></a>
							</div>
						</div>-->
					</div>

					
				</div>						
				
					<?php require('dashboard/dashboard.php');
						  /*if ($akses=='admin') {require('dashboard/dashboard.php');}
						  elseif ($akses=='member'){require('dashboard/dashboardmember.php');}
						  elseif ($akses=='ba'){require('dashboard/dashboardba.php');}*/
			}
			?>
				<!-- Page header -->

