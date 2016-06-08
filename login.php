<?php
require 'clases/Autocarga.php';
$bd = new DataBase();
$gestorUsuario = new ManageUsuario($bd);
$sesion = new Session();
?>

<!DOCTYPE html>
<html>

    <head>
        <title>Kmler</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="assets/font-awesome-4.6.1/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="css/style.css" rel="stylesheet" type="text/css" />
    </head>

    <body id="loginbody">
        <header id="nav-login">
            <div class="container">
                <div id="login">
                    <span><i class="fa fa-bars fa-2x" aria-hidden="true"></i></span>
                </div>
                <div id="logo">
                    <img src="images/kmler_logo_rgb.png" alt="logo" />
                </div>
                <div id="boton-menu">
                    <span class="titulo">Iniciar sesión</span>
                </div>
                <form id="form-login">
                    <div class="contenido-form">
                        <input type="text" id="email" placeholder="Email" />
                        <input type="password" id="clave" placeholder="Contraseña" />
                        <button class="button" id="btLogin">Iniciar sesión</button>
                        <span class="lg-error"></span>
                        <p class="small">
                            <a id="olvidaClave" href="resetClave.php">¿Has olvidado la contraseña?</a>
                        </p>
                        <p class="small">
                            <a id="registrarUsuario" href="registrar.php">Crea tu cuenta para poder acceder.</a>
                        </p>
                    </div>
                </form>
            </div>
            <div id="menu-lateral">
                <p></p>
            </div>
        </header>

        <div id="main-login">
            <div class="container">
                <section id="slogan">
                    <article>
                        <h1>Kmler</h1>
                        <p>La aplicación web para tener un seguimiento exhaustivo de todos tus entrenamientos. Entra y podrás analizar cualquier detalle de tus sesiones deportivas.</p>
                    </article>
                </section>

                <section id="section-tarjetas">
                    <article class="tarjeta">
                        <div>
                            <img src="images/australian-sports-technology-network.jpg"/>
                            <div class="texto">
                                <h2>Sincroniza tu dispositivo Kmler</h2>
                                <p>Si ya cuentas con un dispositivo Kmler, sincronizalo con la aplicación y podrás seguir y analizar cualquier sesión de entramiento.</p>
                            </div>
                        </div>
                    </article>

                    <article class="tarjeta">
                        <div>
                            <img src="images/graficas2.jpg"/>
                            <div class="texto">
                                <h2>Tus datos en gráficas</h2>
                                <p>Podrás ver datos de tus sesiones de entrenamiento de la forma más clara en gráficas. Recrea tus sensaciones y velocidad viendo las curvas del entrenamiengo.</p>
                            </div>
                        </div>
                    </article>

                    <article class="tarjeta">
                        <div>
                            <img src="images/Captura2.png" />
                            <div class="texto">
                                <h2>Revive tus rutas</h2>
                                <p>Vuelve a vivir tus rutas y entrenamientos observando los sitios por donde has pasado realizando la actividad que más te gusta.</p>
                            </div>
                        </div>
                    </article>
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
                    <a href="#S"><img src="images/icono/twitter-icon.png" /></a>
                    <a href="#"><img src="images/icono/instagram-icon.png" /></a>
                    <a href="#"><img src="images/icono/youtube-icon.png" /></a>
                </div>
            </div>
        </footer>

        <script src="javascript/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="javascript/main.js" type="text/javascript"></script>
    </body>

</html>