<!DOCTYPE html>
<html>
<head>
  <title>Comercio de créditos</title>
  <meta charset="UTF-8">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

</head>	
<body>
<?php
//-- No direct access
//defined('_JEXEC') || die('=;)');

require_once("./model/app.php");

print '<style>';
include("comercio.css");
print '</style>';

$app = new App();
$user = new User("User1", 10);

$cuentaNombre = $user->getName();
$creds = $user->getCreditos();

print '<div align="center"><img src="https://www.uppic.es/images/2016/03/03/MercadoNegro.png"><br><br>';

$vista = $_GET['vista'];
$accion = $_GET['accion'];

switch ($vista) {
    case 'nuevaOferta':
        include('nuevaOferta.php');
        break;
    case 'historial':
        include('historial.php');
        break;
    case 'comprar':
        include('comprar.php');
        break;
    case 'nuevaOferta':
        include('nuevaOferta.php');
        break;
    default:
        include('principal.php');
        break;
}

print '<div align="center">';
print '<div class="creditos">Tienes '.$creds.' créditos</div>';
print '<form action="" style="float: left;"><input name="vista" value="nuevaOferta" type="hidden"><input class="boton" value="Nueva Oferta" type="submit"></form>';
print '<form action="" style="float: right;"><input name="vista" value="historial" type="hidden"><input class="boton" value="Mis Ofertas y Compras" type="submit"></form>';
print '<form action="" style="float: right; margin-right: 10px;"><input name="vista" value="inicio" type="hidden"><input class="boton" value="Inicio" type="submit"></form>';


print '</div><br><br>';


print '</div>';

?>
</body>
</html>
