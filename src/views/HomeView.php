<?php

namespace AllanRezende\AppMercado\Views;
use raelgc\view\Template;

class HomeView extends AbstractView {

    public function __construct() {
        $this->template = new Template(__DIR__ . "/html/home.html");
    }
}