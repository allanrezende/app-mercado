<?php

namespace AllanRezende\AppMercado\Models;

class Produto  {

    private ?int $id;
    private string $nome;
    private int $produto_tipo_id;
    private float $valor;
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
    public function setId(?int $id)
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
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get the value of produto_tipo_id
     */ 
    public function getProdutoTipoId()
    {
        return $this->produto_tipo_id;
    }

    /**
     * Set the value of produto_tipo_id
     *
     * @return  self
     */ 
    public function setProdutoTipoId($produto_tipo_id)
    {
        $this->produto_tipo_id = $produto_tipo_id;

        return $this;
    }

    /**
     * Get the value of valor
     */ 
    public function getValor()
    {
        return $this->valor;
    }

    /**
     * Set the value of valor
     *
     * @return  self
     */ 
    public function setValor($valor)
    {
        $this->valor = $valor;

        return $this;
    }

    /**
     * Get the value of data_criacao
     */ 
    public function getDataCriacao()
    {
        return $this->data_criacao;
    }

    /**
     * Set the value of data_criacao
     *
     * @return  self
     */ 
    public function setDataCriacao($data_criacao)
    {
        $this->data_criacao = $data_criacao;

        return $this;
    }
}