# proyectointegrado

Vivimos en una época en la que por suerte el mundo del deporte está cada vez más de moda y día tras día la gente encuentra una actividad física que le sirve para desconectar del ajetreo diario. Si juntamos esto con las últimas tecnologías diseñadas para el mundo del deporte, encontramos infinidad de dispositivos móviles y wearables destinados al seguimiento y análisis de la actividad física y la progresión del deportista.

Yo soy amante del ciclismo e intento realizar bastante deporte y de vez en cuando me gusta observar las rutas que he realizado, los kilómetros realizados, el tiempo de la sesión, los metros ascendidos y demás datos que nos ofrecen las nuevas tecnologías.
Por esto he decidido enfocar el proyecto integrado en una aplicación que tenga que ver con este tema.
La idea de negocio sería fabricar un dispositivo wereable tal como un reloj o una pulsera inteligente que cuente con tecnología GPS de modo que sea capaz de obtener los datos de la actividad física durante sesiones de entrenamiento como velocidad, frecuencia cardiaca, posición, tiempo… y a partir de esos datos cree un archivo con todos esos datos bien estructurados de forma que el acceso a estos sea fácil y rápida.

Por motivos evidentes hay una parte de la idea que no puedo desarrollar, por lo menos por el momento, de modo que empezaré a desarrollar el proyecto obteniendo los datos de otros dispositivos.
Este tipo de dispositivos suelen crear un archivo en formato tcx (Training Center XML) o gpx (GPS Exchange Format) que son ficheros escritos en lenguajes de marcas basados en XML y estandarizados mediante XML Schemas.
La función de la aplicación es obtener esos ficheros y gestinarlos de forma que el usuario pueda observar los datos de los entrenamientos como la ruta realizada (si existiera), ritmo cardiaco, velocidad, distancia, duración, etc. Los datos se mostrarán de forma lógica y agradable para el usuario.

Para la realización del proyecto será necesario estudiar la estructura de los ficheros tcx para la posterior obtención de los datos. Además, para la visualización de la ruta en un mapa, es necesario crear un fichero kml con las coordenadas y otros datos de esta. Con la ayuda de una api de google se mostrará la ruta superpuesta en un mapa.

Utilizando la librería Highcharts de Javascript se mostrarán graficas con datos importantes como el pulso, elevación del terreno, velocidad… de forma que de un vistazo se pueda observar el resultado del entrenamiento.
