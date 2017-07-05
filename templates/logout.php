<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 7/5/17
 * Time: 1:56 AM
 */


// inicia a sessão
session_start();

// muda o valor de logged_in para false
$_SESSION['logged_in'] = false;

// finaliza a sessão
session_destroy();

// retorna para a index.php
header("Location: ../index.php");#retorna para a tela main
