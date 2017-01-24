<?php

//Ruta generica para preguntas

$app->any('/preguntas/{examen}[/{eva}]',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        if ($request->isGet()) {
            retornarPreguntasJSON($response,$args);
        }elseif ($request->isPost()) {
            $input = json_decode($request->getBody());
            \Base\RespuestaQuery::create()->filterByExaId($args['examen'])->delete();
            \Base\PreguntaQuery::create()->filterByExaId($args['examen'])->delete();
            foreach($input as $item){
                $pregunta = new Pregunta();
                guardarPregunta($pregunta, $item, $args['examen']);
            }
            retornarPreguntasJSON($response,$args);
        }
});

//Retorna un json que contiene una lista obtenida de la bd
function retornarPreguntasJSON($response, $args){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $preguntas = \Base\PreguntaQuery::create()
        ->filterByExaId($args['examen'])
        ->find();

    foreach($preguntas as $key => $value)
    {
        $respuestas = $preguntas[$key]->getRespuestas();
        if(isset($args['eva'])){
            foreach ($respuestas as $i => $val){
                $respuestas[$i]->setCorrecto(false);
            }
        }
        $preguntas[$key]->Respuestas= $respuestas;
    }

    $response->getBody()->write($preguntas->toJSON());
}

//Carga los valore recibidos mediante rest a los atributos del objeto
function guardarPregunta(\Base\Pregunta $p, $item, $examen){
    $p->setId($item->Id);
    $p->setExaId($examen);
    $p->setTexto($item->Texto);
    $p->save();
    foreach($item->Respuestas as $respuesta){
        $r = new Respuesta();
        $r->setId($respuesta->Id);
        $r->setTexto($respuesta->Texto);
        $r->setCorrecto($respuesta->Correcto);
        $r->setPregunta($p);
        $r->save();
    }
}
