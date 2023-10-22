<?php

namespace AllanRezende\AppMercado\Views;
use raelgc\view\Template;

abstract class AbstractView {

    protected Template $template;

    public function render(): string {
        $template = new Template(__DIR__ . "/html/wrapper.html");
        $template->CONTENT = $this->template->parse();
        return $template->parse();
    }
}