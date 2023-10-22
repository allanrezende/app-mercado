<?php

namespace AllanRezende\AppMercado\Controllers;

use AllanRezende\AppMercado\Models\Venda;
use AllanRezende\AppMercado\Repositories\VendaRepository;
use AllanRezende\AppMercado\Views\VendaRegisterView;
use AllanRezende\AppMercado\Views\VendaSearchView;

class VendaController {

    public static function renderSearchView(array $params = []): string {

        $vendaRepository = new VendaRepository();
        $data = $vendaRepository->findAll($params);
        $view = new VendaSearchView($data, $params);
        return $view->render();
    }

    public static function renderRegisterView(array $params = []): string {
        $id = $params["id"] ?? null;

        if ($id) {
            $vendaRepository = new VendaRepository();
            $venda = $vendaRepository->findOne($id);
            $params["venda"] = $venda;
         }

        $view = new VendaRegisterView($params);
        return $view->render();
    }
}