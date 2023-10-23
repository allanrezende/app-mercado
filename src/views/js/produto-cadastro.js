var telaProdutoCadastro = (function() {

    var privado = {};
    var publico = {};

    var domForm = document.formProduto;

    privado.removerProdutoTipoSelecionado = function(){
        domForm.produto_tipo_id.value = "";
        document.getElementById('formProdutoProdutoTipoNomeSelecionado').value = "";
        privado.mostrarPesquisaProdutoTipo();
    }

    privado.limparPesquisaProdutoTipo = function() {
        document.getElementById('resultadoPesquisaProdutoTipo').innerHTML = "";
        document.getElementById('formProdutoProdutoTipoNome').value = "";
    }

    privado.mostrarProdutoTipoSelecionado = function() {
        document.getElementById('divPesquisaProdutoTipo').style.display = "none";
        document.getElementById('resultadoPesquisaProdutoTipo').style.display = "none";
        document.getElementById('divProdutoTipoSelecionado').style.display = "";
    };

    privado.mostrarPesquisaProdutoTipo = function() {
        privado.limparPesquisaProdutoTipo();
        document.getElementById('divProdutoTipoSelecionado').style.display = "none";
        document.getElementById('divPesquisaProdutoTipo').style.display = "";
        document.getElementById('resultadoPesquisaProdutoTipo').style.display = "";
    };

    privado.popularProdutoTipo = function(id, nome) {
        if (!id) return false;
        domForm.produto_tipo_id.value = id;
        document.getElementById('formProdutoProdutoTipoNomeSelecionado').value = nome;
        privado.mostrarProdutoTipoSelecionado();
    };

    privado.atribuiEventosPesquisaProdutoTipo = function() {
        const items = document.querySelectorAll("#resultadoPesquisaProdutoTipo a");
        for (let item of items){
            item.onclick = function() {
                privado.popularProdutoTipo(item.getAttribute("data-id"), item.textContent);
                return false;
            }
        }
    };

    privado.pesquisarProdutoTipo = function(event) {

        const termo = event.target.value;

        if (!termo) {
            privado.limparPesquisaProdutoTipo();
            return false;
        };

        fetch('/produto-tipo/resultado-consulta?termo=' + termo, {
                method: "POST",
            })
            .then(function(response) {
                return response.text()
            })
            .then(function(html) {
                document.getElementById('resultadoPesquisaProdutoTipo').innerHTML = html;
                privado.atribuiEventosPesquisaProdutoTipo();
            })
            .catch(function(err) {  
                console.log(err);
            });
    };

    privado.produtoTipoListener = function() {
        if (domForm.produto_tipo_id.value) {
            privado.popularProdutoTipo(domForm.produto_tipo_id.value, document.getElementById('formProdutoProdutoTipoNomeSelecionado').value);
        }
    };

    privado.limparFormulario = function() {
        privado.removerProdutoTipoSelecionado();
        domForm.reset();
    };

    privado.preventEnter = function(e) {
        e = e || event;
        var txtArea = /textarea/i.test((e.target || e.srcElement).tagName);
        return txtArea || (e.keyCode || e.which || e.charCode || 0) !== 13;
    }

    privado.inicializar = function() {
        document.querySelector('form').onkeydown = privado.preventEnter;
        document.getElementById('formProdutoProdutoTipoNome').addEventListener('input', privado.pesquisarProdutoTipo);
        domForm.btRemoverSelecaoProdutoTipo.onclick = privado.removerProdutoTipoSelecionado;
        domForm.btLimparFormulario.onclick = privado.limparFormulario;
        privado.produtoTipoListener();
    };

    document.addEventListener('DOMContentLoaded', privado.inicializar);

    return publico;
})();