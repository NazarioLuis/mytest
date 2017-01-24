<?php

//Ruta generica para examenes


$app->any('/examenes/{per}[/{id}]',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {

        if ($request->isPost()) {
            $input = json_decode($request->getBody());
            $examen = new Examen();
            if(isset($input->Id))
                $examen = \Base\ExamenQuery::create()->findPk($input->Id);
            cargarExamen($examen, $input, $args)->save();
            retornarExamenesJSON($response, $args);
        }elseif ($request->isGet()) {
            retornarExamenesJSON($response, $args);
        }elseif ($request->isDelete()) {
            \Base\ExamenQuery::create()->findPk($args['id'])->delete();
            retornarExamenesJSON($response,$args);
        }
    });

$app->post('/examen',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args){
        $input = json_decode($request->getBody());
        return retornarExamenJSON($response,$input, $args);
    });

function retornarExamenesJSON($response,$args){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $result = \Base\ExamenQuery::create()
            ->join('Materia')
            ->select(array('Id','Materia.Descripcion','MatId','Formativa','Fecha'))
            ->filterByPerId($args['per'])
        ->find();
    foreach($result as $p=>$r){
        $resultados = ResultadoQuery::create()->filterByExaId($r["Id"])->find();
        $result[$p]['Resultados'] = sizeof($resultados)>0;
    }
    $response->getBody()->write(json_encode($result->toArray(),JSON_NUMERIC_CHECK));
}

function cargarExamen(\Base\Examen $e, $i, $args){
    $e->setPerId($args['per']);
    $e->setMatId($i->MatId);
    $e->setFecha($i->Fecha);
    $e->setFormativa($i->Formativa);
    return $e;
}

function retornarExamenJSON($response,$input,$args){
    $alumno = \Base\AlumnoQuery::create()->findOneByDocumento($input->Documento);

    if($alumno==null){
        $newResponse = $response->withStatus(300);
        return($newResponse);
    }

    $pass = new Pass();

    if($pass->encryptIt($input->Pass)!=$alumno->getSenia()){
        $newResponse = $response->withStatus(301);
        return($newResponse);
    }

    $periodo = \Base\PeriodoQuery::create()
        ->where('Periodo.Desde <= ?',$input->Fecha)
        ->where('Periodo.Hasta >= ?',$input->Fecha)
        ->findOneByCarId($input->CarId);

    if($periodo == null){
        $newResponse = $response->withStatus(302);
        return($newResponse);
    }
    $inscipcion = \Base\InscripcionQuery::create()
        ->filterByPeriodo($periodo)
        ->findOneByAluId($alumno->getId());

    if($inscipcion == null){
        $newResponse = $response->withStatus(304);
        return($newResponse);
    }

    $examen = \Base\ExamenQuery::create()
        ->join('Materia')
        ->select(array('Id','Materia.Descripcion','MatId','Formativa','Fecha'))
        ->filterByPeriodo($periodo)
        ->filterByMatId($input->MatId)
        ->findOneByFecha($input->Fecha);

    if($examen == null){
        $newResponse = $response->withStatus(305);
        return($newResponse);
    }

    $resultado = \Base\ResultadoQuery::create()
        ->filterByExaId($examen['Id'])
        ->findOneByAluId($alumno->getId());

    if($resultado!=null){
        $newResponse = $response->withStatus(305);
        return($newResponse);
    }

    $examen['alu'] = $alumno->toArray();
    $newResponse = $response->withStatus(200);
    $newResponse->withHeader("Content-type", "application/json");
    $newResponse->getBody()->write(json_encode($examen,JSON_NUMERIC_CHECK));
    return($newResponse);
}

