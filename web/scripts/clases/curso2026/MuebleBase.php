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
    public function __construct(string $nombre, string $fabricante = "FaMu:", string $pais = "España", int $anio = 2020, string $fechaIniVenta = "01/01/2020", string $fechaFinVenta = "31/12/2040", float $precio = 30.00)
    {
        if (self::$_mueblesCreados >= self::MAXIMO_MUEBLES) {
            throw new Exception("Se ha superado el maximo de las instancias");
        }

        if (!$this->setNombre($nombre)) {
            throw new Exception("Nombre invalido");
        }

        $this->setFabricante($fabricante);
        $this->setPais($pais);
        $this->setAnio($anio);
        $this->setFechaIniVenta($fechaIniVenta);
        $this->setFechaFinVenta($fechaFinVenta);
        $this->setPrecio($precio);

        self::$_mueblesCreados++;
    }


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

    public function getFabricante(): string
    {
        return $this->_fabricante;
    }

    public function setFabricante(string $fabricante): bool
    {
        if (!str_starts_with($fabricante, "FaMu:")) {
            $fabricante = "FaMu:" . $fabricante;
        }

        if (validaCadena($fabricante, 30, "FaMu:")) {
                $this->_fabricante = $fabricante;
                return true;
        } else {
            return false;
        }
    }

    public function getPais(): string
    {
        return $this->_pais;
    }

    public function setPais(string $pais): bool
    {
        if (validaCadena($pais, 20, "España")) {
            $this->_pais = $pais;
            return true;
        } else {
            return false;
        }
    }

    public function getAnio(): int
    {
        return $this->_anio;
    }

    public function setAnio(int $anio): bool
    {
        // Con el date("Y") obtenemos el año actual 
        if (validaEntero($anio, 2020, date("Y"), 2020)) {
            $this->_anio = $anio;
            return true;
        } else {
            return false;
        }
    }

    public function getFechaIniVenta(): string
    {
        return $this->_fechaIniVenta;
    }

    public function setFechaIniVenta(string $fecha): bool
    {
        if (validaFecha($fecha, "01/01/2020")) {
            $this->_fechaIniVenta = $fecha;
            return true;
        } else {
            return false;
        }
    }

    public function getFechaFinVenta(): string
    {
        return $this->_fechaFinVenta;
    }

    public function setFechaFinVenta(string $fecha): bool
    {
        if (validaFecha($fecha, "31/12/2040")) {
            // Una vez que comprobemos que la fecha de fin es una fecha valida 
            // tenemos que pasarlo a date para poder compararlas    
            $d1 = DateTime::createFromFormat('d/m/Y', $this->_fechaIniVenta);
            $d2 = DateTime::createFromFormat('d/m/Y', $fecha);

            if ($d2 >= $d1) {
                $this->_fechaFinVenta = $fecha;
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function getPrecio(): float
    {
        return $this->_precio;
    }

    public function setPrecio(float $precio): bool
    {
        if (!is_float($precio) && $precio < 30) {
            return false;
        } else {
            $this->_precio = $precio;
            return true;
        }
    }
}
