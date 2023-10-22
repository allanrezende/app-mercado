<?php

namespace AllanRezende\AppMercado\Views;

use AllanRezende\AppMercado\Views\Components\AlertComponent;
use raelgc\view\Template;

class ProdutoRegisterView extends AbstractView {

    public function __construct(array $data = []) {
        
        $this->template = new Template(__DIR__ . "/html/produto-cadastro.html");
        $this->handle($data);
    }

    private function handle(array $data = []): void {

        $created = $data["created"] ?? false;
        $produto = $data["produto"] ?? null;
        $produtoTipo = $data["produto_tipo"] ?? null;

        if ($produto) {
            $this->template->ID = $produto->getId();
            $this->template->NOME = $produto->getNome();
            $this->template->VALOR = $produto->getValor();            
        }

        if ($produtoTipo) {
            $this->template->PRODUTO_TIPO_ID = $produtoTipo->getId();
            $this->template->PRODUTO_TIPO_NOME = $produtoTipo->getNome();
        }
        
        if ($created) {
            $alertComponent = new AlertComponent(["type" => "success", "message" => "Produto salvo com sucesso."]);
            $this->template->ALERT = $alertComponent->parse();
        }
    }
}