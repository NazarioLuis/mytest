/**
 * Created by Nazario Luis on 14/03/2016.
 */
//Controlador del template de registro de alumnos
app.controller('alumnoCtlr', function(MyService,$scope,$filter, $http) {
    $scope.resultados;
    $scope.mostrarTabla = true;
    $scope.error = '';
    $scope.bs = '';
    $scope.guardar = true;
    $scope.titulo = "Registro de Alumnos";

    $http.get('api/alumnos').
    success(function(data) {
        console.log(data);
        $scope.resultados = data.Alumnos;
    }).error(function(){
        console.log('Error de datos');
    });



    $scope.confirmar = function(datos){
        if(validarDocumento(datos)) {
            $http.post('api/alumnos', datos)
                .success(function (data) {
                    $scope.resultados = data.Alumnos;
                    $scope.cambiarVisibilidad();
                }).error(function () {
                console.log('Error de datos');
            });
        }
    };

    $scope.eliminar = function($id){
        $http.delete('api/alumnos/'+$id)
            .success(function(data){
                $scope.resultados = data.Alumnos;
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
            $scope.form = {};
            $scope.guardar = true;
            $scope.error = "";
        }
        $scope.mostrarTabla = !$scope.mostrarTabla;
    }

    $scope.buscar = function (row) {
        return MyService.normalize(row.Nombre).indexOf(MyService.normalize($scope.bs)) >= 0
                ||MyService.normalize(row.Apellido).indexOf(MyService.normalize($scope.bs)) >= 0
                ||row.Documento == $scope.bs
                || row.Id == $scope.bs;
    };

    validarDocumento = function(datos){
        var i=0, len=$scope.resultados.length;
        for (; i<len; i++) {
            if ($scope.resultados[i].Documento == datos.Documento && datos['Id'] !== $scope.resultados[i].Id) {
                $scope.error = 'Ya extiste un alumno con documento '+datos.Documento;
                return false;
            }
        }
        return true;
    }

    $scope.$on('$destroy', function() {
        delete window.onbeforeunload;
    });
});