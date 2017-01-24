<?php

//Ruta generica para presultados

$app->any('/resultados/{examen}[/{alumno}]',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        if ($request->isGet()) {
            retornarResultadosJSON($response,$args);
        }elseif ($request->isPost()) {
            $input = json_decode($request->getBody());

            guardarResultado($input, $args, $response);

            //retornarResultadosJSON($response,$args);
        }
});

//Retorna un json que contiene una lista obtenida de la bd
function retornarResultadosJSON($response, $args){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $resultados = \Base\ResultadoQuery::create()
        ->join("Alumno")
        ->select(array('Alumno.Id','Alumno.Nombre','Alumno.Apellido','Alumno.Documento'))
        ->filterByExaId($args['examen'])
        ->find();

    foreach($resultados as $p=>$r){
        $total = \Base\ResultadoDetalleQuery::create()
            ->filterByExaId($args['examen'])
            ->filterByAluId($resultados[$p]['Alumno.Id'])
            ->find();
        $correcto = \Base\ResultadoDetalleQuery::create()
            ->filterByExaId($args['examen'])
            ->filterByAluId($resultados[$p]['Alumno.Id'])
            ->filterByCorrecto(1)
            ->find();
        $resultados[$p]['Total']= sizeof($total);
        $resultados[$p]['Correcto']= sizeof($correcto);
        $resultados[$p]['Porcentaje']= ($resultados[$p]['Correcto']/$resultados[$p]['Total'])*100;
    }

    $response->getBody()->write($resultados->toJSON());
}

//Carga los valore recibidos mediante rest a los atributos del objeto
function guardarResultado($input,$args,$response){
    $puntaje = 0;
    $correctas = \Base\PreguntaQuery::create()
        ->filterByExaId($args['examen'])
        ->find();

    $r = new Resultado();
    $r->setAluId($args['alumno']);
    $r->setExaId($args['examen']);
    $r->save();
    foreach($input as $item){
        $det = new ResultadoDetalle();
        $det->setResultado($r);
        $det->setPreId($item->Id);
        $seleccion = 0;
        foreach($item->Respuestas as $respuesta){
            if($respuesta->Correcto) $seleccion = $respuesta->Id;
        }
        $det->setSeleccion($seleccion);
        $det->setCorrecto(validarRespuesta($det,$correctas));
        $r->save();

        if($det->getCorrecto()) $puntaje++;
    }

    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $response->getBody()->write($puntaje);
}

function validarRespuesta($det,$correctas){
    $correcto = false;
    foreach($correctas as $pregunta){
        if($pregunta->getId() == $det->getPreId()){
            foreach($pregunta->getRespuestas() as $respuesta){
                if($respuesta->getCorrecto()) $correcto = ($respuesta->getId() == $det->getSeleccion());
            }
        }
    }
    return $correcto;
}
