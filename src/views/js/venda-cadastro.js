var telaVendaCadastro = (function() {

    var privado = {};
    var publico = {};

    var domForm = document.formVenda;

    privado.removerProdutoSelecionado = function(){
        domForm.produto_id.value = "";
        document.getElementById('formVendaProdutoNomeSelecionado').value = "";
        privado.mostrarPesquisaProduto();
        privado.desabilitarAdicionar();
    }

    privado.limparPesquisaProduto = function() {
        document.getElementById('resultadoPesquisaProduto').innerHTML = "";
        document.getElementById('formVendaProdutoNome').value = "";
    }

    privado.mostrarProdutoSelecionado = function() {
        document.getElementById('divPesquisaProduto').style.display = "none";
        document.getElementById('resultadoPesquisaProduto').style.display = "none";
        document.getElementById('divProdutoSelecionado').style.display = "";
    };

    privado.mostrarPesquisaProduto = function() {
        privado.limparPesquisaProduto();
        document.getElementById('divProdutoSelecionado').style.display = "none";
        document.getElementById('divPesquisaProduto').style.display = "";
        document.getElementById('resultadoPesquisaProduto').style.display = "";
    };

    privado.desabilitarAdicionar = function() {
        domForm.btAdicionarProduto.disabled = true;
        domForm.quantidade.disabled = true;
        domForm.quantidade.value = "";
    }

    privado.habilitarAdicionar = function() {
        domForm.quantidade.value = 1;
        domForm.quantidade.disabled = false;
        domForm.btAdicionarProduto.disabled = false;
        domForm.quantidade.focus();
    }

    privado.popularProduto = function(id, nome) {
        if (!id) return false;
        domForm.produto_id.value = id;
        document.getElementById('formVendaProdutoNomeSelecionado').value = nome;
        privado.mostrarProdutoSelecionado();
        privado.habilitarAdicionar();
    };

    privado.atribuiEventosPesquisaProduto = function() {
        const items = document.querySelectorAll("#resultadoPesquisaProduto div a");
        for (let item of items){
            item.onclick = function() {
                privado.popularProduto(item.getAttribute("data-id"), item.textContent);
                return false;
            }
        }
    };

    privado.adicionarProduto = function() {
        privado.atualizaCardVendaProduto();
        privado.removerProdutoSelecionado();
    };

    privado.removeLinhaProduto = function(e) {
        e.target.parentElement.parentElement.remove();
        var cleaned = document.querySelectorAll(".btRemoverProduto").length > 0 ? false : true;
        privado.atualizaCardVendaProduto(cleaned);
    }

    privado.atribuiEventosCardVendaProduto = function() {
        const items = document.querySelectorAll(".btRemoverProduto");
        for (let item of items){
            item.onclick = privado.removeLinhaProduto;
        }
    };

    privado.atualizaCardVendaProduto = function(cleaned = false) {

        let data = new FormData(domForm);

        let queryString = new URLSearchParams(data).toString() + (cleaned ? "&cleaned=true" : "");

        fetch('/venda/card-venda-produto?' + queryString, {
                method: "POST",
            })
            .then(function(response) {
                return response.text()
            })
            .then(function(html) {
                document.getElementById('resultadoProdutoVenda').innerHTML = html;
                privado.atribuiEventosCardVendaProduto();
            })
            .catch(function(err) {  
                console.log(err);
            });
    };

    privado.pesquisarProduto = function(event) {

        const termo = event.target.value;

        if (!termo) {
            privado.limparPesquisaProduto();
            return false;
        };

        fetch('/produto/resultado-consulta?termo=' + termo, {
                method: "POST",
            })
            .then(function(response) {
                return response.text()
            })
            .then(function(html) {
                document.getElementById('resultadoPesquisaProduto').innerHTML = html;
                privado.atribuiEventosPesquisaProduto();
            })
            .catch(function(err) {  
                console.log(err);
            });
    };

    privado.preventEnter = function(e) {
        e = e || event;
        var txtArea = /textarea/i.test((e.target || e.srcElement).tagName);
        return txtArea || (e.keyCode || e.which || e.charCode || 0) !== 13;
    }

    privado.inicializar = function() {
        document.querySelector('form').onkeydown = privado.preventEnter;
        document.getElementById('formVendaProdutoNome').addEventListener('input', privado.pesquisarProduto);
        domForm.btRemoverSelecaoProduto.onclick = privado.removerProdutoSelecionado;
        domForm.btAdicionarProduto.onclick = privado.adicionarProduto;
        privado.atualizaCardVendaProduto();
    };

    document.addEventListener('DOMContentLoaded', privado.inicializar);

    return publico;
})();