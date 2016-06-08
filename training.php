<?php
ini_set('max_execution_time', 300);
setlocale(LC_ALL,"es_ES");
require 'clases/Autocarga.php';
require 'lib/api.php';
$lk = conectarKmler();
$bd = new DataBase();
$gestorUsuario = new ManageUsuario($bd);
$gestorActividad = new ManageActividad($bd);
$sesion = new Session();
$usuario = $sesion->getUser();
if ($usuario === NULL) {
    $sesion->sendRedirect("login.php");
}
$id = Request::get("id");
$actividad = $gestorActividad->get($id);
$deporte = $actividad->getDeporte();
$queryDeporte = "Select icono from deportes where nombre = '$deporte'";
if ($result = mysqli_query($lk, $queryDeporte)) {
    while ($obj = $result->fetch_object()) {
        $icono = $obj->icono;
    }
}
$fechaInicio = $actividad->getFechaInicio();
$dias = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sábado","Domingo");
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fechaInicio = $dias[date('w', strtotime($fechaInicio))]." ".date('d', strtotime($fechaInicio))." de ".$meses[date('n', strtotime($fechaInicio))-1]. 
        " del ".date('Y', strtotime($fechaInicio)) . " " . date('H', strtotime($fechaInicio)) . ":" . date('i', strtotime($fechaInicio)) ;
$url = $actividad->getUrl();
$url = substr($url, 0, -3);
$url .= "kml";

$urltcx = $actividad->getUrl();
$urltcx = substr($url, 0, -3);
$urltcx .= "tcx";

$tcx = new Tcx($urltcx);
$datos = $tcx->getDatos($urltcx);
$duracion = $datos['duracion'];
$distancia = $datos['distancia'];
$pulsomedio = $datos['pulsomedio'];
$calorias = $datos['calorias'];

$pulso = $tcx->getPulso($urltcx);
$altura = $tcx->getAltura($urltcx);
$velocidad = $tcx->getSpeed($urltcx);
//mostrarDatos($velocidad);

if ($usuario !== NULL) {
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Kmler</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link href="assets/font-awesome-4.6.1/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
            <link href="css/style.css" rel="stylesheet" type="text/css" />
            <script src="javascript/jquery-2.2.3.min.js" type="text/javascript"></script>
            <script src="assets/Highcharts-4.2.5/js/highcharts.js" type="text/javascript"></script>
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
                    <span class="titulo"><?php echo $usuario->getNombre() . " " . $usuario->getApellidos(); ?></span>
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
                <p></p>
            </div>
        </header>
        
        <div id="wrapper-training">
            <div id="sesion" class="container">
                <div id="sesion-content">
                    <div id="icono">
                        <img src="<?php echo $icono; ?>" width="40" height="40"/>
                    </div>
                    <div id="sesion-texto">
                        <p><?php echo $deporte; ?></p>
                        <p><?php echo $fechaInicio; ?></p>
                    </div>
                </div>
            </div>

            <div id="resumen" class="container">
                <div class="resumen-caja">
                    <div class="resumen-content">
                        <div class="icono">
                            <img src="images/icono/timing.png" width="36" height="36"/>
                        </div>
                        <div class="texto">
                            <p class="valor"> <?php echo $duracion; ?> </p>
                            <p class="dato">Duración</p>
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
                            <p class="dato">Distancia</p>
                        </div>
                    </div>
                </div>
                <div class="resumen-caja">
                    <div class="resumen-content">
                        <div class="icono">
                            <img src="images/icono/heart-beat-icon.png" width="36" height="36"/>
                        </div>
                        <div class="texto">
                            <p class="valor"> <?php echo $pulsomedio; ?> </p>
                            <p class="dato">Frecuencia cardiaca media</p>
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
                            <p class="dato">Calor&iacute;as</p>
                        </div>
                    </div>
                </div>
            </div>

            <div id="mapa" class="container">
                
            </div>

            <div id="grafica" class="container">
                
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
            function initMap(){
                var mapa = new google.maps.Map(document.getElementById('mapa'), {
                    mapTypeId: google.maps.MapTypeId.TERRAIN,
                    scrollwheel: false
                  });

                var kmlLayer = new google.maps.KmlLayer({
                    url: 'http://studio19peluqueria.es/kmler/<?php echo $url; ?>',
                    map: mapa
                });
            }
            
            $(function () { 
                $('#grafica').highcharts({
                    chart: {
                        backgroundColor: "#f2f2f2",
                        zoomType: 'xy'
                    },
                    title: {
                        text: ''
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval:1000000,
                        labels: {
                            format: '{value:%H:%M:%S}',
                            align: 'left'
                        }
                    },
                    yAxis: [
                    {
                        labels: {
                        },
                        title: {
                            text: 'Altura',
                            style: {
                                color: Highcharts.getOptions().colors[1],
                                fontSize: '1rem'
                            }
                        },
                        opposite: true
                    },
                    
                    {
                        labels: {
//                            format: '{value} Km/h',
//                            style: {
//                                color: Highcharts.getOptions().colors[2]
//                            }
                        }
//                        title: {
//                            text: 'Velocidad',
//                            style: {
//                                color: '#0028CE',
//                                fontSize: '1rem'
//                            }
//                        },
//                        opposite: true
                    },
                    
                    {
                        labels: {
                            //format: '{value} bpm'
                        },
                        title: {
                            text: 'FC [ppm]',
                            style: {
                                color: '#D10027',
                                fontSize: '1rem'
                            }
                        },
                    }
                    ],
                    
                    tooltip: {
                        shared: true
                    },
                    
                     plotOptions: {
                        series: {
                            marker: {
                                enabled: false
                            },
                            fillOpacity: 0.1
                        }
                    },
                    series: [{
                        name: 'FC [ppm]',
                        color: '#D10027',
                        fontSize: '20px',
                        type: 'line',
                        data: <?php echo $pulso ?>,
                        yAxis: 2,
                        pointInterval: 1000,
                        zIndex: 1
                    },{
                        name: 'Altura',
                        color: '#808080',
                        type: 'area',
                        data: <?php echo $altura ?>,
                        pointInterval: 1000,
                        zIndex: 0
                    },
//                            {
//                        name: 'Velocidad',
//                        color: '#0028CE',
//                        type: 'line',
//                        data: <?php echo $velocidad ?>,
//                        yAxis: 1,
//                        pointInterval: 1000,
//                        zIndex: 2
//                    }
                    ]
                });
            });
        </script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDOtEY2b5KM2kAXZLDVLluqDREkOnbH4Jc&signed_in=true&callback=initMap"></script>
            
    </body>
</html>


<?php
} else {
    $sesion->sendRedirect("login.php");
}