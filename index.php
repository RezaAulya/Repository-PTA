<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>e-Repository Politeknik Aceh</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
	<link rel="icon" href="assets/images/favicon.png" type="image/gif" sizes="16x16"> 
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script type="text/javascript" src="assets/js/plugins/loaders/pace.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/core/libraries/bootstrap.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/loaders/blockui.min.js"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/login.js"></script>
	
	<!-- /theme JS files -->



	<script type="text/javascript">	
		function showpass()
		{
			$('#password').attr('type', 'text'); 
		}

		function hidepass()
		{
			$('#password').attr('type', 'password'); 
		}
		
        </script>

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<!-- /theme JS files -->
	<script type="text/javascript">
    function prslogin(e)
    {
		if (e.keyCode == 13) {
			ceklogin();
		}
    }

	function nextpass(e)
	{
		if (e.keyCode == 13) {
			document.getElementById('password').focus();
		}
    }	
		 
	function ceklogin()
	{
		var username = document.getElementById('username').value;
		var password = document.getElementById('password').value;
		if ((username=='') || (password==''))
		{
			document.getElementById("error").innerHTML='<div class="alert bg-warning alert-styled-right">'+
										'<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+
										'<span class="text-semibold"></span>Username Atau Password Belum Di isi ! '+
								    '</div>';			
				
		}
		else
		{
			if (window.XMLHttpRequest)
			{// code for IE7+, Firefox, Chrome, Opera, Safari
				xmlhttp=new XMLHttpRequest();
			}
			else
			{// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			xmlhttp.onreadystatechange=function()
			{
				if (xmlhttp.readyState==4 && xmlhttp.status==200)
				{
					myJSON =xmlhttp.responseText;
					var george=JSON.parse(myJSON); //convert JSON string into object
					var tmpcek=(george.success);				
					if (tmpcek)
					{
						document.location.href='view/';
					}
					else {	
						document.getElementById("error").innerHTML='<div class="alert bg-danger alert-styled-right">'+
										'<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>'+
										'<span class="text-semibold"></span>Wrong username or password. Please try again! '+
								    '</div>';	
					}
				}
			}
			xmlhttp.open("GET","view/login/login.php?username="+username+"&password="+password,true);
			xmlhttp.send(null);	
		}
	}
	</script>	
</head>

<body class="bg-slate-800">
	<!-- Main navbar -->
	<!--<div class="navbar navbar-inverse">
		<div class="navbar-header">
			

			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<!--<ul class="nav navbar-nav navbar-right">
				<li>
				<a href="signup.php" class="btn btn-link"><i class="icon-user-plus position-left"></i>CHEERS FORM</a>
				</li>
			</ul>
		</div>
	</div>-->
	<!-- /main navbar -->


	<!-- Page container -->
	<div class="page-container login-container">

		<!-- Page content -->
		<div class="page-content">

			<!-- Main content -->
			<div class="content-wrapper">

				<!-- Content area -->
				<div class="content">
			
					<!-- Simple login form -->				
					<form action="index.html">
						<div class="panel panel-body login-form">					
							<div class="text-center" style="margin-top: -20px;">
								<br/><img width="55%" href="www.politeknikaceh.ac.id" src="assets/images/login.png">
								<h5 class="content-group">Login <small class="display-block">Enter your credentials below</small></h5>
									<?php
									//logout message
									if (isset($_GET['msg']))
									{
										$xtmp=base64_decode(urldecode($_GET['msg']));										
										if ($xtmp=='logout')
										{
											echo '<div class="alert alert-success alert-styled-left alert-arrow-left alert-bordered">
													<button type="button" class="close" data-dismiss="alert"><span>&times;</span><span class="sr-only">Close</span></button>successfully logged out</div><br/>
												  <br/>';	
										}
										else
										{
											echo '<div class="alert bg-danger alert-styled-right">
												 <button type="button" class="close" data-dismiss="alert"><span>&times;</span>
												 <span class="sr-only">Close</span></button>
												 <span class="text-semibold"></span>Logout Otomatis<br>Aplikasi Tidak Digunakan <br> Selama 15 menit. 
												 </div>';
										}
									}
									?>
							</div>

							<div class="form-group has-feedback has-feedback-right">
								<div class="input-group">
								<div class="input-group-addon"><i class="icon-user"></i></div>
								<input type="text" class="form-control" placeholder="Username / Email" id="username" name="username" onkeypress="nextpass(event);">
								<!--<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>-->
								</div>
							</div>

							<div class="form-group has-feedback has-feedback-right">
								<div class="input-group">
								<div class="input-group-addon"><i class="icon-lock2"></i></div>
								<input type="password" class="form-control" placeholder="Password" id="password" name="password" onkeypress="prslogin(event);">
									<div class="input-group-addon"><i class="icon-eye2 text-muted" onMouseOver="showpass()" onMouseOut="hidepass()" ></i></div>
								</div>
							</div>


							<div class="form-group">
								<a onClick="return ceklogin()" class="btn btn-primary btn-block">Sign in <i class="icon-circle-right2 position-right"></i></a>
							</div>
							<div id="error"></div>			
							<div class="form-group login-options">
								<div class="row">
									<div class="col-sm-6">
										
									</div>

									<div class="col-sm-6 text-right">
										<!-- <a href="lupa_password.php">Forgot password?</a> -->
									</div>
								</div>
							</div>
							<div class="content-divider text-muted form-group"><span>Politeknik Aceh</span></div>
							<!--<a href="signup.php" class="btn btn-default btn-block content-group">Sign up</a>-->
							<span class="help-block text-center no-margin">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>
													
						</div>
					</form>
					<!-- /simple login form -->
					<!--	</div>
					</div>-->

					<!-- Footer -->
					<div class="footer text-white">
						&copy; <?php echo date('Y'); ?>. e-Repository Politeknik Aceh 1.0 Beta Version
					</div>
					<!-- /footer -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /main content -->

		</div>
		<!-- /page content -->

	</div>
	<!-- /page container -->

</body>
</html>
