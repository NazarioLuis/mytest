//Controlador del template de registro de carreras
app.controller('carreraCtlr', function($scope,$filter, $http) {
    $scope.resultados = [];
    $scope.mostrarTabla = true;
    $scope.guardar = true;
    $scope.titulo = "Registro de Carreras";

    $http.get('api/carreras').
    success(function(data) {
        $scope.resultados = data.Carreras;
    }).error(function(){
        console.log('Error de datos');
    });

    $scope.confirmar = function(datos){
        $http.post('api/carreras',datos)
            .success(function(data){
                $scope.resultados = data.Carreras;
                $scope.cambiarVisibilidad();
            });
    };

    $scope.eliminar = function($id){
        $http.delete('api/carreras/'+$id)
            .success(function(data){
                $scope.resultados = data.Carreras;
            }).error(function(){
            console.log('Error de datos');
        });
    };


    $scope.selecionarObjeto = function(id){
        $scope.guardar = false;
        var found = $filter('getById')($scope.resultados, id);
        $scope.form = found;
        $scope.cambiarVisibilidad();
    }

    $scope.cambiarVisibilidad = function() {
        if ($scope.mostrarTabla == false) {
            $scope.form = {};
            $scope.guardar = true;
            $scope.error = "";
        }
        $scope.mostrarTabla = !$scope.mostrarTabla;
    }

});