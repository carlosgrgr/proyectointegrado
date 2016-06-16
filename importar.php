<?php
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
$deportes = array();
$queryDeportes = "select nombre from deportes";
if ($result = mysqli_query($lk, $queryDeportes)) {
    while ($obj = $result->fetch_object()) {
        array_push($deportes, $obj->nombre);
    }
}
$selectDeportes = "";
for($d = 0; $d < count($deportes); $d++){
    $selectDeportes .= '<option value="'. $deportes[$d] .'">' . $deportes[$d] . '</option>';
}

if ($usuario !== NULL) {
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <title></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/font-awesome-4.6.1/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
        <script src="javascript/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="javascript/main.js" type="text/javascript"></script>
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
                    <p>ñalskdfj</p>
                </div>
            </header>

            <div id="wrapper-import">
                <div id="formularios" class="container">
                    <h2>Añadir el resultado de un entrenamiento</h2>
                    <div id="import-archivo">
                        <section id="slogan">
                            <form action="subir.php" method="post" enctype="multipart/form-data">
                                <article>
                                    <h3>Subir entrenamiento</h3>
                                    <p>Rellene todos los datos que conozcas. Cuantos más datos introduzca, mejor será el análisis del entrenamiento.</p>
                                    <div class="row-form">
                                        <span>Deporte: </span>
                                        <select id="deportes" name="deportes">
                                            <?php echo utf8_encode($selectDeportes); ?>
                                        </select>
                                    </div>
                                    <div class="row-form">
                                        <span>Archivo: </span>
                                        <input type="file" name="archivo" id="archivo" class="inputfile"/>
                                        <label for="archivo" class="button">Elige un archivo</label>
                                    </div>
                                    <p>
                                        <input type="submit" class="button" id="btimport" value="Importar" />
                                    </p>
                                </article>
                            </form>
                        </section>
                    </div>

                    <div id="import-manual">

                    </div>
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
        <script src="assets/CustomFileInputs/js/custom-file-input.js"></script> 
    </body>
</html>
<?php
} else {
    $sesion->sendRedirect("login.php");
}