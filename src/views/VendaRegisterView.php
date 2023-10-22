<?php

namespace AllanRezende\AppMercado\Views;

use raelgc\view\Template;

class VendaRegisterView extends AbstractView {

    public function __construct(array $data = []) {
        $this->template = new Template(__DIR__ . "/html/venda-cadastro.html");
    }
}