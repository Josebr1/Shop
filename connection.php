<?php

$host = "localhost";
$name_data_base = "appshop";
$user = "root";
$password = "";
$connection = null;

try {
    $connection = new PDO("mysql:host=$host;dbname=$name_data_base", $user, $password);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    echo "<script language='javascript' type='text/javascript'>alert('Esse login já existe');</script>";
}
