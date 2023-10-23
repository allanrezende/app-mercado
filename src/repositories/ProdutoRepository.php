<?php

namespace AllanRezende\AppMercado\Repositories;

use AllanRezende\AppMercado\Database\Connection;
use AllanRezende\AppMercado\Models\Produto;
use Exception;

class ProdutoRepository {
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

        $result = $this->connection->query("SELECT * FROM produto $filter", $queryParams);

        return $result;
    }

    public function findOne(int $id): Produto {

        $result = $this->connection->query("SELECT * FROM produto WHERE id = :id", ["id" => $id]);
        if (count($result) < 1) throw new Exception("Não foi possível carregar o objeto pelo identificador informado.");

        $item = $this->getObjectByRow($result[0]);

        return $item;
    }  

    public function insert(Produto $produto): Produto {

        $sqlParams = [
            "nome" => $produto->getNome(),
            "produto_tipo_id" => $produto->getProdutoTipoId(),
            "valor" => $produto->getValor(),
            "data_criacao" => $produto->getDataCriacao()
        ];

        $sql = "
            INSERT INTO produto (nome, produto_tipo_id, valor, data_criacao)
            VALUES (:nome, :produto_tipo_id, :valor, :data_criacao)
            RETURNING *";
            
        $result = $this->connection->query($sql, $sqlParams);
        if (count($result) < 1) throw new Exception("Não foi possível criar o registro.");
        $created = $this->getObjectByRow($result[0]);

        return $created;
    }

    public function update(Produto $produto): Produto {

        $sqlParams = [
            "id" => $produto->getId(),
            "nome" => $produto->getNome(),
            "produto_tipo_id" => $produto->getProdutoTipoId(),
            "valor" => $produto->getValor(),
            "data_criacao" => $produto->getDataCriacao()
        ];

        $sql = "
            UPDATE produto
            SET nome = :nome,
                produto_tipo_id = :produto_tipo_id,
                valor = :valor,
                data_criacao = :data_criacao
            WHERE id = :id RETURNING *";

        $result = $this->connection->query($sql, $sqlParams);
        if (count($result) < 1) throw new Exception("Não foi possível criar o registro.");
        $updated = self::getObjectByRow($result[0]);

        return $updated;
    }

    public function delete(int $id): bool {

        $result = $this->connection->query("DELETE FROM produto WHERE id = :id", ["id" => $id]);
        if (count($result) < 1) throw new Exception("Não foi possível encontrar o registro informado.");
        return (count($result) > 0);
    }

    public function getObjectByRow(array $row): Produto {

        if (empty($row)) throw new Exception("Não foi possível popular o objeto pois o parametro está vazio.");

        $row = array_filter($row, function($var) {
            return ($var !== NULL && $var !== "");
        });

        $item = new Produto();

        $item->setId($row["id"] ?? null);
        $item->setNome($row["nome"] ?? null);
        $item->setProdutoTipoId($row["produto_tipo_id"] ?? null);
        $item->setValor($row["valor"] ?? null);
        $item->setDataCriacao($row["data_criacao"] ?? null);

        return $item;
    }
}