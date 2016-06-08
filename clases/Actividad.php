<?php

class Actividad {
    private $id, $usuario, $fechaInicio, $duracion, $deporte, $url;
    
    function __construct($id = null, $usuario = null, $fechaInicio = null, $duracion = null, $deporte = null, $url = null) {
        $this->id = $id;
        $this->usuario = $usuario;
        $this->fechaInicio = $fechaInicio;
        $this->duracion = $duracion;
        $this->deporte = $deporte;
        $this->url = $url;
    }
    
    function getId() {
        return $this->id;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getDuracion() {
        return $this->duracion;
    }
    
    function getDeporte() {
        return $this->deporte;
    }
 
    function getUrl() {
        return $this->url;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setDuracion($duracion) {
        $this->duracion = $duracion;
    }
    function setDeporte($deporte) {
        $this->deporte = $deporte;
    }
    
    function setUrl($url) {
        $this->url = $url;
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
