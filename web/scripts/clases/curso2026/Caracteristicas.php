<?php

/**
 * Clase Caracteristicas.
 * Almacena características creadas de forma dinámica (pares nombre => valor).
 * - Se recorre con foreach en orden inverso al de incorporación.
 * - Si se añade la característica ULTIMA, no se pueden crear más, pero sí modificar las existentes.
 * - Al convertirla en cadena devuelve car1:valor1;car2:valor2;...
 */
class Caracteristicas implements IteratorAggregate
{
    /** Nombre de la característica que cierra la lista. */
    public const ULTIMA = 'ULTIMA';

    /** Características en orden de incorporación. */
    private array $datos = [];

    /** Indica si ya se ha añadido ULTIMA. */
    private bool $cerrada = false;

    /** Crea o modifica una característica. */
    public function __set(string $nombre, mixed $valor): void
    {
        if (!array_key_exists($nombre, $this->datos)) {
            if ($this->cerrada) {
                throw new LogicException("No se puede añadir la característica '$nombre': ya se indicó " . self::ULTIMA . '.');
            }
            if ($nombre === self::ULTIMA) {
                $this->cerrada = true;
            }
        }
        $this->datos[$nombre] = $valor;
    }

    /** Devuelve el valor de una característica. */
    public function __get(string $nombre): mixed
    {
        if (!array_key_exists($nombre, $this->datos)) {
            throw new OutOfBoundsException("La característica '$nombre' no existe.");
        }
        return $this->datos[$nombre];
    }

    public function __isset(string $nombre): bool
    {
        return array_key_exists($nombre, $this->datos);
    }

    /** Número de características. */
    public function cuantas(): int
    {
        return count($this->datos);
    }

    /** Recorrido en orden inverso al de incorporación. */
    public function getIterator(): Iterator
    {
        return new ArrayIterator(array_reverse($this->datos, true));
    }

    /** Convierte un valor a texto legible. */
    private static function valorATexto(mixed $valor): string
    {
        if (is_bool($valor)) {
            return $valor ? 'true' : 'false';
        }
        if (is_scalar($valor) || $valor === null) {
            return (string) $valor;
        }
        return json_encode($valor, JSON_UNESCAPED_UNICODE);
    }

    /** Caractetistica numero_serie
     * No se guarda el valor 
     * Se devuelve la secuencia de 15 digitos aleatorios (cada vez que se devuelve sera distinto)
     * 
     */
    public function numero_serie()
    {
        $cadena = '';
        for ($i = 0; $i < 14; $i++) {
            // Generar un número ASCII válido
            $ascii = rand(48, 122);

            // Validar que esté dentro de los rangos permitidos
            if (($ascii >= 48 && $ascii <= 57)) { // numeros 0-9
                $cadena .= chr($ascii);
            } else {
                $i--; // Repetir el ciclo si el carácter no es válido
            }
        }
        return $cadena;
    }

    /** Formato car1:valor1;car2:valor2;... (en orden de incorporación). */
    public function __toString(): string
    {
        $partes = [];
        foreach ($this->datos as $nombre => $valor) {
            $partes[] = $nombre . ':' . self::valorATexto($valor);
        }
        return implode(';', $partes);
    }
}
