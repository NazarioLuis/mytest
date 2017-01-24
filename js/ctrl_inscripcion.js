//Controlador del template de registro de Iscripciones
app.controller('inscripcionCtlr', function(MyService,$scope,$filter, $http) {
    $scope.titulo = "Inscripción de Alumnos";
    $scope.periodos = [];
    $scope.carreras = [];
    $scope.form = {'Documento':''};
    $scope.alumnos = [];
    $scope.mostrarTabla = false;
    $scope.carrera = '';
    $scope.periodo = '';
    $scope.aluExiste = true;
    $scope.error = '';


    $('form').on('keyup keypress', function(e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });



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

    recuperarInscriptos = function(){
        id = 0;
        $scope.mostrarTabla = false;
        if($scope.periodo !== ''){
            id = $scope.periodo;
            $scope.mostrarTabla = true;
        }
        $http.get('api/inscripciones/'+id).
        success(function(data) {
            $scope.alumnos = data.Alumnos;
        }).error(function(){
            console.log('Error de datos');
        });
    }

    $scope.buscarAlumno = function($event){
        if (MyService.isEnter($event) && $scope.form['Documento'] != ''){
            doc = $scope.form['Documento'];
            $http.get('api/alumnos/doc/'+doc).
            success(function(data) {
                console.log(data)
                if (data.Alumnos['length'] == 0){
                    $scope.form = {'Documento' : doc};
                    $scope.aluExiste = false;
                }else {
                    $scope.form = data.Alumnos[0];
                    $scope.aluExiste = true;

                }
            }).error(function(){
                console.log('Error de datos');
            });
        }
    }

    $scope.confirmar = function(datos) {
        $scope.error = '';
        if (buscarAlumnoPorDocumento(datos.Documento)==null){
            $http.post('api/inscripciones/'+$scope.periodo, datos)
                .success(function (data) {
                    $scope.alumnos = data.Alumnos;
                    $scope.form = {'Documento':''};
                    $scope.aluExiste = true;
                }).error(function () {
                console.log('Error de datos');
            });
        }else
            $scope.error = 'El alumno ya esta inscripto';

    }

    buscarAlumnoPorDocumento = function(doc){
            var i=0, len=$scope.alumnos.length;
            for (; i<len; i++) {
                if ($scope.alumnos[i].Documento == doc) {
                    return $scope.alumnos[i];
                }
            }
            return null;
    }

    $scope.eliminar = function($id){
        console.log('api/inscripciones/'+$scope.periodo+'/'+$id);
        $http.delete('api/inscripciones/'+$scope.periodo+'/'+$id)
            .success(function(data){
                $scope.alumnos = data.Alumnos;
            }).error();
    };

    $scope.$watch('carrera', function() {
        recuperarPeriodos();
    });
    $scope.$watch('periodo', function() {
        recuperarInscriptos();
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
    }
    selectChangeListener();


});