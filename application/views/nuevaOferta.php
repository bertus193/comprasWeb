   <SCRIPT language=Javascript>
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;

         return true;
      }
   </SCRIPT>

   <script>
   function my_confirm() {
    if( confirm("¿Estás Seguro?") ) {
        return true;
    }
    else {
        // do something 
        return false;
    }
}
</script>
<?php

print '<h2>Añadir Oferta</h2>';

print '<div style="background-color: rgba(0, 0, 0, 0.14); width: 360px; border-radius: 10px; border-style: solid; border-color: rgb(5, 4, 4);">';
print '<div style="margin: 10px 10px 30px;">';

$ventaSession = $session->get('ventaSession');

if ($ventaSession == 1 && isset($_GET['jugador']) && isset($_GET['creditos']) && isset($_GET['totalAPedir']) && isset($_GET['tipo']) && isset($_GET['tiempo'])) {
    $jugador     = $app->limpiarString($_GET['jugador']);
    $creditos    = $app->limpiarString($_GET['creditos']);
    $totalAPedir = $app->limpiarString($_GET['totalAPedir']);
    $tipo        = $app->limpiarString($_GET['tipo']);
    $tiempo      = $app->limpiarString($_GET['tiempo']);

    if (is_numeric($creditos) && is_numeric($totalAPedir) && ctype_digit($creditos) && ctype_digit($totalAPedir)) {
        if ($totalAPedir > 0 && $creditos > 0 && $totalAPedir <= 900) {
            $totalPjsH = array();
            $totalPjsM = array();
    
            $reino = substr($jugador, 0, 3);
    
            if ($reino == "Hul" || $reino == "Mid") {
                $nombrePj = substr($jugador, 6);
    
                if ($reino == "Hul") {
                    $ObjPersonajes = cuenta::getPjsArray($app, $cuenta, 1);
                } elseif ($reino == "Mid") {
                    $ObjPersonajes = cuenta::getPjsArray($app, $cuenta, 2);
                }
                
                $totalPjs = array();
                foreach ($ObjPersonajes as $pj) {
                    array_push($totalPjs, $pj->getNombre());
                }
        
                if (in_array($nombrePj, $totalPjs)) {
                    if ($tipo == "49426") {
                        if ($tiempo == 1 or $tiempo == 2) {
                            $creditosAcc = $cuenta->getCreditos();
                            if ($creditos >= 1) {
                                if ($creditosAcc >= $creditos) {
                                    $creditosDespues = $creditosAcc - $creditos;
    
                                    $app->getSqlLogon();
    
                                    $query = 'INSERT INTO `don_comercio` (`personaje`, `vendedorCuenta`, `creditos`, `precio`, `precioTipo`,`fechaFin`) VALUES
                                                            ("'.$jugador.'", "'.$cuentaNombre.'", '.$creditos.', '.$totalAPedir.', 
                                                        "'.$tipo.'", NOW() + INTERVAL '.$tiempo.' DAY);';
    
                                    mysql_query($query) or die(mysql_error());
    
                                    print '<font style="color:green">Oferta añadida correctamente.</font>';
    
                                    if ($query) {
                                        $cuenta->setCreditos($creditosDespues, true);
                                    }
                                } else {
                                    $error = "No tienes suficientes créditos.";
                                }
                            } else {
                                $error = "Mínimo, 1 créditos";
                            }
                        } else {
                            $error = "Nope";
                        }
                    } else {
                        $error = "Podria ser pero no, utiliza escarchas...";
                    }
                } else {
                    $error = "Dicho personaje no es tuyo.";
                }
            } else {
                $error = "Dicho Reino no existe.";
            }
        } else {
            $error = "Los créditos o item a pedir debe ser mayor que 0 e inferior o igual a 900.";
        }
    } else {
        $error = "El total de créditos y/o el total a pedir deben ser números enteros.";
    }
}
if ($error) {
    print '<font style="color:red">'.$error.'</font>';
}

print '<form onSubmit="return my_confirm()">';
print '<input name="vista" value="nuevaOferta" type="hidden">';

/*print '<table class="tabla" width="50%">';

print '<tr><td>Jugador</td><td>Saronitas</td></tr>';
print '<tr class="even"><td>Jugador</td><td>Saronitas</td></tr>';
print '<tr class="even"><td>Jugador</td><td>Saronitas</td></tr>';
print '<tr class="even"><td>Jugador</td><td>Saronitas</td></tr>';

print '</table>';*/

print 'Escoge un Jugador<br>';

$PjsH = cuenta::getPjsArray($app, $cuenta, 1);
$PjsM = cuenta::getPjsArray($app, $cuenta, 2);

print '<select name="jugador">';
foreach ($PjsH as $pj) {
    $nombre = "Hul - ".$pj->getNombre();
    print '<option value="'.$nombre.'">'.$nombre.'</option>';
}
foreach ($PjsM as $pj) {
    $nombre = "Mid - ".$pj->getNombre();
    print '<option value="'.$nombre.'">'.$nombre.'</option>';
}

print '</select> ';

if ($ventaSession == 1) {
    $session->clear('ventaSession');
} else {
    $session->set('ventaSession', 1);
}

print '<br>';

print 'Creditos Ofrecidos<br>';

print '<INPUT id="creditos" onkeypress="return isNumberKey(event)" type="text" name="creditos">';

print '<br>';

print 'Quiero:<br>';

print '<INPUT id="txtChar" onkeypress="return isNumberKey(event)" type="text" name="totalAPedir">';
print '<br><input type="radio" name="tipo" value="49426" checked>Emblemas de Escarcha</input>';

print '<br>';

print 'Duración<br>';

print '<input type="radio" name="tiempo" value="2" checked>2 días </input>';
print '<input type="radio" name="tiempo" value="1" >1 día</input>';


print '<br>';

print '<input class="boton" value="Añadir Oferta" type="submit">';

print '</form>';

print '</div></div><br><br>';

?>