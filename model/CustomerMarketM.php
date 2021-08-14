<?php

class CustomerMarketM implements JsonSerializable
{

    protected $idCustomerMarket;

    protected $idCustomer;

    protected $idMarket;

    protected $idArea;

    protected $idRiverBasin;
    
    
    
    public function getIdCustomerMarket()
    {
        return $this->idCustomerMarket;
    }

    public function setIdCustomerMarket($idCustomerMarket)
    {
        $this->idCustomerMarket = $idCustomerMarket;
    }

    public function getIdCustomer()
    {
        return $this->idCustomer;
    }
    
    public function setIdCustomer($idCustomer)
    {
        $this->idCustomer = $idCustomer;
    }
    public function getIdMarket()
    {
        return $this->idMarket;
    }
    
    public function setIdMarket($idMarket)
    {
        $this->idMarket = $idMarket;
    }
    
    public function getIdArea()
    {
        return $this->idArea;
    }
    
    public function setIdArea($idArea)
    {
        $this->idArea = $idArea;
    }
    
    public function getIdRiverBasin()
    {
        return $this->idRiverBasin;
    }
    
    public function setIdRiverBasin($idRiverBasin)
    {
        $this->idRiverBasin = $idRiverBasin;
    }
    
    
    

    public function jsonSerialize()
    {
        return [
            'idCustomerMarket' => $this::getIdCustomerMarket(),
            'idCustomer' => $this::getIdCustomer(),
            'idMarket' => $this::getIdMarket(),
            'idArea' => $this::getIdArea(),
            'idRiverBasin'=>$this::getIdRiverBasin()
        ];
    }
}
?>
