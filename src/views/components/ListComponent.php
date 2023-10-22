<?php

namespace AllanRezende\AppMercado\Views\Components;
use raelgc\view\Template;

class ListComponent extends AbstractComponent {

    public function __construct(array $items = []) {
        $this->template = new Template(__DIR__ . "/html/list.html");
        $this->mount($items);
    }

    private function mount(array $items = []) {
        foreach ($items as $item) {
            $this->template->LIST_ITEM_NAME = $item["name"];
            $this->template->LIST_ITEM_LINK = $item["link"] ?? "#";
            $this->template->LIST_ITEM_ID = $item["id"] ?? "";
            $this->template->block("BLOCK_LIST_ITEM");
        }
    }
}