<?php

abstract class MuebleBase
{
    protected const MAXIMO_MUEBLES = 1;
    protected static int $_mueblesCreados = 0;

    protected string $_nombre;
    protected string $_fabricante = "FaMu:";
    protected string $_pais = "España";
    protected int $_anio = 2020;
    protected string $_fechaIniVenta = "01/01/2020";
    protected string $_fechaFinVenta = "31/12/2040";
    protected float $_precio = 30.00;

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
}
