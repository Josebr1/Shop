<?php
session_start();
require '../connection.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Pedidos realizados</title>
    <link rel="shortcut icon" href="../images/icon-panel-login.png" type="image/x-icon"/>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="../css/materialize.min.css" media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="../css/style.css"/>
    <meta charset="UTF-8">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>

<body class="grey lighten-2" style="min-width: 50%">
<?php
if (!isLoggedIn()) {
    header("Location:../index.php");#retorna para a tela main
}
?>
<div class="page-flexbox-wrapper">

    <header>
        <nav>
            <div class="nav-wrapper grey darken-3">
                <a href="dashboard.php" class="brand-logo">AppShop</a>
                <ul class="right hide-on-med-and-down">
                    <li><a onclick="reload()"><i class="material-icons">refresh</i></a></li>
                    <li><a href="#"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="container">
            <form class="col s12" name="statusform" action="order.php" method="post" enctype='multipart/form-data'>
                <div class="row">
                    <div class="col s12">
                        <div class="card white darken-1">
                            <div class="card-content white-text" style="width: 100%">
                    <span class="card-title black-text">

                        <table>
                            <tr>
                                <td>
                                    <h4 class="center-align">Informações do pedido</h4>
                                </td>
                                <td>
                                    <img width="100" src="../images/order-icon.png">
                                </td>
                            </tr>
                        </table>

                    </span>
                                <div class="row black-text">
                                    <div class="col s6">
                                        <div class="row">
                                            <?php
                                            require_once '../vendor/autoload.php';

                                            if (!empty($_GET)) {
                                                $id = $_GET['idCategory'];
                                                $headers = array();
                                                $response = Unirest\Request::get('http://web-api.files-app.ga/public/order/' . $id, $headers = array(), $parameters = null);
                                                $json = json_decode($response->raw_body);

                                                if ($response->code != 404 && $json != null) {
                                                    foreach ($json as $e) {
                                                        echo "
                                                   <table>
                                                    <tbody>
                                                      <tr>
                                                        <td>Descriçao</td>
                                                        <td>$e->description_order</td>
                                                      </tr>
                                                      <tr>
                                                        <td>Endereço</td>
                                                        <td>$e->address</td>
                                                      </tr>
                                                      <tr>
                                                        <td>Status</td>
                                                        <td>$e->status</td>
                                                      </tr>
                                                      
                                                      <tr>
                                                        <td>Data da compra</td>
                                                        <td>$e->date_order</td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  
                                                  
                                            <table>
                                                <tr>
                                                    <td>
                                                        <h5>Informações do comprador</h5>
                                                    </td>
                                                    <td>
                                                        <img width=\"100\" src=\"../images/icon-user.png\">
                                                    </td>
                                                </tr>
                                                
                                                <tr>
                                                    <td>Nome do comprador</td>
                                                    <td>$e->name</td>
                                                </tr>
                                                <tr>
                                                    <td>E-Mail</td>
                                                    <td>$e->email</td>
                                                </tr>
                                                <tr>
                                                    <td>Telefone</td>
                                                    <td>$e->phone</td>
                                                </tr>
                                            </table>
                                        
                                             ";
                                                        echo "<input type=hidden name='id' value='$e->id_order'> ";
                                                    }
                                                }
                                            }
                                            ?>

                                            <label>Atualizar status do pedido</label>
                                            <select class="black-text" name="status" required>
                                                <option value="" disabled selected>Escolha um status</option>
                                                <option value="Pedido saiu para entrega">Pedido saiu para entrega
                                                </option>
                                                <option value="Pedido Cancelado">Pedido Cancelado</option>
                                                <option value="Pedido Realizado">Pedido Realizado</option>
                                                <option value="Pedido Finalizado">Pedido Finalizado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col s6">
                                        <table>
                                            <thead>
                                            <tr>
                                                <th>Produto</th>
                                                <th>Quantidade</th>
                                                <th>Preço</th>
                                                <th>Valor Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            require_once '../vendor/autoload.php';

                                            if (!empty($_GET)) {
                                                $id = $_GET['idCategory'];
                                                $headers = array();
                                                $response = Unirest\Request::get('http://web-api.files-app.ga/public/order/products/' . $id, $headers = array(), $parameters = null);
                                                $json = json_decode($response->raw_body);

                                                if ($json != null) {
                                                    foreach ($json as $e) {
                                                        $valor_total = ($e->quantity * $e->price);
                                                        echo "
                                                    <tr>
                                                        <td>$e->name</td>
                                                        <td>$e->quantity</td>
                                                        <td>R$ $e->price</td>
                                                        <td>R$ $valor_total</td>
                                                    </tr>
                                    
                                                ";
                                                    }
                                                }
                                            }
                                            ?>
                                            </tbody>
                                        </table>
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

            if (!empty($_POST)) {
                $id = $_POST['id'];
                $status = $_POST['status'];

                if (($status != null)) {

                    $headers = array();
                    $data = array('status' => $status);

                    $response = Request::post('http://web-api.files-app.ga/public/order/status/' . $id, array("Accept" => "application/json"), $data);
                    if ($response->code == 200) {
                        echo "<script>
                                alert('$response->body');
                                window.location='dashboard.php';
                               </script>";
                    } else {
                        echo "<script>
                                alert('Erro ao atualizar status do pedido');
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

<!-- -->
<script type="text/javascript" src="../js/js.js"></script>
</body>
</html>
