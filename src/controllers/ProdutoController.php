<?php

namespace AllanRezende\AppMercado\Controllers;

use AllanRezende\AppMercado\Models\Produto;
use AllanRezende\AppMercado\Repositories\ProdutoRepository;
use AllanRezende\AppMercado\Repositories\ProdutoTipoRepository;
use AllanRezende\AppMercado\Views\ProdutoRegisterView;
use AllanRezende\AppMercado\Views\ProdutoSearchView;

class ProdutoController {

    public static function renderSearchView(array $params = []): string {

        $produtoRepository = new ProdutoRepository();
        $data = $produtoRepository->findAll($params);
        $view = new ProdutoSearchView($data, $params);
        return $view->render();
    }

    public static function renderRegisterView(array $params = []): string {

        $id = $params["id"] ?? null;

        if ($id) {
            $produtoRepository = new ProdutoRepository();
            $produto = $produtoRepository->findOne($id);
            $params["produto"] = $produto;

            if ($produto->getProdutoTipoId()) {
                $produtoTipoRepository = new ProdutoTipoRepository();
                $produtoTipo = $produtoTipoRepository->findOne($produto->getProdutoTipoId());
                $params["produto_tipo"] = $produtoTipo;
            }
         }

        $view = new ProdutoRegisterView($params);
        return $view->render();
    }

    public static function register(array $params): Produto {

        $produtoRepository = new ProdutoRepository();
        $item = $produtoRepository->getObjectByRow($params);

        if (!empty($item->getId())) {
            $produtoTipo = $produtoRepository->update($item);
        } else {
            $produtoTipo = $produtoRepository->insert($item);
        }

        return $produtoTipo;
    }

    public static function remove(int $id): bool {
        $produtoRepository = new ProdutoRepository();
        return $produtoRepository->delete($id);
    }
}