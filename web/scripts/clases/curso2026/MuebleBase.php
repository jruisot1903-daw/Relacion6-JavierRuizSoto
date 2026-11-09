<?php

abstract class MuebleBase
{
    public const MAXIMO_MUEBLES = 1;
    private static int $_mueblesCreados = 0;

    private string $_nombre;
    private string $_fabricante = "FaMu:";
    private string $_pais = "España";
    private int $_anio = 2020;
    private string $_fechaIniVenta = "01/01/2020";
    private string $_fechaFinVenta = "31/12/2040";
    private float $_precio = 30.00;

    // CONSTRUCTOR
    public function __construct(){

    }


    // GETTERS AND SETTERS

    public function getNombre():string
    {
        return $this->_nombre;
    }

    public function setNombre(string $nombre): bool
    {
        $nombre = mb_strtoupper($nombre);
        if (validaCadena($nombre, 40, "")) {
            $this->_nombre = $nombre;
            return true;
        } else {
            return false;
        }
    }

    public function getFabricante():string{
        return $this->_fabricante;
    }

    public function setFabricante(string $fabricante):bool{
            if(!str_starts_with($fabricante, "FaMu:")){
                $fabricante = "FaMu:".$fabricante;
            }

            if(validaCadena($fabricante,30,"FaMu:")){
                $this->_fabricante = $fabricante;
                return true;
            }else{
                return false;
            }
    }

    public function getPais():string{
        return $this->_pais;
    }

    public function setPais(string $pais):bool{
        if(validaCadena($pais,20,"España")){
            $this->_pais = $pais;
            return true;
        }else{
            return false;
        }
    }

    public function getAnio():int{
        return $this->_anio;
    }

    public function setAnio(int $anio):bool{
        // Con el date("Y") obtenemos el año actual 
        if(validaEntero($anio,2020,date("Y"),2020)){
            $this->_anio = $anio;
            return true;
        }else{
            return false;
        }
    }

    public function getFechaIniVenta():string{
        return $this->_fechaIniVenta;
    }

    public function setFechaIniVenta():bool{

    }

    public function getFechaFinVenta():string{
        return $this->_fechaFinVenta;
    }

    public function setFechaFinVenta():bool{

    }

    public function getPrecio():float{
        return $this->_precio;
    }

    public function setPrecio(float $precio):bool{
        if(!is_float($precio) && $precio < 30){
            return false;
        }else{
            $this->_precio = $precio;
            return true;
        }
    }
}
