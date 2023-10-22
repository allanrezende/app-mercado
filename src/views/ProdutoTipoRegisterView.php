<?php

namespace AllanRezende\AppMercado\Views;

use AllanRezende\AppMercado\Views\Components\AlertComponent;
use raelgc\view\Template;

class ProdutoTipoRegisterView extends AbstractView {

    public function __construct(array $data = []) {

        $this->template = new Template(__DIR__ . "/html/produto-tipo-cadastro.html");
        $this->handle($data);
    }

    private function handle(array $data = []): void {

        $created = $data["created"] ?? false;
        $produtoTipo = $data["produtoTipo"] ?? null;

        if ($produtoTipo) {
            $this->template->ID = $produtoTipo->getId();
            $this->template->NOME = $produtoTipo->getNome();
            $this->template->IMPOSTO_PERCENTUAL = $produtoTipo->getImpostoPercentual();
        }
        
        if ($created) {
            $alertComponent = new AlertComponent(["type" => "success", "message" => "Tipo de produto salvo com sucesso."]);
            $this->template->ALERT = $alertComponent->parse();
        }
    }
}