<?php

namespace AllanRezende\AppMercado\Models;

class VendaProduto {
    
    private ?int $id = null;
    private ?int $venda_id = null;
    private int $produto_id;
    private int $quantidade;
    private float $valor_unitario;
    private float $imposto_percentual;

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
    public function setId($id): VendaProduto
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of venda_id
     */ 
    public function getVendaId(): ?int
    {
        return $this->venda_id;
    }

    /**
     * Set the value of venda_id
     *
     * @return  self
     */ 
    public function setVendaId($venda_id): VendaProduto
    {
        $this->venda_id = $venda_id;

        return $this;
    }

    /**
     * Get the value of produto_id
     */ 
    public function getProdutoId(): int
    {
        return $this->produto_id;
    }

    /**
     * Set the value of produto_id
     *
     * @return  self
     */ 
    public function setProdutoId($produto_id): VendaProduto
    {
        $this->produto_id = $produto_id;

        return $this;
    }

    /**
     * Get the value of quantidade
     */ 
    public function getQuantidade(): int
    {
        return $this->quantidade;
    }

    /**
     * Set the value of quantidade
     *
     * @return  self
     */ 
    public function setQuantidade($quantidade): VendaProduto
    {
        $this->quantidade = $quantidade;

        return $this;
    }

    /**
     * Get the value of valor_unitario
     */ 
    public function getValorUnitario(): float
    {
        return $this->valor_unitario;
    }

    /**
     * Set the value of valor_unitario
     *
     * @return  self
     */ 
    public function setValorUnitario($valor_unitario): VendaProduto
    {
        $this->valor_unitario = $valor_unitario;

        return $this;
    }

    /**
     * Get the value of imposto_percentual
     */ 
    public function getImpostoPercentual(): float
    {
        return $this->imposto_percentual;
    }

    /**
     * Set the value of imposto_percentual
     *
     * @return  self
     */ 
    public function setImpostoPercentual($imposto_percentual): VendaProduto
    {
        $this->imposto_percentual = $imposto_percentual;

        return $this;
    }
}