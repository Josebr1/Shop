<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="shortcut icon" href="../images/icon-panel-login.png" type="image/x-icon" />
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/style.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>

<?php
session_start();
if(!isset($_SESSION["usuario"])){
    header("Location:../index.php");#retorna para a tela main
} 
?>

<div class="page-flexbox-wrapper">
<header>
    <ul id="dropdown1" class="dropdown-content">
        <li><a href="../index.php" ">Sair</a></li>
    </ul>
    <nav class="nav-extended grey darken-3">
        <div class="nav-content" style="margin-left: 20px;">
            <a href="dashboard.php" class="nav-title">AppShop</a>
            <ul class="right hide-on-med-and-down">
                <li><a class="dropdown-button " href="#!" data-activates="dropdown1"><i class="material-icons left">more_vert</i></a>
            </ul>
        </div>
    </nav>
</header>
<main>
    <div class="row">
        <div class="col s12 m4 l3">

            <div class="collection">
                <a href="dashboard.php" class="amber-text text-darken-3 collection-item">Home</a>
                <a href="list-category.php" class="amber-text text-darken-3 collection-item">Categoria</a>
                <a href="list-products.php" class="amber-text text-darken-3 collection-item">Produto</a>
                <a href="sales.php" class="amber-text text-darken-3 collection-item">Vendas</a>
                <a href="sales-all.php" class="amber-text text-darken-3 collection-item">Todas as vendas</a>
                <a href="best-customers.php" class="amber-text text-darken-3 collection-item">Melhores Clientes</a>
            </div>

        </div>

        <div class="col s12 m8 l9"> <!-- Note that "m8 l9" was added -->
            <div class="row">
                <div class="col s6">
                    <div class="row">
                        <div class="col s12">
                            <div class="card blue-grey darken-1">
                                <div class="card-content white-text">
                                    <span class="card-title">
                                        <i class="medium material-icons">trending_up</i> Total Vendas mês</span>
                                    <h1 align="center"><?php

                                        require_once '../vendor/autoload.php';
                                        $headers = array();
                                        $response = Unirest\Request::get('http://localhost:8000/order/sale/month', $headers = array(), $parameters = null);

                                        $json = json_decode($response->raw_body);

                                        if ($json == null) {
                                            echo "0";
                                        } else {
                                            foreach ($json as $e) {
                                                echo $e->count;
                                            }
                                        }

                                        ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col s6">
                    <div class="row">
                        <div class="col s12">
                            <div class="card blue-grey darken-1">
                                <div class="card-content white-text">
                                    <span class="card-title">
                                        <i class="medium material-icons">trending_up</i>Total vendas dia
                                    </span>
                                    <h1 align="center"><?php

                                        require_once '../vendor/autoload.php';
                                        $headers = array();
                                        $response = Unirest\Request::get('http://localhost:8000/order/sale/day', $headers = array(), $parameters = null);

                                        $json = json_decode($response->raw_body);

                                        if ($json == null) {
                                            echo "0";
                                        } else {
                                            foreach ($json as $e) {
                                                echo $e->count;
                                            }
                                        }

                                        ?></h1>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<footer class="page-footer amber darken-3" style="margin-bottom: 0">
    <div class="container">
        <div class="row">
            <div class="col l6 s12">
                <h5 class="white-text">AppShop</h5>
                <p class="grey-text text-lighten-4"></p>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <div class="container">
            © 2017 Copyright
        </div>
    </div>
</footer>
</div>
<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
<script type="text/javascript" src="../js/js.js"></script>
</body>
</html>
