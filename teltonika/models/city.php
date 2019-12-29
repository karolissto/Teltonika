<?php


class city
{
    protected static $data_file;
    protected  $inventory = [];

    public $id;
    public $pavadinimas;
    public $plotas;
    public $gyventojai;
    public $pasto_kodas;
    public $salis_fk;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->pavadinimas = $data['pavadinimas'];
        $this->plotas = $data['plotas'];
        $this->gyventojai = $data['gyventojai'];
        $this->pasto_kodas = $data['pasto_kodas'];
        $this->salis_fk = $data['salis_fk'];
    }

    public function getId(){
        return $this->id;
    }
    public function getPavadinimas(){
        return $this->pavadinimas;
    }
    public function getPlotas(){
        return $this->plotas;
    }
    public function getGyventojai(){
        return $this->gyventojai;
    }
    public function getPasto_kodas(){
        return $this->pasto_kodas;
    }
    public function getSalis_fk(){
        return $this->salis_fk;
    }

}