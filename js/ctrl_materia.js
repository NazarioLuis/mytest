//Controlador del template de registro de Materias
app.controller('materiaCtlr', function($scope,$filter, $http) {
    $scope.titulo = "Registro de Asignaturas";
    $scope.resultados = [];
    $scope.carreras = [];
    $scope.form = {CarId:''};
    $scope.mostrarTabla = true;
    $scope.guardar = true;
    $scope.error = '';
    $scope.bs = {carrera:'',texto:''};


    $http.get('api/materias').
    success(function(data) {
        $scope.resultados = data.Materias;
    }).error(function(){
        console.log('Error de datos');
    });

    $http.get('api/carreras').
    success(function(data) {
        $scope.carreras = data.Carreras;
        $scope.$broadcast('dataloaded');
    }).error(function(){
        console.log('Error de datos');
    });

    $scope.confirmar = function(datos){
        if($scope.form.CarId !== ''){
            $http.post('api/materias',datos)
                .success(function(data){
                    console.log(data);
                    $scope.resultados = data.Materias;
                    $scope.cambiarVisibilidad();
                });
        }else {
           $scope.error = "Debe seleccionar una carrera";
        }
    };

    $scope.eliminar = function($id){
        $http.delete('api/materias/'+$id)
            .success(function(data){
                $scope.resultados = data.Materias;
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

    $scope.cambiarVisibilidad = function(){
        if($scope.mostrarTabla == false){
            $scope.form = {CarId:''};
            $scope.guardar = true;
            $scope.error = "";
        }
        $scope.mostrarTabla = !$scope.mostrarTabla;
        changeSelects();
    }

    selectChangeListener = function(){
        $("#carrera").on('change', function() {
            $scope.form.CarId = $("#carrera").val();
        });
        $("#carreraFilter").on('change', function() {
            $scope.bs.carrera = $("#carreraFilter").val();
            $scope.$apply();
        });
    }
    selectChangeListener();

    changeSelects = function(){
        $("#carrera").val($scope.form.CarId);
        $('#carrera').material_select();
    }

    $scope.buscar = function (row) {

        return ((row.Descripcion.indexOf($scope.bs.texto) !== -1 || row.Id == $scope.bs.texto)
            && ($scope.bs.carrera == '' || row.CarId == $scope.bs.carrera));

    };
});