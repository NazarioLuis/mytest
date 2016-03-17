//Controlador del template de registro de Materias
app.controller('materiaCtlr', function(MyService,$scope,$filter, $http) {
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
        if(validar(datos)){
            $http.post('api/materias',datos)
                .success(function(data){
                    console.log(data);
                    $scope.resultados = data.Materias;
                    $scope.cambiarVisibilidad();
                });
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
            $scope.$apply();
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
        return (MyService.normalize(row.Descripcion).indexOf(MyService.normalize($scope.bs.texto)) >= 0
            || row.Id == $scope.bs.texto)
            && ($scope.bs.carrera == '' || row.CarId == $scope.bs.carrera);

    };
    validar = function(datos){
        if (datos.CarId == ''){
            $scope.error = 'Debes seleccionar una carrera';
            return false;
        }
        if (!validarDescripcionYCarrera(datos)){
            $scope.error = 'Ya extiste la asignatura '+datos.Descripcion+' en la carrera seleccionada';
            console.log(true);
            return false;
        }
        return true;
    }

    validarDescripcionYCarrera = function(datos){
        var i=0, len=$scope.resultados.length;
        for (; i<len; i++) {
            if (MyService.normalize($scope.resultados[i].Descripcion) == MyService.normalize(datos.Descripcion)
                && $scope.resultados[i].CarId == datos.CarId && datos['Id'] !== $scope.resultados[i].Id) {
                return false;
            }
        }
        return true;
    }
});