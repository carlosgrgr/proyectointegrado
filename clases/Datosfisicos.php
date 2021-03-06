<?php

class Datosfisicos {
    
    private $email, $fecha, $altura, $peso, $fcmax, $fcmed, $imc;
            
    function __construct($email = null, $fecha = null, $altura = null, $peso = null, $fcmax = null, $fcmed = null, $imc = null) {
        $this->email = $email;
        $this->fecha = $fecha;
        $this->altura = $altura;
        $this->peso = $peso;
        $this->fcmax = $fcmax;
        $this->fcmed = $fcmed;
        $this->imc = $imc;
    }
    
    function getEmail() {
        return $this->email;
    }

    function getFecha() {
        return $this->fecha;
    }

    function getAltura() {
        return $this->altura;
    }

    function getPeso() {
        return $this->peso;
    }

    function getFcmax() {
        return $this->fcmax;
    }
    
    function getFcmed() {
        return $this->fcmed;
    }

    function getImc() {
        return $this->imc;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setAltura($altura) {
        $this->altura = $altura;
    }

    function setPeso($peso) {
        $this->peso = $peso;
    }

    function setFcmax($fcmax) {
        $this->fcmax = $fcmax;
    }
    
    function setFcmed($fcmed) {
        $this->fcmed = $fcmed;
    }

    function setImc($imc) {
        $this->imc = $imc;
    }

    public function getJson() {
        $r = '{';
        foreach ($this as $indice => $valor) {
            $r .= '"' . $indice . '"' . ':' . '"' . $valor . '"' . ',' ;
        }
        $r = substr($r, 0, -1);
        $r .= '}';
        return $r;
    }
    
    function set($valores, $inicio=0) {
        $i = 0;
        foreach ($this as $indice => $valor) {
            $this->$indice = $valores[$i+$inicio];
            $i++;
        }
    }
    
     public function __toString() {
        $r = '';
        foreach ($this as $key => $valor){
            $r .= "$valor ";
        }
        return $r;
    }
    
    public function getArray($valores=true) {
        $array = array();
        foreach ($this as $key => $valor) {
            if($valores===true){
                $array[$key] = $valor;
            }else{
                $array[$key] = null;
            }
        }
        return $array;
    }
    
    function read() {
        foreach ($this as $key => $valor){
            $this->$key = Request::req($key);
        }
    }

}
