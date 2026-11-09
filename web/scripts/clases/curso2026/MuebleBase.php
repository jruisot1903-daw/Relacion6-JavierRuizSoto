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

    public function getNombre(): string
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
        
    }
}
