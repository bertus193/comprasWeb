<?php
defined('BASEPATH') or exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Comercio de créditos</title>
	<link rel = "stylesheet" type = "text/css" href = "<?php echo base_url(); ?>assets/css/comercio.css">
</head>
<body>

<?php
$app = new App();
$user = new User("User1", 10);

$cuentaNombre = $user->getName();
$creds = $user->getCreditos();

print '<div align="center"><img src="https://www.uppic.es/images/2016/03/03/MercadoNegro.png"><br><br>';

$vista = $this->input->get('vista');
$accion = $this->input->get('accion');
$data['app'] = $app;

switch ($vista) {
    case 'nuevaOferta':
        //include('nuevaOferta.php');
        break;
    case 'historial':
        //include('historial.php');
        break;
    case 'comprar':
        //include('comprar.php');
        break;
    default:
        $this->load->view('principal', $data);
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