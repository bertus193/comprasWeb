<?php

//-- No direct access
//defined('_JEXEC') || die('=;)');
//ini_set('display_errors', '1');

$finalizarCompra = false;

print '<h2>Comprar Oferta</h2>';

if (is_numeric($accion) && ctype_digit($accion)) {
    $sql = $app->getSqlLogon();
    $vistaSession = $session->get('vistaSession');

    $query = mysql_query("SELECT *, now() as now FROM don_comercio WHERE id = $accion LIMIT 1");

    if (mysql_num_rows($query) == 0) {
        $error = "Dicha oferta no está disponible.";
    } else {
        while ($select = mysql_fetch_array($query)) {
            $vendedor = $select['personaje'];
            $precioTipo = $select['precioTipo'];
            $precio = $select['precio'];
            $vendedorCuenta = $select['vendedorCuenta'];
            $idOferta = $select['id'];
            $creditos = $select['creditos'];
            $fechaFin = strtotime($select['fechaFin']);
            $now = strtotime($select['now']);
            $finalizada = $select['finalizada'];
            $compradorAcc = $select['compradorCuenta'];
            $finOferta = $fechaFin - $now;

            if ($precioTipo == "49426") {
                $tipo = "emblemas de Escarcha";
            }

            print '<table class="tabla" style="min-width: 300px;">';
            print '<tr><td>Tipo</td><td>Info</td>';
            print '<tr class="odd"><td>id</td><td>'.$idOferta.'</td></tr>';
            print '<tr class="even"><td>Jugador</td><td>'.$vendedor.'</td></tr>';
            print '<tr class="odd"><td>Créditos</td><td>'.$creditos.'</td></tr>';
            print '<tr class="even"><td>Precio</td><td>'.$precio.' '.$tipo.'</td></tr>';
            if ($compradorAcc) {
                print '<tr class="even"><td colspan="2"><font color="green">¡Esta Oferta ha sido comprada ya!</font></td></tr>';
            }
            if ($finalizada == 0 && $fechaFin > $now) {
                print '<tr class="even"><td>Finaliza en</td><td><span id="time'.$id.'">Cargando...<script>startTimer('.$finOferta.',document.querySelector("#time'.$id.'"))</script></span></td></tr>';
            }
            print '</table>';

            $jugador = $app->limpiarString($_GET['jugador']);
            $reinoC = substr($jugador, 0, 3);
            $nombrePjC = substr($jugador, 6);

            $pjExisten = false;

            $reinoV = substr($vendedor, 0, 3);
            $nombrePjV = substr($vendedor, 6);


            if ($reinoC == "Hul" || $reinoC == "Mid") {
                if ($reinoC == "Hul") {
                    $reino = $app->getReino(1);
                } elseif ($reinoC == "Mid") {
                    $reino = $app->getReino(2);
                }
                
                $pjC = pj::getGuidByNombre($reino, $nombrePjC);
                $guidPjC = $pjC->getGuid();

                if ($reinoV == "Hul" || $reinoV == "Mid") {
                    if ($reinoV == "Hul") {
                        $reino = $app->getReino(1);
                    } elseif ($reinoV == "Mid") {
                        $reino = $app->getReino(2);
                    }

                    $pjV = pj::getGuidByNombre($reino, $nombrePjV);
                    $guidPjV = $pjV->getGuid();
                    if ($guidPjV && $guidPjC) {
                        $pjExisten = true;
                    }
                }
            }

            

            if ($finalizada == 0 && $fechaFin > $now) {
                $ObjPersonajesH = cuenta::getPjsArray($app, $cuenta, 1);
                $ObjPersonajesM = cuenta::getPjsArray($app, $cuenta, 2);
                $arrayPjs = array();
            
                $personajesDinero;

                $app->getReino(1)->getCharSql();
                foreach ($ObjPersonajesH as $pj) {
                    $guid = $pj->getGuid();
                    $nombre = $pj->getNombre();
                    $queryPj = mysql_query("SELECT guid FROM item_instance WHERE owner_guid = $guid AND itemEntry = $precioTipo AND count >= $precio LIMIT 1");
                    if ($selectPj = mysql_fetch_array($queryPj)) {
                        $nombre = "Hul - ".$nombre;
                        array_push($arrayPjs, $nombre);
                    }
                }

                $app->getReino(2)->getCharSql();
                foreach ($ObjPersonajesM as $pj) {
                    $guid = $pj->getGuid();
                    $nombre = $pj->getNombre();
                    $queryPj = mysql_query("SELECT guid FROM item_instance WHERE owner_guid = $guid AND itemEntry = $precioTipo AND count >= $precio LIMIT 1");
                    if ($selectPj = mysql_fetch_array($queryPj)) {
                        $nombre = "Mid - ".$nombre;
                        array_push($arrayPjs, $nombre);
                    }
                }

                if (sizeof($arrayPjs) >= 1) {

                //print "B;".$vistaSession;
                $comprarIdOferta = 'comprar'.$idOferta;
                    if ($_GET['jugador'] && $vistaSession == $comprarIdOferta) {
                        if ($pjExisten == true) {
                            $session->clear('vistaSession');
                            $jugador = $app->limpiarString($_GET['jugador']);
                            if (in_array($jugador, $arrayPjs)) {
                                $reinoC = substr($jugador, 0, 3);
    
                                if ($reinoC == "Hul" || $reinoC == "Mid") {
                                    $sql = $app->getSqlLogon();
    
                                    $conex = mysql_query("SELECT online FROM account WHERE username = '$cuentaNombre' LIMIT 1");
                                    $select = mysql_fetch_array($conex);
                                    if ($select['online'] == 0) {
                                        if ($reinoC == "Hul") {
                                            $reino = $app->getReino(1);
                                        } elseif ($reinoC == "Mid") {
                                            $reino = $app->getReino(2);
                                        }
    
                                        $nombrePjC = substr($jugador, 6);
    
                                        $pjC = pj::getGuidByNombre($reino, $nombrePjC);
                                        $guidPjC = $pjC->getGuid();
    
                                        if (strtoupper($cuentaNombre) != strtoupper($vendedorCuenta)) {
                                            $reino->getCharSql();
        
                                            $queryItemComprar = "UPDATE item_instance SET count = (count - $precio) WHERE itemEntry = $precioTipo AND owner_guid = $guidPjC LIMIT 1";
                                        
        
                                            mysql_query($queryItemComprar)or die(mysql_error());
                                            ;
    
                                            $creditosC = $cuenta->getCreditos();
                                            $creditosDespues = $creditosC + $creditos;
                                            $cuenta->setCreditos($creditosDespues, true);
        
                                            $reinoV = substr($vendedor, 0, 3);
                                            $nombrePjV = substr($vendedor, 6);
                                            if ($reinoV == "Hul") {
                                                $PjV = pj::getGuidByNombre($app->getReino(1), $nombrePjV);
                                                $app->getReino(1)->getCharSql();
                                            } else {
                                                $PjV = pj::getGuidByNombre($app->getReino(2), $nombrePjV);
                                                $app->getReino(2)->getCharSql();
                                            }
        
                                            $guidPjV = $PjV->getGuid();
                                            $cuentaPjV = $PjV->getCuenta();
        
                                            $correo1 = "INSERT INTO don_mail (guid,pj,asunto,contenido,tipo,cantidad, esReenvio, cuenta, idOferta)
										 				VALUES ($guidPjV, '$nombrePjV', 'Comercio Creditos', 'Aqui tienes la recompensa!', 'ITEM', $precio, 0, $cuentaPjV, $idOferta)";
                                            mysql_query($correo1)or die(mysql_error());
                                            $idMail = mysql_insert_id();
                                            $correo2 = "INSERT INTO don_itemmail (idmail,item,quant) 
														VALUES ($idMail,'$precioTipo','1')";
                                            mysql_query($correo2)or die(mysql_error());
        
                                            $sql = $app->getSqlLogon();
                                            $actualizarOferta = "UPDATE don_comercio SET compradorCuenta = '$cuentaNombre', finalizada = 1, compradorCreditosAntes = $creditosC, compradorCreditosDespues = $creditosDespues, compradorPjGuid = $guidPjC, compradorPjNombre = '$jugador', fechaCompra = now() WHERE id = $idOferta";
                                            mysql_query($actualizarOferta)or die(mysql_error());
                                            $finalizarCompra = true;
                                            print '<p style="color:green">Compra realizada correctamente, Créditos: '.$creditosC.' -> '.$creditosDespues.'</p>';
                                            $creds = $creditosDespues;
                                        } else {
                                            $error = "No puedes comprar una oferta a ti mismo.";
                                        }
                                    } else {
                                        $error = "Debes desconectarte del servidor primero.";
                                    }
                                } else {
                                    $error = "Reino no válido";
                                }
                            } else {
                                $error = "Personaje no válido";
                            }
                        } else {
                            $error = "Dicha oferta no está disponible";
                        }
                    } elseif ($_GET['jugador']) {
                        $error = "Los parametros son incorrectos, vuelve al Inicio del Mercado Negro";
                    } elseif ($finalizarCompra == false) {
                        $comprarIdOferta = 'comprar'.$idOferta;
                        $session->set('vistaSession', $comprarIdOferta);
                        print '<h5>Elige un personaje quién se le restará el precio de dicha compra</h5>';
                        print '<form>';
                        print '<input name="vista" value="comprar" type="hidden">';
                        print '<input name="accion" value="'.$accion.'" type="hidden">';
                        print '<select name="jugador">';
                        foreach ($arrayPjs as $pj) {
                            print 'Elige un personaje:';
                            print '<option value="'.$pj.'">'.$pj.'</option>';
                        }
                        print '</select> ';
                        print '<br>';

    
                        print '<input class="boton" value="Comprar Oferta" type="submit">';
    
                        print '</form>';
                    }
                } else {
                    $error = "No posees personajes que posea suficiente cantidad del item pedido.";
                }
            } else {
                $error = "Dicha oferta ya ha finalizado.";
            }
        }
    }
} else {
    $error = "Nop...";
}

if ($error) {
    print '<br><font style="color:red">'.$error.'</font>';
}

print '<br><br>';
