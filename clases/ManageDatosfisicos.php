<?php

class ManageDatosfisicos {
    
    private $bd = null;
    private $tabla = "datosfisicos";
    
    function __construct(DataBase $bd) {
        $this->bd = $bd;
    }
    
    function get($email, $fecha) {
        //devuelve el objeto de la fila cuyo email coincide con el email que le estoy pasando;
        //devuelve el objeto entero;
        $parametros = array();
        $parametros["email"] = $email;
        $parametros["fecha"] = $fecha;
        $this->bd->select($this->tabla, "*", "email =:email and fecha =:fecha", $parametros);
        $fila = $this->bd->getRow();
        $datosfisicos = new Datosfisicos();
        $datosfisicos->set($fila);
        return $datosfisicos;
    }
    
    function count($condicion="1=1", $parametros=array()){
        return $this->bd->count($this->tabla, $condicion, $parametros);
    }
            
    function delete($email, $fecha) {
        //borrar por id
        $parametros = array();
        $parametros["email"] = $email;
        $parametros["fecha"] = $fecha;
        return $this->bd->delete($this->tabla, $parametros);
    }
    
    function insert(Datosfisicos $datosfisicos) {
        //se le pasa un objeto City y lo inserta en la tabla
        //dice el numero de filas insertadas;
        $parametrosSet = array();
        $parametrosSet["email"]=$datosfisicos->getEmail();
        $parametrosSet["fecha"]=$datosfisicos->getFecha();
        $parametrosSet["altura"]=$datosfisicos->getAltura();
        $parametrosSet["peso"]=$datosfisicos->getPeso();
        $parametrosSet["fcmax"]=$datosfisicos->getFcmax();
        $parametrosSet["fcmed"]=$datosfisicos->getFcmed();
        $parametrosSet["imc"]=$datosfisicos->getImc();
        return $this->bd->insert($this->tabla, $parametrosSet);
    }
    
    function getList($pagina=1, $orden="", $nrpp=Constants::NRPP, $condicion ="1=1", $parametros=array()) {
        $ordenPredeterminado = "$orden, fecha, email";
        if(trim($orden)==="" || trim($orden)===null){
            $ordenPredeterminado = "fecha, email";
        }
        $registroInicial = ($pagina - 1) * $nrpp;
        $this->bd->select($this->tabla, "*", $condicion, $parametros, $ordenPredeterminado,
                "$registroInicial, $nrpp");
        $r = array();
        while ($fila = $this->bd->getRow()){
            $datosfisicos = new Datosfisicos();
            $datosfisicos->set($fila);
            $r[] = $datosfisicos;
        }
        return $r;
    }
    
    function getListJson($pagina = 1, $orden = "", $nrpp = Constants::NRPP, $condicion = "1=1", $parametros = array()) {
        $list = $this->getList($pagina, $orden, $nrpp, $condicion, $parametros);
        $r = "[ ";
        foreach ($list as $objeto) {
            $r .= $objeto->getJSON() . ",";
        }
        $r = substr($r, 0, -1) . "]";
        return $r;
    }
    
}
