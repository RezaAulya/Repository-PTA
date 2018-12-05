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
<div class="content">
	<div class="row">
		<div class="col-lg-12">
		<!-- Traffic sources -->
			<div class="panel panel-flat">
				<div class="panel-heading">
					<h6 class="panel-title">System info</h6>
					<div class="heading-elements">
						<form class="heading-form" action="#">										
						</form>
					</div>
				</div>
				<div class="container-fluid">
					<div class="row">
						<div class="col-lg-3	">
							<ul class="list-inline text-center">
							<li>
								<a href="#" class="btn border-indigo-400 text-indigo-400 btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-people"></i></a>
							</li>
							<li class="text-left">
								<div class="text-semibold">Alumni</div>
								<div class="text-muted">
									<span class="status-mark border-success position-left"></span>
									<?php 
									$sql="SELECT COUNT(*) as jumlah FROM master_user";
									$stmt=$koneksi->prepare($sql);
									$stmt->execute();
									$hasil=$stmt->fetch();
									echo $hasil['jumlah'];
									?> Mahasiswa.
								</div>
							</li>
							</ul>
						</div>
						<div class="col-lg-3">
							<ul class="list-inline text-center">
								<li>
									<a href="#" class="btn border-teal text-teal btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-people"></i></a>
								</li>
								<li class="text-left">
									<div class="text-semibold">Jurusan</div>
										<div class="text-muted">
										<?php 
											$sql1="SELECT COUNT(*) as jumlah FROM master_unit";
											$stmt1=$koneksi->prepare($sql1);
											$stmt1->execute();
											$hasil1=$stmt1->fetch();
											echo $hasil1['jumlah'];
										?> Jurusan.
										</div>
								</li>
							</ul>
							<div class="col-lg-10 col-lg-offset-1">
							<div class="content-group" id="new-visitors"></div>
							</div>
						</div>
						<div class="col-lg-3">
							<ul class="list-inline text-center">
								<li>
									<a href="#" class="btn border-teal text-teal btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-book"></i></a>
								</li>
								<li class="text-left">
									<div class="text-semibold">Tugas Akhir</div>
										<div class="text-muted">
										<?php 
										$sql1="SELECT count(*) AS jumlah from master_upload_data";
										$stmt1=$koneksi->prepare($sql1);
										$stmt1->execute();
										$hasil1=$stmt1->fetch();
										echo $hasil1['jumlah'];
										?> Judul
									</div>
								</li>
							</ul>
							<div class="col-lg-10 col-lg-offset-1">
								<div class="content-group" id="new-visitors"></div>
							</div>
						</div>
						<div class="col-lg-3">
							<ul class="list-inline text-center">
								<li>
									<a href="#" class="btn border-warning-400 text-warning-400 btn-flat btn-rounded btn-icon btn-xs valign-text-bottom"><i class="icon-cash"></i></a>
								</li>
								<li class="text-left">
									<div class="text-semibold">User Account</div>
									<div class="text-muted">
										<?php 
										$sql1="SELECT count(*) AS jumlah from master_user";
										$stmt1=$koneksi->prepare($sql1);
										$stmt1->execute();
										$hasil1=$stmt1->fetch();
										echo $hasil1['jumlah'];
										?> Pengguna						
									</div>
								</li>
							</ul>
							<div class="col-lg-10 col-lg-offset-1">
								<div class="content-group" id="new-sessions"></div>
							</div>
						</div>
					</div>
				</div>		
			</div>
		</div>
	</div>
					

<script type="text/javascript">
	$(document).on('click', '#btndetail', function () { 
		var idbook=$(this).data('id');
		var oTable1 = $('#dataordernya').dataTable();
		oTable1.fnDestroy();
		oTable=$('#dataordernya').DataTable({
			dom: "frtip",
			"bRetrieve": true,
			"bProcessing": true,
			"bDestroy": true, 
			//"scrollY": "500px",
			autoWidth: false,
			"oLanguage": {
				"sSearch": "Search&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
			},				
			responsive: true,				
			'ajax':{
				"type"   : "GET",
				"url"    : './proses/ambildata.php',
				"data"   : {
					"kode" : "dataorder",
					"id" : idbook
				},		
				"dataSrc": ""
			},
			'columns': [
				{"data" : "code_book"},
				{"data" : "book_title"},
				{"data" : "tgl_input"},
				{"data" : "location"}
			],
			"columnDefs": [{
				"defaultContent": "-",
				"targets": "_all"
			}]			
		});
		$('#modal_theme_info').modal('show');
		return false;	
		
	});
	
$('.datatable-responsivetk').DataTable({
	dom: "rtip",
	"scrollY": "300px",
    autoWidth: false,
    responsive: true,	
});
$('.datatable-responsivet').DataTable({
	dom: "frtip",
	"scrollY": "300px",
	//dom: "Bflrtip",
    autoWidth: false,
    responsive: true,	
	"oLanguage": {
		"sSearch": "Search&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;"
	},	
    buttons: [
        {
            extend: "copy",
            className: "btn-sm"
        },
        {
            extend: "csv",
            className: "btn-sm"
        },
        {
            extend: "excel",
            className: "btn-sm"
        },
        {
            extend: "pdfHtml5",
            className: "btn-sm"
        },
        {
            extend: "print",
            className: "btn-sm"
        },
    ]
});

	
</script>					

