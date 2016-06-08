<?php

class ManageActividad {
    private $bd = null;
    private $tabla = "actividades";
    
    function __construct(DataBase $bd) {
        $this->bd = $bd;
    }
    
    function get($id) {
        //devuelve el objeto de la fila cuyo email coincide con el email que le estoy pasando;
        //devuelve el objeto entero;
        $parametros = array();
        $parametros["id"] = $id;
        $this->bd->select($this->tabla, "*", "id =:id", $parametros);
        $fila = $this->bd->getRow();
        $actividad = new Actividad();
        $actividad->set($fila);
        return $actividad;
    }
    
    function count($condicion="1=1", $parametros=array()){
        return $this->bd->count($this->tabla, $condicion, $parametros);
    }
            
    function delete($id) {
        //borrar por id
        $parametros = array();
        $parametros["id"] = $id;
        return $this->bd->delete($this->tabla, $parametros);
    }
    
    function set(Actividad $actividad, $pkId) {
        //update de todos los campos 
        //pasamos el codigo que tenia y como en este si se puede cambiar el codigo, cambiamos todos los campos
        //dice el numero de filas modificades
        $parametros = $actividad->getArray();
        $parametrosWhere = array();
        $parametrosWhere["id"] = $pkId;
        $this->bd->update($this->tabla, $parametros, $parametrosWhere);
    }
    
    function insert(Actividad $actividad) {
        //se le pasa un objeto City y lo inserta en la tabla
        //dice el numero de filas insertadas;
        $parametrosSet = array();
        $parametrosSet["id"]=$actividad->getId();
        $parametrosSet["usuario"]=$actividad->getUsuario();
        $parametrosSet["fechaInicio"]=$actividad->getFechaInicio();
        $parametrosSet["duracion"]=$actividad->getDuracion();
        $parametrosSet["deporte"]=$actividad->getDeporte();
        $parametrosSet["url"]=$actividad->getUrl();
        return $this->bd->insert($this->tabla, $parametrosSet);
    }
    
    function getList($pagina=1, $orden="", $nrpp=Constants::NRPP, $condicion ="1=1", $parametros=array()) {
        $ordenPredeterminado = "$orden, id, usuario";
        if(trim($orden)==="" || trim($orden)===null){
            $ordenPredeterminado = "id, usuario";
        }
        $registroInicial = ($pagina - 1) * $nrpp;
        $this->bd->select($this->tabla, "*", $condicion, $parametros, $ordenPredeterminado,
                "$registroInicial, $nrpp");
        $r = array();
        while ($fila = $this->bd->getRow()){
            $actividad = new Actividad();
            $actividad->set($fila);
            $r[] = $actividad;
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
    
//    function getValuesSelect() {
//        $this->bd->query($this->tabla, "ID, Name", array(), "Name");
//        $array = array();
//        while ($fila = $this->bd->getRow()){
//            $array[$fila[0]] = $fila[1];
//        }
//        return $array;
//    }
}
