<?php
if (!isset($_SESSION)) {
	session_start();
}
include ("./config/conn.php");
 if (isset($_POST['submit']))
{
	$iduser=$_POST['id_user'];
	$username=$_POST['username'];
	$password=$_POST['password'];
	$namadepan=$_POST['nama_depan'];
	$namabelakang=$_POST['nama_belakang'];
	
	if ($password<>'')
	{
		$sqlup="update master_user set u_username='".$username."',u_password=md5('".$password."'),u_first_name='".$namadepan."',u_last_name='".$namabelakang."'
			where u_id='".$iduser."'";
	}
	else
	{
		$sqlup="update master_user set u_username='".$username."',u_first_name='".$namadepan."',u_last_name='".$namabelakang."'
			where u_id='".$iduser."'";		
	}
	$stmt = $koneksi->prepare($sqlup);
	$stmt->execute();				
}

if (isset($_SESSION['idusersikeni']))
{
	$iduser=$_SESSION['idusersikeni'];
	$sql = "SELECT u_id,u_username,u_password,u_first_name,u_last_name";
	$sql.=" FROM master_user where u_id='".$iduser."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();		
	$result = $stmt -> fetch();
	$iduser=$result['u_id'];
	$username=$result['u_username'];
	$namadepan=$result['u_first_name'];
	$namabelakang=$result['u_last_name'];
}
else
{
	$iduser='';
	$username='';
	$namadepan='';
	$namabelakang='';
}
?>
<div class="container-fluid">
  <hr>
  <div class="row-fluid">
    <div class="span6">
	  <div id="msg"></div>
      <div class="widget-box">
        <div class="widget-title"> <span class="icon"> <i class="icon-align-justify"></i> </span>
          <h5>Data Profile</h5>
        </div>
        <div class="widget-content nopadding">
		  <form action="#" method="post" class="form-horizontal" name="basic_validate" id="basic_validate" novalidate="novalidate">
			<input type="hidden" class="span11" name="id_user" value="<?php echo $iduser;?>" id="id_user"/>
            <div class="control-group">			
              <label class="control-label">Username :</label>
              <div class="controls">
                <input type="text" class="span11" value="<?php echo $username;?>" name="username" id="username" placeholder="Isi Username" required />
              </div>
            </div>
            <div class="control-group">			
              <label class="control-label">Password :</label>
              <div class="controls">
                <input type="password" class="span11"  name="password" id="password" placeholder="Isi Password" />
              </div>
            </div>			
            <div class="control-group">
              <label class="control-label">Nama Depan :</label>
              <div class="controls">
                <input type="text" class="span11" value="<?php echo $namadepan;?>" name="nama_depan" id="nama_depan" placeholder="Isi Nama Depan" required />
              </div>
            </div>
            <div class="control-group">
              <label class="control-label">Nama Belakang :</label>
              <div class="controls">
                <input type="text" class="span11" value="<?php echo $namabelakang;?>" name="nama_belakang" id="nama_belakang" placeholder="Isi Nama Belakang" required />
              </div>
            </div>			
            <div class="form-actions">
<!--              <a href="?menuid=<?php //echo $_GET['menuid'];?>" class="btn btn-primary">Clear</a>&nbsp;&nbsp;&nbsp;&nbsp;-->
			  <button type="submit" name="submit" id="submit" class="btn btn-success">Save</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="../asset/js/jquery.min.js"></script> 
<script src="../asset/js/jquery.ui.custom.js"></script> 
<script src="../asset/js/bootstrap.min.js"></script> 
<script src="../asset/js/jquery.uniform.js"></script> 
<script src="../asset/js/select2.min.js"></script> 
<script src="../asset/js/jquery.dataTables.min.js"></script> 
<script src="../asset/js/jquery.validate.js"></script> 
<script src="../asset/js/matrix.js"></script> 
<script src="../asset/js/matrix.tables.js"></script>
<script src="../asset/js/bootstrap-colorpicker.js"></script> 
<script src="../asset/js/bootstrap-datepicker.js"></script> 
<script src="../asset/js/matrix.form_validation.js"></script>
<script src="../asset/js/masked.js"></script> 
<script src="../asset/js/matrix.form_common.js"></script> 
<script src="../asset/js/jquery.peity.min.js"></script>  
