<?php
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_GET['menuid'])) {$menuid=$_GET['menuid'];}
?>
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
<script type="text/javascript">
 function prslogin(e)
    {
		if (e.keyCode == 13) {
			ceklogin();
		}
    }

	function cek()
	{
	  if (document.getElementById('cekpass').checked) 
	  {
		  var pass1=document.getElementById('username').value;
		  document.getElementById('password').value=pass1;
	  }
	  else
	  {
		  document.getElementById('password').value='';
	  }
	}

	function akses(){

		var levelid=$("#user_level").val();

		//alert(levelid);

		if(levelid==1){

			document.getElementById("prodi").disabled=true;
			document.getElementById("angkatan").disabled=true;

			console.log(levelid);
		}
	}

function simpan()
{
	var iduser=document.getElementById("iduser").value;
	var nama=document.getElementById("username").value;
	var pass=document.getElementById("password").value;
	var namadepan=document.getElementById("namadepan").value;
	var angkatan=document.getElementById("angkatan").value;
	var levelid=document.getElementById("user_level").value;
	var prodi=document.getElementById("prodi").value;
	var statusid=document.getElementById("user_status").value;
	var cekpass=document.getElementById("cekpass").value;
	
	var idmenu=document.getElementById("menuid").value;
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
			var pesan=xmlhttp.responseText;
			if (pesan)
			{
				$('body').find('.jGrowl').attr('class', '').attr('id', '').hide();
				swal({
					title: "Success",
					text: "Data has been saved.",
					confirmButtonColor: "#66BB6A",
					type: "success"
				});
				window.location.href="?menuid="+idmenu;				 
				//formasterlevel.reset();
			}
		}
	}
	xmlhttp.open("GET","./proses/simpandata.php?kode=masteruser&iduser="+iduser+"&username="+nama+"&password="+pass+"&namadepan="+namadepan+"&angkatan="+angkatan+"&statusid="+statusid+"&idlevel="+levelid+"&prodi="+prodi,true);
	xmlhttp.send(null);
}
</script>	
<?php
if (isset($_GET['useridnya']))
{
	$sql = "SELECT u_id,u_username,u_password,u_first_name,angkatan,user_level,prodi,active";
	$sql.=" FROM master_user where u_id='".$_GET['useridnya']."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();		
	$result = $stmt -> fetch();
	$id= $result['u_id'];	
	$username= $result['u_username'];	
	$firstname= $result['u_first_name'];	
	$userlevel= $result['user_level'];
	$idactive= $result['active'];
	if ($idactive==1){
			$plh1=" selected";
			$plh2="";
		} 
			else {
				$plh1="";
				$plh2=" selected";
			}		
	$passedit=$result['u_password'];
	$angkatan=$result['angkatan'];
	$prodi=$result['prodi'];

	$btn='Update';
}
else
{
	$id='';	
	$username='';
	$angkatan='';	
	$firstname='';	
	$userlevel='';	
	$idjabatan='';
	$plh1='';	
	$plh2='';
	$prodi='';
	$passedit='';
	$btn='Save';
}
?>
			
		<div class="content">
			<div class="row">					
				<div class="col-md-12">
					<div class="panel panel-danger">
						<div class="panel-heading">
							<h6 class="panel-title">Input User Account</h6>
						   </div>


				<!--form -->
							<div class="panel-body">
								<div class="row">
									<div class="col-md-12">
										<fieldset>
										<legend><i class="icon-reading position-left"></i> Account Control </legend>
						                	<div class="row">
												<div class="">
													<form class="form-horizontal" id="formasterlevel">
														<input type="hidden" class="span11" name="iduser" value="<?php echo $id;?>" id="iduser">
														<input type="hidden" class="span11" name="menuid" value="<?php echo $menuid;?>" id="menuid">
												</div>
											</div>
										</div>	
											
												<div class="col-md-4">
													<div class="form-group">
														<label>Nim:</label>
															<input type="text" class="form-control" value="<?php echo $username;?>" 
												 name="username" id="username" placeholder="Masukan NIM Anda" >	
													</div>
												</div>
												<div class="col-md-3">	
													<label>&nbsp;</label>
														<div class="checkbox">											
															<label>
																<input type="checkbox" name="cekpass" id="cekpass" onclick="cek();" class="control-primary">
																	Password Sama Dengan Nim
															</label>			
														</div>				
													</div>

												<div class="col-md-5">
													<div class="form-group">
														<label>Password:</label>
														<input type="password" class="form-control"  name="password" id="password" value="<?php echo $passedit;?>" placeholder="Input Your Password" onMouseOver="showpass()" onMouseOut="hidepass()" onkeypress="prslogin(event);">
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Level User:</label>
														<select class="select" name="user_level" id="user_level" onchange="akses();" ">
													<option value="" >--Choose Level--</option>
												  <?php
												$sqlevel="SELECT level_id,level_nama from master_level";
													$stmt1 = $koneksi->prepare($sqlevel);
													$stmt1->execute();					
													while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) { 
													if ($arr2['level_id']==$userlevel) { $plh="selected";} else {$plh="";}
														?>
														<option value="<?php echo $arr2['level_id']; ?>" <?php  echo $plh; ?>><?php echo $arr2['level_nama'];?></option>	
													<?php
													}						
												  ?>
												</select>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Jurusan:</label>
													<select class="select" name="prodi" id="prodi">
													<option value="" >--Pilih Level--</option>
												  <?php
												$sqlevel="SELECT id_master_unit,unit from master_unit";
													$stmt1 = $koneksi->prepare($sqlevel);
													$stmt1->execute();					
													while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) { 
													if ($arr2['id_master_unit']==$prodi) { $plh="selected";} else {$plh="";}
														?>
														<option value="<?php echo $arr2['id_master_unit']; ?>" <?php  echo $plh; ?>><?php echo $arr2['unit'];?></option>	
													<?php
													}						
												  ?>
												</select>
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Angkatan:</label>
														<select class="select" name="angkatan" id="angkatan">
													<option value="" >--Pilih Agkatan--</option>
												  <?php
												$sqlevel="SELECT id_angkatan,angkatan from master_angkatan";
													$stmt1 = $koneksi->prepare($sqlevel);
													$stmt1->execute();					
													while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) { 
													if ($arr2['id_angkatan']==$angkatan) { $plh="selected";} else {$plh="";}
														?>
														<option value="<?php echo $arr2['id_angkatan']; ?>" <?php  echo $plh; ?>><?php echo $arr2['angkatan'];?></option>	
													<?php
													}						
												  ?>
												</select>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Nama Lengkap:</label>
														<input type="text" class="form-control" value="<?php echo $firstname;?>" placeholder="Masukan Nama Lengkap" name="namadepan" id="namadepan">
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
														<label>User Active:</label>
													<select class="select" name="user_status" id="user_status">
													<option value="1" <?php echo $plh1; ?>>Aktif</option>
													<option value="0" <?php echo $plh2; ?>>Tidak Aktif</option>
												</select>
													</div>
												</div>
											</div>
										</fieldset>

								
									<div class="text-right">
										<a href="?menuid=<?php echo $_GET['menuid'];?>" class="btn btn-default">Reset <i class="icon-reload-alt position-right"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="" class="btn btn-primary" onclick="simpan();return false;"><?php echo $btn; ?><i class="icon-arrow-right14 position-right"></i></a>
									</div>									
									</div>
								</div>
							</div>					
						</div>

						<div class="row">
						<div class="col-md-12">
							<div class="panel panel-danger">
								<div class="panel-heading">
									<h6 class="panel-title">Daftar Dosen</h6>
								</div>
								<div class="panel-body">
									<table id="masterlevel" class="table datatable-responsivet">
										<thead>
											<tr>
												<th>Username</th>
												<th>Name</th>
												<th>Angkatan</th>>
												<th>Level</th>
												<th>Jurusan</th>
												<th>Status</th>
												<th>Create date</th>
												<th>Last Login</th>
												<th class="text-center">Actions</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$sql = "SELECT u_id,u_username,u_password,u_first_name,angkatan,prodi,user_level,
												(select level_nama from master_level where master_level.level_id=master_user.user_level) as nmlevel,
												(SELECT unit from master_unit where master_unit.id_master_unit=master_user.prodi) as nmunit,
												(select angkatan from master_angkatan where master_angkatan.id_angkatan=master_user.angkatan) as anmnm,
												IF(active='1','Active','Inactive') as nmstatus,
												u_sys_created_by,u_sys_created_date,u_sys_lastlogin_date,u_sys_modified_by,u_sys_modified_date";
										$sql.=" FROM master_user order by user_level";
										$stmt = $koneksi->prepare($sql);
										$stmt->execute();
										while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
											?>
											<tr>
											<td><?php echo $arr2['u_username']; ?></td>
											<td><?php echo $arr2['u_first_name']; ?></td>
											<td><?php echo $arr2['anmnm']; ?></td>
											<td><?php echo $arr2['nmlevel']; ?></td>
											<td><?php echo $arr2['nmunit']; ?></td>
											<td><?php echo $arr2['nmstatus']; ?></td>
											<td><?php echo $arr2['u_sys_created_date']; ?></td>
											<td><?php echo $arr2['u_sys_lastlogin_date']; ?></td>
											<td class="text-center">
												<a class="tip" href="?menuid=<?php echo $_GET['menuid'];?>&useridnya=<?php echo $arr2['u_id'];?>" title="Edit"><i class="icon-pencil"></i></a> 
												<a  class="deletenya" title="Delete" onclick="tes('<?php echo $arr2['u_id'];?>','<?php echo $arr2['u_first_name'];?>')"><i class="icon-trash"></i></a>
											</td>
											</tr>
										<?php
										}				
										?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
					<!-- /fieldset legend -->					
					
<script type="text/javascript">
function tes(x,y)
{
    swal({
        title: "Confirmation",
        text: "Are you sure to delete "+y+" ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#EF5350",
        confirmButtonText: "Yes",
        cancelButtonText: "No",
        closeOnConfirm: false,
        closeOnCancel: false
    },
    function(isConfirm){
        if (isConfirm) {
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
					var pesan=xmlhttp.responseText;
					if (pesan)
					{
						swal({
							title: "Success",
							text: "Data has been deleted.",
							confirmButtonColor: "#66BB6A",
							type: "success"
						});
						//direset();
						var idmenu=document.getElementById("menuid").value;
						window.location.href="?menuid="+idmenu;								
					}
				}
			}
			xmlhttp.open("GET","./proses/hapusdata.php?kode=hapusmasteruser&iduser="+x,true);
			xmlhttp.send(null);					
        }
        else {
            swal({
                title: "Cancelled",
                text: "",
                confirmButtonColor: "#2196F3",
                type: "error"
            });
        }
    });	
}
$('.datatable-responsivet').DataTable({
	dom: "frtip",
    autoWidth: false,
    responsive: true,		
	"oLanguage": {
		"sSearch": "Search&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
	}	
});



	
</script>
