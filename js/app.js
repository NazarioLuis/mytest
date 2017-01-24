
var app = angular.module('myApp',[])
    .run(function($rootScope){
        $rootScope.template=null;
        $rootScope.template_carga=null;
        $rootScope.primario=true;
    });

app.directive('ngConfirmClick', [
    function(){
        return {
            link: function ($scope, element, attr) {
                var msg = attr.ngConfirmClick || "Estas seguro?";
                var title = attr.ngConfirmTitle || "Atención";
                var icon = attr.ngConfirmIcon || "warning";
                var clickAction = attr.confirmedClick;
                element.bind('click',function (event) {
                    var div = document.createElement("div");
                    div.setAttribute("title",title);
                    $(div).append(
                        "<p>" +
                        "<i class='material-icons' style='float:left; margin:0 7px 20px 0;'>"+icon+"</i>" +
                        msg +
                        "</p>"
                    );
                    $(div).dialog({
                        resizable: false,
                        height:200,
                        modal: true,
                        buttons: {
                            "Si": function() {
                                $( this ).dialog( "close" );
                                $scope.$eval(clickAction)
                            },
                            Cancel: function() {
                                $( this ).dialog( "close" );
                            }
                        }
                    });
                });
            }
        };
    }]);

app.directive('displaySelect', ['$timeout', function ($timeout) {
    return {
        link: function ($scope, element, attrs) {
            $scope.$on('dataloaded', function (event,args) {
                $timeout(function () {
                    $('#'+args.ele).material_select();
                }, 0, false);
            })
        }
    };
}]);


app.filter('getById', function() {
    return function(input, id) {
        var i=0, len=input.length;
        for (; i<len; i++) {
            if (+input[i].Id == +id) {
                return input[i];
            }
        }
        return null;
    }
});

app.service('MyService',function(){
    this.normalize = function(texto){
        texto = texto.replace(/[áàäâ]/g, "a");
        texto = texto.replace(/[éèëê]/g, "e");
        texto = texto.replace(/[íìïî]/g, "i");
        texto = texto.replace(/[óòôö]/g, "o");
        texto = texto.replace(/[úùüü]/g, "u");
        texto = texto.toUpperCase();
        return texto;
    }
    this.isEnter = function($event){
        var keyCode = $event.which || $event.keyCode;

        if (keyCode === 13) {
            return true;
        }else{
            return false;
        }
    }
    this.error = function(texto){
        var div = document.createElement("div");
        div.setAttribute("title",'Error');
        $(div).append(
            "<p>" +
            "<i class='material-icons' style='float:left; margin:0 7px 20px 0;'>error</i>" +
            texto +
            "</p>"
        );
        $(div).dialog({
            resizable: false,
            height:200,
            modal: true
        });
    }

});
