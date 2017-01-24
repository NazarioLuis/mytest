<?php

//Ruta generica para carreras

$app->any('/carreras[/{id}]',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    //Se coprueba que parametro id no exista
    if (!isset($args['id'])) {
    	if ($request->isGet()) {
            retornarCarrerasJSON($response);
	    }elseif ($request->isPost()) {
            $input = json_decode($request->getBody());
            $carrera = new Carrera();
            if(isset($input->Id))
                $carrera= \Base\CarreraQuery::create()->findPk($input->Id);
            cargarCarrera($carrera, $input)->save();
            retornarCarrerasJSON($response);
        }
    }else{
        if ($request->isGet()) {
            retornarCarreraComoJSON($response, $args['id']);
        }elseif ($request->isDelete()) {
            \Base\CarreraQuery::create()->findPk($args['id'])->delete();
            retornarCarrerasJSON($response);
        }
    }
});

//Retorna un json que contiene una lista obtenida de la bd
function retornarCarrerasJSON($response){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $response->getBody()->write(\Base\CarreraQuery::create()->find()->toJSON());
}

//Retorna un json que contiene la fila que cumpla con la condicion fk = ?
function retornarCarreraComoJSON($response, $id){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $response->getBody()->write(\Base\CarreraQuery::create()->findPk($id)->toJSON());
}

//Carga los valore recibidos mediante rest a los atributos del objeto
function cargarCarrera(\Base\Carrera $c, $input){
    $c->setDescripcion($input->Descripcion);
    if(isset($input->Observacion))
        $c->setObservacion($input->Observacion);
    return $c;
}
