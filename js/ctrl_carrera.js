//Controlador del template de registro de carreras
app.controller('carreraCtlr', function(MyService,$scope,$filter, $http) {
    $scope.resultados = [];
    $scope.mostrarTabla = true;
    $scope.guardar = true;
    $scope.error = '';
    $scope.bs = '';
    $scope.titulo = "Registro de Carreras";

    $http.get('api/carreras').
    success(function(data) {
        $scope.resultados = data.Carreras;
    }).error(function(){
        console.log('Error de datos');
    });

    $scope.confirmar = function(datos){
        if(validarDescripcion(datos)){
            $http.post('api/carreras',datos)
                .success(function(data){
                    $scope.resultados = data.Carreras;
                    $scope.cambiarVisibilidad();
                });
        }
    };

    $scope.eliminar = function($id){
        $http.delete('api/carreras/'+$id)
            .success(function(data){
                $scope.resultados = data.Carreras;
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

    $scope.cambiarVisibilidad = function() {
        if ($scope.mostrarTabla == false) {
            $scope.form = {};
            $scope.guardar = true;
            $scope.error = "";
        }
        $scope.mostrarTabla = !$scope.mostrarTabla;
    }

    $scope.buscar = function (row) {
        return MyService.normalize(row.Descripcion).indexOf(MyService.normalize($scope.bs)) >= 0 || row.Id == $scope.bs;
    };

    validarDescripcion = function(datos){
        var i=0, len=$scope.resultados.length;
        for (; i<len; i++) {
            if (MyService.normalize($scope.resultados[i].Descripcion) == MyService.normalize(datos.Descripcion)
                    && datos['Id'] !== $scope.resultados[i].Id) {
                $scope.error = 'Ya extiste la carrera '+datos.Descripcion;
                return false;
            }
        }
        return true;
    }
});