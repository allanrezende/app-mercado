<?php

namespace AllanRezende\AppMercado\Controllers;

use AllanRezende\AppMercado\Models\VendaProduto;
use AllanRezende\AppMercado\Repositories\ProdutoRepository;
use AllanRezende\AppMercado\Repositories\ProdutoTipoRepository;
use AllanRezende\AppMercado\Repositories\VendaProdutoRepository;
use AllanRezende\AppMercado\Views\Components\CardVendaProdutoComponent;
use Exception;

class VendaProdutoController {

    public static function renderVendaProdutoView(array $params = []): string {

        $produtoRepository = new ProdutoRepository();
        $produtoTipoRepository = new ProdutoTipoRepository();
        $vendaProdutoRepository = new VendaProdutoRepository();

        // Popula o vetor de parâmetros com os dados da tabela venda_produto (quando for edição) 
        $vendaId = $params["id"] ?? null;

        if (!empty($vendaId) && !isset($params["venda_produto_id"])) {
            $params = [];

            $vendaProdutos = $vendaProdutoRepository->findAll(["venda_id" => $vendaId]);

            foreach ($vendaProdutos as $vendaProduto) {
                $params["venda_produto_id"][$vendaProduto["produto_id"]] = $vendaProduto["id"];
                $params["venda_produto_quantidade"][$vendaProduto["produto_id"]] = $vendaProduto["quantidade"];
                $params["venda_produto_valor_unitario"][$vendaProduto["produto_id"]] = $vendaProduto["valor_unitario"];
                $params["venda_produto_imposto_percentual"][$vendaProduto["produto_id"]] = $vendaProduto["imposto_percentual"];
            }
        }

        // Inicialização
        $params["venda_produto_id"] = $params["venda_produto_id"] ?? [];
        $params["venda_produto_quantidade"] = $params["venda_produto_quantidade"] ?? [];
        $params["venda_produto_valor_unitario"] = $params["venda_produto_valor_unitario"] ?? [];
        $params["venda_produto_imposto_percentual"] = $params["venda_produto_imposto_percentual"] ?? [];

        // Adicona o novo produto ao vetor
        $produtoId = $params["produto_id"] ?? null;
        $quantidade = $params["quantidade"] ?? null;
        
        // Adiciona o novo produto no vetor de venda_produto_id
        if ($produtoId && $quantidade) {
            $params["venda_produto_id"][$produtoId] = null;
            $params["venda_produto_quantidade"][$produtoId] = ($params["venda_produto_quantidade"][$produtoId] ?? 0) + $quantidade;
        }

        //TODO somar produto já inserido

        $data = [];

        foreach ($params["venda_produto_id"] as $produtoId => $vendaProdutoId) {

            $quantidade = $params["venda_produto_quantidade"][$produtoId] ?? 0;
            $valorUnitario = $params["venda_produto_valor_unitario"][$produtoId] ?? null;
            $impostoPercentual = $params["venda_produto_imposto_percentual"][$produtoId] ?? null;

            if ($quantidade > 0){

                $produto = $produtoRepository->findOne($produtoId);
                $produtoTipo = $produtoTipoRepository->findOne($produto->getProdutoTipoId());

                if (empty($vendaProdutoId)){
                    $vendaProduto = new VendaProduto();
                    $vendaProduto->setProdutoId($produtoId);
                    $vendaProduto->setQuantidade($quantidade);
                    $vendaProduto->setValorUnitario( ($valorUnitario === null ? $produto->getValor() : $valorUnitario) );
                    $vendaProduto->setImpostoPercentual( ($impostoPercentual === null ? $produtoTipo->getImpostoPercentual() : $impostoPercentual ));
                } else {
                    $vendaProduto = $vendaProdutoRepository->findOne($vendaProdutoId);
                }
    
                $data[$produtoId]["produto"] = $produto;
                $data[$produtoId]["vendaProduto"] = $vendaProduto;
            }
        }

        $cardVendaProdutoComponent = new CardVendaProdutoComponent($data);
        return $cardVendaProdutoComponent->parse();
    }
}