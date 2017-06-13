<?php

//-- No direct access
defined('_JEXEC') || die('=;)');

$app->getSqlLogon();

if($_GET['accion']){
	$reclamarId = $_GET['accion'];
}

print '<h2>Historial de Ofertas</h2>';

$query = mysql_query("SELECT *, now() as now FROM don_comercio WHERE vendedorCuenta = '$cuentaNombre'");

if($query && mysql_num_rows($query) >= 1){
	print '<table class="tabla" width="100%">';
	print '<tr><td>id</td><td>Jugador</td><td>Créditos</td><td>Precio</td><td>Fecha Inicio</td>
				<td>Fecha Fin</td><td>Comprador</td><td>Reclamar Créditos</td></tr>';
	$trTipo = 0;

	while($oferta = mysql_fetch_array($query)){
		$now = $oferta['now'];
		$id = $oferta['id'];
		$pj = $oferta['personaje'];
		$creditos = $oferta['creditos'];
		$compradorCuenta =$oferta['compradorCuenta'];
		$finalizada = $oferta['finalizada'];

		if($compradorCuenta != null){
			$compradorCuenta = "SI";
		}
		if($oferta['precioTipo'] == 49426){
			$ofertaTipo = "escarchas";
		}
		$precio = $oferta['precio'].' '.$ofertaTipo;
		$fechaInicio = $oferta['fechaInicio'];
		$fechaFin = $oferta['fechaFin'];
		if($fechaFin < $now){
			$fechaFin = '<font style="color:red">'.$fechaFin.'</font>';
			$finOferta = true;
		}
		else{
			$finOferta = false;
		}


		//RECLAMAR
		if($finOferta == true && $_GET['accion'] && $finalizada == 0 && $id == $reclamarId){
			mysql_query("UPDATE don_comercio SET finalizada = 1 WHERE id = $id");

			$creditosAcc = $cuenta->getCreditos();
			$creditosDespues = $creditosAcc + $creditos;
			$cuenta->setCreditos($creditosDespues, true);
			print '<p style="color:green">Se han añadido '.$creditos.' créditos de 
						dicha oferta en la cuenta correctamente ('.$creditosAcc.' -> '. $creditosDespues.')';
			$finalizada = 1;
		}
		if($trTipo == 0){
			print '<tr class="odd">';
			$trTipo = 1;
		}
		else{
			print '<tr class="even">';	
			$trTipo = 0;
		}
		print '<td>'.$id.'</td><td>'.$pj.'</td><td>'.$creditos.' C</td><td>'.$precio.'</td>
				<td>'.$fechaInicio.'</td><td>'.$fechaFin.'</td>';
			print '<td>'.$compradorCuenta.'</td>';
			if($finOferta == false){
				print '<td></td>';
			} 
			else if($finalizada == 1){
				print '<td></td>';
			}
			else if($finalizada == 0){
				print '<td><a href="comercio?vista=historial&accion='.$id.'">Reclamar</a></td>';
			}
			
			print '</tr>';

		
	}

	print '</table>';
}
else{
	print '<p>Todavía no has creado ninguna oferta</p>';
}

print '<h2>Historial de Compras</h2>';

$cuentaId = $cuenta->getId();
$queryCompras = mysql_query("SELECT * FROM don_comercio WHERE compradorCuenta = $cuentaId");

if($queryCompras && mysql_num_rows($queryCompras) >= 1){

	print '<table class="tabla" width="100%">';
	print '<tr><td>id</td><td>Jugador</td><td>Créditos</td><td>Precio</td><td>Fecha Inicio</td>
				<td>Fecha Fin</td></tr>';
	$trTipo = 0;

	while($compra = mysql_fetch_array($queryCompras)){
		$now = $compra['now'];
		$id = $compra['id'];
		$pj = $compra['personaje'];
		$creditos = $compra['creditos'];
		$finalizada = $compra['finalizada'];

		if($trTipo == 0){
			print '<tr class="odd">';
			$trTipo = 1;
		}
		else{
			print '<tr class="even">';	
			$trTipo = 0;
		}

		print '<td>'.$id.'</td><td>'.$pj.'</td><td>'.$creditos.' C</td><td>'.$precio.'</td>
				<td>'.$fechaInicio.'</td><td>'.$fechaFin.'</td>';
			
		print '</tr>';
	}

	print '</table>';

}

else{
	print '<p>Todavía no has comprado ninguna oferta</p>';
}

?>