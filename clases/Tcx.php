<?php

class Tcx {
    private $archivo = null;
    private $usuario = null;
    
    function __construct($archivo, $usuario = null) {
        $this->archivo = $archivo;
        $this->usuario = $usuario;
    }
    
    function xmlDom($archivo){
        $dom = new DOMDocument('1.0', 'utf-8');
        $texto = file_get_contents($archivo);
        $dom->loadXML($texto);
    }
    
    function tcxtoobj($archivo){
        if(file_exists($archivo)){
            $archivo = simplexml_load_file($archivo);
            return $archivo;
        }else{
            exit('Fallo al abrir el documento');
        }
    }
    
    function tcxtoarray ($archivo){
        if(file_exists($archivo)){
            $xml = simplexml_load_string($archivo);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
        }
        return $array;
    }
    
    function getNombreArchivo($archivo){
        if(file_exists($archivo)){
            return pathinfo($archivo, PATHINFO_FILENAME);
        }
        return 0;
    }
    
    function getExtension($archivo){
        if(file_exists($archivo)){
            return pathinfo($archivo, PATHINFO_EXTENSION);
        }
        return 0;
    }
    
    function getInicio($archivo, $type = "string"){
        if(file_exists($archivo)){
            $datos = $this->tcxtoobj($archivo);
            $begin = $datos->Activities->Activity->Lap[0]["StartTime"]->asXML();
            $begin = substr($begin, 12, -1);
            if($type == "timestamp"){
                return strtotime($begin);
            }
            return $begin;
        }
    }
    
    function getDatos($archivo){
        if(file_exists($archivo)){
            $datos = $this->tcxtoobj($archivo);
            $duracion = 0;
            $distancia = 0;
            $pulsomedio = 0;
            $calorias = 0;
            for($i = 0; $i < count($datos->Activities->Activity->Lap); $i++){
                $duracion += $datos->Activities->Activity->Lap[$i]->TotalTimeSeconds;
                $distancia += $datos->Activities->Activity->Lap[$i]->DistanceMeters;
                $pulsomedio += $datos->Activities->Activity->Lap[$i]->AverageHeartRateBpm->Value;
                $calorias += $datos->Activities->Activity->Lap[$i]->Calories;
            }
            $pulsomedio = $pulsomedio / count($datos->Activities->Activity->Lap);
            $duracion = date('H:i:s', $duracion-3600);
            $distancia = $distancia/1000;
            $result["duracion"] = $duracion;
            $result["distancia"] = round($distancia, 2);
            $result["pulsomedio"] = $pulsomedio;
            $result["calorias"] = $calorias;
            return $result;
        }
    }
    
    function getDistancia($archivo){
        if(file_exists($archivo)){
            $datos = $this->tcxtoobj($archivo);

            for($i = 0; $i < count($datos->Activities->Activity->Lap); $i++){
                $duracion += $datos->Activities->Activity->Lap[$i]->TotalTimeSeconds;
            }
            $duracion = date('H:i:s', $duracion-3600);
            return $duracion;
        }
    }
    
    function getPulso($archivo){
        if(file_exists($archivo)){
            $dom = new DOMDocument('1.0', 'utf-8');
            $texto = file_get_contents($archivo);
            $dom->loadXML($texto);
            $pulso = "([";
            $trackpoints = $dom->getElementsByTagName('Trackpoint');
            for ($i = 0; $i < $trackpoints->length; $i=$i+40){
                $heartRate = $trackpoints[$i]->getElementsByTagName('HeartRateBpm')->item(0)->nodeValue;
                $pulso .= "$heartRate,";
            }
            $pulso = substr($pulso, 0, -1);
            $pulso .= "])";
            return $pulso;
        }
    }
    
    function getAltura($archivo){
        if(file_exists($archivo)){
            $dom = new DOMDocument('1.0', 'utf-8');
            $texto = file_get_contents($archivo);
            $dom->loadXML($texto);
            $altura = "([";
            $trackpoints = $dom->getElementsByTagName('Trackpoint');
            for ($i = 0; $i < $trackpoints->length; $i=$i+40){
                $altitude = number_format($trackpoints[$i]->getElementsByTagName('AltitudeMeters')->item(0)->nodeValue, 2, '.', '');
                $altura .= "$altitude,";
            }
            $altura = substr($altura, 0, -1);
            $altura .= "])";
            return $altura;
        }
    }
    
    function getSpeed($archivo){
        if(file_exists($archivo)){
            $dom = new DOMDocument('1.0', 'utf-8');
            $texto = file_get_contents($archivo);
            $dom->loadXML($texto);
            $v = array();
            $trackpoints = $dom->getElementsByTagName('Trackpoint');
            for ($i = 0; $i < $trackpoints->length; $i=$i+10){
                array_push($v, $trackpoints[$i]->getElementsByTagName('DistanceMeters')->item(0)->nodeValue);
            }
            
            $speed = "([";
            for($a = 0; $a < count($v); $a++){
                    $velocidad = ($v[$a] - $v[$a-1])*0.36;
                    $speed .= $velocidad . ",";
                
            }
            $speed = substr($speed, 0, -1);
            $speed .= "])";
        }
        return $speed;
    }
    
    function tcxtokml($archivo, $usuario){
        ini_set('max_execution_time', 300);
        $dom = new DOMDocument('1.0', 'utf-8');
        $texto = file_get_contents($archivo);
        $dom->loadXML($texto);
        
        $nombre = $this->getNombreArchivo($archivo);
        $begin = $this->getInicio($archivo);
        $end = "";
        $coordenadas = "";
        
        $trackpoints = $dom->getElementsByTagName('Trackpoint');
        foreach ($trackpoints as $trackpoint) {
            $end = $trackpoint->getElementsByTagName('Time')->item(0)->nodeValue;
            $position = $trackpoint->getElementsByTagName('Position');
            foreach ($position as $posicion){
                $coordenadas .= $posicion->getElementsByTagName('LongitudeDegrees')->item(0)->nodeValue . ",";
                $coordenadas .= $posicion->getElementsByTagName('LatitudeDegrees')->item(0)->nodeValue . ",";
                $coordenadas .= $trackpoint->getElementsByTagName('AltitudeMeters')->item(0)->nodeValue . " ";
            }
        }
       
        $xml = new DomDocument('1.0', 'UTF-8');
        $kml = $xml->createElement('kml');
        $xml->appendChild($kml);
        
        $document = $xml->createElement('Document');
        $kml->appendChild($document);
        
        $timespan = $xml->createElement('TimeSpan');
        $document->appendChild($timespan);
        
            $beginNode = $xml->createElement('begin', $begin);
            $timespan->appendChild($beginNode);
            
            $endNode = $xml->createElement('end', $end);
            $timespan->appendChild($endNode);
        
        $placemark = $xml->createElement('Placemark');
        $document->appendChild($placemark);
        
            $name = $xml->createElement('name', 'Actividad deportiva');
            $placemark->appendChild($name);
            
            $style = $xml->createElement('Style');
            $placemark->appendChild($style);
                
                $linestyle = $xml->createElement('LineStyle');
                $style->appendChild($linestyle);
                
                    $color = $xml->createElement('color', 'ff00d300');
                    $linestyle->appendChild($color);
                    
                    $width = $xml->createElement('width', '5');
                    $linestyle->appendChild($width);
                
            $linestring = $xml->createElement('LineString');
            $placemark->appendChild($linestring);
            
                $tessellate = $xml->createElement('tessellate', '1');
                $linestring->appendChild($tessellate);
                
                $coordinates = $xml->createElement('coordinates', $coordenadas);
                $linestring->appendChild($coordinates);
                
        $xml->formatOutput = true;
        $xml->saveXML();
        if(!file_exists("archivos/".$usuario ."/".$nombre.".kml")){
            if($xml->save("archivos/".$usuario ."/".$nombre.".kml")){
                return TRUE;
            }            
        }
        return FALSE;
    }
    
    
    
    
}
