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

        <div id="main-registro" class="ajustes">
            <div class="container">
                <section id="slogan">
                    <article>
                        <div>
                            <h1>Ajustes</h1>
                            <h3>Cuenta</h3>
                        </div>
                    </article>
                </section>

                <section id="section-registro">
                    <form id="form-registro" autocomplete="off">
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="nombre">Nombre:</label>
                            </div>
                            <div class="caja">
                                <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>"/>
                                <span class="lg-error"></span>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="apellidos">Apellidos:</label>
                            </div>
                            <div class="caja">
                                <input type="text" name="apellidos" id="apellidos" value="<?php echo $apellidos; ?>"/>
                                <span class="lg-error"></span>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="email">Email:</label>
                            </div>
                            <div class="caja">
                                <input type="text" name="email" id="emailReg" value="<?php echo $email; ?>" disabled="true"/>
                                <span class="lg-error"></span>
                            </div>
                        </div>
                        <div class="form-grupo submit">
                            <div class="etiqueta"></div>
                            <div class="caja botones">
                                <button type="button" id="btcambiaremail" class="button">Cambiar email</button>
                                <button type="button" id="btcambiarclave" class="button">Cambiar contrase&nacute;a</button>
                            </div>
                        </div>
                    </form>
                </section>    
            </div>
            <div class="container">
                <div class="separador"></div>
            </div>
            
            <div class="container">
                <section id="slogan"> 
                    <article>
                        <div>
                            <h3>Im&aacute;gen personal</h3>
                        </div>
                    </article>
                </section>

            <section id="section-registro">
                    <div id="form-registro" autocomplete="off">
                        <div class="form-grupo">
                            <div class="etiqueta">
                            </div>
                            <form action="subirimagen.php" method="post" enctype="multipart/form-data">
                                <div class="caja imagen">
                                    <div class="imagen-perfil">
                                        <img src="<?php echo $imagen; ?>"/>
                                    </div>
                                    <input type="file" name="archivo" id="archivo" class="inputfile"/>
                                    <label for="archivo" class="button labelfile">Elige un archivo</label>
                                    <input type="submit" id="subirimagen" value="Subir im&aacute;gen" />
                                </div>
                            </form>
                        </div>
                        
                    </div>
                </section>    
            </div>
            <div class="container">
                <div class="separador"></div>
            </div>
            <div class="container">
                <section id="slogan"> 
                    <article>
                        <div>
                            <h3>Ajustes f&iacute;sicos</h3>
                            <p>Tus ajustes f&iacute;sicos te ofrecen una gu&iacute;a y una interpretaci&oacute;n m&aacute;s exacta de tus sesiones de entrenamiento. Tus ajustes f&iacute;sicos nunca se har&aacute;n p&uacute;blicos.</p>
                        </div>
                    </article>
                </section>

                <section id="section-registro">
                    <form id="form-registro">
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="sexo">Sexo:</label>
                            </div>
                            <div class="caja radio">
                                <?php echo $radiohombre; ?>
                                <label class="button left" for="label-hombre">Hombre</label>
                                <?php echo $radiomujer; ?>
                                <label class="button right" for="label-mujer">Mujer</label>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label>Fecha de nacimiento:</label>
                            </div>
                            <div class="caja select">
                                <select id="select-dia">
                                    <?php echo $selectdia; ?>
                                </select>
                                <select id="select-mes">
                                    <?php echo $selectmes; ?>
                                </select>
                                <select id="select-ano">
                                    <?php echo $selectano; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="altura">Altura:</label>
                            </div>
                            <div class="caja">
                                <input type="text" name="altura" id="altura" value="<?php echo $datosfisicos["altura"]; ?>" />
                                <span class="lg-error"></span>
                                
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="peso">Peso:</label>
                            </div>
                            <div class="caja">
                                <input type="text" name="peso" id="peso" value="<?php echo $datosfisicos["peso"]; ?>" />
                                <span class="lg-error"></span>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="fcmax">Frecuencia cardiaca m&aacute;xima</label>
                            </div>
                            <div class="caja wrap">
                                <input type="text" name="fcmax" id="fcmax" value="<?php echo $datosfisicos["fcmax"]; ?>" /><br/>
                                <span class="explicacion">El n&uacute;mero m&aacute;ximo de pulsaciones por minuto (ppm) que puedes alcanzar durante un esfuerzo de gran intensidad.</span><br/>
                                <span class="lg-error"></span>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="fcrep">Frecuencia cardiaca en reposo</label>
                            </div>
                            <div class="caja wrap">
                                <input type="text" name="fcrep" id="fcrep" value="<?php echo $datosfisicos["fcrep"]; ?>" /><br/>
                                <span class="explicacion">El n&uacute;mero m&iacute;nimo de pulsaciones por minuto (ppm) en reposo absoluto.</span><br/>
                                <span class="lg-error"></span>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="fcmax">IMC</label>
                            </div>
                            <div class="caja wrap">
                                <input type="text" name="imc" id="imc" value="<?php echo $datosfisicos["imc"]; ?>" disabled="true"/><br/>
                                <span class="explicacion">Una medida sencilla para indicar peso normal, bajo peso o sobrepeso. El c&aacute;lculo se basa en el peso y la altura.</span><br/>
                                <span class="lg-error"></span>
                            </div>
                        </div>
                        
                        <div class="form-grupo submit">
                            <div class="etiqueta"></div>
                            <div class="caja fin">
                                <button type="button" id="btGuardar" class="button">Guardar</button>
                                <button type="button" id="btCancelar" class="button cancelar">Cancelar</button>
                            </div>
                        </div>
                    </form>
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