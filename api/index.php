<?php

date_default_timezone_set("America/Asuncion");

require __DIR__ . '/app/util/pass.php';

// setup composer autoloader
require_once __DIR__ . '/lib/autoload.php';
// setup Propel
require_once __DIR__ . '/lib/bin/generated-conf/config.php';
$app = new \Slim\App;

require __DIR__ . '/app/routes/carrera.php';
require __DIR__ . '/app/routes/alumno.php';
require __DIR__ . '/app/routes/materia.php';
require __DIR__ . '/app/routes/periodo.php';
require __DIR__ . '/app/routes/inscripcion.php';
require __DIR__ . '/app/routes/examen.php';
require __DIR__ . '/app/routes/pregunta.php';
require __DIR__ . '/app/routes/resultado.php';
$app->run();