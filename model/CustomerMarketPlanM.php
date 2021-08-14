<?php

class CustomerMarketPlanM implements JsonSerializable
{

    protected $idCustomerMaketplan;

    protected $idCustomer;

    protected $idArea;

    protected $plan_Year;

    protected $idAgri;

    protected $agri_weekplan_amount;

    protected $unit_id;

    protected $agri_spect;

    protected $idTypeOfStand;

    protected $idLogistic;

    protected $Refund_period;

    protected $conn_status_id;

    protected $update_date;

    protected $idRiverBasin;

    public function getIdCustomerMaketplan()
    {
        return $this->CustomerMaketplan;
    }

    public function setIdCustomerMaketplan($idCustomerMaketplan)
    {
        $this->CustomerMaketplan = $idCustomerMaketplan;
    }

    public function getIdCustomer()
    {
        return $this->idCustomer;
    }

    public function setIdCustomer($idCustomer)
    {
        $this->idCustomer = $idCustomer;
    }

    public function getIdArea()
    {
        return $this->idArea;
    }

    public function setIdArea($idArea)
    {
        $this->idArea = $idArea;
    }

    public function getPlanYear()
    {
        return $this->plan_Year;
    }

    public function setPlanYear($plan_Year)
    {
        $this->plan_Year = $plan_Year;
    }

    public function getIdAgri()
    {
        return $this->idAgri;
    }

    public function setIdAgri($idAgri)
    {
        $this->idAgri = $idAgri;
    }

    public function getAgriWeekplanAmount()
    {
        return $this->agri_weekplan_amount;
    }

    public function setAgriWeekplanAmount($agri_weekplan_amount)
    {
        $this->agri_weekplan_amount = $agri_weekplan_amount;
    }

    public function getUnitId()
    {
        return $this->unit_id;
    }

    public function setUnitId($unit_id)
    {
        $this->unit_id = $unit_id;
    }

    public function getAgriSpect()
    {
        return $this->agri_spect;
    }

    public function setAgriSpect($agri_spect)
    {
        $this->agri_spect = $agri_spect;
    }

    public function getIdTypeOfStand()
    {
        return $this->idTypeOfStand;
    }

    public function setIdTypeOfStand($idTypeOfStand)
    {
        $this->idTypeOfStand = $idTypeOfStand;
    }

    public function getIdLogistic()
    {
        return $this->idLogistic;
    }

    public function setIdLogistic($idLogistic)
    {
        $this->idLogistic = $idLogistic;
    }

    public function getRefundPeriod()
    {
        return $this->Refund_period;
    }

    public function setRefundPeriod($Refund_period)
    {
        $this->Refund_period = $Refund_period;
    }

    public function getConnStatusId()
    {
        return $this->conn_status_id;
    }

    public function setConnStatusId($conn_status_id)
    {
        $this->conn_status_id = $conn_status_id;
    }

    public function getUpdateDate()
    {
        return $this->update_date;
    }

    public function setUpdateDate($update_date)
    {
        $this->update_date = $update_date;
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
            'idCustomerMaketplan' => $this::getIdCustomerMaketplan(),
            'idCustomer' => $this::getIdCustomer(),
            'idArea' => $this::getIdArea(),
            'plan_Year' => $this::getPlanYear(),
            'idAgri' => $this::getIdAgri(),
            'agri_weekplan_amount' => $this::getAgriWeekplanAmount(),
            'unit_id' => $this::getUnitId(),
            'agri_spect' => $this::getAgriSpect(),
            'idTypeOfStand' => $this::getIdTypeOfStand(),
            'idLogistic' => $this::getIdLogistic(),
            'Refund_period' => $this::getRefundPeriod(),
            'conn_status_id' => $this::getConnStatusId(),
            'update_date' => $this::getUpdateDate(),
            'idRiverBasin'=>$this::getIdRiverBasin()
        ];
    }
}
?>
