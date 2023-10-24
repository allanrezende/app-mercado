<?php

namespace AllanRezende\AppMercado\Views;

use AllanRezende\AppMercado\Views\Components\ListComponent;
use raelgc\view\Template;

class VendaSearchView extends AbstractView {

    public function __construct(array $data = [], array $params = []) {
        $this->template = new Template(__DIR__ . "/html/venda-consulta.html");
        $this->handle($data, $params);
    }

    private function handle(array $data = [], array $params = []): void {

        $termo = $params["termo"] ?? "";

        $this->template->TERMO_PESQUISA = htmlentities($termo);

        $items = [];
        
        foreach ($data as $venda) {
            $item = [];
            $item["name"] = "<strong>#". $venda["id"] ."</strong> - " . date('d-m-Y H:i', strtotime($venda["data_criacao"]));
            $item["link"] = "/venda/cadastro?id=" . $venda["id"];
            $items[] = $item;
        }

        $listComponent = new ListComponent($items);
        $this->template->LIST_ITEM_CONSULTA = $listComponent->parse();
    }
}