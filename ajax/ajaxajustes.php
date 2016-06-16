<?php
header("Content-Type: text/html;charset=utf-8");
require '../clases/Autocarga.php';
require '../lib/api.php';
$bd = new DataBase();
$lk = conectarKmler();
mysqli_query($lk, "SET NAMES 'utf8'");
$gestorUsuario = new ManageUsuario($bd);
$email = Request::post("email");
$nombre = Request::post('nombre');
$apellidos = Request::post('apellidos');
$sexo = Request::post("sexo");
$dia = Request::post("dia");
$mes = Request::post("mes");
$ano = Request::post("ano");
$timestamp = strtotime($ano . "-" . $mes . "-" . $dia);
$fechanacimiento = date("Y-m-d", $timestamp);
$altura = Request::post("altura");
$peso = Request::post("peso");
$fcmax = Request::post("fcmax");
$fcrep = Request::post("fcrep");
$fechaactual = date("Y-m-d", time());

$alturametros = $altura / 100;
$imc = $peso / ($alturametros * $alturametros);
$imc = number_format($imc, 2, '.', '');

$query = "SELECT * FROM datosfisicos WHERE usuario = '$email' AND fecha = '$fechaactual'";
$result = mysqli_query($lk, $query);

if($result->num_rows > 0){
    $updateDatosfisicos = "UPDATE datosfisicos SET altura = $altura, peso = $peso, fcmax = $fcmax, fcrep = $fcrep, imc = $imc WHERE usuario = '$email' AND fecha = '$fechaactual'";
    echo mysqli_query($lk, $updateDatosfisicos);
}else{
    $insert = "INSERT INTO datosfisicos(usuario, fecha, altura, peso, fcmax, fcrep, imc)
                VALUES ('$email', '$fechaactual', $altura, $peso, $fcmax, $fcrep, $imc)";
    echo mysqli_query($lk, $insert);
}

$update = "UPDATE usuarios SET nombre= '$nombre', apellidos = '$apellidos', sexo = '$sexo',
            fechanacimiento = '$fechanacimiento' WHERE email = '$email'";
echo mysqli_query($lk, $update);

