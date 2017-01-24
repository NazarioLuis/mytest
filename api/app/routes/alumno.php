<?php

//Ruta generica para alumnos
$app->any('/alumnos[/{id}]',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    //Se coprueba que parametro id no exista
    if (!isset($args['id'])) {
    	if ($request->isGet()) {
            retornarAlumnosJSON($response);
	    }elseif ($request->isPost()) {
            $input = json_decode($request->getBody());
            $alumno = new Alumno();
            cargarAlumno($alumno, $input)->save();
            retornarAlumnosJSON($response);

        }
    }else{
        if ($request->isGet()) {
            retornarAlumnoComoJSON($response, $args['id']);
        }elseif ($request->isDelete()) {
            \Base\AlumnoQuery::create()->findPk($args['id'])->delete();
            retornarAlumnosJSON($response);
        }
    }
});

$app->get('/alumnos/doc/{doc}',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        retornarAlumnoPorDocumentoJSON($response, $args['doc']);
    });

//Retorna un json que contiene una lista obtenida de la bd
function retornarAlumnosJSON($response){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $response->getBody()->write(desencriptarSenia(\Base\AlumnoQuery::create()->find())->toJSON());
}

//Retorna un json que contiene la fila que cumpla con la condicion fk = ?
function retornarAlumnoComoJSON($response, $id){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $response->getBody()->write(\Base\AlumnoQuery::create()->findPk($id)->toJSON());
}

//Recupera por documento
function retornarAlumnoPorDocumentoJSON($response, $doc){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $result = \Base\AlumnoQuery::create()
        ->findByDocumento($doc);
    $response->getBody()->write($result->toJSON());
}

//Carga los valore recibidos mediante rest a los atributos del objeto
function cargarAlumno(\Base\Alumno $a, $input){
    if(isset($input->Id)){
        $a = \Base\AlumnoQuery::create()->findPk($input->Id);
    }else{
        $pass = new Pass();
        $a->setSenia($pass->encryptIt($pass->generaPass()));
    }
    $a->setNombre($input->Nombre);
    $a->setApellido($input->Apellido);
    $a->setDocumento($input->Documento);
    return $a;
}



function desencriptarSenia($lista){
    $p = new Pass();
    foreach($lista as $key => $value)
    {
        $lista[$key]->setSenia($p->decryptIt( $lista[$key]->getSenia()));
    }
    return $lista;
}
