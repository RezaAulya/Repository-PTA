<?php

$host="localhost";
$user="root";
$pass="";
$db="bkd_akademik";

try {
    $koneksi = new PDO("mysql:host=".$host.";dbname=".$db."", $user, $pass);
} catch (PDOException $pe) {
    die("Could not connect to the database ".$db." :" . $pe->getMessage());
}

// Include the main TCPDF library (search for installation path)
  require_once('../assets/tcpdf/tcpdf.php');
//  $conn = mysqli_connect('localhost',"ahdmuhajir","Dhoc71%1","myijazah");
 // $conn = mysqli_connect('localhost',"root","","validasi_ijazah");
  
// QUERY Here [get data app] !!
  $query = "SELECT id_nama,(SELECT angkatan from master_angkatan WHERE id_angkatan=master_upload_data.id_angkatan ) as angkatan , (SELECT unit from master_unit WHERE id_master_unit=master_upload_data.id_unit) as prodi, judul_tugas, data from master_upload_data limit 8";

  $stmt = $koneksi->prepare($query);
  $stmt->execute();



// create new PDF document
$pdf = new TCPDF('portrait', PDF_UNIT, 'A4', true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Fahrul Razi');
$pdf->SetTitle('Repository');
$pdf->SetSubject('Repository');
$pdf->SetKeywords('Repository');

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font

$pdf->SetFont('helvetica', 'B', 11.5);
$pdf->AddFont('timesBI');

// add a page
$pdf->AddPage();

$pdf->SetFont('helvetica', 'B', 11.5);

// set style for barcode
$style = array(
  'border' => false,
  'vpadding' => 'auto',
  'hpadding' => 'auto',
  'fgcolor' => array(0,0,0),
  'bgcolor' => false, //array(255,255,255)
  'module_width' => 1, // width of a single module in points
  'module_height' => 1 // height of a single module in points
);

$pdf->setXY(10,10);
$html = '<table cellspacing="0" cellpadding="3" border="0">';
 

 for ($x=5; $x <250 ; $x+=32) { 
  if ($x>100) {
    $x+=2;
  }
  //qr here
  $i= $stmt->fetch(PDO::FETCH_ASSOC);
  $pdf->write2DBarcode('https://imukal.com/fahrul/'.$i['data'], 'QRCODE,H', 150, $x, 30, 30, $style, 'Q');

  $html .= '
    <tr>
        <td>NAMA </td>
        <td>: '.$i['id_nama'].'</td>
    </tr>
  <tr>
        <td>ANGKATAN </td>
        <td>: '.$i['angkatan'].'</td>
    </tr>
  <tr>
        <td>PRODI </td>
        <td>: '.$i['prodi'].'</td>
    </tr>
  <tr>
        <td>JUDUL TUGAS AKHIR </td>
        <td>: '.$i['judul_tugas'].'</td>
    </tr>
  <tr>
    <td border="0" colspan="2"><hr></td>
  </tr>
    ';
  }   
$html .='</table>';

/*$pdf->write2DBarcode('https://imukal.com/fahrul/upload/data.pdf', 'QRCODE,H', 150, 10, 30, 30, $style, 'Q');
$pdf->write2DBarcode('https://imukal.com/fahrul/upload/data.pdf', 'QRCODE,H', 150, 42, 30, 30, $style, 'Q');
$pdf->write2DBarcode('https://imukal.com/fahrul/upload/data.pdf', 'QRCODE,H', 150, 76, 30, 30, $style, 'Q');
$pdf->write2DBarcode('https://imukal.com/fahrul/upload/data.pdf', 'QRCODE,H', 150, 110, 30, 30, $style, 'Q');
$pdf->write2DBarcode('https://imukal.com/fahrul/upload/data.pdf', 'QRCODE,H', 150, 144, 30, 30, $style, 'Q');
$pdf->write2DBarcode('https://imukal.com/fahrul/upload/data.pdf', 'QRCODE,H', 150, 178, 30, 30, $style, 'Q');
$pdf->write2DBarcode('https://imukal.com/fahrul/upload/data.pdf', 'QRCODE,H', 150, 212, 30, 30, $style, 'Q');
$pdf->write2DBarcode('https://imukal.com/fahrul/upload/data.pdf', 'QRCODE,H', 150, 244, 30, 30, $style, 'Q');
*/// output the HTML content

$pdf->writeHTML($html, true, true, 0, true, '');

//Close and output PDF document
$pdf->Output('Repository'.'pdf', 'I');