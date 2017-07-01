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
print '<a style="text-decoration: none; float: left;" class="boton" href="'.$currentUrl.'nuevaOferta">Nueva Oferta</a>';
print '<a style="text-decoration: none; float: right;" class="boton" href="'.$currentUrl.'nuevaOferta">Mis Ofertas y Compras</a>';
print '<a style="text-decoration: none; float: right; margin-right: 10px;" class="boton" href="'.$currentUrl.'">Inicio</a>';

print '</div><br><br>';


print '</div>';

?>

</body>
</html>