<?php 

$host = "127.0.0.1";
$uname = "root";
$paswd = "";
$db_name = "perpus";

$dbh =null;

try {
    $dbh = new PDO("mysql:host=$host;dbname=$db_name", $uname, $paswd);
}
catch(PDOException $e)
{
   echo $e->getMessage();
}
?>