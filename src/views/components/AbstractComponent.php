<?php

namespace AllanRezende\AppMercado\Views\Components;
use raelgc\view\Template;

abstract class AbstractComponent {
    
    protected Template $template;

    public abstract function __construct(array $data = []);

    public function parse(): string {
        return $this->template->parse();
    }
}