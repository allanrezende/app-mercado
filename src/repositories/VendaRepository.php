<?php

namespace AllanRezende\AppMercado\Repositories;

use AllanRezende\AppMercado\Database\Connection;
use AllanRezende\AppMercado\Models\Venda;
use Exception;

class VendaRepository {
    private Connection $connection;

    public function __construct(){
        $this->connection = new Connection();
    }
    
    public function findAll(array $params = []): array {

        $filter = "";
        $queryParams = [];

        if (isset($params['termo'])) {
            if (!empty($params['termo'])) {
                $filter .= ' WHERE id::TEXT ILIKE :id ';
                $queryParams['id'] = $params['termo'];
            }
        }

        $result = $this->connection->query("SELECT * FROM venda $filter ORDER BY id DESC", $queryParams);

        return $result;
    }

    public function findOne(int $id): Venda {

        $result = $this->connection->query("SELECT * FROM venda WHERE id = :id", ["id" => $id]);
        if (count($result) < 1) throw new Exception("Não foi possível carregar o objeto pelo identificador informado.");

        $item = $this->getObjectByRow($result[0]);

        return $item;
    }

    public function insert(Venda $venda): Venda {

        $sqlParams = ["data_criacao" => $venda->getDataCriacao()];

        $sql = "
            INSERT INTO venda (data_criacao)
            VALUES (:data_criacao)
            RETURNING *";
        $result = $this->connection->query($sql, $sqlParams);
        if (count($result) < 1) throw new Exception("Não foi possível criar o registro.");
        $created = $this->getObjectByRow($result[0]);

        return $created;
    }

    public function getObjectByRow(array $row): Venda {

        if (empty($row)) throw new Exception("Não foi possível popular o objeto pois o parametro está vazio.");
        $row = array_filter($row);

        $item = new Venda();

        $item->setId($row["id"] ?? null);
        $item->setDataCriacao($row["data_criacao"] ?? null);

        return $item;
    }
}