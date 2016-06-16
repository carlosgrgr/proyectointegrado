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
$actividades = array();
$queryActividades = "SELECT * FROM actividades a
                        INNER JOIN deportes d ON a.deporte = d.nombre  
                     WHERE usuario = '$email'";

if ($result = mysqli_query($lk, $queryActividades)) {
    while ($obj = $result->fetch_object()) {
        array_push($actividades, array(
            "id" => $obj->id,
            "fechaInicio" => $obj->fechaInicio,
            "duracion" => $obj->duracion,
            "deporte" => $obj->deporte,
            "url" => $obj->url,
            "icono" => $obj->icono
                )
        );
    }
}
$eventos = "";
for ($i = 0; $i < count($actividades); $i++) {
    $id = $actividades[$i]["id"];
    $duracion = $actividades[$i]["duracion"];
    $fechaInicio = $actividades[$i]["fechaInicio"];
    $icono = $actividades[$i]["icono"];
    $eventos .= "{id: '$id', title: '$duracion', start: '$fechaInicio', icono: '$icono', url: 'training.php?id=$id'},";
}
$eventos = substr($eventos, 0, -1);

if ($usuario !== NULL) {
    ?>

    <!DOCTYPE html>
    <html lang="es">

        <head>
            <title>Kmler</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="assets/font-awesome-4.6.1/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
            <link href="assets/fullcalendar-2.7.1/fullcalendar.print.css" rel="stylesheet" type="text/css" media='print' />
            <link href="assets/fullcalendar-2.7.1/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
            <link href="css/style.css" rel="stylesheet" type="text/css" />
            <script src="javascript/jquery-2.2.3.min.js" type="text/javascript"></script>
            <script src="assets/fullcalendar-2.7.1/lib/moment.min.js" type="text/javascript"></script>
            <script src="assets/fullcalendar-2.7.1/fullcalendar.min.js" type="text/javascript"></script>
            <script src="assets/fullcalendar-2.7.1/lang/es.js" type="text/javascript"></script>
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
                    <p></p>
                </div>
            </header>

            <div id="main" class="container">
                <div id="calendar">  
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

            <script>
                $('#calendar').fullCalendar({
                    eventClick: function() {
                        $(this).css('border-color', 'red');
                    },
                  
                    customButtons: {
                        addEvent: {
                            text: 'Añadir',
                            click: function () {
                                document.location = "importar.php";
                            }
                        }
                    },
                    editable: false,
                    header: {
                        left: 'prev,next, title',
                        right: 'today, month,agendaWeek,agendaDay, addEvent'
                    },
                    contentHeight: 700,
                    views: {
                        month: {// name of view
                            titleFormat: 'MMMM YYYY'
                                    // other view-specific options here
                        }
                    },
                    buttonText: {
                        prevYear: 'Prev'
                    },
                    columnFormat: {
                        month: 'dddd', // Monday, Wednesday, etc
                    },
                    dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
//                    eventColor: '#FFFFFF',
                    events: [<?php echo $eventos; ?>],
                    eventRender: function(event, element) {
                        element.find(".fc-content").append($("<span class=\"fc-event-icon\"><img src='" + event.icono + "'/></span>"));
                    }
                });
            </script>

        </body>
    </html>
    <?php
} else {
    $sesion->sendRedirect("login.php");
}