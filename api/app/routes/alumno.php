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
            if(isset($input->Id))
                $alumno = \Base\AlumnoQuery::create()->findPk($input->Id);
            cargarAlumno($alumno, $input)->save();
            retornarAlumnosJSON($response);
        }elseif ($request->isPut()) {
            $input = json_decode($request->getBody());

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

//Carga los valore recibidos mediante rest a los atributos del objeto
function cargarAlumno(\Base\Alumno $a, $input){
    $a->setNombre($input->Nombre);
    $a->setApellido($input->Apellido);
    $a->setDocumento($input->Documento);
    $pass = new App\Util\Pass();
    $a->setSenia($pass->encryptIt($pass->generaPass()));
    return $a;
}



function desencriptarSenia($lista){
    $p = new \App\Util\Pass();
    foreach($lista as $key => $value)
    {
        $lista[$key]->setSenia($p->decryptIt( $lista[$key]->getSenia()));
    }
    return $lista;
}
