<?php
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_GET['menuid'])) {$menuid=$_GET['menuid'];}
?>
<script type="text/javascript">
function simpan()
{
	var unit=document.getElementById("unit").value;
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
					title: "Confirmation Save Data",
					text: "Succeed",
					confirmButtonColor: "#66BB6A",
					type: "success"
				});
				window.location.href="?menuid="+idmenu;				 
				//formasterlevel.reset();
			}
		}
	}
	xmlhttp.open("GET","./proses/simpandata.php?kode=masterunit&unit="+unit+"&id="+id,true);
	xmlhttp.send(null);
}
</script>	
<?php
if (isset($_GET['id']))
{
	$sql = "SELECT id_master_unit,unit";
	$sql.=" FROM master_unit where id_master_unit='".$_GET['id']."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();		
	$result = $stmt -> fetch();
	$id= $result['id_master_unit'];	
	$unit= $result['unit'];
	$btn='Update';
}
else
{
	$id='';	
	$unit='';
	$btn='Save';	
}
?>
				<!-- Content area -->
				<div class="content">
					<div class="row">					
						<div class="col-md-5">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h6 class="panel-title">Master Prodi</h6>
								</div>
								<div class="panel-body">
									<form class="form-horizontal" id="formasterlevel">
									<input type="hidden" class="span11" name="id" value="<?php echo $id;?>" id="id"/>
									<input type="hidden" class="span11" name="menuid" value="<?php echo $menuid;?>" id="menuid"/>
									<fieldset>
										<div class="form-group">
											<label class="col-lg-3 control-label">Prodi:</label>
											<div class="col-lg-9">
												<input type="text" class="form-control" placeholder="Masukan Nama Prodi" value="<?php echo $unit;?>"  name="unit" id="unit" >
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
									<h6 class="panel-title">Daftar Prodi</h6>
								</div>
								<div class="panel-body">
									<table id="masterlevel" class="table datatable-responsivet">
										<thead>
											<tr>
												<th>Jurusan</th>
												<th class="text-center">Actions</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$sql = "SELECT id_master_unit,unit";
										$sql.=" FROM master_unit";
										$stmt = $koneksi->prepare($sql);
										$stmt->execute();
										while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
											?>
											<tr>
											<td><?php echo $arr2['unit']; ?></td>
											<td class="text-center">
												<a class="tip" href="?menuid=<?php echo $_GET['menuid'];?>&id=<?php echo $arr2['id_master_unit'];?>" title="Edit"><i class="icon-pencil"></i></a> 
												<a  class="deletenya" title="Delete" onclick="tes('<?php echo $arr2['id_master_unit'];?>','<?php echo $arr2['unit'];?>')"><i class="icon-trash"></i></a>
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
        text: ""+y+" will be deleted ???",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#EF5350",
        confirmButtonText: "Yes, delete it!",
        cancelButtonText: "No, cancel pls!",
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
			xmlhttp.open("GET","./proses/hapusdata.php?kode=hapusmasterunit&id="+x,true);
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


/*$('.datatable-responsivet').DataTable({
	dom: "rtip",
    autoWidth: false,
    responsive: true,		
});*/

$('.datatable-responsivet').DataTable({
	dom: "frtip",
    autoWidth: false,
    responsive: true,		
	"oLanguage": {
		"sSearch": "Search&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
	}	
});
	
</script>
