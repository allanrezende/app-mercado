<?php

namespace AllanRezende\AppMercado\Controllers;
use AllanRezende\AppMercado\Models\ProdutoTipo;
use AllanRezende\AppMercado\Repositories\ProdutoTipoRepository;
use AllanRezende\AppMercado\Views\Components\ListComponent;
use AllanRezende\AppMercado\Views\ProdutoTipoSearchView;
use AllanRezende\AppMercado\Views\ProdutoTipoRegisterView;
use Exception;
use InvalidArgumentException;

class ProdutoTipoController {

    public static function renderSearchView(array $params = []): string {

        $produtoTipoRepository = new ProdutoTipoRepository();
        $data = $produtoTipoRepository->findAll($params);
        $view = new ProdutoTipoSearchView($data, $params);
        return $view->render();
    }

    public static function renderRegisterView(array $params = [], ?string $error = ""): string {

        $id = $params["id"] ?? null;

        if ($id) {
            $produtoTipoRepository = new ProdutoTipoRepository();
            $produtoTipo = $produtoTipoRepository->findOne($id);
            $params["produtoTipo"] = $produtoTipo;
        }

        $view = new ProdutoTipoRegisterView($params, $error);
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

        $id = $params["id"] ?? null;
        $nome = $params["nome"] ?? null;
        $impostoPercentual = $params["imposto_percentual"];

        if ($id) {
            $produtoTipo = $produtoTipoRepository->findOne($id);
        } else {
            $produtoTipo = new ProdutoTipo();
            $produtoTipo->setDataCriacao(date("Y-m-d H:i:s"));
        }

        if (empty($nome)) throw new InvalidArgumentException("O nome deve ser informado.");
        if ($impostoPercentual === null) throw new InvalidArgumentException("O imposto percentual deve ser informado.");

        $produtoTipo->setNome($nome);
        $produtoTipo->setImpostoPercentual($impostoPercentual);
        
        if ($id) {
            $produtoTipo = $produtoTipoRepository->update($produtoTipo);
        } else {
            $produtoTipo = $produtoTipoRepository->insert($produtoTipo);
        }

        return $produtoTipo;
    }

    public static function remove(int $id): bool {
        $produtoTipoRepository = new ProdutoTipoRepository();
        return $produtoTipoRepository->delete($id);
    }
}