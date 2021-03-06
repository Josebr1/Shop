<?php
session_start();
require '../connection.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastrar categoria</title>
    <link rel="shortcut icon" href="../images/icon-panel-login.png" type="image/x-icon"/>
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
if (!isLoggedIn()) {
    header("Location:../index.php");#retorna para a tela main
}
?>
<div class="page-flexbox-wrapper">
    <main>
        <div class="row">
            <nav class="nav-extended grey darken-3">
                <div class="nav-content" style="margin-left: 20px;">
                    <a href="dashboard.php" class="nav-title">AppShop</a>
                    <a class="btn-floating btn-large halfway-fab waves-effect waves-light amber accent-3"
                       href="register-category.php">
                        <i class="material-icons">add</i>
                    </a>
                </div>
            </nav>

            <div class="container ">
                <?php
                require_once '../vendor/autoload.php';

                $response = Unirest\Request::get('http://web-api.files-app.ga/public/category', $headers = array(), $parameters = null);

                $json = json_decode($response->raw_body);


                if ($response->code == 404 || $json == null) {
                    echo "
                             <div class='col s12 m6 offset-m3'>
                                <div class='card horizontal'>
                                    <div class='card-stacked'>
                                        <div class='card-content'>
                                            <p class='center-align'>Não existem itens cadastrados</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ";
                } else {
                    echo("<div class='row'>");
                    foreach ($json as $e) {
                        echo "

                        <div class='grid-example col s12 m4'>
                            <div class='card small'>
                                        <div class='card-image'>
                                            <img src='http://site.files-app.ga/$e->icon' style='width: 100%; height: auto;'>
                                        </div>
                                     <div class='card-stacked'>
                                            <div class='card-content'>
                                                  <span>$e->name</span>
                                            </div>
                                            <div class='card-action'>
                                              <a href='update-category.php?idCategory=$e->id_category'>EDITAR</a>
                                            </div>
                                     </div>
                            </div>
                        </div>
                        
                        ";
                    }
                    echo "</div>";
                }
                ?>
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
<script type="text/javascript" src="../js/js.js"></script>
</body>
</html>
