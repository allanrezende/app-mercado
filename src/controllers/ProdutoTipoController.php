<?php

namespace AllanRezende\AppMercado\Controllers;
use AllanRezende\AppMercado\Models\ProdutoTipo;
use AllanRezende\AppMercado\Repositories\ProdutoTipoRepository;
use AllanRezende\AppMercado\Views\Components\ListComponent;
use AllanRezende\AppMercado\Views\ProdutoTipoSearchView;
use AllanRezende\AppMercado\Views\ProdutoTipoRegisterView;

class ProdutoTipoController {

    public static function renderSearchView(array $params = []): string {

        $produtoTipoRepository = new ProdutoTipoRepository();
        $data = $produtoTipoRepository->findAll($params);
        $view = new ProdutoTipoSearchView($data, $params);
        return $view->render();
    }

    public static function renderRegisterView(array $params = []): string {

        $id = $params["id"] ?? null;

        if ($id) {
            $produtoTipoRepository = new ProdutoTipoRepository();
            $produtoTipo = $produtoTipoRepository->findOne($id);
            $params["produtoTipo"] = $produtoTipo;
        }

        $view = new ProdutoTipoRegisterView($params);
        return $view->render();
    }

    public static function renderSearchResultsView(array $params = []): string {
        $produtoTipoRepository = new ProdutoTipoRepository();
        $data = $produtoTipoRepository->findAll($params);

        $items = [];
        
        foreach ($data as $produtoTipo) {
            $item = [];
            $item["name"] = $produtoTipo["nome"];
            $item["id"] = $produtoTipo["id"];
            $items[] = $item;
        }

        $listComponent = new ListComponent($items);
        return $listComponent->parse();
    }

    public static function register(array $params): ProdutoTipo {
        
        $produtoTipoRepository = new ProdutoTipoRepository();
        $item = $produtoTipoRepository->getObjectByRow($params);

        if (!empty($item->getId())) {
            $produtoTipo = $produtoTipoRepository->update($item);
        } else {
            $produtoTipo = $produtoTipoRepository->insert($item);
        }

        return $produtoTipo;
    }

    public static function remove(int $id): bool {
        $produtoTipoRepository = new ProdutoTipoRepository();
        return $produtoTipoRepository->delete($id);
    }
}