<?php


class country
{
    public $id;
    public $pavadinimas;
    public $plotas;
    public $gyventojai;
    public $tel_kodas;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->pavadinimas = $data['pavadinimas'];
        $this->plotas = $data['plotas'];
        $this->gyventojai = $data['gyventojai'];
        $this->tel_kodas = $data['tel_kodas'];
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
    public function getTel_kodas(){
        return $this->tel_kodas;
    }
}