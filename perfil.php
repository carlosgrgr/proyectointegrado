<?php
header('Content-Type: text/html; charset=utf-8');
require 'clases/Autocarga.php';
require 'lib/api.php';
$lk = conectarKmler();
$bd = new DataBase();
$gestorUsuario = new ManageUsuario($bd);
$gestorDatosfisicos = new ManageDatosfisicos($bd);
$sesion = new Session();
$usuario = $sesion->getUser();
if ($usuario === NULL) {
    $sesion->sendRedirect("login.php");
}
$email = $usuario->getEmail();
$usuario = $gestorUsuario->get($email);
$nombre = $usuario->getNombre();
$apellidos = $usuario->getApellidos();
$imagen = $usuario->getImagen();
$datosfisicos = array();
$querydatos = "SELECT * FROM datosfisicos where usuario = '$email' ORDER BY fecha DESC LIMIT 1";
if ($result = mysqli_query($lk, $querydatos)) {
    while ($obj = $result->fetch_object()) {
        $datosfisicos['altura'] = $obj->altura;
        $datosfisicos['peso'] = $obj->peso;
        $datosfisicos['fcmax'] = $obj->fcmax;
        $datosfisicos['fcrep'] = $obj->fcrep;
        $datosfisicos['imc'] = $obj->imc;
    }
}
$query = "SELECT fechanacimiento, sexo FROM usuarios WHERE email = '$email'";
if ($result = mysqli_query($lk, $query)) {
    while ($obj = $result->fetch_object()) {
        $datosfisicos["sexo"] = $obj->sexo;
        $datosfisicos["fechanacimiento"] = $obj->fechanacimiento;
    }
}
if($datosfisicos["fechanacimiento"] != null){
    $dia = date('d', strtotime($datosfisicos["fechanacimiento"]));
    $mes = date("m", strtotime($datosfisicos["fechanacimiento"]));
    $ano = date("Y", strtotime($datosfisicos["fechanacimiento"]));
}else{
    $dia = date("d", time());
    $mes = date("m", time());
    $ano = date("Y", time());
}

$selectdias = "";
$selectmes = "";
$selectano = "";
for($d = 1; $d < 32; $d++){
    if($d == $dia){
        $selectdia .= '<option value="' . $d . '" selected>' . $d . '</option>';
    }else{
        $selectdia .= '<option value="' . $d . '">' . $d . '</option>';
    }
}
$nombreMeses = array(0, "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Nomviembre", "Diciembre");
for($m = 1; $m < 13; $m++){
    if($m == $mes){
        $selectmes .= '<option value="' . $m . '" selected>' . $nombreMeses[$m] . '</option>';
    }else{
        $selectmes .= '<option value="' . $m . '">' . $nombreMeses[$m] . '</option>';
    }
}
for($a = $ano; $a > 1969; $a--){
    if($a == $ano){
        $selectano .= '<option value="' . $a . '" selected>' . $a . '</option>';
    }else{
        $selectano .= '<option value="' . $a . '">' . $a . '</option>';
    }
}

if($datosfisicos['sexo'] != null){
    switch ($datosfisicos['sexo']){
        case "M":
            $radiohombre = '<input type="radio" id="label-hombre" name="sexo" value="M" checked>';
            $radiomujer = '<input type="radio" id="label-mujer" name="sexo" value="F">';
            break;
        case "F":
            $radiohombre = '<input type="radio" id="label-hombre" name="sexo" value="M">';
            $radiomujer = '<input type="radio" id="label-mujer" name="sexo" value="F" checked>';
    }
}else{
    $radiohombre = '<input type="radio" id="label-hombre" name="sexo" value="M">';
    $radiomujer = '<input type="radio" id="label-mujer" name="sexo" value="F">';
}

if ($usuario !== NULL) {
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
        <title></title>
        <link href="assets/font-awesome-4.6.1/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body class="logged">
        <div id="loading">
                <div class="spinner">
                    <div class="bounce1"></div>
                    <div class="bounce2"></div>
                    <div class="bounce3"></div>
                </div>
            </div>
            <header id="nav-login">
                <div class="container">
                    <div id="login">
                        <span><i class="fa fa-bars fa-2x" aria-hidden="true"></i></span>
                    </div>
                    <div id="logo">
                        <a href="index.php"><img src="images/kmler_logo_rgb.png" alt="logo" /></a>
                    </div>
                    <div id="boton-menu">
                        <span class="titulo"><?php echo $nombre . " " . $apellidos; ?><img src="<?php echo $imagen; ?>"/></span>
                        <div class="contenido-form">
                            <ul class="dropdown">
                                <a href="index.php">
                                    <li id="menu-inicio">Inicio</li>
                                </a>
                                <a href="perfil.php">
                                    <li id="menu-perfil">Ver perfil</li>
                                </a>
                                <a href="ajustes.php">
                                    <li id="menu-ajustes">Ajustes</li>
                                </a>
                                <li id="btLogout">Cerrar sesión</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div id="menu-lateral">
                    <p></p>
                </div>
            </header>

        <div id="main-perfil">
            <div class="container">
                <section id="slogan">
                    <article>
                        <div>
                            <h1>Tu perfil</h1>
                        </div>
                    </article>
                </section>
                <section id="section-perfil">
                    <div id="datos-personales">
                        <div id="imagen">
                            <img src="<?php echo $imagen; ?>"/>
                        </div>
                        <h2><?php echo $nombre . " " . $apellidos; ?></h2>
                        <div id="total-sesiones">
                            <i class="fa fa-calendar-o" aria-hidden="true"></i> <?php echo $entrenamientos; ?> entrenamientos.
                        </div>
                    </div>
                    
                    <div id="resumen">
                        <div class="resumen-caja">
                            <div class="resumen-content">
                                <div class="icono">
                                    <img src="images/icono/calendar-icon.png" width="36" height="36"/>
                                </div>
                                <div class="texto">
                                    <p class="valor"> <?php echo $entrenamientos; ?> </p>
                                    <p class="dato">Sesiones de entrenamiento</p>
                                </div>
                            </div>
                        </div>
                        <div class="resumen-caja">
                            <div class="resumen-content">
                                <div class="icono">
                                    <img src="images/icono/timing.png" width="36" height="36"/>
                                </div>
                                <div class="texto">
                                    <p class="valor"> <?php echo $duracion; ?> </p>
                                    <p class="dato">Duración total</p>
                                </div>
                            </div>
                        </div>
                        <div class="resumen-caja">
                            <div class="resumen-content">
                                <div class="icono">
                                    <img src="images/icono/distance.png" width="36" height="36"/>
                                </div>
                                <div class="texto">
                                    <p class="valor"> <?php echo $distancia; ?> </p>
                                    <p class="dato">Distancia total</p>
                                </div>
                            </div>
                        </div>
                        <div class="resumen-caja">
                            <div class="resumen-content">
                                <div class="icono">
                                    <img src="images/icono/imgres.png" width="36" height="36"/>
                                </div>
                                <div class="texto">
                                    <p class="valor"> <?php echo $calorias; ?> </p>
                                    <p class="dato">Calor&iacute;as total</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>    
            </div>   
        </div>


        <footer>
            <div id="footer" class="container">
                <div id="legal">
                    <a href="#">&#169; Kmler 2016</a>
                    <a href="#">Términos de uso</a>
                    <a href="#">Política de privacidad</a>
                    <a href="#">Atención al cliente</a>
                </div>
                <div id="social">
                    <p>Síguenos en</p>
                    <a href="#"><img id="fb" src="images/icono/facebook-icon.png" /></a>
                    <a href="#"><img src="images/icono/twitter-icon.png" /></a>
                    <a href="#"><img src="images/icono/instagram-icon.png" /></a>
                    <a href="#"><img src="images/icono/youtube-icon.png" /></a>
                </div>
            </div>
        </footer>

        <script src="javascript/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="javascript/main.js" type="text/javascript"></script>
    </body>
</html>
    <?php
} else {
    $sesion->sendRedirect("login.php");
}