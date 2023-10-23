var telaVendaConsulta = (function() {

    var privado = {};
    var publico = {};

    var domForm = document.formVenda;

    privado.consultarSeTeclaEnter = function(event) {
        if (event.keyCode == 13) {
            domForm.submit();
        }
    }

    privado.inicializar = function() {
        domForm.termo.onkeypress = privado.consultarSeTeclaEnter;
    };

    document.addEventListener("DOMContentLoaded", privado.inicializar );

    return publico;
})();