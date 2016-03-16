/**
 * Created by Nazario Luis on 14/03/2016.
 */
//Controlador del template de registro de alumnos
app.controller('alumnoCtlr', function($scope,$filter, $http) {
    $scope.resultados;
    $scope.mostrarTabla = true;
    $scope.guardar = true;
    $scope.titulo = "Registro de Alumnos";

    $http.get('api/alumnos').
    success(function(data) {
        $scope.resultados = data.Alumnos;
    }).error(function(){
        console.log('Error de datos');
    });



    $scope.confirmar = function(datos){
       $http.post('api/alumnos',datos)
           .success(function(data){
               $scope.resultados = data.Alumnos;
               $scope.cambiarVisibilidad();
           }).error(function(){
           console.log('Error de datos');
       });
    };

    $scope.eliminar = function($id){
        $http.delete('api/alumnos/'+$id)
            .success(function(data){
                $scope.resultados = data.Alumnos;
            }).error();
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
});