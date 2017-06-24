<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="shortcut icon" href="images/icon-panel-login.png" type="image/x-icon" />
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>
    <!-- Style -->
    <link type="text/css" rel="stylesheet" href="css/style.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body style="background-color: #ff6f00">

<?php
session_start();
session_destroy();
?>

<div class="container">
    <div class="row">
        <div class="col s12 m5 offset-m3">
            <div class="card white darken-1">
                <div class="card-content white-text center-align">
                    <img src="images/icon-panel-login.png">
                    <span class="card-title black-text"><h3>Entrar</h3></span>
                    <div class="row">
                        <form class="col s12" method="post" action="index.php">
                            <div class="row">
                                <div class="input-field black-text col s12">
                                    <i class="material-icons prefix">email</i>
                                    <input id="email" type="email" name="email" class="validate" value="
                                    <?php if (!empty($_GET)) {
                                        echo $_GET['email'];
                                    } else {
                                        echo "";
                                    } ?>
                                    ">
                                    <label for="email" data-error="E-Mail incorreto" data-success="">Email</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field black-text col s12">
                                    <i class="material-icons prefix">vpn_key</i>
                                    <input id="password" type="password" name="password" class="validate">
                                    <label for="password" data-error="Senha incorreta" data-success="">Senha</label>
                                </div>
                            </div>
                            <button class="waves-effect waves-teal btn-flat" type="submit">Login</button>
                        </form>

                        <?php

                        if (!empty($_POST)) {
                            include("connection.php");

                            $email = $_POST["email"];
                            $password = md5($_POST["password"]);
                            $consultaBD = null;
                            $resultadoLogin = null;
                            $dados = null;

                            $consultaBD = "SELECT * FROM administrador WHERE email = '$email' AND password = '$password'";

                            $resultadoLogin = $conexao->prepare($consultaBD);
                            if ($resultadoLogin->execute()) {
                                if ($resultadoLogin->rowCount() > 0) {
                                    #echo "Autenticado com sucesso";
                                    $dados = $resultadoLogin->fetch(PDO::FETCH_OBJ);
                                    session_start("usuario");
                                    session_cache_expire(10);
                                    $_SESSION["usuario"] = "" . $dados->id_administrador;
                                    $_SESSION["email"] = "" . $email;

                                    header("Location: templates/dashboard.php");#redireciona para o menu principal
                                } else {
                                    echo "<script>if(confirm('Email ou Senha incorretos')) document.location = 'index.php?email=$email';</script>";
                                }
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="fixed-action-btn">
    <a href="sign-up.php">
        <button class="btn-floating btn-large grey darken-3">
            <i class="large material-icons">add</i>
        </button>
    </a>
</div>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
</body>
</html>
