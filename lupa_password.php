<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>BCH e-Academic 1.0</title>
	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="assets/css/icons/icomoon/styles.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/core.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/components.min.css" rel="stylesheet" type="text/css">
	<link href="assets/css/minified/colors.min.css" rel="stylesheet" type="text/css">
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

	<link href="assets/js/plugins/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/forms/selects/select2.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/styling/uniform.min.js"></script>

	<script type="text/javascript" src="assets/js/core/app.js"></script>
	<script type="text/javascript" src="assets/js/pages/form_layouts.js"></script>	
	<!--<script type="text/javascript" src="assets/js/pages/form_validation.js"></script>-->

	<script type="text/javascript" src="assets/js/core/libraries/jquery_ui/datepicker.min.js"></script>	
	<script type="text/javascript" src="assets/js/plugins/forms/styling/switch.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/validation/validate.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/forms/selects/bootstrap_multiselect.js"></script>	

	<script type="text/javascript" src="assets/js/plugins/notifications/jgrowl.min.js"></script>	
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script type="text/javascript" src="assets/js/plugins/notifications/bootbox.min.js"></script>
	<script type="text/javascript" src="assets/js/plugins/notifications/sweet_alert.min.js"></script>		
	<!-- /theme JS files -->
	<script type="text/javascript">
	</script>

</head>

<body class="bg-slate-800">
	<!-- Main navbar -->
	<div class="navbar navbar-inverse">
		<div class="navbar-header">
			<ul class="nav navbar-nav pull-right visible-xs-block">
				<li><a data-toggle="collapse" data-target="#navbar-mobile"><i class="icon-tree5"></i></a></li>
			</ul>
		</div>

		<div class="navbar-collapse collapse" id="navbar-mobile">
			<ul class="nav navbar-nav navbar-right">
				<li>
				<a href="./" class="btn btn-link"><i class="icon-home2 position-left"></i> Sign In</a>
				</li>
			</ul>
		</div>
	</div>
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
					<form action="" method="post">
						<div class="panel panel-body login-form">					
							<div class="text-center">
								<div><img src="assets/images/lupa_password.png"></div>
								<h5 class="content-group">Forgot Password
								<small class="display-block">Enter your email address to get a new password</small></h5>	
							</div>
							<div class="form-group has-feedback has-feedback-left">
								<input type="email" class="form-control" placeholder="Input Your Email" id="email" name="email" required="required">
								<div class="form-control-feedback">
									<i class="icon-envelop3 text-muted"></i>
								</div>
							</div>
							<div class="form-group">
								<input type="submit"  name="act_resset"  value="Recovery" class="btn btn-primary btn-block">
							</div>
							<div id="error"></div>		
<!-- 			<a href="index.php" class="btn btn-default btn-block content-group">Sign in</a> -->
							<!--<span class="help-block text-center no-margin">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span>-->
													
						</div>
					</form>
					<!-- /simple login form -->


					<!-- Footer -->
					<div class="footer text-white">
						&copy; <?php echo date("Y"); ?>. BKD-Politeknik Aceh 1.0 Beta Version
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

<script type="text/javascript">
 function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}

$(function(){
    $('form').validate({
        highlight: function(element) {
            $(element).closest('.form-group').addClass('has-error');
        },
        unhighlight: function(element) {
            $(element).closest('.form-group').removeClass('has-error');
        },
        errorElement: 'span',
        errorClass: 'help-block',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else {
                error.insertAfter(element);
            }
        },
		submitHandler: function(form) {			
			var email=document.getElementById("email").value;
		
			var form_data = new FormData();                  
			form_data.append('email',email);
			form_data.append('kode','recoverypass');		
			
			$.ajax({
				url: 'view/proses/simpandata.php', // point to server-side PHP script 
				dataType: 'text',  // what to expect back from the PHP script, if anything
				cache: false,
				contentType: false,
				processData: false,
				data: form_data,                         
				type: 'post',
				success: function(php_script_response){
					var george=JSON.parse(php_script_response); //convert JSON string into object
					var tmpcek=(george.success);				
					var tmpmsg=(george.msg);				
					var idkar=(george.nomor);		
					if 	(tmpcek)	
					{
						swal({
							title: "Success",
							text: tmpmsg,
							confirmButtonColor: "#66BB6A",
							type: "success"
						});
						document.location.href='./index.php';					
					}
					else
					{
						swal({
							title: "Error !!",
							text: tmpmsg,
							confirmButtonColor: "#EF5350",
							type: "error"
						});					
					}
				}
			});			
		}		
    });
});

$(".datepicker").datepicker({
	showOtherMonths: true,
    selectOtherMonths: true,
	changeMonth: true,
    changeYear: true	
});
</script>