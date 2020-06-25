<?php

function mostrar_matriz($matriz,$título="",$nivel=0) {

  // Parámetros
  //    - $matriz = matriz cuyo contenido se debe mostrar
  //    - $título = título que se debe mostrar sobre el contenido
  //    - $nivel = nivel de visualización

  // Si hay un título, mostrarlo.
  if ($título != "") {
    echo "<br /><b>$título</b><br />";
  }

  // Comprobar si hay datos.
  if (isset($matriz)) { // hay datos

    // Examinar la matriz con parámetros.
    reset ($matriz);
    foreach ($matriz as $clave => $valor) {

      // Mostrar la clave (con sangría función
      // del nivel).
      echo
        str_pad('',12*$nivel, '&nbsp;'),
        htmlentities($clave,ENT_QUOTES|ENT_XHTML,'UTF-8'),' = ';

      // Mostrar el valor
      if (is_array($valor)) { // es una matriz ...

        // incluir una etiqueta <br />
        echo '<br />';
        // Y llamar de manera recursiva a mostrar_matriz para
        // mostrar la matriz en cuestión (sin título y
        // a nivel siguiente para la sangría)
        mostrar_matriz($valor,'',$nivel+1);

      } else { // es un valor escalar

        // Mostrar el valor.
        echo htmlentities($valor,ENT_QUOTES|ENT_XHTML,'UTF-8'),'<br />';

      }

    }

  } else { // sin datos

    // incluir una simple etiqueta <br />
    echo '<br />';

  }

}


function hacia_formulario($valor) {

  // presentación en un formulario

  // codificar todos los caracteres HTML especiales
  //  - ENT_QUOTES: incluyendo " y '
  return htmlentities($valor,ENT_QUOTES|ENT_HTML5,'UTF-8');

}


function hacia_página($valor) {

  // presentación directa en una página

  // 1. codificar todos los caracteres HTML especiales
  //  - ENT_QUOTES: incluyendo " y '
  // 2. transformar los saltos de línea en <br />
  return nl2br(htmlentities($valor,ENT_QUOTES|ENT_HTML5,'UTF-8'));

}


function construir_consulta($sql) {

  // Recuperar el número de parámetro.
  $número_param = func_num_args();

  // Hacer bucle en todos los parámetros a partir del segundo
  // (el primero contiene la consulta de base).
  for($i=1;$i<$número_param;$i++) {

    // Recuperar el valor del parámetro.
    $valor = func_get_arg($i);

    // Si es una cadena, escaparla.
    if (is_string($valor)) {
      $valor = str_replace("'","''",$valor);
    }

    // Colocar el valor en su ubicación %n (n = $i).
    $sql = str_replace("%$i",$valor,$sql);
  }

  // Devolver la consulta.
  return $sql;

}


function identificador_único() {

  // generación del identificador
  return md5(uniqid(rand()));

}


function url($url) {

  // si la directiva de configuración session.use_trans_sid 
  // está en 0 (ninguna transmisión automática a través de la URL) y 
  // si SID no está vacío (el equipo ha rechazado la cookie), entonces
  // es necesario gestionar él mismo la transmisión

  if ((get_cfg_var("session.use_trans_sid") == 0) and (SID != "")) {
  
    // agregar la constante SID detrás de la URL con un ? 
    // si todavía no hay ningún parámetro o con un & en
    // caso contrario.

    $url .= ((strpos($url,"?") === FALSE)?"?":"&").SID;

  }

  return $url;

}

?>
