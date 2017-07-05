<!DOCTYPE html>
<html>
<head>
    <title>Entrar</title>
    <link rel="shortcut icon" href="images/icon-panel-login.png" type="image/x-icon"/>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
    <!-- Style -->
    <link type="text/css" rel="stylesheet" href="css/style.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body>

<?php
session_start();
session_destroy();
?>

<div class="container">


    <div class="container-card">

        <img src="images/icon-circle-application.png" style="width: 20%; height: auto;" class="center-div">
<h5 align="center">Entrar</h5>
        <p align="center">Use sua conta de login</p>

        <form class="col s12" id="formValidate" method="post" action="sign-in.php">
            <div class="row">
                <div class="input-field black-text col s12">
                    <input id="email" type="email" name="email" class="validate" required value="
                                    <?php if (!empty($_GET)) {
                        echo $_GET['email'];
                    } else {
                        echo "";
                    } ?>
                                    ">
                    <label for="email" data-error="E-Mail incorreto" data-success="">E-mail</label>
                </div>
            </div>
            <div class="row">
                <div class="input-field black-text col s12">
                    <input id="password" type="password" name="password" class="validate" required>
                    <label for="password" data-error="Senha incorreta" data-success="">Senha</label>
                </div>
            </div>
          <button class="waves-effect waves-light btn-large button-center orange darken-4" style="width: 100%;" type="submit">Próximo</button>

            <p>Não tem uma conta? <a href="sign-up.php">Crie uma!</a></p>

        </form>
    </div>
    <?php

    if (!empty($_POST)) {


        try{
            include("connection.php");
            $email = $_POST["email"];
            $password = md5($_POST["password"]);

            $query = null;
            $result = null;
            $data = null;

            $query = "SELECT * FROM administrador WHERE email = '$email' AND password = '$password'";

            $result = $connection->prepare($query);
            if ($result->execute()) {
                if ($result->rowCount() > 0) {
                    $data = $result->fetch(PDO::FETCH_OBJ);
                    session_start("usuario");
                    session_cache_expire(10);
                    $_SESSION["user_administrator"] = "" . $data->id_administrador;
                    $_SESSION["email"] = "" . $email;
                    header("Location: templates/dashboard.php");#redireciona para o menu principal
                } else {
                    echo "<script>if(confirm('Email ou Senha incorretos')) document.location = 'sign-in.php?email=$email';</script>";
                }
            }
        }catch (Exception $e)
        {
            echo "<script>if(confirm('Email ou Senha incorretos')) document.location = 'sign-in.php?email=$email';</script>";
        }
    }
    ?>
</div>
<div class="fixed-action-btn">
    <a href="sign-up.php">
        <button class="btn-floating btn-large grey darken-3">
            <i class="large material-icons">home</i>
        </button>
    </a>
</div>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</body>
</html>
