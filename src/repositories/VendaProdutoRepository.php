<?php

namespace AllanRezende\AppMercado\Repositories;

use AllanRezende\AppMercado\Database\Connection;
use AllanRezende\AppMercado\Models\VendaProduto;
use Exception;

class VendaProdutoRepository {
    private Connection $connection;

    public function __construct(){
        $this->connection = new Connection();
    }
    
    public function findAll(array $params = []): array {

        $filter = "";
        $queryParams = [];

        if (isset($params['venda_id'])) {
            if (!empty($params['termo'])) {
                $filter .= ' WHERE venda_id = :venda_id ';
                $queryParams['venda_id'] = $params['venda_id'];
            }
        }

        $result = $this->connection->query("SELECT * FROM venda_produto $filter", $queryParams);

        return $result;
    }

    public function findOne(int $id): VendaProduto {

        $result = $this->connection->query("SELECT * FROM venda_produto WHERE id = :id", ["id" => $id]);
        if (count($result) < 1) throw new Exception("Não foi possível carregar o objeto pelo identificador informado.");

        $item = $this->getObjectByRow($result[0]);

        return $item;
    }

    public function insert(VendaProduto $vendaProduto): VendaProduto {

        $sqlParams = [
            "venda_id" => $vendaProduto->getVendaId(),
            "produto_id" => $vendaProduto->getProdutoId(),
            "quantidade" => $vendaProduto->getQuantidade(),
            "valor_unitario" => $vendaProduto->getValorUnitario(),
            "imposto_percentual" => $vendaProduto->getImpostoPercentual()
        ];

        $sql = "
            INSERT INTO venda_produto (venda_id, produto_id, quantidade, valor_unitario, imposto_percentual)
            VALUES (:venda_id, :produto_id, :quantidade, :valor_unitario, :imposto_percentual)
            RETURNING *";
        $result = $this->connection->query($sql, $sqlParams);
        if (count($result) < 1) throw new Exception("Não foi possível criar o registro.");
        $created = $this->getObjectByRow($result[0]);

        return $created;
    }

    public function delete(int $id): bool {

        $result = $this->connection->query("DELETE FROM venda_produto WHERE id = :id", ["id" => $id]);
        if (count($result) < 1) throw new Exception("Não foi possível encontrar o registro informado.");
        return (count($result) > 0);
    }

    public function getObjectByRow(array $row): VendaProduto {

        if (empty($row)) throw new Exception("Não foi possível popular o objeto pois o parametro está vazio.");
        $row = array_filter($row);

        $item = new VendaProduto();

        $id = $row["id"] ?? null;

        $item->setId($id);
        $item->setVendaId($row["venda_id"]);
        $item->setProdutoId($row["produto_id"]);
        $item->setQuantidade($row["quantidade"]);
        $item->setValorUnitario($row["valor_unitario"]);
        $item->setImpostoPercentual($row["imposto_percentual"]);

        return $item;
    }
}