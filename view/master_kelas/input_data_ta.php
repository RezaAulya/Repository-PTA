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

if (isset($_GET['menuid'])) {$menuid=$_GET['menuid'];}
?>		
<?php
if (isset($_GET['id']))
{
	$sql = "SELECT id_upload,id_nama,nim,id_unit,id_angkatan,judul_tugas,id_user,data";
	$sql.=" FROM master_upload_data where id_upload='".$_GET['id']."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();		
	$result = $stmt -> fetch();
	$id= $result['id_upload'];
	$nama= $result['id_nama'];
	$nim=$result['nim'];	
	$prodi= $result['id_unit'];
	$angkatan = $result['id_angkatan'];
	$judul = $result['judul_tugas'];
	$user=$result['id_user'];
	$filenya=$result['data'];

	$btn='Update';
}
else
{
	$id='';
	$nama='';
	$nim='';
	$prodi='';
	$angkatan='';	
	$judul='';
	$user='';
	$filenya='';

	$btn='Save';	
}
?>
				<!-- Content area -->
				<div class="content">
					<div class="row">					
						<div class="col-md-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h6 class="panel-title">Masukan Project Akhir</h6>
								</div>
								<div class="panel-body">
									<div class="row">					
										<form class="form-horizontal" id="formasterjabatan">
										<div class="col-md-6">																	
											<input type="hidden" class="span11" name="id" value="<?php echo $id;?>" id="id">
											<input type="hidden" class="span11" name="user" value="<?php echo $iduser;?>" id="user">
											<input type="hidden" class="form-control" name="angkatan" id="angkatan" value="<?php echo $angkatan1;?>">
											<input type="hidden" class="form-control" name="prodi" id="prodi" value="<?php echo $jurusan;?>">
											<input type="hidden" class="form-control" name="nim" id="nim" value="<?php echo $dia;?>">
											<input type="hidden" class="span11" name="menuid" value="<?php echo $menuid;?>" id="menuid">
										<fieldset>
										</div>	
										</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label>Judul Tugas Akhir:</label>*
														<input class="form-control required" type="text" name="judul" id="judul" placeholder="judul Tugas Akhir" value="<?php echo $judul;?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Nama Lengkap:</label>
														<input type="text" disabled class="form-control" name="nama" id="nama" value="<?php echo $yuyu;?>">
													</div>
												</div>
												<div class="col-md-3">
													<div class="form-group">
														<label>Upload Disini:</label>
														<input id="filenya" name="filenya" type="file" class="file-styled">
														<span class="help-block">format : pdf.Max file 2MB</span>
													</div>
												</div>
											</div>
										</fieldset>
											<div class="text-right">

												<?php

													$sql="SELECT id_user FROM master_upload_data where nim='".$dia."'";
													$stmt = $koneksi->prepare($sql);
													$stmt->execute();
													$data=$stmt->fetch();

													$yu=$data[0];

													if($yu==""){
													

													echo "<a href='' class='btn btn-primary' id='btnsimpan'>".$btn."<i class='icon-arrow-right14 position-right'></i></a>";

													}else
													{
														echo "<a href='' class='btn btn-primary disabled' id='btnsimpan'>".$btn."<i class='icon-arrow-right14 position-right'></i></a>";
														
													}

												?>

											</div>									
											
										</div>			
										</form>
									</div>					
								</div>
							</div>					
						</div>

					<div class="col-md-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h6 class="panel-title">Daftar Tugas Akhir</h6>
								</div>
								<div class="panel-body">
									<table id="masterlevel" class="table datatable-responsivet">
										<thead>
											<tr>
												<th>Nama</th>
												<th>Jurusan</th>
												<th>Angkatan</th>
												<th>Judul</th>
												<th>file</th>
												<th class="text-center">Actions</th>
											</tr>
										</thead>
										<tbody>
										<?php
										$sql = "SELECT id_upload,id_nama,id_unit,id_angkatan,judul_tugas,data,
										(SELECT unit from master_unit where master_unit.id_master_unit=master_upload_data.id_unit) as nmunit,
										(select u_first_name from master_user where master_user.u_first_name=master_upload_data.id_nama) as nmnm,
										(SELECT angkatan from master_angkatan where master_angkatan.id_angkatan=master_upload_data.id_angkatan) as angk";
										
										$sql.=" FROM master_upload_data where id_user='".$iduser."'";
										$stmt = $koneksi->prepare($sql);
										$stmt->execute();
										while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
											?>
											<tr>
											<td><?php echo $arr2['nmnm']; ?></td>
											<td><?php echo $arr2['nmunit']; ?></td>
											<td><?php echo $arr2['angk']; ?></td>
											<td><?php echo $arr2['judul_tugas']; ?></td>
											<td><a class="btn btn-warning" href="http://localhost/repository/cetak/qr.php"><i class="icon-book2"> file</a></td>
											<td class="text-center">
												<a  class="deletenya" title="Delete" onclick="tes('<?php echo $arr2['id_upload'];?>','<?php echo $arr2['id_nama'];?>')"><i class="icon-trash"></i></a>
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

$(function(){
	
	$('#btnsimpan').on('click', function(e) {
		e.preventDefault();
		var nama=$("#nama").val();
		var nim=$("#nim").val();
		var id=$("#id").val();
		var prodi =$("#prodi").val();
		var angkatan = $("#angkatan").val();
		var judul = $("#judul").val();
		var user = $("#user").val();
		var filenya = $('#filenya').prop('files')[0];  	
		if (typeof filenya != 'undefined')
		{	
			var filenya = $('#filenya').prop('files')[0];  	
		}
		else
		{
			var filenya = '';  	
		}
		var idmenu=document.getElementById("menuid").value;
		
		var form_data = new FormData(); 
		form_data.append('id',id);                 
		form_data.append('nama',nama);
		form_data.append('nim',nim);
		form_data.append('prodi',prodi);
		form_data.append('angkatan',angkatan);
		form_data.append('judul',judul);
		form_data.append('user',user);
		form_data.append('filenya',filenya);

		form_data.append('kode','judultugas');


	 	$.ajax({
			url: './proses/simpandata.php', // point to server-side PHP script 
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

				console.log(tmpcek);

				if (tmpcek){

				$('body').find('.jGrowl').attr('class', '').attr('id', '').hide();
				swal({
					title: "Confirmation",
					text: tmpmsg,
					confirmButtonColor: "#66BB6A",
					type: "success"
				});
				window.location.href="?menuid="+idmenu;				 
				//formasterlevel.reset();
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
	});
});

			
		
function tes(x,y)
{
    swal({
        title: "Konfirmasi",
        text: "Anda Ingin Menghapus "+y+"?",
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
							title: "Sukses",
							text: "Data Berhasil dihapus.",
							confirmButtonColor: "#66BB6A",
							type: "success"
						});
						//direset();
						var idmenu=document.getElementById("menuid").value;
						window.location.href="?menuid="+idmenu;								
					}
				}
			}
			xmlhttp.open("GET","./proses/hapusdata.php?kode=hapusta&id="+x,true);
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
});
	
</script>
