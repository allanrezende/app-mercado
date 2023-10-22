<?php

namespace AllanRezende\AppMercado\Views;

use AllanRezende\AppMercado\Views\Components\ListComponent;
use raelgc\view\Template;

class ProdutoSearchView extends AbstractView {

    public function __construct(array $data = [], array $params = []) {
        $this->template = new Template(__DIR__ . "/html/produto-consulta.html");
        $this->handle($data, $params);
    }

    private function handle(array $data = [], array $params = []): void {

        $termo = $params["termo"] ?? "";

        $this->template->TERMO_PESQUISA = htmlentities($termo);

        $items = [];
        
        foreach ($data as $produto) {
            $item = [];
            $item["name"] = $produto["nome"];
            $item["link"] = "/produto/cadastro?id=" . $produto["id"];
            $items[] = $item;
        }

        $listComponent = new ListComponent($items);
        $this->template->LIST_ITEM_CONSULTA = $listComponent->parse();
    }
}