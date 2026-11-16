<?php
/**
 * Mueble reciclado: añade PorcentajeReciclado (entero entre 0 y 100, por defecto 10).
 * No se pueden crear subclases.
 */
final class MuebleReciclado extends MuebleBase
{
    private int $porcentajeReciclado = 10;

    public function __construct(
        string $nombre,
        string $fabricante = 'FaMu:',
        string $pais = 'ESPAÑA',
        int $anio = 2020,
        string $fechaIniVenta = '01/01/2020',
        string $fechaFinVenta = '31/12/2040',
        float $precio = 30,
        int $porcentajeReciclado = 10
    ) {
        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio);
        if (!$this->setPorcentajeReciclado($porcentajeReciclado)) {
            $this->setPorcentajeReciclado(10);
        }
    }

    public function setPorcentajeReciclado(int $porcentaje): bool
    {
        $valor = $porcentaje;
        if (!validaEntero($valor, 0, 100, 10)) {
            return false;
        }
        $this->porcentajeReciclado = $valor;
        return true;
    }
    public function getPorcentajeReciclado(): int
    {
        return $this->porcentajeReciclado;
    }

    public function damePropiedadesAdicionales(): array
    {
        return ['PorcentajeReciclado'];
    }
}