app.controller('preguntaCtlr', function(MyService,$scope,$rootScope,$filter, $http) {
    $scope.preguntas = [];
    $scope.abc = ['','a','b','c','d','e','f','g','h','i','j'];
    $scope.formsRespuesta = [];
    $scope.error = false;
    $scope.message = '';




    $http.get('api/preguntas/'+$rootScope.par['examen'].Id).
        success(function(data) {
            $scope.preguntas = data.Preguntas;
        }).error(function(){
            console.log('Error de datos');
        });

    $scope.volverAExamenes = function(){
        $rootScope.primario = true;
        $rootScope.template_carga = null;
        $rootScope.$applyAsync();
    }

    $scope.confirmar = function(){
        if($scope.preguntas.length>0 && validarRespuestaCorrecta()){
            $http.post('api/preguntas/'+$rootScope.par['examen'].Id,$scope.preguntas)
                .success(function(data){
                    $scope.preguntas = data.Preguntas;
                    $scope.message = 'El formulario se guardo correctamente!';
                    $scope.error = false;
                    $scope.edit = false;
                });
        }
    };

    $scope.agregarPregunta = function(pregunta){
         var p = {
             'Id':($scope.preguntas.length+1),
             'Texto':pregunta,
             'Respuestas':[]
         };
        var fr = {
            'correcto':false,
            'preId':($scope.preguntas.length+1)
        };
        $scope.formsRespuesta.push(fr);
        $scope.preguntas.push(p);
        $scope.pregunta = '';


    }

    $scope.agregarRespuesta = function(respuesta){
        var id = respuesta.preId-1;
        if(validarRespuesta($scope.preguntas[id]['Respuestas'],respuesta.correcto)){
            var r = {
                'Id':($scope.preguntas[id]['Respuestas'].length+1),
                'Texto':respuesta.texto,
                'Correcto':(respuesta.correcto==null?false:respuesta.correcto)
            };
            var fr = {
                'correcto':false,
                'preId':(respuesta.preId)
            };
            $scope.formsRespuesta[id] = fr;
            $scope.preguntas[id]['Respuestas'].push(r);

        }else{

        }
    }

    validarRespuesta = function(lista,b){
        var i=0, len=lista.length;
        for (; i<len; i++) {
            if (lista[i].Correcto&&b) {
                return false;
            }
        }
        return true;
    }
    $scope.cambiarSeleccion = function(preId,id){
        var i=0, len=$scope.preguntas[preId-1]['Respuestas'].length;
        for (; i<len; i++) {
            if ($scope.preguntas[preId-1].Respuestas[i].Id == id) {
                $scope.preguntas[preId-1].Respuestas[i].Correcto=true;
            }else {
                $scope.preguntas[preId-1].Respuestas[i].Correcto=false;
            }
        }
    }
    $scope.quitarPregunta = function(id){
        $scope.preguntas.splice(id-1,1);
        reorganizarPreguntas(id-1);

        $scope.$applyAsync();

    }
    reorganizarPreguntas = function(desde){
        var i=desde, len=$scope.preguntas.length;
        for (; i<len; i++) {
            $scope.preguntas[i].Id = i+1;
        }
    }
    $scope.quitarRespuesta = function(idPre,id){
        $scope.preguntas[idPre-1].Respuestas.splice(id-1,1);
        reorganizarRespuestas(idPre,id-1);

        $scope.$applyAsync();
    }
    reorganizarRespuestas = function(idPre,desde){
        var i=desde, len=$scope.preguntas[idPre-1]['Respuestas'].length;
        for (; i<len; i++) {
            $scope.preguntas[idPre-1].Respuestas[i].Id = i+1;
        }
    }
    validarRespuestaCorrecta = function(){
        var i=0, sinCorrecto=[], len=$scope.preguntas.length;
        for (; i<len; i++) {
            var c=0, correctos=0, len2=$scope.preguntas[i].Respuestas.length;
            for (; c<len2; c++) {
                if ($scope.preguntas[i].Respuestas[c].Correcto){
                    correctos++;
                }
            }
            if(correctos == 0){
                sinCorrecto.push($scope.preguntas[i].Id);
            }
        }
        if(sinCorrecto.length>0){
            $scope.error = true;
            var aux = '';
            for(i=0;i<sinCorrecto.length;i++){
                aux += (i==0?'':', ')+sinCorrecto[i];
            }
            $scope.message = 'Existen preguntas a las que no se asigno una respuesta correcta. '+
                'El problema se da en las siguientes preguntas: '+aux;
            return false;
        }
        return true;
    }
});