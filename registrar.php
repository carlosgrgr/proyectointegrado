<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
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
                <p>ñalskdfj</p>
            </div>
        </header>

        <div id="main-registro">
            <div class="container">
                <section id="slogan">
                    <article>
                        <h3>¿Ya tiene una cuenta creada anteriormente con Kmler?</h3>
                        <p>Inicie aquí una sesión con su cuenta anterior</p>
                        <p>
                            <button class="button" id="btLogin2">Iniciar sesión</button>
                        </p>
                        <h3>¿Para qué sirve una cuenta Kmler?</h3>
                        <p>Es la puerta de entrada para tener un seguimiento total de tu actividad física y poder observar toda tu progresión.
                    </article>
                </section>

                <section id="section-registro">
                    <form id="form-registro">
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="nombre">Nombre:</label>
                            </div>
                            <div class="caja">
                                <input type="text" name="nombre" id="nombre"/>
                                <span class="lg-error"></span>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="apellidos">Apellidos:</label>
                            </div>
                            <div class="caja">
                                <input type="text" name="apellidos" id="apellidos"/>
                                <span class="lg-error"></span>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="email">Email:</label>
                            </div>
                            <div class="caja">
                                <input type="text" name="email" id="emailReg"/>
                                <span class="lg-error"></span>
                                
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="clave">Contraseña:</label>
                            </div>
                            <div class="caja">
                                <input type="password" name="clave" id="claveReg"/>
                                <span class="lg-error"></span>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="claveR">Repita su contraseña:</label>
                            </div>
                            <div class="caja">
                                <input type="password" name="claveR" id="claveR"/>
                                <span class="lg-error"></span><br/>
                                <span class="lg-error e2"></span>
                            </div>
                        </div>
                        <div class="form-grupo">
                            <div class="etiqueta">
                                <label for="claveR">Términos de uso:</label>
                            </div>
                            <div class="caja">
                                <input type="checkbox" name="terminos" value="true" id="terminos"/>
                                <span>Sí, he leido y acepto los Términos de uso y la Política de privacidad de Kmler
                            </div>
                        </div>
                        <div class="form-grupo submit">
                            <div class="etiqueta"></div>
                            <div class="caja">
                                <button type="button" id="btRegistro" class="button">Crear cuenta</button>
                            </div>
                        </div>
                        <div class="form-grupo submit">
                            <div class="etiqueta"></div>
                            <div class="caja">
                                <span class="mensaje"></span>
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
