//Controlador del template de registro de examenes
app.controller('examenCtlr', function(MyService,$scope,$rootScope,$filter, $http) {
    $scope.titulo = "Registro de Exámenes";
    $scope.periodos = [];
    $scope.carreras = [];
    $scope.materias = [];
    $scope.resultados = [];
    $scope.mostrarContenido = false;
    $scope.mostrarTabla = true;
    $scope.carrera = '';
    $scope.periodo = '';
    $scope.materia = '';
    today = new Date();
    todayUTC = new Date(today.getTime()-(today.getTimezoneOffset()*60000));
    $scope.form = {MatId:'',Fecha:todayUTC,Formativa:false};
    $scope.guardar = true;
    $scope.error = '';

    $scope.addPreguntas = function(x){
        $rootScope.template_carga='pregunta';
        $rootScope.primario=false;
        $rootScope.par = {
            'examen':x,
            'periodo':$filter('getById')($scope.periodos, $scope.periodo)
        };
    }

    $scope.verInforme = function(x){
        $rootScope.template_carga='informe_examen_view';
        $rootScope.primario=false;
        $rootScope.par = {
            'examen':x,
            'periodo':$filter('getById')($scope.periodos, $scope.periodo)
        };
    }


    $http.get('api/carreras').
    success(function(data) {
        $scope.carreras = data.Carreras;
        $scope.$broadcast('dataloaded', {ele:'carrera'});
    }).error(function(){
        console.log('Error de datos');
    });

    recuperarPeriodos = function(){
        $scope.periodo = '';
        id= ($scope.carrera == '' ? 0 : $scope.carrera);
        $http.get('api/periodos/c/'+id).
        success(function(data) {
            $scope.periodos = data.Periodos;
            $scope.$broadcast('dataloaded',{ele:'periodo'});
        }).error(function(){
            console.log('Error de datos');
        });
    }

    $scope.$watch('carrera', function() {
        recuperarPeriodos();
    });


    $scope.$watch('periodo', function() {
        recuperarExamenes();
    });

    selectChangeListener = function(){
        $("#carrera").on('change', function() {
            $scope.carrera = $("#carrera").val();
            $scope.$apply();
        });
        $("#periodo").on('change', function() {
            $scope.periodo = $("#periodo").val();
            $scope.$apply();
        });
        $("#materia").on('change', function() {
            $scope.form.MatId = $("#materia").val();
            $scope.$apply();
        });
        $("#materiaFilter").on('change', function() {
            $scope.materia = $("#materiaFilter").val();
            $scope.$apply();
        });
    }
    selectChangeListener();

    recuperarExamenes = function(){
        id = 0;
        $scope.mostrarContenido = false;
        if($scope.periodo !== ''){
            id = $scope.periodo;
            $scope.mostrarContenido = true;
        }

        $http.get('api/examenes/'+id).
        success(function(data) {
            $scope.resultados = formatearDatos(data);
        }).error(function(){
            console.log('Error de datos');
        });
        recuperarMaterias();

    }

    recuperarMaterias = function(){
        $scope.materia = '';
        if ($scope.carrera !== ''){
            $http.get('api/materias/'+$scope.carrera).
            success(function(data) {
                $scope.materias = data.Materias;
                $scope.$broadcast('dataloaded',{ele:'materia'});
                $scope.$broadcast('dataloaded',{ele:'materiaFilter'});
            }).error(function(){
                console.log('Error de datos');
            });
        }
    }

    $scope.confirmar = function(datos){
        console.log(datos.Fecha);
        if(validar(datos)){
            $http.post('api/examenes/'+$scope.periodo,datos)
                .success(function(data){
                    console.log(data);
                    $scope.resultados = formatearDatos(data);
                    $scope.cambiarVisibilidad();
                }).error(function(){
                    console.log("error de datos");
                });
        }
    };

    $scope.eliminar = function($id){
        $http.delete('api/examenes/'+$scope.periodo+'/'+$id)
            .success(function(data){
                $scope.resultados = formatearDatos(data);
            }).error(function(){
                MyService.error("No se puede elminar, pues esta en uso!");
            });
    };

    $scope.selecionarObjeto = function(id){
        $scope.guardar = false;
        var found = $filter('getById')($scope.resultados, id);
        $scope.form = found;
        $scope.cambiarVisibilidad();
    }

    $scope.cambiarVisibilidad = function(){
        if($scope.mostrarTabla == false){
            $scope.form = {MatId:'',Fecha:todayUTC,Formativa:false};
            $scope.guardar = true;
            $scope.error = "";
        }
        $scope.mostrarTabla = !$scope.mostrarTabla;
        changeSelects();
    }

    changeSelects = function(){
        $("#materia").val($scope.form.MatId);
        $('#materia').material_select();
    }

    $scope.buscar = function (row) {
        return $scope.materia == '' || row.MatId == $scope.materia;
    };
    validar = function(datos){
        if (datos.MatId == ''){
            $scope.error = 'Debes seleccionar una materia';
            return false;
        }
        var i=0, len=$scope.resultados.length;
        for (; i<len; i++) {
            if ($scope.resultados[i].MatId == datos.MatId
                && formatearFecha(datos.Fecha) == $scope.resultados[i].FechaFormato
                && datos['Id'] !== $scope.resultados[i].Id) {
                $scope.error = 'No pueden registrarse dos pruebas de '+$scope.resultados[i]['Materia.Descripcion']+' en la misma fecha!';
                return false;
            }
        }
        return true;
    }

    formatearDatos = function(lista){
        var i=0, len=lista.length;
        for (; i<len; i++) {
            lista[i].Formativa = (lista[i].Formativa==1);
            lista[i].Fecha = new Date(lista[i].Fecha);
            lista[i].FechaFormato = formatearFecha(lista[i].Fecha);
        }
        return lista;
    }

    formatearFecha = function(fecha){
        d = fecha.getUTCDate()<10 ? '0'+fecha.getUTCDate():fecha.getUTCDate();
        m = fecha.getUTCMonth()<10 ? '0'+(fecha.getUTCMonth()+1):(fecha.getUTCMonth()+1);
        return [d,m,fecha.getUTCFullYear()].join('/');
    }


});