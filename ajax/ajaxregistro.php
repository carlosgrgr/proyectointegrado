<?php
require '../clases/Autocarga.php';
$bd = new DataBase();
$gestorUsuario = new ManageUsuario($bd);

$nombre = Request::post("nombre");
$apellidos = Request::post("apellidos");
$email = Request::post("email");
$clave = Request::post("clave");
$claveR = Request::post("claveR");
$terminos = Request::post("terminos");

if($nombre != "" && $apellidos != "" && $clave != "" && $claveR != "" && $terminos && $clave === $claveR){
    $usuario = new Usuario($email, sha1($clave), $nombre, $apellidos);
    $r = $gestorUsuario->insert($usuario);
    echo $r;
}else{
    echo -1;
}