<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Europe/Madrid");

$data = $this->input->post();
if ($data['page'] > 0) {
    $app = new App();
    
    $page = $data['page'];
    $cur_page = $page;
    $page -= 1;
    $per_page = 6; // Per page records

    $start = $page * $per_page;
    
    //print $start." ".$per_page;
    print '<div style="display: table; text-align: center;">';
    $subastas = $app->getSubastas($start, $per_page);

    foreach ($subastas as $oferta) {
        $pj = $oferta->getPersonaje();
        $creditos = $oferta->getCreditos();
        if ($oferta->getPrecioTipo() == 49426) {
            $ofertaTipo = "emblemas de escarcha";
        }
        $precio = $oferta->getPrecio().' '.$ofertaTipo;
        $fechaFin = strtotime($oferta->getFechaFin());
        $now = strtotime($oferta->getFechaInicio());
        $finOferta = $fechaFin - $now;

        print '<a href="comercio?vista=comprar&accion='.$oferta->getId().'"><div class="caja">
                <div class="cajaImagen">
                    <img src="https://static.terra-golfa.com/img/icons/coin-icon.png">';
        print '<span style="position: absolute; margin: 45px 0px 0px -16px; background-color: rgb(59, 58, 125); min-width: 24px; border-radius: 15px; height: 23px;">'.$creditos.'</span>';

        print '</div>
                <div class="cajaBody">';
        print '<p><font class=descripcion>Vendedor: </font>'.$pj.'</p>';
        print '<p><font class=descripcion>Finaliza en: </font><span id="time'.$oferta->getId().'">Cargando...<script>startTimer('.$finOferta.',document.querySelector("#time'.$oferta->getId().'"))</script></span></p>';
        print '<p><font class=descripcion>Precio: </font>'.$precio.'</p>';
        print '</div></div></a>';
    }
    if (sizeof($subastas) <=0) {
        print 'No existen ofertas actualmente';
    }

    $count = $app->getRowsSUbastas();
    $no_of_paginations = ceil($count / $per_page);

    if ($cur_page >= 7) {
        $start_loop = $cur_page - 3;
        if ($no_of_paginations > $cur_page + 3) {
            $end_loop = $cur_page + 3;
        } elseif ($cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6) {
            $start_loop = $no_of_paginations - 6;
            $end_loop = $no_of_paginations;
        } else {
            $end_loop = $no_of_paginations;
        }
    } else {
        $start_loop = 1;
        if ($no_of_paginations > 7) {
            $end_loop = 7;
        } else {
            $end_loop = $no_of_paginations;
        }
    }

    print "<div class='pagination'><ul class='paginate'>";

    // FOR ENABLING THE Primero BUTTON
    if ($cur_page > 1) {
        print "<li p='1' class='active paginateLi'>Primero</li>";
    } else {
        print '<li style="float: left; width: 62.11px; padding: 0px 6px 1px;"></li>';
    }

    // FOR ENABLING THE Anterior BUTTON
    if ($cur_page > 1) {
        $pre = $cur_page - 1;
        print "<li p='$pre' class='active paginateLi'>Anterior</li>";
    } else {
        print '<li style="float: left; width: 63.5px; padding: 0px 6px 1px;"></li>';
    }

    for ($i = $start_loop; $i <= $end_loop; $i++) {
        if ($cur_page == $i) {
            print "<li p='$i' style='color:#fff;background-color:#006699;' class='active paginateLi'>{$i}</li>";
        } else {
            print "<li p='$i' class='active paginateLi'>{$i}</li>";
        }
    }

    // TO ENABLE THE Siguiente BUTTON

    if ($cur_page < $no_of_paginations) {
        $nex = $cur_page + 1;
        print "<li p='$nex' class='active paginateLi'>Siguiente</li>";
    } else {
        print '<li style="float: left; width: 71.14px; padding: 0px 6px 1px;"></li>';
    }

    // TO ENABLE THE END BUTTON
    if ($cur_page < $no_of_paginations) {
        print "<li p='$no_of_paginations' class='active paginateLi'>Último</li>";
    } else {
        print '<li style="float: left; width: 53.74px; padding: 0px 6px 1px;"></li>';
    }

    print '</div>';
}
