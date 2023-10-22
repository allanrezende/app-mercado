var produtoCadastro = (function() {

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
        domForm.produto_tipo_id.value = id;
        document.getElementById('formProdutoProdutoTipoNomeSelecionado').value = nome;
        privado.mostrarProdutoTipoSelecionado();
    };

    privado.atribuiEventosPesquisaProdutoTipo = function() {
        const items = document.querySelectorAll("#resultadoPesquisaProdutoTipo div a");
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

    privado.inicializar = function() {
        document.getElementById('formProdutoProdutoTipoNome').addEventListener('input', privado.pesquisarProdutoTipo);
        domForm.btRemoverSelecaoProdutoTipo.onclick = privado.removerProdutoTipoSelecionado;
        privado.produtoTipoListener();
    };

    document.addEventListener('DOMContentLoaded', privado.inicializar);

    return publico;
})();