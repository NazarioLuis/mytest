<?php

//Ruta generica para carreras

$app->any('/materias[/{id}]',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    //Se coprueba que parametro id no exista
    if (!isset($args['id'])) {
    	if ($request->isGet()) {
            retornarMateriasJSON($response);
	    }elseif ($request->isPost()) {
            $input = json_decode($request->getBody());
            $materia = new Materia();
            if(isset($input->Id))
                $materia= \Base\MateriaQuery::create()->findPk($input->Id);

            cargarMateria($materia, $input)->save();
            retornarMateriasJSON($response);
        }
    }else{
        if ($request->isGet()) {
            retornarMateriasPorCarreraJSON($response, $args['id']);
        }elseif ($request->isDelete()) {
            \Base\MateriaQuery::create()->findPk($args['id'])->delete();
            retornarMateriasJSON($response);
        }
    }
});



//Retorna un json que contiene una lista obtenida de la bd
function retornarMateriasJSON($response){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $result = \Base\MateriaQuery::create()
        ->join('Carrera')
        ->select(array('Id','Descripcion','CarId','Carrera.Descripcion','Observacion'))
        ->find();
    $response->getBody()->write(json_encode($result->toArray(),JSON_NUMERIC_CHECK));
}


//Retorna un json que contiene una lista obtenida de la bd
function retornarMateriasPorCarreraJSON($response,$id){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $result = \Base\MateriaQuery::create()
        ->join('Carrera')
        ->select(array('Id','Descripcion','CarId','Carrera.Descripcion','Observacion'))
        ->filterByCarId($id)
        ->find();
    $response->getBody()->write($result->toJSON());
}
//Carga los valore recibidos mediante rest a los atributos del objeto
function cargarMateria(\Base\Materia $m, $input){
    $m->setDescripcion($input->Descripcion);
    $m->setCarId($input->CarId);
    if(isset($input->Observacion))
        $m->setObservacion($input->Observacion);
    return $m;
}


