<?php
/**
 * Mueble tradicional: añade Peso (real entre 15 y 300, por defecto 15) y Serie (cadena, por defecto S01).
 * No se pueden crear subclases.
 */
final class MuebleTradicional extends MuebleBase
{
    private float $peso = 15;
    private string $serie = 'S01';

    public function __construct(
        string $nombre,
        string $fabricante = 'FaMu:',
        string $pais = 'ESPAÑA',
        int $anio = 2020,
        string $fechaIniVenta = '01/01/2020',
        string $fechaFinVenta = '31/12/2040',
        float $precio = 30,
        float $peso = 15,
        Materiales $material = Materiales::Hierro,
        string $serie = 'S01'
    ) {
        parent::__construct($nombre, $fabricante, $pais, $anio, $fechaIniVenta, $fechaFinVenta, $precio,$material);
        if (!$this->setPeso($peso)) {
            $this->setPeso(15);
        }
        if (!$this->setSerie($serie)) {
            $this->setSerie('S01');
        }
    }

    public function setPeso(float $peso): bool
    {
        $valor = $peso;
        if (!validaReal($valor, 15, 300, 15)) {
            return false;
        }
        $this->peso = $valor;
        return true;
    }
    public function getPeso(): float
    {
        return $this->peso;
    }

    public function setSerie(string $serie): bool
    {
        $valor = trim($serie);
        if ($valor === '') {
            return false;
        }
        $this->serie = $valor;
        return true;
    }
    public function getSerie(): string
    {
        return $this->serie;
    }

    public function damePropiedadesAdicionales(): array
    {
        return ['Peso', 'Serie'];
    }
}
