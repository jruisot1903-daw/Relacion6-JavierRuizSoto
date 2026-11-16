<?php
/**
 * Clase abstracta MuebleBase.
 * Las propiedades son privadas: solo se accede mediante set/get.
 * Los set devuelven true y asignan si el valor es correcto; si no, devuelven false y no asignan nada.
 */
abstract class MuebleBase
{
    /** Número máximo de muebles que se pueden crear. */
    public const MAXIMO_MUEBLES = 20;

    /** Número de muebles (instancias) creados hasta el momento. */
    private static int $mueblesCreados = 0;

    private string $nombre = '';
    private string $fabricante = 'FaMu:';
    private string $pais = 'ESPAÑA';
    private int $anio = 2020;
    private string $fechaIniVenta = '01/01/2020';
    private string $fechaFinVenta = '31/12/2040';
    private float $precio = 30;
    private Caracteristicas $caracteristicas;

    /**
     * Constructor. El nombre es obligatorio: si no es válido se lanza una excepción.
     * Para el resto de campos, si el set falla se asigna el valor por defecto.
     * Si se ha superado el máximo de instancias también se lanza una excepción.
     */
    public function __construct(
        string $nombre,
        string $fabricante = 'FaMu:',
        string $pais = 'ESPAÑA',
        int $anio = 2020,
        string $fechaIniVenta = '01/01/2020',
        string $fechaFinVenta = '31/12/2040',
        float $precio = 30
    ) {
        if (!self::puedeCrear()) {
            throw new RuntimeException('Se ha superado el máximo de muebles (' . self::MAXIMO_MUEBLES . ').');
        }
        if (!$this->setNombre($nombre)) {
            throw new InvalidArgumentException('El nombre del mueble no es válido.');
        }
        $this->caracteristicas = new Caracteristicas();

        if (!$this->setFabricante($fabricante)) {
            $this->setFabricante('FaMu:');
        }
        if (!$this->setPais($pais)) {
            $this->setPais('ESPAÑA');
        }
        if (!$this->setAnio($anio)) {
            $this->setAnio(2020);
        }
        if (!$this->setFechaIniVenta($fechaIniVenta)) {
            $this->setFechaIniVenta('01/01/' . $this->anio);
        }
        if (!$this->setFechaFinVenta($fechaFinVenta)) {
            $this->setFechaFinVenta('31/12/2040');
        }
        if (!$this->setPrecio($precio)) {
            $this->setPrecio(30);
        }
        self::$mueblesCreados++;
    }

    /** No se permite la sobrecarga dinámica de propiedades. */
    public function __set(string $nombre, mixed $valor): void
    {
        throw new Error("No se puede asignar la propiedad '$nombre': use los métodos set.");
    }

    /** Tampoco se puede leer directamente ninguna propiedad. */
    public function __get(string $nombre): mixed
    {
        throw new Error("No se puede acceder a la propiedad '$nombre': use los métodos get.");
    }

    /** Convierte una fecha dd/mm/aaaa en aaaammdd para poder compararlas. */
    protected static function claveFecha(string $fecha): string
    {
        [$d, $m, $a] = explode('/', $fecha);
        return sprintf('%04d%02d%02d', $a, $m, $d);
    }

    // ---------- Nombre ----------
    public function setNombre(string $nombre): bool
    {
        $valor = mb_strtoupper(trim($nombre));
        if ($valor === '') {
            return false;
        }
        $aux = $valor;
        if (!validaCadena($aux, 40, '')) {
            return false;
        }
        $this->nombre = $valor;
        return true;
    }
    public function getNombre(): string
    {
        return $this->nombre;
    }

    // ---------- Fabricante ----------
    public function setFabricante(string $fabricante): bool
    {
        $valor = trim($fabricante);
        if (!str_starts_with($valor, 'FaMu:')) {
            $valor = 'FaMu:' . $valor;
        }
        $this->fabricante = mb_substr($valor, 0, 30);
        return true;
    }
    public function getFabricante(): string
    {
        return $this->fabricante;
    }

    // ---------- País ----------
    public function setPais(string $pais): bool
    {
        $valor = trim($pais);
        if ($valor === '' || !validaCadena($valor, 20, 'ESPAÑA')) {
            return false;
        }
        $this->pais = $valor;
        return true;
    }
    public function getPais(): string
    {
        return $this->pais;
    }

    // ---------- Año ----------
    public function setAnio(int $anio): bool
    {
        $valor = $anio;
        if (!validaEntero($valor, 2020, (int) date('Y'), 2020)) {
            return false;
        }
        $this->anio = $valor;
        return true;
    }
    public function getAnio(): int
    {
        return $this->anio;
    }

    // ---------- Fecha de inicio de venta ----------
    public function setFechaIniVenta(string $fecha): bool
    {
        $valor = $fecha;
        if (!validaFecha($valor, '01/01/' . $this->anio)) {
            return false;
        }
        // No puede ser anterior al 1 de enero del año de inicio de fabricación
        if (self::claveFecha($valor) < self::claveFecha('01/01/' . $this->anio)) {
            return false;
        }
        $this->fechaIniVenta = $valor;
        return true;
    }
    public function getFechaIniVenta(): string
    {
        return $this->fechaIniVenta;
    }

    // ---------- Fecha de fin de venta ----------
    public function setFechaFinVenta(string $fecha): bool
    {
        $valor = $fecha;
        if (!validaFecha($valor, '31/12/2040')) {
            return false;
        }
        // No puede ser anterior a la fecha de inicio de venta
        if (self::claveFecha($valor) < self::claveFecha($this->fechaIniVenta)) {
            return false;
        }
        $this->fechaFinVenta = $valor;
        return true;
    }
    public function getFechaFinVenta(): string
    {
        return $this->fechaFinVenta;
    }

    // ---------- Precio ----------
    public function setPrecio(float $precio): bool
    {
        $valor = $precio;
        if (!validaReal($valor, 30, PHP_FLOAT_MAX, 30)) {
            return false;
        }
        $this->precio = $valor;
        return true;
    }
    public function getPrecio(): float
    {
        return $this->precio;
    }

    // ---------- Características ----------
    /**
     * Añade características a partir de pares (nombre, valor): anadirCaracteristicas('saliente', true, 'precio', 300).
     * Si el número de argumentos es impar se descarta el último.
     * Devuelve el número de características indicadas.
     */
    public function anadirCaracteristicas(mixed ...$pares): int
    {
        $total = 0;
        for ($i = 0; $i + 1 < count($pares); $i += 2) {
            $this->caracteristicas->{(string) $pares[$i]} = $pares[$i + 1];
            $total++;
        }
        return $total;
    }
    public function getCaracteristicas(): Caracteristicas
    {
        return $this->caracteristicas;
    }

    // ---------- Propiedades adicionales ----------
    /** Será redefinido en las clases hijas: nombres de las propiedades adicionales. */
    public function damePropiedadesAdicionales(): array
    {
        return [];
    }

    // ---------- Método de clase ----------
    /**
     * Devuelve true si se pueden crear más muebles.
     * En $numero se devuelve cuántos muebles se pueden crear aún.
     */
    public static function puedeCrear(?int &$numero = null): bool
    {
        $numero = self::MAXIMO_MUEBLES - self::$mueblesCreados;
        return $numero > 0;
    }

    // ---------- Conversión a cadena ----------
    public function __toString(): string
    {
        $texto = 'MUEBLE de clase ' . static::class
            . ' con nombre ' . $this->nombre
            . ', fabricante ' . $this->fabricante
            . ', fabricado en ' . $this->pais
            . ' a partir del año ' . $this->anio
            . ', vendido desde ' . $this->fechaIniVenta
            . ' hasta ' . $this->fechaFinVenta
            . ', precio ' . $this->precio;

        foreach ($this->damePropiedadesAdicionales() as $propiedad) {
            $texto .= ', ' . $propiedad . ' ' . $this->{'get' . $propiedad}();
        }
        if ($this->caracteristicas->cuantas() > 0) {
            $texto .= ', características: ' . $this->caracteristicas;
        }
        return $texto;
    }
}
