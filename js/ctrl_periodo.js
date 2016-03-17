//Controlador del template de registro de Materias
app.controller('periodoCtlr', function(MyService,$scope,$filter, $http) {
    $scope.titulo = "Registro de Periodos Lectivos";
    $scope.resultados = [];
    $scope.carreras = [];
    $scope.form = {CarId:''};
    $scope.mostrarTabla = true;
    $scope.guardar = true;
    $scope.error = '';
    $scope.bs = {carrera:'',texto:''};


    $http.get('api/periodos').
    success(function(data) {
        $scope.resultados = data.Periodos;
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
        console.log(datos);
        if(validar(datos)){
            $http.post('api/periodos',datos)
                .success(function(data){
                    console.log(data);
                    $scope.resultados = data.Periodos;
                    $scope.cambiarVisibilidad();
                });
        }
    };

    $scope.eliminar = function($id){
        $http.delete('api/periodos/'+$id)
            .success(function(data){
                $scope.resultados = data.Periodos;
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
        return ((row.Anio+"0/"+row.Periodo).indexOf($scope.bs.texto) >= 0
            || row.Id == $scope.bs.texto)
            && ($scope.bs.carrera == '' || row.CarId == $scope.bs.carrera);

    };
    validar = function(datos){
        if (datos.CarId == ''){
            $scope.error = 'Debes seleccionar una carrera';
            return false;
        }
        if (!validarAnioYPeriodo(datos)){
            $scope.error = 'Ya extiste el Periodo '+datos.Anio+'/0'+datos.Periodo+' en la carrera seleccionada';
            console.log(true);
            return false;
        }
        return true;
    }

    validarAnioYPeriodo = function(datos){
        var i=0, len=$scope.resultados.length;
        for (; i<len; i++) {
            if ($scope.resultados[i].Anio == datos.Anio && $scope.resultados[i].Periodo == datos.Periodo
                && $scope.resultados[i].CarId == datos.CarId && datos['Id'] !== $scope.resultados[i].Id) {
                return false;
            }
        }
        return true;
    }
});