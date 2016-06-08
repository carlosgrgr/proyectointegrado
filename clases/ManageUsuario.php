<?php

class ManageUsuario {
    
    private $bd = null;
    private $tabla = "usuarios";
    
    function __construct(DataBase $bd) {
        $this->bd = $bd;
    }
    
    function get($email) {
        //devuelve el objeto de la fila cuyo email coincide con el email que le estoy pasando;
        //devuelve el objeto entero;
        $parametros = array();
        $parametros["email"] = $email;
        $this->bd->select($this->tabla, "*", "email =:email", $parametros);
        $fila = $this->bd->getRow();
        $usuario = new Usuario();
        $usuario->set($fila);
        return $usuario;
    }
    
    function count($condicion="1=1", $parametros=array()){
        return $this->bd->count($this->tabla, $condicion, $parametros);
    }
            
    function delete($email) {
        //borrar por id
        $parametros = array();
        $parametros["email"] = $email;
        return $this->bd->delete($this->tabla, $parametros);
    }
    
    function set(Usuario $usuario, $pkEmail) {
        //update de todos los campos 
        //pasamos el codigo que tenia y como en este si se puede cambiar el codigo, cambiamos todos los campos
        //dice el numero de filas modificades
        $parametros = $usuario->getArray();
        $parametrosWhere = array();
        $parametrosWhere["email"] = $pkEmail;
        $this->bd->update($this->tabla, $parametros, $parametrosWhere);
    }
    
    function insert(Usuario $usuario) {
        //se le pasa un objeto City y lo inserta en la tabla
        //dice el numero de filas insertadas;
        $parametrosSet = array();
        $parametrosSet["email"]=$usuario->getEmail();
        $parametrosSet["clave"]=$usuario->getClave();
        $parametrosSet["nombre"]=$usuario->getNombre();
        $parametrosSet["apellidos"]=$usuario->getApellidos();
        $parametrosSet["sexo"]=$usuario->getSexo();
        $parametrosSet["fechanacimiento"]=$usuario->getFechanacimiento();
        $parametrosSet["altura"]=$usuario->getAltura();
        $parametrosSet["peso"]=$usuario->getPeso();
        $parametrosSet["fcmax"]=$usuario->getFcmax();
        $parametrosSet["imc"]=$usuario->getImc();
        $parametrosSet["img"]=$usuario->getImagen();
        return $this->bd->insert($this->tabla, $parametrosSet);
    }
    
    function getList($pagina=1, $orden="", $nrpp=Constants::NRPP, $condicion ="1=1", $parametros=array()) {
        $ordenPredeterminado = "$orden, nombre, email";
        if(trim($orden)==="" || trim($orden)===null){
            $ordenPredeterminado = "nombre, email";
        }
        $registroInicial = ($pagina - 1) * $nrpp;
        $this->bd->select($this->tabla, "*", $condicion, $parametros, $ordenPredeterminado,
                "$registroInicial, $nrpp");
        $r = array();
        while ($fila = $this->bd->getRow()){
            $usuario = new Usuario();
            $usuario->set($fila);
            $r[] = $usuario;
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
    
    function getValuesSelect() {
        $this->bd->query($this->tabla, "ID, Name", array(), "Name");
        $array = array();
        while ($fila = $this->bd->getRow()){
            $array[$fila[0]] = $fila[1];
        }
        return $array;
    }
    
}
