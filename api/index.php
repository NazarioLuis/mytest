<?php

require 'app/util/pass.php';

// setup composer autoloader
require_once '/vendor/autoload.php';
// setup Propel
require_once '/vendor/bin/generated-conf/config.php';
$app = new \Slim\App;

require '/app/routes/carrera.php';
require '/app/routes/alumno.php';
require '/app/routes/materia.php';
require '/app/routes/periodo.php';

$app->run();