<?php

class FileUpload {

    private $destino = "./", $nombre = "", $tamano = 1000000, $parametro;
    const CONSERVAR = 1, REEMPLAZAR = 2, RENOMBRAR = 3; 
    private $error = false, $politica = self::RENOMBRAR;
    private $subido = false;
    private $arrayDeTipos = array(
        "tcx" => 1,
        "kml" => 1,
        "jpg" => 1,
        "png" => 1
    );
    private $extension;

    function __construct($parametro) {
        //var_dump($_FILES[$parametro]);
        if (isset($_FILES[$parametro]) && $_FILES[$parametro] !== "") {
            $this->parametro = $parametro;
            $nombre = $_FILES[$this->parametro]["name"];
            $trozos = pathinfo($nombre);
            $extension = $trozos["extension"];
            $this->nombre = $trozos["filename"];
            $this->extension = $extension;
        }else{
            $this->error = true;
        }
    }

    public function getDestino() {
        return $this->destino;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getTamano() {
        return $this->tamano;
    }
    
    public function getExtension(){
        return $this->extension;
    }

    public function setDestino($destino) {
        $this->destino = $destino;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setTamano($tamano) {
        $this->tamano = $tamano;
    }
    
    public function setPolitica ($politica){
        $this->politica = $politica;
    }
    
    public function getPolitica ($politica){
        return $this->politica;
    }

    public function upload() {
        if($this->subido) {
            return false;
        }
        
        if ($this->error) {
            return false;
        }
        
        if ($_FILES[$this->parametro]["error"] != UPLOAD_ERR_OK) {
            return false;
        }

        if ($_FILES[$this->parametro]["size"] > $this->tamano) {
            return false;
        }

        if (!$this->isTipo($this->extension)) {
            return false;
        }
        
        if (!(is_dir($this->destino) && substr($this->destino, -1) === "/")) {
            return false;
        }
        
        $nombre = $this->nombre;
        
        if ($this->politica === self::CONSERVAR && file_exists($this->destino.$this->nombre. "." .$this->extension)) {
            return false;
        }
        
        if ($this->politica === self::RENOMBRAR && file_exists($this->destino.$this->nombre. "." .$this->extension)) {
            $nombre = $this->renombrar($nombre);
        }
        
        $this->subido = true;

        return move_uploaded_file($_FILES[$this->parametro]["tmp_name"], $this->destino. $nombre . "." . $this->extension);
    }
    
    
    private function renombrar($nombre) {
        $i=0;
        while (file_exists($this->destino.$nombre."_". $i .".".$this->extension)) {
            $i++;
        }
        return $nombre .'_'. $i;
    }

    public function addTipo($tipo) {
        if (!$this->isTipo($tipo)) {
            $this->arrayDeTipos[$tipo] = 1;
            return true;
        }
        return false;
    }

    public function removeTipo($tipo) {
        if ($this->isTipo($tipo)) {
            unset($this->arrayDeTipos[$tipo]);
            return true;
        }
        return false;
    }

    public function isTipo($tipo) {
        return isset($this->arrayDeTipos[$tipo]);
    }

}
