<?php
session_start();
require '../connection.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Atualizar Produto</title>
    <link rel="shortcut icon" href="../images/icon-panel-login.png" type="image/x-icon" />
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/style.css"/>

    <meta charset="UTF-8">

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
        <ul id="dropdown1" class="dropdown-content">
            <li><a onclick="deleteProduct(<?php if (!empty($_GET)) {
                    $id = $_GET['idProduct'];
                    echo $id;
                } ?>)">Excluir</a></li>
        </ul>
        <nav>
            <div class="nav-wrapper amber darken-3">
                <a href="dashboard.php" class="brand-logo">AppShop</a>
                <ul class="right hide-on-med-and-down">
                    <li><a onclick="reload()"><i class="material-icons">refresh</i></a></li>
                    <li><a class="dropdown-button" href="#!" data-activates="dropdown1"><i class="material-icons right">more_vert</i></a>
                    </li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <form class="col l6 s12" action="update-products.php" method="post" enctype='multipart/form-data'>
                <div class="row">
                    <div class="col s12 m6 offset-m3">
                        <div class="card white darken-1">
                            <div class="card-content white-text center-align">
                                <div class="row">
                                    <div class="s12 m12 l12">
                                        <img src="../images/icon-product.png">
                                    </div>
                                    <div class="s12 m12 l12">
                                        <span class='card-title black-text'><h3>Produto</h3></span>
                                    </div>
                                </div>
                                <?php

                                require_once '../vendor/autoload.php';

                                if (!empty($_GET)) {

                                    $id = $_GET['idProduct'];

                                    //$headers = array();
                                    $response = Unirest\Request::get('http://localhost:8000/product/' . $id, $headers = array(), $parameters = null);
                                    $json = json_decode($response->raw_body);

                                    foreach ($json as $e) {

                                        echo "
                                    <div class='row'>
                                        <div class='row'>
                                            <div class='input-field black-text col s12'>
                                                <input id='name' name='name' type='text' class='validate' value='$e->name'>
                                                <label for='name' data-error='Nome incorreto' data-success=''>Nome do
                                                    Produto</label>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='input-field black-text col s12'>
                                                <textarea id='description' name='description' class='materialize-textarea'
                                                          maxlength='240' required>$e->description</textarea>
                                                <label for='description'>Descrição</label>
                                            </div>
                                        </div>
                                        <div class='row'>
                                            <div class='input-field black-text col s12'>
                                                <input id='price' name='price' type=number step=any class='validate' value='$e->price'>
                                                <label for='price' data-error='' data-success=''>Preço do produto</label>
                                            </div>
                                        </div>
            
                                        <div class='row'>
                                            <div class='file-field input-field col s12'>
                                                <div class='btn amber darken-4'>
                                                      <span>Imagem</span>
                                                      <input type='file' name='foto' id='foto' accept='.gif,.jpg,.jpeg,.png'>
                                                </div>
                                                <div class='file-path-wrapper'>
                                                    <input class='file-path validate black-text' type='text'
                                                           placeholder='Upload one or more files' name='inputimagem'>
                                                </div>
                                            </div>
                                        </div>
                                    ";
                                        echo "<input type=hidden name='id_product' value='$e->id_product'> ";
                                    }
                                }
                                ?>


                                <?php
                                require_once '../vendor/autoload.php';

                                $headers = array();

                                $response = Unirest\Request::get('http://localhost:8000/category', $headers = array(), $parameters = null);

                                $json = json_decode($response->raw_body);
                                echo "<div class='row'>";
                                echo "<select class='input-field col s12 black-text' name='category'>";
                                echo "<option value='' disabled selected>Escolha uma categoria</option>";
                                foreach ($json as $e) {
                                    echo "<option value='$e->id_category'>$e->name</option>";
                                }
                                echo "</select>";

                                ?>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        <div class="fixed-action-btn">
            <button class="btn-floating btn-large amber darken-3" name="submit">
                <i class="large material-icons">save</i>
            </button>
        </div>
        </form>
    </main>




</div>

<?php
use Unirest\Request;

require_once '../vendor/autoload.php';
include "../Upload.php";
if (!empty($_POST)) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $path_image = null;
    $id_product = $_POST['id_product'];

    if (($name != null && $description != null && $price != null && $_FILES['foto'] != null)) {

        $path_image = null;

        if ($_FILES['foto']['error'] == 0) {
            $upload = new Upload($_FILES['foto'], 1000, 800, "../uploads/");
            $path_image = 'uploads/' . $upload->salvar();
        }

        $headers = array();
        $data = array('name' => $name, 'description' => $description, 'price' => $price, 'product_image' => $path_image);

        $body = Unirest\Request\Body::json($data);

        $response = Unirest\Request::post('http://localhost:8000/product/update/' . $id_product, null, $data);

        if ($response->code == 200) {
            echo "<script>
                alert('Produto atualizado com sucesso!');
                window.location='list-products.php';
                        </script>";
        } else {
            echo "<script>
                        alert('Erro ao atualizar produto');
                  </script>";
        }
    } else {
        echo "<script>
                        alert('Error');
                  </script>";
    }
}
?>

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
<script type="text/javascript" src="../js/js.js"></script>
</body>
</html>
