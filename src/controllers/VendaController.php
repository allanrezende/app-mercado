<?php

namespace AllanRezende\AppMercado\Controllers;

use AllanRezende\AppMercado\Models\Venda;
use AllanRezende\AppMercado\Repositories\VendaProdutoRepository;
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
        $view = new VendaRegisterView($params);
        return $view->render();
    }

    public static function register(array $params): Venda {

        // Organiza os parâmetros da venda e dos venda_produto
        $vendaParams = [];
        $arrVendaProdutoParams = [];

        $vendaParams["id"] = $params["id"] ?? null;

        $params["venda_produto_id"] = $params["venda_produto_id"] ?? [];

        foreach ($params["venda_produto_id"] as $produtoId => $vendaProdutoId) {
            
            $quantidade = $params["venda_produto_quantidade"][$produtoId] ?? null;
            $valorUnitario = $params["venda_produto_valor_unitario"][$produtoId] ?? null;
            $impostoPercentual = $params["venda_produto_imposto_percentual"][$produtoId] ?? null;

            $arrVendaProdutoParams[] = [
                "id" => $vendaProdutoId,
                "venda_id" => $vendaParams["id"],
                "produto_id" => $produtoId,
                "quantidade" => $quantidade,
                "valor_unitario" => $valorUnitario,
                "imposto_percentual" => $impostoPercentual
            ];
        }

        // Cria o registro da tabela venda
        $vendaRepository = new VendaRepository();
        $venda = $vendaRepository->getObjectByRow($vendaParams);

        if (empty($venda->getId())) {
            $venda->setDataCriacao(date("Y-m-d H:i:s"));
            $venda = $vendaRepository->insert($venda);
        }

        // Cria os registros da tabela venda_produto e armazena no vetor para não serem excluídos
        $vendaProdutoRepository = new VendaProdutoRepository();
        $idsNaoExcluir = [];

        foreach ($arrVendaProdutoParams as $vendaProdutoParams) {
            $vendaProduto = $vendaProdutoRepository->getObjectByRow($vendaProdutoParams);
            $vendaProduto->setVendaId($venda->getId());
            if (empty($vendaProduto->getId())) {
                $vendaProduto = $vendaProdutoRepository->insert($vendaProduto);
            }
            $idsNaoExcluir[] = $vendaProduto->getId();
        }

        // Busca os registros da tabela venda_produto que pertencem a venda e excluir os
        $arrVendaProduto = $vendaProdutoRepository->findAll(["venda_id" => $venda->getId()]);

        foreach ($arrVendaProduto as $vendaProdutoExcluir) {
            if (!in_array($vendaProdutoExcluir["id"], $idsNaoExcluir)) {
                $vendaProdutoRepository->delete($vendaProdutoExcluir["id"]);
            }
        }
        
        return $venda;
    }
}