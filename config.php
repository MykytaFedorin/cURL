<?php
    require_once("loadDotenv.php");
include("exceptions/PDOConnectionFailedException.php");
    try{
        $pdo = new PDO('mysql:host=mysql; dbname=subjects', $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);
    }
    catch(PDOException $e){
         throw new PDOConnectionFailedException($e->getMessage());
    }
?>
