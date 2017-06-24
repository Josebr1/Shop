<?php
/*Declaração de variáveis*/
$servidor = "localhost";
$bancoDados = "appshop";
$usuario = "root";
$senha = "";
$conexao = null;
/*Fim da declaração*/
/*Conexão*/
try {
    $conexao = new PDO("mysql:host=$servidor;dbname=$bancoDados", $usuario, $senha);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    echo "<script language='javascript' type='text/javascript'>alert('Esse login já existe');</script>";
}
/*Fim da conexão*/
?>