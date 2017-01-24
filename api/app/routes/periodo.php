<?php

//Ruta generica para carreras

$app->any('/periodos[/{id}]',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
    //Se coprueba que parametro id no exista
    if (!isset($args['id'])) {
    	if ($request->isGet()) {
            retornarPeriodosJSON($response);
	    }elseif ($request->isPost()) {
            $input = json_decode($request->getBody());
            $periodo = new Periodo();
            if(isset($input->Id))
                $periodo= \Base\PeriodoQuery::create()->findPk($input->Id);

            cargarPeriodo($periodo, $input)->save();
            retornarPeriodosJSON($response);
        }
    }else{
        if ($request->isGet()) {
            retornarPeriodoComoJSON($response, $args['id']);
        }elseif ($request->isDelete()) {
            \Base\PeriodoQuery::create()->findPk($args['id'])->delete();
            retornarPeriodosJSON($response);
        }
    }
});

$app->get('/periodos/c/{id}',
    function(\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        retornarPeriodosPorCarreraComoJSON($response, $args['id']);
    });

//Retorna un json que contiene una lista obtenida de la bd
function retornarPeriodosJSON($response){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $result = \Base\PeriodoQuery::create()
        ->join('Carrera')
        ->select(array('Id','Anio','Periodo','CarId','Carrera.Descripcion','Desde','Hasta'))
        ->find();
    $response->getBody()->write(json_encode($result->toArray(),JSON_NUMERIC_CHECK));
}

function retornarPeriodosPorCarreraComoJSON($response,$id){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $result = \Base\PeriodoQuery::create()
        ->join('Carrera')
        ->select(array('Id','Anio','Periodo','CarId','Carrera.Descripcion','Desde','Hasta'))
        ->filterByCarId($id)
        ->orderById(\Propel\Runtime\ActiveQuery\Criteria::DESC)
        ->find();
    $response->getBody()->write($result->toJSON());
}

//Retorna un json que contiene la fila que cumpla con la condicion fk = ?
function retornarPeriodoComoJSON($response, $id){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $result = \Base\PeriodoQuery::create()
        ->join('Carrera')
        ->select(array('Id','Anio','Periodo','CarId','Carrera.Descripcion','Desde','Hasta'))
        ->findPk($id);
    $response->getBody()->write(json_encode($result));
}

//Carga los valore recibidos mediante rest a los atributos del objeto
function cargarPeriodo(\Base\Periodo $p, $input){
    $p->setAnio($input->Anio);
    $p->setPeriodo($input->Periodo);
    $p->setCarId($input->CarId);
    $p->setDesde($input->Desde);
    $p->setHasta($input->Hasta);
    return $p;
}


