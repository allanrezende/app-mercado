<?php

namespace AllanRezende\AppMercado\Controllers;

use AllanRezende\AppMercado\Models\Produto;
use AllanRezende\AppMercado\Repositories\ProdutoRepository;
use AllanRezende\AppMercado\Repositories\ProdutoTipoRepository;
use AllanRezende\AppMercado\Views\Components\ListComponent;
use AllanRezende\AppMercado\Views\ProdutoRegisterView;
use AllanRezende\AppMercado\Views\ProdutoSearchView;
use InvalidArgumentException;

class ProdutoController {

    public static function renderSearchView(array $params = []): string {

        $produtoRepository = new ProdutoRepository();
        $data = $produtoRepository->findAll($params);
        $view = new ProdutoSearchView($data, $params);
        return $view->render();
    }

    public static function renderRegisterView(array $params = [], ?string $error = ""): string {

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

        $view = new ProdutoRegisterView($params, $error);
        return $view->render();
    }

    public static function renderSearchResultsView(array $params = []): string {
        $produtoRepository = new ProdutoRepository();
        $data = $produtoRepository->findAll($params);

        $items = [];
        
        foreach ($data as $produto) {
            $item = [];
            $item["name"] = $produto["nome"];
            $item["id"] = $produto["id"];
            $items[] = $item;
        }

        $listComponent = new ListComponent($items);
        return $listComponent->parse();
    }

    public static function register(array $params): Produto {

        $produtoRepository = new ProdutoRepository();

        $id = $params["id"] ?? null;
        $nome = $params["nome"] ?? null;
        $produtoTipoId = $params["produto_tipo_id"] ?? null;
        $valor = $params["valor"] ?? null;

        if ($id) {
            $produto = $produtoRepository->findOne($id);
        } else {
            $produto = new Produto();
            $produto->setDataCriacao(date("Y-m-d H:i:s"));
        }

        if (empty($nome)) throw new InvalidArgumentException("O nome do produto deve ser informado.");
        if (empty($produtoTipoId)) throw new InvalidArgumentException("O tipo do produto deve ser selecionado.");
        if ($valor === null) throw new InvalidArgumentException("O valor do produto deve ser informado.");

        $produto->setNome($nome);
        $produto->setProdutoTipoId($produtoTipoId);
        $produto->setValor($valor);

        if ($id) {
            $produto = $produtoRepository->update($produto);
        } else {
            $produto = $produtoRepository->insert($produto);
        }

        return $produto;
    }

    public static function remove(int $id): bool {
        $produtoRepository = new ProdutoRepository();
        return $produtoRepository->delete($id);
    }
}