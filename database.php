<?php
 session_start();
 ob_start();
 session_regenerate_id();

$servername = "lrgs.ftsm.ukm.my";
$username = "a174856";
$password = "giantredsnake";
$dbname = "a174856";
 

try {
    $db = new PDO('mysql:host='.$servername.';dbname='.$dbname, $username, $password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo $e->getMessage();
    exit();
}

?>