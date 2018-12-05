<?php
if (!isset($_SESSION)) {
	session_start();
}
if (isset($_SESSION['iduserkaryawan']))
{
	$iduser=$_SESSION['iduserkaryawan'];
	$dia=$_SESSION['namakaryawan'];
	$email=$_SESSION['emailkaryawan'];
	$yuyu=$_SESSION['yuyu21'];
	$jurusan=$_SESSION['jurusankaryawan'];

} else {$iduser='';}

if (isset($_GET['menuid'])) {$menuid=$_GET['menuid'];}
?>

</script>
<script type="text/javascript">	

function simpan()
{
	var id = document.getElementById("id").value;
	var id_nama = document.getElementById('id_nama').value;
	var id_unit = document.getElementById("id_unit").value;
	var id_angkatan = document.getElementById("id_angkatan").value;
	var judul = document.getElementById("judul").value;
	var user = document.getElementById("user").value;
	var filenya = $('#filenya').prop('files')[0]; 
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
	xmlhttp.open("GET","./proses/simpandata.php?kode=judultugas&id_nama="+id_nama+"&id_unit="+id_unit+"&id_angkatan="+id_angkatan+"&judul="+judul+"&filenya="+filenya+"&user="+user+"&id="+id,true);
	xmlhttp.send(null);
}
</script>	
<?php
if (isset($_GET['id']))
{
	$sql = "SELECT id_upload,id_nama,id_unit,id_angkatan,judul_tugas,id_user,file_upload";
	$sql.=" FROM master_upload_data where id_upload='".$_GET['id']."'";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();		
	$result = $stmt -> fetch();
	$id= $result['id_upload'];	
	$id_nama= $result['id_nama'];	
	$id_unit= $result['id_unit'];
	$id_angkatan = $result['id_angkatan'];
	$judul_tugas = $result['judul_tugas'];
	$file= $result['file_jobdesk'];
	$user=$result['id_user'];

	$btn='Update';
}
else
{
	$id='';
	$id_nama='';
	$id_unit='';
	$id_angkatan='';	
	$judul_tugas='';
	$user='';
	$file='';

	$btn='Save';
}
			?>
			
				<div class="content">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-info">
								<div class="panel-heading">
									<h6 class="panel-title">Daftar Tugas Akhir&nbsp;&nbsp;&nbsp;&nbsp;<span><a class="btn btn-warning" href="http://localhost/repository/cetak/qr.php"><i class="icon-cloud-download2"></i> Katalog QR-Code</a></span></h6>
								</div>
								<div class="panel-body">
									<table id="masterlevel" class="table datatable-responsivet">
										<thead>
											<tr>
												<th>Nim</th>
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
										$sql = "SELECT id_upload,id_nama,nim,id_unit,id_angkatan,judul_tugas,data,
										(SELECT unit from master_unit where master_unit.id_master_unit=master_upload_data.id_unit) as nmunit,
										(select u_first_name from master_user where master_user.u_first_name=master_upload_data.id_nama) as nmnm,
										(SELECT angkatan from master_angkatan where master_angkatan.id_angkatan=master_upload_data.id_angkatan) as angk";
										
										$sql.=" FROM master_upload_data";
										$stmt = $koneksi->prepare($sql);
										$stmt->execute();
										while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
											?>
											<tr>
											<td><?php echo $arr2['nim']; ?></td>
											<td><?php echo $arr2['nmnm']; ?></td>
											<td><?php echo $arr2['nmunit']; ?></td>
											<td><?php echo $arr2['angk']; ?></td>
											<td><?php echo $arr2['judul_tugas']; ?></td>
											<td><a class="btn btn-warning" href="http://localhost/repository/upload/<?php echo $arr2['data']; ?>"><i class="icon-download"> Download</a></td>
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

</script>
