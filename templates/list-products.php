<?php
session_start();
require '../connection.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <title>Cadastrar produto</title>
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
            <form action="list-products.php" method="post" enctype='multipart/form-data'>

                <ul id="dropdown1" class="dropdown-content">
                    <li><a href="register-products.php">Adicionar</a></li>
                </ul>
                <nav class="nav-extended grey darken-3">
                    <div class="nav-content" style="margin-left: 20px;">
                        <a href="dashboard.php" class="nav-title">AppShop</a>
                        <button class="btn-floating btn-large halfway-fab waves-effect waves-light amber accent-3"
                                name="submit">
                            <i class="material-icons">search</i>
                        </button>
                        <ul class="right hide-on-med-and-down">
                            <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><i
                                            class="material-icons right">more_vert</i></a>
                        </ul>
                    </div>
                </nav>
                <div class="container ">
                    <label>Escolha uma categoria de produto</label>
                    <select class="input-field col s12" name="category" required>
                        <option value="" disabled selected>Escolha uma categoria</option>
                        <?php
                        require_once '../vendor/autoload.php';

                        $response = Unirest\Request::get('http://web-api.files-app.ga/public/category', $headers = array(), $parameters = null);
                        $json = json_decode($response->raw_body);

                            foreach ($json as $e) {
                                echo "
                                    <option value='$e->id_category'>$e->name</option>
                                ";
                            }
                        ?>
                    </select>
            </form>

            <?php
            require_once '../vendor/autoload.php';

            if (!empty($_POST)) {
                $category = $_POST['category'];

                $response = Unirest\Request::get('http://web-api.files-app.ga/public/product/category/' . $category, $headers = array(), $parameters = null);
                $json = json_decode($response->raw_body);
                if ($response->code == 404) {
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
                                <div class='card medium'>
                                    <div class='card-image'>
                                          <img src='http://site.files-app.ga/$e->product_image'>
                                    </div>
                                    <div class='card-stacked'>
                                        <div class='card-content'>
                                            <strong><i><p>$e->name</p></i></strong>
                                            <!--p>$e->description</p-->
                                            <p><b>R$ $e->price</b></p>
                                        </div>
                                        <div class='card-action'>
                                            <a href='update-products.php?idProduct=$e->id_product'>EDITAR</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            ";
                        }
                    echo "</div>";
                }
            }
            ?>
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
                © 2017 Copyright Text
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
