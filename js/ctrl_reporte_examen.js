/**
 * Created by Nazario Luis on 14/03/2016.
 */
//Controlador del template de registro de alumnos
app.controller('informeExamenCtlr', function(MyService,$scope,$rootScope, $http) {
    $scope.resultados;

    $http.get('api/resultados/'+$rootScope.par['examen'].Id).
    success(function(data) {
        console.log(data);
        $scope.resultados = data.Resultados;
    }).error(function(){
        console.log('Error de datos');
    });

});