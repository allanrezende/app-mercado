<?php

namespace AllanRezende\AppMercado\Repositories;

use AllanRezende\AppMercado\Database\Connection;
use AllanRezende\AppMercado\Models\ProdutoTipo;
use Exception;

class ProdutoTipoRepository {
    private Connection $connection;

    public function __construct(){
        $this->connection = new Connection();
    }

    public function findAll(array $params = []): array {

        $filter = "";
        $queryParams = [];

        if (isset($params['termo'])) {
            if (!empty($params['termo'])) {
                $filter .= ' WHERE unaccent(nome) ILIKE unaccent(:nome) ';
                $queryParams['nome'] = "%" . $params['termo'] . "%";
            }
        }

        $result = $this->connection->query("SELECT * FROM produto_tipo $filter", $queryParams);

        return $result;
    }

    public function findOne(int $id): ProdutoTipo {

        $result = $this->connection->query("SELECT * FROM produto_tipo WHERE id = :id", ["id" => $id]);
        if (count($result) < 1) throw new Exception("Não foi possível carregar o objeto pelo identificador informado.");

        $item = $this->getObjectByRow($result[0]);

        return $item;
    }  

    public function insert(ProdutoTipo $produtoTipo): ProdutoTipo {

        $sql = "
            INSERT INTO produto_tipo (nome, imposto_percentual, data_criacao)
            VALUES ('" . $produtoTipo->getNome() . "', " . $produtoTipo->getImpostoPercentual() . ", " . $produtoTipo->getDataCriacao(). ")
            RETURNING *";
        $result = $this->connection->query($sql);
        if (count($result) < 1) throw new Exception("Não foi possível criar o registro.");
        $created = $this->getObjectByRow($result[0]);

        return $created;
    }

    public function update(ProdutoTipo $produtoTipo): ProdutoTipo {

        $sql = "
            UPDATE produto_tipo
            SET nome = '" . $produtoTipo->getNome() . "',
                imposto_percentual = " . $produtoTipo->getImpostoPercentual(). "
            WHERE id = :id RETURNING *";
        $result = $this->connection->query($sql, ["id" => $produtoTipo->getId()]);
        if (count($result) < 1) throw new Exception("Não foi possível criar o registro.");
        $updated = self::getObjectByRow($result[0]);

        return $updated;
    }

    public function delete(int $id): bool {

        $result = $this->connection->query("DELETE FROM produto_tipo WHERE id = :id", ["id" => $id]);
        if (count($result) < 1) throw new Exception("Não foi possível encontrar o registro informado.");
        return (count($result) > 0);
    }

    public function getObjectByRow(array $row): ProdutoTipo {

        if (empty($row)) throw new Exception("Não foi possível popular o objeto pois o parametro está vazio.");
        $row = array_filter($row);

        $item = new ProdutoTipo();
        $id = $row["id"] ?? null;

        $item->setId($id);
        $item->setNome($row["nome"] ?? null);
        $item->setImpostoPercentual($row["imposto_percentual"] ?? null);
        $item->setDataCriacao($row["data_criacao"] ?? "now()");

        return $item;
    }
}