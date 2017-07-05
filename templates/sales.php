<?php
session_start();
require '../connection.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pedidos realizados</title>
    <link rel="shortcut icon" href="../images/icon-panel-login.png" type="image/x-icon" />
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/style.css"/>

    <meta http-equiv="refresh" content="5;url=sales.php">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body style="background-color: #424242">

<?php
if(!isLoggedIn()){
    header("Location:../index.php");#retorna para a tela main
}
?>
<div class="page-flexbox-wrapper">
    <header>
        <nav>
            <div class="nav-wrapper amber darken-3">
                <a href="dashboard.php" class="brand-logo center">AppShop</a>
                <ul class="right hide-on-med-and-down">
                    <li><a onclick="reload()"><i class="material-icons">refresh</i></a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="row">
            <div>
                <ul class="tabs">
                    <li class="tab col s3"><a class="active orange-text text-darken-4" href="#test1">Vendas pagamento na
                            entrega</a></li>
                    <li class="tab col s3"><a class="orange-text text-darken-4" href="#test2">Vendas pagamento
                            online</a></li>
                </ul>
            </div>
            <div id="test1" class="col s10 offset-m1">
                <div class="row">
                    <div class="row">
                        <div class="col s12 m12">
                            <div class="card blue-grey darken-1">
                                <div class="card-content white-text">
                                    <span class="card-title">Pagamento na entrega</span>

                                    <?php
                                    require_once '../vendor/autoload.php';
                                    $headers = array();
                                    $response = Unirest\Request::get('http://localhost:8000/order/orders/form/PAYMENT_ON_TIME', $headers = array(), $parameters = null);

                                    $json = json_decode($response->raw_body);

                                    if ($response->code == 404) {
                                        echo "Nao existe pedido";
                                    } else {
                                        echo "<div class='collection'>";
                                        foreach ($json as $e) {
                                            echo "
                                        <a href='order.php?idCategory=$e->id_order' class='collection-item grey-text text-darken-3'><b>Endereço:</b><br/>$e->address<br/>
                                         <b>Descriçao:</b><br/>$e->description_order <br/>
                                         <b>Status:</b><br/>$e->status</a>
                                        ";
                                        }
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="test2" class="col s10 offset-m1">
                <div class="row">
                    <div class="row">
                        <div class="col s12 m12">
                            <div class="card blue-grey darken-1">
                                <div class="card-content white-text">
                                    <span class="card-title">Pagamento online</span>

                                    <?php
                                    require_once '../vendor/autoload.php';
                                    $headers = array();
                                    $response = Unirest\Request::get('http://localhost:8000/order/orders/form/CREDIT_ONLINE', $headers = array(), $parameters = null);

                                    $json = json_decode($response->raw_body);

                                    if ($response->code == 404) {
                                        echo "Nao existe pedido";
                                    } else {
                                        echo "<div class='collection'>";
                                        foreach ($json as $e) {
                                            echo "
                                        <a href='order.php?idCategory=$e->id_order' class='collection-item'><b>Endereço:</b><br/>$e->address<br/>
                                         <b>Descriçao:</b><br/>$e->description_order <br/>
                                         <b>Status:</b><br/>$e->status</a>
                                        ";
                                        }
                                        echo "</div>";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <footer class="page-footer grey darken-4" style="margin-bottom: 0">
        <div class="container">
            <div class="row">
                <div class="col l6 s12">
                    <h5 class="white-text">AppShop</h5>
                    <p class="grey-text text-lighten-4"></p>
                </div>
                <div class="col l4 offset-l2 s12">
                    <h5 class="white-text">Links</h5>
                    <ul>
                        <li><a class="grey-text text-lighten-3" href="dashboard.php">Home</a></li>
                        <li><a class="grey-text text-lighten-3" href="register-products.php">Cadastrar produto</a></li>
                        <li><a class="grey-text text-lighten-3" href="register-category.php">Cadastrar categoria</a>
                        </li>
                        <li><a class="grey-text text-lighten-3" href="best-customers.php">Melhores clientes</a></li>
                    </ul>
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
</body>
</html>
