<?php

namespace AllanRezende\AppMercado\Models;

use JsonSerializable;

class ProdutoTipo implements JsonSerializable {

    private ?int $id = null;
    private string $nome;
    private float $impostoPercentual;
    private ?string $dataCriacao = null;

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
    public function setId(?int $id): ProdutoTipo
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nome
     */ 
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     *
     * @return  self
     */ 
    public function setNome(string $nome): ProdutoTipo
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of dataCriacao
     */ 
    public function getDataCriacao(): string
    {
        return $this->dataCriacao;
    }

    /**
     * Set the value of dataCriacao
     *
     * @return  self
     */ 
    public function setDataCriacao(string $dataCriacao): ProdutoTipo
    {
        $this->dataCriacao = $dataCriacao;

        return $this;
    }

    /**
     * Get the value of impostoPercentual
     */ 
    public function getImpostoPercentual(): float
    {
        return $this->impostoPercentual;
    }

    /**
     * Set the value of impostoPercentual
     *
     * @return  self
     */ 
    public function setImpostoPercentual(float $impostoPercentual): ProdutoTipo
    {
        $this->impostoPercentual = $impostoPercentual;

        return $this;
    }

    public function jsonSerialize(): mixed {
        return get_object_vars($this);
    }
}