<?php


$host="localhost";
$user="root";
$pass="";
$db="bkd_akademik";

try {
    $koneksi = new PDO("mysql:host=".$host.";dbname=".$db."", $user, $pass);
   // echo "Connected to ".$db." at ".$host." successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database ".$db." :" . $pe->getMessage());
}

/*$hostc="localhost";
$userc="root";
$passc="";
$dbc="bkd_dosen";

try {
    $koneksicheers = new PDO("mysql:host=".$hostc.";dbname=".$dbc."", $userc, $passc);
    //echo "Connected to ".$dbc." at ".$hostc." successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database ".$dbc." :" . $pe->getMessage());
}*/

?>