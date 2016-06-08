<?php
require '../clases/Autocarga.php';
require '../lib/api.php';
$subir = new FileUpload("file");
$sesion = new Session();
$bd = new DataBase();
$gestorUsuario = new ManageUsuario($bd);
$gestorActividad = new ManageActividad($bd);
$usuario = $sesion->getUser();

$email = $usuario->getEmail();
$extension = $subir->getExtension();
$fecha = time();

$carpeta = "../archivos/$email/";
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}
$subir->setDestino("../archivos/". $email . "/");
$subir->setTamano(10485760);
$subir->setNombre($fecha);
$subir->setPolitica(FileUpload::RENOMBRAR);
if($subir->upload()) {
    
    $archivo = $subir->getDestino().$subir->getNombre().".".$subir->getExtension();
    
    $tcx = new Tcx($archivo, $email);
    $dom = $tcx->xmlDom($archivo);

    $fInicio = $tcx->getInicio($archivo, "timestamp");
    $duracion = $tcx->getDuracion($archivo);
    $url = "archivos/" . $email . "/" . $fInicio . "." . $extension;
    $actividad = new Actividad(0, $email, date("Y-m-d H:i:s", $fInicio), $duracion, "ciclismo de carretera", $url);
    if($gestorActividad->insert($actividad)){
        rename("../archivos/" . $email . "/" . $fecha . "." . $extension, "../archivos/" . $email . "/" . $fInicio . "." . $extension);
        if($tcx->tcxtokml("../archivos/" . $email . "/" . $fInicio . "." . $extension, $email)){
            echo 1;
        }else{
            echo 0;
        }
    }else{
        echo -1;
        unlink("../archivos/" . $email . "/" . $fecha . "." . $extension);
    }

    echo 0;
}else{
//    echo 1;
}