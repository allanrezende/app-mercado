var produto = (function() {

    var privado = {};
    var publico = {};

    var domForm = document.formProduto;

    privado.consultarSeTeclaEnter = function(event) {
        if (event.keyCode == 13) {
            domForm.submit();
        }
    }

    privado.inicializar = function() {
        domForm.nome.onkeypress = privado.consultarSeTeclaEnter;
    };

    document.addEventListener("DOMContentLoaded", privado.inicializar );

    return publico;
})();