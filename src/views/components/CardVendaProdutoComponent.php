<?php

namespace AllanRezende\AppMercado\Views\Components;
use raelgc\view\Template;

class CardVendaProdutoComponent extends AbstractComponent {

    public function __construct(array $data = []){

        $this->template = new Template(__DIR__ . "/html/card-venda-produto.html");
        $this->mount($data);
    }

    private function numberFormat($number) {
        return number_format($number, 2, ",");
    }

    private function mount(array $data = []): void {

        $somatorio = [
            "quantidade" => 0,
            "valor_produtos" => 0,
            "valor_imposto" => 0,
            "valor_total" => 0
        ];

        foreach ($data as $item) {

            $produto = $item["produto"];
            $vendaProduto = $item["vendaProduto"];

            $valorProdutoQuantidade = $vendaProduto->getQuantidade() * $vendaProduto->getValorUnitario();
            $valorImpostoProdutoQuantidade = $valorProdutoQuantidade * $vendaProduto->getImpostoPercentual()/100;
            $somaProdutoQuantidade = $valorProdutoQuantidade + $valorImpostoProdutoQuantidade;

            $this->template->PRODUTO_NOME = $produto->getNome();
            $this->template->PRODUTO_ID = $produto->getId();
            $this->template->VENDA_PRODUTO_ID = $vendaProduto->getId();
            $this->template->VENDA_PRODUTO_QUANTIDADE = $vendaProduto->getQuantidade();
            $this->template->F_PRODUTO_VALOR = $this->numberFormat($vendaProduto->getValorUnitario());
            $this->template->PRODUTO_VALOR = $vendaProduto->getValorUnitario();
            $this->template->F_PRODUTO_TIPO_IMPOSTO_PERCENTUAL = $this->numberFormat($vendaProduto->getImpostoPercentual());
            $this->template->PRODUTO_TIPO_IMPOSTO_PERCENTUAL = $vendaProduto->getImpostoPercentual();

            $this->template->VALOR_PRODUTO_X_QUANTIDADE = $this->numberFormat($valorProdutoQuantidade);
            $this->template->VALOR_IMPOSTO_PRODUTO_X_QUANTIDADE = $this->numberFormat($valorImpostoProdutoQuantidade);
            $this->template->SOMA_PRODUTO_X_QUANTIDADE = $this->numberFormat($somaProdutoQuantidade);

            $somatorio["quantidade"] += $vendaProduto->getQuantidade();
            $somatorio["valor_produtos"] += $valorProdutoQuantidade;
            $somatorio["valor_imposto"] += $valorImpostoProdutoQuantidade;
            $somatorio["valor_total"] += $somaProdutoQuantidade;

            $this->template->block("BLOCK_VENDA_PRODUTO");
        }

        $this->template->SOMATORIO_QUANTIDADE = $somatorio["quantidade"];
        $this->template->SOMATORIO_VALOR_PRODUTOS = $this->numberFormat($somatorio["valor_produtos"]);
        $this->template->SOMATORIO_VALOR_IMPOSTO = $this->numberFormat($somatorio["valor_imposto"]);
        $this->template->SOMATORIO_VALOR_FINAL = $this->numberFormat($somatorio["valor_total"]);
    }
}