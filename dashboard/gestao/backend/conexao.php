<?php
$hostname = "193.203.175.99";
$database = "u789700470_idpb";
$username = "u789700470_chris";
$password = 'vGT{R_A^-E+4';

try {
    $pdo = new PDO("mysql:host=$hostname;dbname=$database", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log($e->getMessage());
} 

