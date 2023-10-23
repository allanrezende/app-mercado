var telaProdutoTipoCadastro = (function() {

    var privado = {};
    var publico = {};

    var domForm = document.formProdutoTipo;
    
    privado.limparFormulario = function() {
        domForm.reset();
    }

    privado.preventEnter = function(e) {
        e = e || event;
        var txtArea = /textarea/i.test((e.target || e.srcElement).tagName);
        return txtArea || (e.keyCode || e.which || e.charCode || 0) !== 13;
    }

    privado.inicializar = function() {
        document.querySelector('form').onkeydown = privado.preventEnter;
        domForm.btLimparFormulario.onclick = privado.limparFormulario;
    }

    document.addEventListener("DOMContentLoaded", privado.inicializar );

    return publico;
})();