<?php
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_GET['menuid'])) {$menuid=$_GET['menuid'];}
?>
<script type="text/javascript">

function simpan()
{
	var angkatan=document.getElementById("angkatan").value;
	var id_master_unit=document.getElementById("id_master_unit").value;
	var id=document.getElementById("id").value;
	
	
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
					title: "Confirmation",
					text: "Data Has Been Saved !",
					confirmButtonColor: "#66BB6A",
					type: "success"
				});
				window.location.href="?menuid="+idmenu;				 
				//formasterlevel.reset();
			}
		}
	}
	xmlhttp.open("GET","./proses/simpandata.php?kode=masterangkatan&id_master_unit="+id_master_unit+"&angkatan="+angkatan+"&id="+id,true);
	xmlhttp.send(null);
}
</script>	
<?php
if (isset($_GET['id']))
{
	$sql = "SELECT id_angkatan,angkatan,id_master_unit";
	$sql.=" FROM master_angkatan where id_angkatan='".$_GET['id']."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();		
	$result = $stmt -> fetch();
	$id= $result['id_angkatan'];
	$angkatan= $result['angkatan'];	
	$idunit= $result['id_master_unit'];	

	$btn='Update';
}
else
{
	$id='';	
	$angkatan='';
	$idunit='';	
	$btn='Save';	
}
?>
				<!-- Content area -->
				<div class="content">
					<div class="row">					
						<div class="col-md-5">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h6 class="panel-title">Master Angkatan</h6>
								</div>
								<div class="panel-body">
									<form class="form-horizontal" id="formasterlevel">
									<input type="hidden" class="span11" name="id" value="<?php echo $id;?>" id="id"/>
									<input type="hidden" class="span11" name="menuid" value="<?php echo $menuid;?>" id="menuid"/>
									<fieldset>
										<div class="form-group">
											<label class="col-lg-3 control-label">Jurusan:</label>
											<div class="col-lg-9">
												<select class="select" name="id_master_unit" id="id_master_unit" onchange="caridosen(this)">
													<option value="" >--Pilih Jurusan--</option>
												   <?php
													$sqlevel="SELECT id_master_unit,unit from master_unit";
													$stmt1 = $koneksi->prepare($sqlevel);
													$stmt1->execute();					
													while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) { 
													if ($arr2['id_master_unit']==$idunit) { $plh="selected";} else {$plh="";}
														?>
														<option value="<?php echo $arr2['id_master_unit']; ?>" <?php  echo $plh; ?>><?php echo $arr2['unit'];?></option>	
													<?php
													}						
												  ?>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-3 control-label">Angkatan:</label>
											<div class="col-lg-9">
												<input type="text" class="form-control" placeholder="Masukan Tahun Angkatan" value="<?php echo $angkatan;?>"  name="angkatan" id="angkatan">
											</div>
										</div>										
									</fieldset>
									<div class="text-right">
										<a href="?menuid=<?php echo $_GET['menuid'];?>" class="btn btn-default">Reset <i class="icon-reload-alt position-right"></i></a>&nbsp;&nbsp;&nbsp;&nbsp;
										<a href="" class="btn btn-primary" onclick="simpan();return false;"><?php echo $btn; ?><i class="icon-arrow-right14 position-right"></i></a>
									</div>									
									</form>
								</div>
							</div>					
						</div>

						<div class="col-md-7">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h6 class="panel-title">Daftar Angkatan</h6>
								</div>
								<div class="panel-body">
									<table id="masterlevel" class="table datatable-responsivet">
										<thead>
											<tr>
											    <th>Jurusan</th>
												<th>Angkatan</th>
												<th class="text-center">Actions</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$sql = "SELECT id_angkatan,angkatan,id_master_unit,
												(SELECT unit from master_unit where master_unit.id_master_unit=master_angkatan.id_master_unit) as nmide";
										$sql.=" FROM master_angkatan";
										$stmt = $koneksi->prepare($sql);
										$stmt->execute();
										while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
											?>
											<tr>
											<td><?php echo $arr2['nmide']; ?></td>
											<td><?php echo $arr2['angkatan']; ?></td>
											<td class="text-center">
												<a class="tip" href="?menuid=<?php echo $_GET['menuid'];?>&id=<?php echo $arr2['id_angkatan'];?>" title="Edit"><i class="icon-pencil"></i></a> 
												<a  class="deletenya" title="Delete" onclick="tes('<?php echo $arr2['id_angkatan'];?>','<?php echo $arr2['angkatan'];?>')"><i class="icon-trash"></i></a>
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
        text: "Angkatan "+y+" Akan dihapus ?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#EF5350",
        confirmButtonText: "Hapus",
        cancelButtonText: "Tidak",
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
							title: "Deleted!",
							text: "Data Has Been Deleted !",
							confirmButtonColor: "#66BB6A",
							type: "success"
						});
						//direset();
						var idmenu=document.getElementById("menuid").value;
						window.location.href="?menuid="+idmenu;								
					}
				}
			}
			xmlhttp.open("GET","./proses/hapusdata.php?kode=hapusangkatan&id="+x,true);
			xmlhttp.send(null);					
        }
        else {
            swal({
                title: "Cancelled",
                //text: "Proses Hapus Tidak Dilakukan  :)",
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
