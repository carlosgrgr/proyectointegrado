<?php
require 'clases/Autocarga.php';
require 'lib/api.php';
$bd = new DataBase();
$gestorUsuario = new ManageUsuario($bd);
$sesion = new Session();
$usuario = $sesion->getUser();
if($usuario === NULL){
    $sesion->sendRedirect("login.php");
}
$usuarioEmail = $usuario->getEmail();


if ($usuario !== NULL) {
    ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ajustes de cuenta - Kmler</title>
        <link href="assets/font-awesome-4.6.1/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <header id="nav-login">
            <div class="container">
                <div id="login">
                    <span><i class="fa fa-bars fa-2x" aria-hidden="true"></i></span>
                </div>
                <div id="logo">
                    <img src="images/kmler_logo_rgb.png" alt="logo" />
                </div>
                <div id="boton-menu">
                    <span class="titulo"><?php echo $usuario->getNombre() . " " . $usuario->getApellidos() ; ?></span>
                    <div class="contenido-form">
                        <ul class="dropdown">
                            <li id="menu-perfil">Ver perfil</li>
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

        <div id="wrapper-ajustes" class="container">
            <div class="titulo-ajustes">
                <h1>Ajustes</h1>
            </div>
            <div class="formulario-ajustes">
                <form>
                    <input type="hidden" name="usuario" value="<?php echo $usuarioEmail; ?>" />
                    <div class="ajustes-form-group">
                        <div class="info-part">
                            <h2>Cuenta</h2>
                        </div>
                        <div class="accion-part">
                            <div class="etiquetas">
                                <label for="nombre">Nombre:</label>
                                <label for="apellidos">Apellidos:</label>
                                <label for="email">Email:</label>
                                
                            </div>
                            <div class="cajas">
                                <input type="text" name="nombre" id="nombre" value="<?php echo $usuario->getNombre(); ?>" />
                                <input type="text" name="apellidos" id="apellidos" value="<?php echo $usuario->getApellidos(); ?>"/>
                                <input type="text" name="email" id="emailReg" disabled value="<?php echo $usuarioEmail; ?>" />
                            </div>
                        </div>
                    </div>
                </form>
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
                    <img src="" />
                    <img src="" />
                    <img src="" />
                    <img src="" />
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