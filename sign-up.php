<!DOCTYPE html>
<html lang="pt-br">
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

<body>

<div class="container">
    <div class="row">
        <div class="col s12 m6  offset-m3">

            <div class="row">
                <div class="s12 m12 l12">
                    <!--img src="images/icon-user-add.png" -->
                </div>
                <div class="s12 m12 l12">
                    <span class="card-title black-text"><h4>Cadastre-se, é rápido</h4></span>
                </div>
                <div class="s12 m12 l12">
                    <span class="card-title black-text"><p>Já é um administrador? Faça o <a href="sign-in.php">login</a> agora mesmo</p></span>
                </div>
            </div>

            <div class="row">
                <form class="s12 m12 l12" method="post" action="sign-up.php" id="signUp">
                    <div class="row">
                        <div class="input-field black-text col s12">
                            <input id="name" type="text" name="name" class="validate" required>
                            <label for="name" data-error="Campo Obrigatório" data-success="">Nome completo</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field black-text col s12">
                            <input id="email" type="email" name="email" class="validate" required>
                            <label for="email" data-error="E-Mail incorreto" data-success="">E-mail</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field black-text col s12">
                            <input type="tel" name="phone" id="phone" class="validate"
                                   title="Número Telefone Inválido"
                                   pattern="[\(]\d{2}[\)] \d{4}[\-]\d{4}" data-mask="(00) 0000-0000"  required>
                            <label for="phone" data-error="Número Telefone Inválido"
                                   data-success="">Telefone</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field black-text col s12">
                            <input id="password" type="password" name="password" class="validate"
                                   title="O senha deve conter: no mínimo 8 caracteres; no máximo 28 caracteres; apenas letras e números."
                                   pattern="[a-zA-Z0-9]{8,28}$" required>
                            <label for="password"
                                   data-error="O senha deve conter no mínimo 8 caracteres, no máximo 28 caracteres, apenas letras e números."
                                   data-success="">Senha</label>
                        </div>
                    </div>
                    <button class="waves-effect waves-light btn-large button-center orange darken-4"
                            style="width: 100%;" type="submit">Cadastrar
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<?php
if (!empty($_POST)) {
    /*Estabelece conexão com o banco de dados*/
    include("connection.php");

    $email = $_POST['email'];
    $password = make_hash($_POST['password']);
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    $query = "";
    $isRegistered = null;
    $insert = null;
    $data = null;

    $query = "SELECT email FROM administrador WHERE email = :email";
    $isRegistered = db_connect()->prepare($query);
    $isRegistered->bindParam("email", $email);

    if ($isRegistered->execute()) {
        if ($isRegistered->rowCount() > 0) {
            echo "<script language='javascript' type='text/javascript'>alert('Esse login já existe');</script>";
        } else { #Se não estiver cadastrado
            $query = "INSERT INTO administrador (name, password, email, phone) VALUES (?, ?, ?, ?)";
            $insert = db_connect()->prepare($query);
            $insert->bindParam(1, $name);
            $insert->bindParam(2, $password);
            $insert->bindParam(3, $email);
            $insert->bindParam(4, $phone);
            /*Verifica se inseriu*/
            if ($insert->execute()) {
                if ($insert->rowCount() > 0) {
                    $data = $insert->fetch(PDO::FETCH_OBJ);
                    echo "<script>
                                alert('Usuário cadastrado com sucesso');
                                window.location='index.php?email=$email';
                        </script>";
                }
            }
        }
    }
}
?>

<div class="fixed-action-btn">
    <a href="index.php">
        <button class="btn-floating btn-large grey darken-3" name="submit">
            <i class="large material-icons">home</i>
        </button>
    </a>
</div>

<!--Import jQuery before materialize.js-->
<script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script type="text/javascript" src="js/materialize.min.js"></script>
<script type="text/javascript" src="js/js.js"></script>
<script type="text/javascript" src="bower_components/formatter.js/dist/jquery.formatter.js"></script>
<script type="text/javascript" src="bower_components/jquery-mask-plugin/dist/jquery.mask.js"></script>
</body>
</html>
