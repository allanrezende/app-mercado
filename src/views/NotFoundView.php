<?php

namespace AllanRezende\AppMercado\Views;
use raelgc\view\Template;

class NotFoundView extends AbstractView {

    public function __construct() {
        $this->template = new Template(__DIR__ . "/html/not-found.html");
    }
}