<?php


function db_connect()
{
    try {
        $host = "localhost";
        $name_data_base = "appshop";
        $user = "root";
        $password = "";
        $PDO = null;

        $PDO = new PDO('mysql:host=' . $host . ';dbname=' . $name_data_base . ';charset=utf8', $user, $password);

        return $PDO;
    } catch (PDOException $e) {
        echo "Erro: " . $e->getMessage();
        echo "<script language='javascript' type='text/javascript'>alert('Esse login já existe');</script>";
        return null;
    }
}


function make_hash($str)
{
    return sha1(md5($str));
}

function isLoggedIn()
{
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true)
    {
        return false;
    }

    return true;
}
