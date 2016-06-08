<?php

class Usuario {
    
    private $email, $clave, $nombre, $apellidos, $sexo, $fechanacimiento, $altura, $peso, $fcmax, $imc, $imagen;
            
    function __construct($email = null, $clave = null, $nombre = null, $apellidos = null, $sexo = null, 
            $fechanacimiento = null, $altura = null, $peso = null, $fcmax = null, $imc = null, $imagen = null) {
        $this->email = $email;
        $this->clave = $clave;
        $this->nombre = $nombre;
        $this->apellidos = $apellidos;
        $this->sexo = $sexo;
        $this->fechanacimiento = $fechanacimiento;
        $this->altura = $altura;
        $this->peso = $peso;
        $this->fcmax = $fcmax;
        $this->imc = $imc;
        $this->imagen = $imagen;
    }
    
    function getEmail() {
        return $this->email;
    }

    function getClave() {
        return $this->clave;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getSexo() {
        return $this->sexo;
    }

    function getFechanacimiento() {
        return $this->fechanacimiento;
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

    function getImc() {
        return $this->imc;
    }

    function getImagen() {
        return $this->imagen;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setClave($clave) {
        $this->clave = $clave;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setSexo($sexo) {
        $this->sexo = $sexo;
    }

    function setFechanacimiento($fechanacimiento) {
        $this->fechanacimiento = $fechanacimiento;
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

    function setImc($imc) {
        $this->imc = $imc;
    }

    function setImagen($imagen) {
        $this->imagen = $imagen;
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
