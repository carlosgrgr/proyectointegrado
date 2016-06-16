<?php
require 'clases/Autocarga.php';
require 'lib/api.php';
$lk = conectarKmler();
$subir = new FileUpload("archivo");
$sesion = new Session();
$bd = new DataBase();
$gestorUsuario = new ManageUsuario($bd);
$gestorActividad = new ManageActividad($bd);
$usuario = $sesion->getUser();
$email = $usuario->getEmail();
$usuario = $gestorUsuario->get($email);
$extension = $subir->getExtension();
$nombre = $usuario->getNombre();

$carpeta = "archivos/$email/img/";
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
$subir->setDestino("archivos/". $email . "/img/");
$subir->setTamano(10485760);
$subir->setNombre($nombre);
$subir->setPolitica(FileUpload::REEMPLAZAR);

$path = $subir->getDestino() . $subir->getNombre() . "." . $extension;

if($subir->upload()) {
    $update = "UPDATE usuarios SET imagen = '$path' WHERE email = '$email'";
    mysqli_query($lk, $update);
    header("Location:ajustes.php");
}else{
    header("Location:ajustes.php?error=subir");
}