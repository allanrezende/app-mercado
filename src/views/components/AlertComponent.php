<?php

namespace AllanRezende\AppMercado\Views\Components;
use raelgc\view\Template;

class AlertComponent extends AbstractComponent {

    public function __construct(array $message = []){
        $this->template = new Template(__DIR__ . "/html/alert.html");
        $this->mount($message);
    }

    private function mount(array $message = []): void {
        $this->template->TYPE = $message["type"] ?? "light";
        $this->template->MESSAGE = $message["message"] ?? "";
    }
}