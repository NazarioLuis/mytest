<?php

//Ruta generica para inscripciones

$app->any('/inscripciones/{id}[/{alu}]',
    function (\Slim\Http\Request $request, \Slim\Http\Response $response, $args) {
        if ($request->isPost()) {
            $input = json_decode($request->getBody());
            $periodo = PeriodoQuery::create()->findPk($args['id']);
            cargarInscripto($periodo, $input)->save();
            retornarInscriptosJSON($response, $args['id']);
        }elseif ($request->isGet()) {
            retornarInscriptosJSON($response, $args['id']);
        }elseif ($request->isDelete()) {
            $periodo = \Base\PeriodoQuery::create()->findPk($args['id']);
            $alumno = \Base\AlumnoQuery::create()->findPk($args['alu']);
            $periodo->removeAlumno($alumno);
            $periodo->save();
            retornarInscriptosJSON($response,$args['id']);
        }
});

//Retorna un json que contiene una lista obtenida de la bd
function retornarInscriptosJSON($response, $id){
    $response->withHeader("Content-type", "application/json");
    $response->withStatus(200);
    $periodo =  \Base\PeriodoQuery::create()->findPk($id);
    echo $periodo->getAlumnos()->toJSON();

}

//Carga los valore recibidos mediante rest a los atributos del objeto
function cargarInscripto(\Base\Periodo $p, $input){
    $a = new Alumno();
    if(isset($input->Id)){
        $a = \Base\AlumnoQuery::create()->findPk($input->Id);
    }else{
        $pass = new Pass();
        $a->setSenia($pass->encryptIt($pass->generaPass()));
    }
    $a->setNombre($input->Nombre);
    $a->setApellido($input->Apellido);
    $a->setDocumento($input->Documento);

    $p->addAlumno($a);
    return $p;
}


