<!DOCTYPE html>
<html>
<head>
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
session_start();
if(!isset($_SESSION["usuario"])){
    header("Location:../index.php");#retorna para a tela main
}
?>
<ul id="dropdown1" class="dropdown-content">
    <li><a onclick="excluirCategory()">Excluir</a></li>
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
<div class="container">
    <form class="col s12" action="register-category.php" method="post" enctype='multipart/form-data'>
        <div class="row">
            <div class="col s12 m6 offset-m3">
                <div class="card white darken-1">
                    <div class="card-content white-text center-align">
                        <div class="row">
                            <div class="col s2">
                                <img src="../images/icon-category.png">
                            </div>
                            <div class="col s6 offset-m3">
                                <span class='card-title black-text'><h3>Categoria</h3></span>
                            </div>
                        </div>
                        <div class='row'>
                            <div class='row'>
                                <div class='input-field black-text col s12'>
                                    <input id='name' name='name' type='text' class='validate' required>
                                    <label for='name' data-error='Nome incorreto' data-success=''>Nome</label>

                                </div>
                            </div>
                            <div class='row'>
                                <div class='input-field black-text col s12'>
                                            <textarea id='description' name='description' class='materialize-textarea'
                                                      maxlength='240' required></textarea>
                                    <label for='description'>Descrição</label>
                                </div>
                            </div>
                            <div class='row'>
                                <div class='file-field input-field'>
                                    <div class='btn amber darken-4'>
                                        <span>Imagem</span>
                                        <input type='file' name='foto' id='foto' accept='.gif,.jpg,.jpeg,.png' required>
                                    </div>
                                    <div class='file-path-wrapper'>
                                        <input class='file-path validate black-text' type='text'
                                               placeholder='Carregar um arquivos' name='inputimagem'>
                                    </div>
                                </div>
                            </div>
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

    <?php
    use Unirest\Request;

    require_once '../vendor/autoload.php';
    include "../Upload.php";
    if (!empty($_POST)) {
        $name = $_POST['name'];
        $description = $_POST['description'];

        if (($name != null && $description != null && $_FILES['foto'] != null)) {

            $path_image = null;

            if ($_FILES['foto']['error'] == 0) {
                $upload = new Upload($_FILES['foto'], 1000, 800, "../uploads/");
                $path_image = 'uploads/' . $upload->salvar();
            }

            $headers = array();
            $data = array('name' => $name, 'description' => $description, 'icon' => $path_image);

            $body = Unirest\Request\Body::json($data);
    
            $response = Unirest\Request::post('http://localhost:8000/category', null, $data);

            if ($response->code == 200) {
                echo "<script>
                alert('Categoria adicionada com sucesso!');
                window.location='list-category.php';
                        </script>";
            } else {
                echo "<script>
                        alert('Categoria pode já cadastrada');
                  </script>";
            }
        } else {
            echo "<script>
                        alert('Error');
                  </script>";
        }
    }
    ?>
</div>

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
                    <li><a class="grey-text text-lighten-3" href="register-category.php">Cadastrar categoria</a></li>
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

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="../js/materialize.min.js"></script>
<script type="text/javascript" src="../js/js.js"></script>
</body>
</html>
