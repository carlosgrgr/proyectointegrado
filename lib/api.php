<?php
function conectarKmler(){
    $server = "localhost";
    $bbdd = "kmler";
    $user = "mystudio19";
    $pass = "eJ441E0c";

    $link = new mysqli($server, $user, $pass, $bbdd);

    if ($link->connect_error) {
      die('Error de Conexión (' . $link->connect_errno . ') '
        . $link->connect_error);
    }else{
      return $link;
    }
}

function mostrarDatos($array){
  echo "<pre>";
  print_r($array);
  echo "</pre>";
}