<?php
require '../clases/Autocarga.php';
$bd = new DataBase();
$gestorUsuario = new ManageUsuario($bd);
$email = Request::post("email");
$clave = Request::post("clave");
$usuario = $gestorUsuario->get($email);
$sesion = new Session();

if($usuario != null && $email === $usuario->getEmail() && sha1($clave) === $usuario->getClave()){
    $sesion->setUser($usuario);
    echo 1;
}else{
    echo 0;
}
