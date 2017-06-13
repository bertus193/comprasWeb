<script type="text/javascript">
jQuery(function ($) {
	            $(document).ready(function(){
                function loading_show(){
                    $('#loading').html("<img src='images/loading.gif'/>").fadeIn('fast');
                }
                function loading_hide(){
                    $('#loading').fadeOut('fast');
                }                
                function loadData(page){
                    loading_show();                    
                    $.ajax
                    ({
                        type: "POST",
                        url: "/extras/comercio/ofertas.php",
                        data: "page="+page,
                        success: function(msg)
                        {
                            $("#container").ajaxComplete(function(event, request, settings)
                            {
                                loading_hide();
                                $("#container").html(msg);
                				$("#container").find("script").each(function(i) {
                    				eval($(this).text());
                    			});
                            });
                        }
                    });
                }
                loadData(1);  // For first time page load default results
                $('#container .pagination li.active').live('click',function(){
                    var page = $(this).attr('p');
                    loadData(page);
                    
                });           
                $('#go_btn').live('click',function(){
                    var page = parseInt($('.goto').val());
                    var no_of_pages = parseInt($('.total').attr('a'));
                    if(page != 0 && page <= no_of_pages){
                        loadData(page);
                    }else{
                        alert('Enter a PAGE between 1 and '+no_of_pages);
                        $('.goto').val("").focus();
                        return false;
                    }
                    
                });
            });
});


</script>

<?php
//-- No direct access
defined('_JEXEC') || die('=;)');

$app->getSqlLogon();

print '<div id="container"style="min-height: 448px;">
            <div class="data"></div>
            <div class="pagination"></div>
        </div>';

print '<h2>Últimas 6 ventas realizadas</h2>';

print '<div style="display: table; text-align: center;">';

//Finalizadas
$query = mysql_query("SELECT id, compradorPjNombre , personaje, creditos, precioTipo, precio, fechaFin, compradorCuenta, now() as now FROM don_comercio WHERE fechaCompra is not null ORDER BY fechaCompra desc LIMIT 6");

if($query && mysql_num_rows($query) >= 1){
	//print '<table class="tabla" width="100%">';
	//print '<tr><td>Jugador</td><td>Créditos Ofrecidos</td><td>Precio de Venta</td><td>Fecha de Finalización</td></tr>';
	$trTipo = 0;

	while($oferta = mysql_fetch_array($query)){
		$id = $oferta['id'];
		$pj = $oferta['personaje'];
		$creditos = $oferta['creditos'];
		$compradorPjNombre = $oferta['compradorPjNombre'];
		if($oferta['precioTipo'] == 49426){
			$ofertaTipo = "emblemas de escarcha";
		}
		$precio = $oferta['precio'].' '.$ofertaTipo;
		$fechaFin = strtotime($oferta['fechaFin']);
		$now = strtotime($oferta['now']);
		$finOferta = $fechaFin - $now;
		/*if($trTipo == 0){

			print '<tr class="odd"><td>'.$pj.'</td><td>'.$creditos.' C</td><td>'.$precio.'</td><td>'.$finOferta.'</td>';
			//print '<td><a href="comercio?vista=comprar&accion='.$id.'">Comprar</a></td>';
			print '</tr>';
			$trTipo = 1;
		}
		else{
			print '<a href="comercio?vista=comprar&accion='.$id.'"><tr class="even"><td>'.$pj.'</td><td>'.$creditos.' C</td><td>'.$precio.'</td><td>'.$finOferta.'</td>';
			print '</tr></a>';			
			$trTipo = 0;
		}*/

		print '<a href="comercio?vista=comprar&accion='.$id.'"><div class="caja">
				<div class="cajaImagen">
					<img src="https://static.terra-golfa.com/img/icons/coin-icon.png">';
					print '<span style="position: absolute; margin: 45px 0px 0px -16px; background-color: rgb(59, 58, 125); min-width: 24px; border-radius: 15px; height: 23px;">'.$creditos.'</span>';
					
		 print '</div>
				<div class="cajaBody">';
				print '<p><font class=descripcion>Vendedor: </font>'.$pj.'</p>';
				print '<p><font class=descripcion>Precio: </font>'.$precio.' </p>';
				if($compradorPjNombre){
					print '<p><font color="green">¡VENDIDO a '.$compradorPjNombre.'!</font></p>';
				}
				else{
					print '<p><font color="green">¡VENDIDO!</font></p>';
				}
				
				
		print '</div></div></a>';

		
	}

	//print '</table>';
}

print '</div><br><br>';



?>