<?php
$hostname = "108.167.151.34";
$database = "evolud85_idpb";
$username = "evolud85_chris";
$password = 'vGT{R_A^-E+4';
try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage());
} 

