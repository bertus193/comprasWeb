
 <?php
 //-- No direct access
//defined('_JEXEC') || die('=;)');


include_once("/var/www/vhosts/terra-golfa.com/framework/TG.php"); 

$app = new app();



if($_POST['page']){
	$page = $_POST['page'];
	$cur_page = $page;
	$page -= 1;
	$per_page = 6; // Per page records

	$start = $page * $per_page;
	$app->getSqlLogon();
	$query = mysql_query("SELECT id, personaje, creditos, precioTipo, precio, fechaFin, now() as now FROM don_comercio WHERE fechaFin > now() AND finalizada = 0 ORDER BY (precio/creditos),id ASC LIMIT $start, $per_page");
	//print $start." ".$per_page;
	print '<div style="display: table; text-align: center;">';

	while($oferta = mysql_fetch_array($query)){
		$id = $oferta['id'];
		$pj = $oferta['personaje'];
		$creditos = $oferta['creditos'];
		if($oferta['precioTipo'] == 49426){
			$ofertaTipo = "emblemas de escarcha";
		}
		$precio = $oferta['precio'].' '.$ofertaTipo;
		$fechaFin = strtotime($oferta['fechaFin']);
		$now = strtotime($oferta['now']);
		$finOferta = $fechaFin - $now;

		print '<a href="comercio?vista=comprar&accion='.$id.'"><div class="caja">
				<div class="cajaImagen">
					<img src="https://static.terra-golfa.com/img/icons/coin-icon.png">';
					print '<span style="position: absolute; margin: 45px 0px 0px -16px; background-color: rgb(59, 58, 125); min-width: 24px; border-radius: 15px; height: 23px;">'.$creditos.'</span>';
					
		 print '</div>
				<div class="cajaBody">';
				print '<p><font class=descripcion>Vendedor: </font>'.$pj.'</p>';
				print '<p><font class=descripcion>Finaliza en: </font><span id="time'.$id.'">Cargando...<script>startTimer('.$finOferta.',document.querySelector("#time'.$id.'"))</script></span></p>';
				print '<p><font class=descripcion>Precio: </font>'.$precio.'</p>';
		print '</div></div></a>';
	}

	$query_pag_num = mysql_query("SELECT * FROM don_comercio WHERE fechaFin > now() AND finalizada = 0"); // Total records
	$count = mysql_num_rows($query_pag_num);
	$no_of_paginations = ceil($count / $per_page);

if ($cur_page >= 7) {
    $start_loop = $cur_page - 3;
    if ($no_of_paginations > $cur_page + 3)
        $end_loop = $cur_page + 3;
    else if ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
        $start_loop = $no_of_paginations - 6;
        $end_loop = $no_of_paginations;
    } else {
        $end_loop = $no_of_paginations;
    }
} else {
    $start_loop = 1;
    if ($no_of_paginations > 7)
        $end_loop = 7;
    else
        $end_loop = $no_of_paginations;
}

print "<div class='pagination'><ul class='paginate'>";

// FOR ENABLING THE Primero BUTTON
if ($cur_page > 1) {
    print "<li p='1' class='active paginateLi'>Primero</li>";
}
else{
	print '<li style="float: left; width: 62.11px; padding: 0px 6px 1px;"></li>';
}

// FOR ENABLING THE Anterior BUTTON
if ($cur_page > 1) {
    $pre = $cur_page - 1;
    print "<li p='$pre' class='active paginateLi'>Anterior</li>";
}
else{
	print '<li style="float: left; width: 63.5px; padding: 0px 6px 1px;"></li>';
}

for ($i = $start_loop; $i <= $end_loop; $i++) {

    if ($cur_page == $i)
        print "<li p='$i' style='color:#fff;background-color:#006699;' class='active paginateLi'>{$i}</li>";
    else
        print "<li p='$i' class='active paginateLi'>{$i}</li>";
}

// TO ENABLE THE Siguiente BUTTON

if ($cur_page < $no_of_paginations) {
    $nex = $cur_page + 1;
    print "<li p='$nex' class='active paginateLi'>Siguiente</li>";
}
else{
	print '<li style="float: left; width: 71.14px; padding: 0px 6px 1px;"></li>';
}

// TO ENABLE THE END BUTTON
if ($cur_page < $no_of_paginations) {
    print "<li p='$no_of_paginations' class='active paginateLi'>Último</li>";
}
else{
	print '<li style="float: left; width: 53.74px; padding: 0px 6px 1px;"></li>';
}

	print '</div>';
	
}
?>