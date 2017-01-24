app.controller('evaluacionCtlr', function(MyService,$scope,$rootScope,$filter, $http) {
    $scope.carreras = [];
    $scope.examen = null;
    $scope.form = {CarId:'', MatId:''};
    $scope.login = false;
    $scope.preguntas = [];
    $scope.abc = ['','a','b','c','d','e','f','g','h','i','j'];
    $scope.puntaje = "";
    $scope.total = "";
    $scope.porcentaje = "";
    $scope.concluido = false;
    $scope.error = "";
    today = new Date();
    todayUTC = new Date(today.getTime()-(today.getTimezoneOffset()*60000));

    if (localStorage.getItem('examen') != null){
        $scope.examen = JSON.parse(localStorage.getItem('examen'));
        $scope.preguntas = JSON.parse(localStorage.getItem('preguntas'));
        $scope.total = $scope.preguntas.length;
        $scope.login = true;
    }

    $scope.guardarResultado = function(){
        $http.post('api/resultados/'+$scope.examen.Id+'/'+$scope.examen.alu.Id ,$scope.preguntas)
            .success(function(data){
                $scope.puntaje = data;
                $scope.porcentaje = (($scope.puntaje/$scope.total)*100)+"%";
                localStorage.removeItem('examen');
                localStorage.removeItem('preguntas');
                $scope.concluido = true;
            });
    }

    $http.get('api/carreras').
    success(function(data) {
        $scope.carreras = data.Carreras;
        $scope.$broadcast('dataloaded', {ele:'carrera'});

    }).error(function(){
        console.log('Error de datos');
    });

    $scope.confirmar = function(datos){
        datos.Fecha = todayUTC;
        if(validar(datos)){
            $http.post('api/examen',datos)
                .success(function(data){

                    $scope.examen = formatearDatos(data);
                    $scope.login = true;
                    recuperarPreguntas();
                }).error(function(error, status){
                    console.log(status);
                    switch(status) {
                        case 300:
                            $scope.error = 'Usted no esta registrado!';
                            break;
                        case 301:
                            $scope.error = 'Contraseña incorrecta!';
                            break;
                        case 302:
                            $scope.error = 'No existe un periodo activo!!';
                            break;
                        case 304:
                            $scope.error = 'Usted no esta habilitado para realizar la prueba!';
                            break;
                        case 305:
                            $scope.error = 'No se encuentran ninguna prueba disponible ' +
                                'o es probable que ya la haya realizado!';
                            break;
                        default:
                            $scope.error = '';
                    }
                });
        }
    };

    validar = function(datos){
        if (datos.CarId == ''){
            $scope.error = 'Debes seleccionar una carrera';
            return false;
        }

        if (datos.MatId == ''){
            $scope.error = 'Debes seleccionar una asignatura';
            return false;
        }

        return true;
    }

    selectChangeListener = function(){
        $("#carrera").on('change', function() {
            $scope.form.CarId = $("#carrera").val();
            $scope.$apply();
        });
        $("#materia").on('change', function() {
            $scope.form.MatId = $("#materia").val();
            $scope.$apply();
        });
    }
    selectChangeListener();

    $scope.$watch('form.CarId', function() {
        recuperarMaterias();
    });


    recuperarMaterias = function(){
        $scope.form.MatId = '';
        var id = 0;
        if ($scope.form.CarId !== '')
            id = $scope.form.CarId;


        $http.get('api/materias/'+id).
        success(function(data) {
            $scope.materias = data.Materias;
            $scope.$broadcast('dataloaded',{ele:'materia'});
        }).error(function(){
            console.log('Error de datos');
        });

    }
    recuperarMaterias();

    function recuperarPreguntas(){
        $http.get('api/preguntas/'+$scope.examen.Id+'/true').
        success(function(data) {
            $scope.preguntas = data.Preguntas;
            $scope.total = data.Preguntas.length;
            localStorage.setItem('examen',JSON.stringify($scope.examen));
            localStorage.setItem('preguntas',JSON.stringify($scope.preguntas));
        }).error(function(){
            console.log('Error de datos');
        });
    }

    formatearDatos = function($objeto){

        $objeto.Formativa = ($objeto.Formativa==1);
        $objeto.Fecha = new Date($objeto.Fecha);
        $objeto.FechaFormato = formatearFecha($objeto.Fecha);

        return $objeto;
    }

    formatearFecha = function(fecha){
        d = fecha.getUTCDate()<10 ? '0'+fecha.getUTCDate():fecha.getUTCDate();
        m = fecha.getUTCMonth()<10 ? '0'+(fecha.getUTCMonth()+1):(fecha.getUTCMonth()+1);
        return [d,m,fecha.getUTCFullYear()].join('/');
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
        localStorage.setItem('preguntas',JSON.stringify($scope.preguntas));
    }


});