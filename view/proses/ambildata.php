<?php
error_reporting(0);
if (!isset($_SESSION)) {
	session_start();
}
include ("../config/conn.php");
if (isset($_GET["kode"]))
{
$kode=$_GET["kode"];
}
else
{
$kode=$_POST["kode"];
}
if ($kode=='cariMain')
{	
	$idtype=$_GET["id_e"];
	$sql = "SELECT id_main_e,id_e,name";
	$sql.=" FROM master_main_education where id_e='".$idtype."'";
	$stmt1 = $koneksi->prepare($sql);
	$stmt1->execute();
	$hasil='<option value="" selected>--Pilih Category--</option>';
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil=$hasil.'<option value="'.$arr2['id_main_e'].'">'.$arr2['name'].'</option>';	
	}
	echo $hasil;	
}

elseif ($kode=='cari_tanggal')
{	
	$bln=$_GET["tanggal"];
	$thn=$_GET["tahun"];
	$tglawal=$thn.'-'.$bln."-01";
	$sqltgl="select date_format(LAST_DAY(STR_TO_DATE('".$tglawal."','%Y-%m-%d')),'%d') as tglakhir from dual";

	$stmtgl= $koneksi->prepare($sqltgl);
	$stmtgl->execute();
	$hasiltgl=$stmtgl->fetch();
	$tglakhir=$hasiltgl['tglakhir'];
	$hasil='<option value="" selected>--Date--</option>';
	for ($x = 1; $x <= $tglakhir; $x++) {
		//Cek Tanggal Hari Sabtu/Minggu
		$tglnya=$thn.'-'.$bln.'-'.$x;
		$weekDay = date('w', strtotime($tglnya));

		if (($weekDay <> '0') && ($weekDay <> '6'))
		{
			//Bukan Sabtu/Minggu
			//Cek ke Academic Calendar
			$sqlkal="select count(*) as jml from calendar_academic where STR_TO_DATE('".$tglnya."','%Y-%m-%d') between 
			start_date and end_date and harilibur='1'";
			$stmtkal= $koneksi->prepare($sqlkal);
			$stmtkal->execute();
			$hasilkal=$stmtkal->fetch();
			$jmlkal=$hasilkal['jml'];			
			if ($jmlkal<=0)
			{
				$hasil=$hasil.'<option value="'.$x.'">'.$x.'</option>';	
			}
		}    		
	} 	
	echo $hasil;	
}
elseif ($kode=='dataevent')
{	
	$sql="select id_calendar_academic,start_date as start,end_date as end,title,note,CONCAT('#',color) as color from calendar_academic";
	//echo $sql;
	$stmt1 = $koneksi->prepare($sql);
	$stmt1->execute();
	$total=$stmt1 -> rowCount();
	if ($total>0)
	{
	$events = array();
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
             array_push($events,$arr2);
	}	
	echo json_encode($events);		
	}
}

elseif ($kode=='carisubclass')
{	
	$id=$_GET["idclass"];
	$sqlevel="SELECT id_master_subclass,subclass from master_subclass where id_master_class='".$id."'";
	$stmt1 = $koneksi->prepare($sqlevel);
	$stmt1->execute();
	$hasil='<option value="" selected>--Choose SubClass--</option>';
	//$hasil=$hasil.'<option value="0" selected>All</option>';
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil=$hasil.'<option value="'.$arr2['id_master_subclass'].'">'.$arr2['subclass'].'</option>';	
	}
	echo $hasil;	
}

elseif ($kode=='carijampelajaran')
{	
	$id=$_GET["harinya"];
	$idthn=$_GET["idthnajaran"];
	$idunit=$_GET["idunit"];
	$idkelas=$_GET["idkelas"];
	$idsubkelas=$_GET["idsubkelas"];
	$sql="SELECT count(*) as jml,jumlah_jam from master_jam_pelajaran where hari_aktif like('%".trim($id)."%') and 
	          id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."' and id_class='".$idkelas."' and
			  id_subclass='".$idsubkelas."' ";
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();		
	$result = $stmt -> fetch();	
	$jml=$result['jml'];
	$lstjam=array();
	if ($jml==0)
	{
		$sql="SELECT count(*) as jml,jumlah_jam from master_jam_pelajaran where hari_aktif like('%".trim($id)."%') and 
				  id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."' and id_class='".$idkelas."'";
		$stmt = $koneksi->prepare($sql);
		$stmt->execute();		
		$result = $stmt -> fetch();	
		$jml=$result['jml'];		
		if ($jml==0)
		{
			$sql="SELECT count(*) as jml,jumlah_jam from master_jam_pelajaran where hari_aktif like('%".trim($id)."%') and 
					  id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."'";
			$stmt = $koneksi->prepare($sql);
			$stmt->execute();		
			$result = $stmt -> fetch();	
			$jml=$result['jml'];					
			if ($jml==0)
			{				
				$sql="SELECT count(*) as jml,jumlah_jam from master_jam_pelajaran where hari_aktif like('%".trim($id)."%') and 
						  id_tahun_ajaran='".$idthn."'";
				$stmt = $koneksi->prepare($sql);
				$stmt->execute();		
				$result = $stmt -> fetch();	
				$jml=$result['jml'];					
				if ($jml==0)	
				{
					$jmljam=0;	
				}
				else
				{
					$jmljam=$result['jumlah_jam'];	
				}
			}
			else
			{
				$jmljam=$result['jumlah_jam'];	
			}
		}
		else
		{
			$jmljam=$result['jumlah_jam'];			
		}
	}
	else
	{
		$jmljam=$result['jumlah_jam'];	
	}
	
	
	
	//Jam Pelajaran
	$sql="SELECT count(*) as jml,jam_pelajaran from jadwal_teori where hari like('%".trim($id)."%') and 
	          id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."' and id_class='".$idkelas."' and
			  id_master_subclass='".$idsubkelas."'";	  
	$stmt = $koneksi->prepare($sql);
	$stmt->execute();		
	$result = $stmt -> fetch();	
	$jml=$result['jml'];
	$lstjam=array();
	if ($jml==0)
	{
		$sql="SELECT count(*) as jml,jam_pelajaran from jadwal_teori where hari like('%".trim($id)."%') and 
				id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."' and id_class='".$idkelas."'";	  				  
		$stmt = $koneksi->prepare($sql);
		$stmt->execute();		
		$result = $stmt -> fetch();	
		$jml=$result['jml'];		
		if ($jml==0)
		{
			$sql="SELECT count(*) as jml,jam_pelajaran from jadwal_teori where hari like('%".trim($id)."%') and 
					id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."'";	  						  
			$stmt = $koneksi->prepare($sql);
			$stmt->execute();		
			$result = $stmt -> fetch();	
			$jml=$result['jml'];					
			if ($jml==0)
			{				
				$sql="SELECT count(*) as jml,jam_pelajaran from jadwal_teori where hari like('%".trim($id)."%') and 
					id_tahun_ajaran='".$idthn."'";	  							  
				$stmt = $koneksi->prepare($sql);
				$stmt->execute();		
				$result = $stmt -> fetch();	
				$jml=$result['jml'];					
				if ($jml==0)	
				{
					$jampelajaran='';
				}
				else
				{
					$sql="SELECT jam_pelajaran from jadwal_teori order by jam_pelajaran where hari like('%".trim($id)."%') and 
							  id_tahun_ajaran='".$idthn."'";	  
					$stmt = $koneksi->prepare($sql);
					$stmt->execute();				
					while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
						$jampelajaran=$arr2['jam_pelajaran'];
						if (strpos($jampelajaran, ',') !== false) {
							$xjam=explode(",",$jampelajaran);
							foreach ($xjam as $itemjam) {
								array_push($lstjam,$itemjam);
							}	
						}	
						else
						{
							array_push($lstjam,$jampelajaran);
						}			
					}				
				}
			}
			else
			{
				
				$sql="SELECT jam_pelajaran from jadwal_teori where hari like('%".trim($id)."%') and 
						  id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."'";	  
				$stmt = $koneksi->prepare($sql);
				$stmt->execute();				
				while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
					$jampelajaran=$arr2['jam_pelajaran'];
					if (strpos($jampelajaran, ',') !== false) {
						$xjam=explode(",",$jampelajaran);
						foreach ($xjam as $itemjam) {
							array_push($lstjam,$itemjam);
						}	
					}	
					else
					{
						array_push($lstjam,$jampelajaran);
					}			
				}				

			}
		}
		else
		{
			$sql="SELECT jam_pelajaran from jadwal_teori where hari like('%".trim($id)."%') and 
					  id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."' and id_class='".$idkelas."'";	  
			$stmt = $koneksi->prepare($sql);
			$stmt->execute();				
			while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
				$jampelajaran=$arr2['jam_pelajaran'];
				if (strpos($jampelajaran, ',') !== false) {
					$xjam=explode(",",$jampelajaran);
					foreach ($xjam as $itemjam) {
						array_push($lstjam,$itemjam);
					}	
				}	
				else
				{
					array_push($lstjam,$jampelajaran);
				}			
			}				
		}
	}
	else
	{
		$sql="SELECT jam_pelajaran from jadwal_teori where hari like('%".trim($id)."%') and 
				  id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."' and id_class='".$idkelas."' and
				  id_master_subclass='".$idsubkelas."'";	  
		$stmt = $koneksi->prepare($sql);
		$stmt->execute();				
		while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$jampelajaran=$arr2['jam_pelajaran'];
			if (strpos($jampelajaran, ',') !== false) {
				$xjam=explode(",",$jampelajaran);
				foreach ($xjam as $itemjam) {
					array_push($lstjam,$itemjam);
				}				
			}	
			else
			{
				array_push($lstjam,$jampelajaran);
			}			
		}				
	}

	
	
	//Jam Istirahat
	$sqlis="SELECT count(*) as jml,jam_pelajaran from master_jam_istirahat where hari_aktif like('%".trim($id)."%') and 
	          id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."' and id_class='".$idkelas."' and
			  id_subclass='".$idsubkelas."' ";
	$stmt = $koneksi->prepare($sqlis);
	$stmt->execute();		
	$result = $stmt -> fetch();	
	$jml=$result['jml'];
	if ($jml==0)
	{
		$sqlis="SELECT count(*) as jml,jam_pelajaran from master_jam_istirahat where hari_aktif like('%".trim($id)."%') and 
				  id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."' and id_class='".$idkelas."'";
		$stmt = $koneksi->prepare($sqlis);
		$stmt->execute();		
		$result = $stmt -> fetch();	
		$jml=$result['jml'];		
		if ($jml==0)
		{
			$sqlis="SELECT count(*) as jml,jam_pelajaran from master_jam_istirahat where hari_aktif like('%".trim($id)."%') and 
					  id_tahun_ajaran='".$idthn."' and	id_unit='".$idunit."'";
			$stmt = $koneksi->prepare($sqlis);
			$stmt->execute();		
			$result = $stmt -> fetch();	
			$jml=$result['jml'];					
			if ($jml==0)
			{				
				$sqlis="SELECT count(*) as jml,jam_pelajaran from master_jam_istirahat where hari_aktif like('%".trim($id)."%') and 
						  id_tahun_ajaran='".$idthn."'";
				$stmt = $koneksi->prepare($sqlis);
				$stmt->execute();		
				$result = $stmt -> fetch();	
				$jml=$result['jml'];					
				if ($jml==0)	
				{
					$jmlist=0;	
				}
				else
				{
					$jmlist=$result['jam_pelajaran'];	
				}
			}
			else
			{
				$jmlist=$result['jam_pelajaran'];	
			}
		}
		else
		{
			$jmlist=$result['jam_pelajaran'];			
		}
	}
	else
	{
		$jmlist=$result['jam_pelajaran'];	
	}
	array_push($lstjam,$jmlist);

	$xx=1;
   	while($xx <= $jmljam) 
	{
		if( !in_array($xx,$lstjam ) )
		{
			$hasil=$hasil.'<option value="'.$xx.'">'.$xx.'</option>';	
		}		
		$xx++;		
	}
	echo $hasil;	
}


elseif ($kode=='carikelas')
{	
	if (isset($_GET["kelas"]))
	{ $id=$_GET["kelas"];}
	else {$id=$_GET["prodi"];}
	$sqlevel="SELECT id_master_class,class from master_class where id_master_unit='".$id."'";
	
	$stmt1 = $koneksi->prepare($sqlevel);
	$stmt1->execute();
	$hasil='<option value="" selected>--Pilih Kelas--</option>';	
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil=$hasil.'<option value="'.$arr2['id_master_class'].'">'.$arr2['class'].'</option>';	
	}
	echo $hasil;	
}
elseif ($kode=='carisiswa')
{	
	if (isset($_GET["nama"]))
	{ $id=$_GET["nama"];}
	else {$id=$_GET["kelas"];}
	$sqlevel="SELECT id_mahasiswa,nim,nama_mahasiswa from master_mahasiswa where id_class='".$id."'";
	
	$stmt1 = $koneksi->prepare($sqlevel);
	$stmt1->execute();
	$hasil='<option value="" selected>--Pilih Mahasiswa--</option>';
    //$hasil=$hasil.'<option value="0" selected>All</option>';	
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil=$hasil.'<option value="'.$arr2['id_mahasiswa'].'">'.$arr2['nim'].'  ==  '.$arr2['nama_mahasiswa'].'</option>';	
	}
	echo $hasil;	
}

elseif ($kode=='carimk')
{	
	if (isset($_GET["idsubject"]))
	{ $id=$_GET["idsubject"];}
	else {$id=$_GET["idclass"];}
	$sqlevel="SELECT id_subject,subject,pelajaran,kurikulum from master_subject where id_class='".$id."' AND active='1'";
	
	$stmt1 = $koneksi->prepare($sqlevel);
	$stmt1->execute();
	$hasil='<option value="" selected>--Pilih matakuliah--</option>';
    //$hasil=$hasil.'<option value="0" selected>All</option>';	
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil=$hasil.'<option value="'.$arr2['id_subject'].'">'.$arr2['pelajaran'].'  --  '.$arr2['subject'].'</option>';	
	}
	echo $hasil;	
}

elseif ($kode=='caripel')
{	
	if (isset($_GET["idsubject"]))
	{ $id=$_GET["idsubject"];}
	else {$id=$_GET["kurikulum"];}
	$sqlevel="SELECT id_subject,pelajaran,subject,kurikulum from master_subject where kurikulum='".$id."' AND id_class";
	
	$stmt1 = $koneksi->prepare($sqlevel);
	$stmt1->execute();
	$hasil='<option value="" selected>--Pilih matakuliah--</option>';
    //$hasil=$hasil.'<option value="0" selected>All</option>';	
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil=$hasil.'<option value="'.$arr2['id_subject'].'">'.$arr2['pelajaran'].'  --  '.$arr2['subject'].'</option>';	
	}
	echo $hasil;	
}
elseif ($kode=='carikam')
{	
	if (isset($_GET["idsubject"]))
	{ $id=$_GET["idsubject"];}
	else {$id=$_GET["kurikulum"];}
	$sqlevel="SELECT id_subject,pelajaran,subject,kurikulum from master_subject_praktikum where kurikulum='".$id."' AND id_class";
	
	$stmt1 = $koneksi->prepare($sqlevel);
	$stmt1->execute();
	$hasil='<option value="" selected>--Pilih matakuliah--</option>';
    //$hasil=$hasil.'<option value="0" selected>All</option>';	
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil2=$hasil2.'<option value="'.$arr2['id_subject'].'">'.$arr2['pelajaran'].'  --  '.$arr2['subject'].'</option>';	
	}
	echo $hasil2;	
}
elseif ($kode=='carikul')
{	
	if (isset($_GET["idsubject"]))
	{ $id=$_GET["idsubject"];}
	else {$id=$_GET["idsubclass"];}
	$sqlevel="SELECT id_subject,subject,pelajaran,kurikulum from master_subject_praktikum where id_master_subclass='".$id."' AND active='1'";
	
	$stmt1 = $koneksi->prepare($sqlevel);
	$stmt1->execute();
	$hasil='<option value="" selected>--Pilih matakuliah--</option>';
    //$hasil=$hasil.'<option value="0" selected>All</option>';	
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil2=$hasil2.'<option value="'.$arr2['id_subject'].'">'.$arr2['pelajaran'].'  --  '.$arr2['subject'].'</option>';	
	}
	echo $hasil2;	
}



elseif ($kode=='cariruang')
{	
	if (isset($_GET["idlab"]))
	{ $id=$_GET["idlab"];}
	else {$id=$_GET["idunit"];}
	$sqlevel="SELECT id_lab,no_ruang from master_lab where id_master_unit='".$id."'";
	
	$stmt1 = $koneksi->prepare($sqlevel);
	$stmt1->execute();
	$hasil='<option value="" selected>--Pilih Ruang--</option>';
    //$hasil=$hasil.'<option value="0" selected>All</option>';	
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil=$hasil.'<option value="'.$arr2['id_lab'].'">'.$arr2['no_ruang'].'</option>';	
	}
	echo $hasil;	
}
elseif ($kode=='carisubjectclass')
{	
	if (isset($_GET["idclass"]))
	{ $id=$_GET["idclass"];}
	else {$id=$_GET["idunit"];}
	$sqlevel="SELECT id_subject,subject from master_subject where (id_class='".$id."' or id_class='0')";
	echo $sqlevel;
	$stmt1 = $koneksi->prepare($sqlevel);
	$stmt1->execute();
	$hasil='<option value="" selected>--Choose Subject--</option>';
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil=$hasil.'<option value="'.$arr2['id_subject'].'">'.$arr2['subject'].'</option>';	
	}
	echo $hasil;	
}
elseif ($kode=='carisubjectsubclass')
{	
    $id=$_GET["idclass"];
	$idsub=$_GET["idsubclass"];

	$sqlevel="SELECT id_subject,subject from master_subject where id_class='".$id."' and id_subclass='".$idsub."'";
	echo $sqlevel;
	$stmt1 = $koneksi->prepare($sqlevel);
	$stmt1->execute();
	$hasil='<option value="" selected>--Choose Subject--</option>';
	while ($arr2 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
	$hasil=$hasil.'<option value="'.$arr2['id_subject'].'">'.$arr2['subject'].'</option>';	
	}
	echo $hasil;	
}

elseif($kode=='carimingguaktif')
{
	$idthn=$_GET["idthnajaran"];
	$idunit=$_GET["idunit"];
	$idkelas=$_GET["classnya"];
	$subkelas=$_GET["subclass"];
	
	$sqlsch="select distinct(minggu) as minggu from jadwal_praktikum where id_tahun_ajaran='".$idthn."' 
			 and (id_unit='".$idunit."' or id_unit='0') and (id_class='".$idkelas."' or id_class='0') and ( id_master_subclass='".$subkelas."' or id_master_subclass='0')" ;
	//echo $sqlsch;
	$stmt = $koneksi->prepare($sqlsch);
	$stmt->execute();
	$total=$stmt -> rowCount();
	if ($total>0)
	{
	$items = array();
	while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
		array_push($items, $arr2);
	}	
	$result = $items;		
	echo json_encode($result);		
	}
	else
	{
	$myData = array('data' =>'');
	echo json_encode($myData);
	}
}

elseif($kode=='carihariaktif')
{
	$idthn=$_GET["idthnajaran"];
	$idunit=$_GET["idunit"];
	$idkelas=$_GET["classnya"];
	$subkelas=$_GET["subclass"];
	
	$sqlsch="select distinct(hari) as hari from jadwal_teori where id_tahun_ajaran='".$idthn."' 
			 and (id_unit='".$idunit."' or id_unit='0') and (id_class='".$idkelas."' or id_class='0') and ( id_master_subclass='".$subkelas."' or id_master_subclass='0')" ;
	//echo $sqlsch;
	$stmt = $koneksi->prepare($sqlsch);
	$stmt->execute();
	$total=$stmt -> rowCount();
	if ($total>0)
	{
	$items = array();
	while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
		array_push($items, $arr2);
	}	
	$result = $items;		
	echo json_encode($result);		
	}
	else
	{
	$myData = array('data' =>'');
	echo json_encode($myData);
	}
}
elseif($kode=='carijadwalpraktikum')
{
	$idthn=$_GET["idthnajaran"];
	$idunit=$_GET["idunit"];
	$idkelas=$_GET["classnya"];
	$subkelas=$_GET["subclass"];
	
	$sqlsch="select distinct(minggu) as minggu from jadwal_praktikum where id_tahun_ajaran='".$idthn."' 
			 and (id_unit='".$idunit."' or id_unit='0') and (id_class='".$idkelas."' or id_class='0') 
			 and ( id_master_subclass='".$subkelas."' or id_master_subclass='0')" ;
	//echo $sqlsch;
	$stmt = $koneksi->prepare($sqlsch);
	$stmt->execute();
	$mingguarraynya = array();
	while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
		array_push($mingguarraynya, $arr2['minggu']);
	}
	
	$sqlsch="select distinct(jam_pelajaran) as jam_pelajaran from jadwal_praktikum where id_tahun_ajaran='".$idthn."' 
			 and (id_unit='".$idunit."' or id_unit='0') and (id_class='".$idkelas."' or id_class='0') 
			 and ( id_master_subclass='".$subkelas."' or id_master_subclass='0')";
	$stmt1 = $koneksi->prepare($sqlsch);
	$stmt1->execute();
	while ($hasil = $stmt1->fetch(PDO::FETCH_ASSOC)) 
	{
		$jampel=$hasil['jam_pelajaran'];
		//$nmx='';
		$sqlist="select tgl_mulai,tgl_selesai from jadwal_praktikum where id_tahun_ajaran='".$idthn."' 
				 and (id_unit='".$idunit."' or id_unit='0') and (id_class='".$idkelas."' or id_class='0') 
				 and ( id_master_subclass='".$subkelas."' or id_master_subclass='0') and jam_pelajaran='".$jampel."'";
		$stmtsqlist = $koneksi->prepare($sqlist);
		$stmtsqlist->execute();
		$hasilsqlist=$stmtsqlist->fetch();
		$startdate= $hasilsqlist['tgl_mulai'];	
		$endtdate= $hasilsqlist['tgl_selesai'];
		$dtist='';
		foreach ($mingguarraynya as $itemnya) {			
			
			//Cek Jadwal Tiap Jam Pelajaran
			$sqlist1="select count(*) as jml,minggu,jam_pelajaran,jumlah_jam,id_karyawan,
					 IF(id_subject='0',kegiatan,(select subject from master_subject_praktikum 
					 where master_subject_praktikum.id_subject=jadwal_praktikum.id_subject)) as kegiatan,karyawan,
					 (SELECT nama_tahun_ajaran from master_tahun_ajaran where master_tahun_ajaran.id_tahun_ajaran=jadwal_praktikum.id_tahun_ajaran) as tahun,
					 (SELECT unit from master_unit where master_unit.id_master_unit=jadwal_praktikum.id_unit)as unit, 
					 (SELECT class from master_class where master_class.id_master_class=jadwal_praktikum.id_class)as class, 
					 (SELECT subclass from master_subclass where master_subclass.id_master_subclass=jadwal_praktikum.id_master_subclass) as subclass
					 from jadwal_praktikum
					 where jam_pelajaran like ('%".$jampel."%') and minggu like('%".trim($itemnya)."%')
					 and id_tahun_ajaran='".$idthn."' 
					 and (id_unit='".$idunit."' or id_unit='0') and (id_class='".$idkelas."' or id_class='0') 
					 and ( id_master_subclass='".$subkelas."' or id_master_subclass='0')";			 
			//,IF(id_karyawan='0',karyawan,(select nama from    c0110111_karyawan.data_karyawan where c0110111_karyawan.data_karyawan.id_karyawan=class_schedule.id_karyawan)) as karyawan
			//echo $sqlist1;
			$stmtsqlist1 = $koneksi->prepare($sqlist1);
			$stmtsqlist1->execute();
			$hasilsqlist1=$stmtsqlist1->fetch();
			$jmlnya1=$hasilsqlist1['jml'];
			$jampelajaran=$hasilsqlist1['jam_pelajaran'];
			$jmljam=$hasilsqlist1['jumlah_jam'];
			$kegiatan=$hasilsqlist1['kegiatan'];
			$idkaryawan=$hasilsqlist1['id_karyawan'];
			
			$tahun=$hasilsqlist1['tahun'];
			$unit=$hasilsqlist1['unit'];
			$class=$hasilsqlist1['class'];
			$subclass=$hasilsqlist1['subclass'];
			$jmlmenitnya=(60*$jmljam);
			$rowCount1 = $stmtsqlist1->fetchColumn(0);

			if ($idkaryawan=='0')
			{
				$karyawan=$hasilsqlist1['karyawan'];
			}
			else
			{
				$nmkar='';
				//$karyawan=$hasilsqlist1['karyawan'];
				$kar=(explode(",",$idkaryawan));
				$arrlength = count($kar);
				for($xy = 0; $xy < $arrlength; $xy++) {
							$sqlnmkar="select nama from bkd_akademik.master_dosen where bkd_akademik.master_dosen.id_karyawan='".$kar[$xy]."'";
					//echo $sqlnmkar;
					$stmtnmkar = $koneksi->prepare($sqlnmkar);
					$stmtnmkar->execute();
					$hasilnmkar=$stmtnmkar->fetch();
					if ($nmkar=='') {$nmkar=$nmkar.''.$hasilnmkar['nama'];}
					else {$nmkar=$nmkar.','.$hasilnmkar['nama'];}
				}
				$karyawan=$nmkar;
				//echo $karyawan;
				//echo "<br>";
			}
		$dtist=$dtist.'<td><b>'.$kegiatan.'</b><br>'.$karyawan.'</td>';
									
	
		}
$nmx=$nmx.'<tr><td>'.$startdate.'  s/d  '.$endtdate.'</td>'.$dtist.'</tr>';
			
	}
	echo $nmx;		
}
elseif($kode=='carijadwal')
{
	$idthn=$_GET["idthnajaran"];
	$idunit=$_GET["idunit"];
	$idkelas=$_GET["classnya"];
	$subkelas=$_GET["subclass"];
	
	$sqlsch="select distinct(hari) as hari from jadwal_teori where id_tahun_ajaran='".$idthn."' 
			 and (id_unit='".$idunit."' or id_unit='0') and (id_class='".$idkelas."' or id_class='0') 
			 and ( id_master_subclass='".$subkelas."' or id_master_subclass='0')" ;
	//echo $sqlsch;
	$stmt = $koneksi->prepare($sqlsch);
	$stmt->execute();
	$hariarraynya = array();
	while ($arr2 = $stmt->fetch(PDO::FETCH_ASSOC)) {
		array_push($hariarraynya, $arr2['hari']);
	}
	
	$sqlsch="select distinct(jam_pelajaran) as jam_pelajaran from jadwal_teori where id_tahun_ajaran='".$idthn."' 
			 and (id_unit='".$idunit."' or id_unit='0') and (id_class='".$idkelas."' or id_class='0') 
			 and ( id_master_subclass='".$subkelas."' or id_master_subclass='0')";
	$stmt1 = $koneksi->prepare($sqlsch);
	$stmt1->execute();
	while ($hasil = $stmt1->fetch(PDO::FETCH_ASSOC)) 
	{
		$jampel=$hasil['jam_pelajaran'];
		//$nmx='';
		$sqlist="select jam_mulai,jam_selesai from jadwal_teori where id_tahun_ajaran='".$idthn."' 
				 and (id_unit='".$idunit."' or id_unit='0') and (id_class='".$idkelas."' or id_class='0') 
				 and ( id_master_subclass='".$subkelas."' or id_master_subclass='0') and jam_pelajaran='".$jampel."'";
		$stmtsqlist = $koneksi->prepare($sqlist);
		$stmtsqlist->execute();
		$hasilsqlist=$stmtsqlist->fetch();
		$jamulai=$hasilsqlist['jam_mulai'];
		$jamselesai=$hasilsqlist['jam_selesai'];
		$dtist='';
		foreach ($hariarraynya as $itemnya) {			
			
			//Cek Jadwal Tiap Jam Pelajaran
			$sqlist1="select count(*) as jml,hari,jam_pelajaran,jumlah_jam,id_karyawan,
					 IF(id_subject='0',kegiatan,(select subject from master_subject 
					 where master_subject.id_subject=jadwal_teori.id_subject)) as kegiatan,karyawan,
					 (SELECT nama_tahun_ajaran from master_tahun_ajaran where master_tahun_ajaran.id_tahun_ajaran=jadwal_teori.id_tahun_ajaran) as tahun,
					 (SELECT unit from master_unit where master_unit.id_master_unit=jadwal_teori.id_unit)as unit, 
					 (SELECT class from master_class where master_class.id_master_class=jadwal_teori.id_class)as class, 
					 (SELECT subclass from master_subclass where master_subclass.id_master_subclass=jadwal_teori.id_master_subclass) as subclass
					 from jadwal_teori
					 where jam_pelajaran like ('%".$jampel."%') and hari like('%".trim($itemnya)."%')
					 and id_tahun_ajaran='".$idthn."' 
					 and (id_unit='".$idunit."' or id_unit='0') and (id_class='".$idkelas."' or id_class='0') 
					 and ( id_master_subclass='".$subkelas."' or id_master_subclass='0')";			 
			//,IF(id_karyawan='0',karyawan,(select nama from    c0110111_karyawan.data_karyawan where c0110111_karyawan.data_karyawan.id_karyawan=class_schedule.id_karyawan)) as karyawan
			//echo $sqlist1;
			$stmtsqlist1 = $koneksi->prepare($sqlist1);
			$stmtsqlist1->execute();
			$hasilsqlist1=$stmtsqlist1->fetch();
			$jmlnya1=$hasilsqlist1['jml'];
			$jampelajaran=$hasilsqlist1['jam_pelajaran'];
			$jmljam=$hasilsqlist1['jumlah_jam'];
			$kegiatan=$hasilsqlist1['kegiatan'];
			$idkaryawan=$hasilsqlist1['id_karyawan'];
			
			$tahun=$hasilsqlist1['tahun'];
			$unit=$hasilsqlist1['unit'];
			$class=$hasilsqlist1['class'];
			$subclass=$hasilsqlist1['subclass'];
			$jmlmenitnya=(60*$jmljam);
			$rowCount1 = $stmtsqlist1->fetchColumn(0);

			if ($idkaryawan=='0')
			{
				$karyawan=$hasilsqlist1['karyawan'];
			}
			else
			{
				$nmkar='';
				//$karyawan=$hasilsqlist1['karyawan'];
				$kar=(explode(",",$idkaryawan));
				$arrlength = count($kar);
				for($xy = 0; $xy < $arrlength; $xy++) {
							$sqlnmkar="select nama from bkd_akademik.master_dosen where bkd_akademik.master_dosen.id_karyawan='".$kar[$xy]."'";
					//echo $sqlnmkar;
					$stmtnmkar = $koneksi->prepare($sqlnmkar);
					$stmtnmkar->execute();
					$hasilnmkar=$stmtnmkar->fetch();
					if ($nmkar=='') {$nmkar=$nmkar.''.$hasilnmkar['nama'];}
					else {$nmkar=$nmkar.','.$hasilnmkar['nama'];}
				}
				$karyawan=$nmkar;
				//echo $karyawan;
				//echo "<br>";
			}
		$dtist=$dtist.'<td><b>'.$kegiatan.'</b><br>'.$karyawan.'</td>';
									
	
		}
$nmx=$nmx.'<tr><td>'.$jamulai.'  s/d  '.$jamselesai.'</td>'.$dtist.'</tr>';
			
	}
	echo $nmx;		
}
//cari dosen

?>