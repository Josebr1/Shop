<!DOCTYPE html>
<html>
<head>
    <title>Cadastramento</title>
    <link rel="shortcut icon" href="images/icon-panel-login.png" type="image/x-icon"/>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection"/>

    <link type="text/css" rel="stylesheet" href="css/style.css"/>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body style="background-color: #ff6f00">

<div class="container">
    <div class="row">
        <div class="col s12 m6  offset-m3">
            <div class="card white darken-1">
                <div class="card-content white-text center-align">
                    <div class="row">
                        <div class="s12 m12 l12">
                            <img src="images/icon-user-add.png">
                        </div>
                        <div class="s12 m12 l12">
                            <span class="card-title black-text"><h4>Cadastramento</h4></span>
                        </div>
                    </div>

                    <div class="row">
                        <form class="s12 m12 l12" method="post" action="sign-up.php" id="formValidate">
                            <div class="row">
                                <div class="input-field black-text col s12">
                                    <i class="material-icons prefix">perm_identity</i>
                                    <input id="name" type="text" name="name" class="validate" required>
                                    <label for="name" data-error="Campo Obrigatório" data-success="">Nome</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field black-text col s12">
                                    <i class="material-icons prefix">email</i>
                                    <input id="email" type="email" name="email" class="validate" required>
                                    <label for="email" data-error="E-Mail incorreto" data-success="">E-mail</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field black-text col s12">
                                    <i class="material-icons prefix">phone</i>
                                    <input type="text" name="phone"  class="validate" required maxlength="11" minlength="10">
                                    <label for="phone" id="phone" data-error="Tel: dd seguido do números" data-success="">Telefone</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field black-text col s12">
                                    <i class="material-icons prefix">vpn_key</i>
                                    <input id="password" type="password" name="password" class="validate" title="O senha deve conter: no mínimo 8 caracteres; no máximo 28 caracteres; apenas letras e números."
                                           pattern="[a-zA-Z0-9]{8,28}$" required>
                                    <label for="password" data-error="O senha deve conter no mínimo 8 caracteres, no máximo 28 caracteres, apenas letras e números."  data-success="">Senha</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="input-field black-text col s12">
                                    <i class="material-icons prefix">vpn_key</i>
                                    <input id="passwordRefresh" type="password" name="passwordRefresh"  class="validate"
                                           title="O senha deve conter: no mínimo 8 caracteres; no máximo 28 caracteres; apenas letras e números."
                                           pattern="[a-zA-Z0-9]{8,28}$" required>
                                    <label for="passwordRefresh" data-error="O senha deve conter no mínimo 8 caracteres, no máximo 28 caracteres, apenas letras e números."  data-success="">Repita a
                                        senha</label>
                                </div>
                            </div>
                            <button class="waves-effect waves-teal btn-flat" type="submit">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
if (!empty($_POST)) {
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    $passwordRefresh = md5($_POST['passwordRefresh']);
    $name = $_POST['name'];
    $phone = md5($_POST['phone']);

    /*Estabelece conexão com o banco de dados*/
    include("connection.php");

    $insereBD = "";
    $jaCadastrado = null;
    $insere = null;
    $dados = null;

    if ($password == $passwordRefresh) {
        $consultaBD = "SELECT email FROM administrador WHERE email = '$email'";

        $jaCadastrado = $conexao->prepare($consultaBD);
        if ($jaCadastrado->execute()) {
            if ($jaCadastrado->rowCount() > 0) {
                echo "<script language='javascript' type='text/javascript'>alert('Esse login já existe');</script>";
            } else { #Se não estiver cadastrado
                $insereBD = "INSERT INTO administrador (name, password, email, phone) VALUES ('$name', '$password', '$email', '$phone')";
                $insere = $conexao->prepare($insereBD);
                $insere->execute();

                /*Verifica se inseriu*/
                if ($jaCadastrado->execute()) {
                    if ($jaCadastrado->rowCount() > 0) {
                        $dados = $jaCadastrado->fetch(PDO::FETCH_OBJ);
                        echo "<script>
                                alert('Usuário cadastrado com sucesso');
                                window.location='index.php?email=$email';
                        </script>";
                    }
                }
            }
        }
    } else {
        echo "<script>
                alert('As senhas não correspondem');
                window.location='index.php';
                        </script>";
    }
}
?>

<div class="fixed-action-btn">
    <a href="index.php">
        <button class="btn-floating btn-large grey darken-3" name="submit">
            <i class="large material-icons">skip_previous</i>
        </button>
    </a>
</div>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</body>
</html>
