<?php

namespace AllanRezende\AppMercado\Models;

class Venda  {

    private ?int $id;
    private ?string $data_criacao;

    /**
     * Get the value of id
     */ 
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId(?int $id): Venda
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of data_criacao
     */ 
    public function getDataCriacao(): ?string
    {
        return $this->data_criacao;
    }

    /**
     * Set the value of data_criacao
     *
     * @return  self
     */ 
    public function setDataCriacao($data_criacao): Venda
    {
        $this->data_criacao = $data_criacao;

        return $this;
    }
}