<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

/**
 * Escapa un texto para mostrarlo en HTML.
 */
function esc(mixed $texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

/**
 * Devuelve las etiquetas de los campos del formulario según el tipo de mueble.
 */
function dameCampos(MuebleBase $mueble): array
{
    $campos = [
        'nombre'     => 'Nombre',
        'fabricante' => 'Fabricante',
        'pais'       => 'País',
        'anio'       => 'Año de inicio de fabricación',
        'fechaini'   => 'Fecha inicio de venta (dd/mm/aaaa)',
        'fechafin'   => 'Fecha fin de venta (dd/mm/aaaa)',
        'precio'     => 'Precio',
    ];
    if ($mueble instanceof MuebleReciclado) {
        $campos['porcentaje'] = 'Porcentaje reciclado';
    } else {
        $campos['peso'] = 'Peso';
        $campos['serie'] = 'Serie';
    }
    return $campos;
}

/**
 * Datos actuales del mueble, con los nombres de los campos del formulario.
 */
function valoresDeMueble(MuebleBase $mueble): array
{
    $valores = [
        'nombre'     => $mueble->getNombre(),
        'fabricante' => $mueble->getFabricante(),
        'pais'       => $mueble->getPais(),
        'anio'       => $mueble->getAnio(),
        'fechaini'   => $mueble->getFechaIniVenta(),
        'fechafin'   => $mueble->getFechaFinVenta(),
        'precio'     => $mueble->getPrecio(),
    ];
    if ($mueble instanceof MuebleReciclado) {
        $valores['porcentaje'] = $mueble->getPorcentajeReciclado();
    } else {
        $valores['peso'] = $mueble->getPeso();
        $valores['serie'] = $mueble->getSerie();
    }
    return $valores;
}

/**
 * Valida los datos enviados.
 * Primera mitad (nombre, fabricante, país y año): con una instancia auxiliar y los métodos set.
 * Segunda mitad (fechas, precio y propiedades propias del tipo): directamente con condiciones.
 * Devuelve [errores, datos].
 */
function validarDatos(MuebleBase $mueble, array $p): array
{
    $errores = [];
    $datos = [];
    $texto = fn(string $campo): string => is_string($p[$campo] ?? null) ? trim($p[$campo]) : '';

    // ---------- Mitad 1: instancia auxiliar + métodos set ----------
    $aux = ($mueble instanceof MuebleReciclado) ? new MuebleReciclado('AUX') : new MuebleTradicional('AUX');

    if ($aux->setNombre($texto('nombre'))) {
        $datos['nombre'] = $aux->getNombre();
    } else {
        $errores['nombre'] = 'El nombre es obligatorio y tiene como máximo 40 caracteres.';
    }

    $aux->setFabricante($texto('fabricante'));
    $datos['fabricante'] = $aux->getFabricante();

    if ($aux->setPais($texto('pais'))) {
        $datos['pais'] = $aux->getPais();
    } else {
        $errores['pais'] = 'El país no puede estar vacío y tiene como máximo 20 caracteres.';
    }

    $anioTxt = $texto('anio');
    if (ctype_digit($anioTxt) && $aux->setAnio((int) $anioTxt)) {
        $datos['anio'] = $aux->getAnio();
    } else {
        $errores['anio'] = 'El año debe ser un entero entre 2020 y ' . date('Y') . '.';
    }

    // ---------- Mitad 2: condiciones directas ----------
    $anio = $datos['anio'] ?? $mueble->getAnio();

    // Fecha de inicio de venta
    $partes = explode('/', $texto('fechaini'));
    if (count($partes) === 3 && ctype_digit(implode('', $partes)) && checkdate((int) $partes[1], (int) $partes[0], (int) $partes[2])) {
        $claveIni = sprintf('%04d%02d%02d', $partes[2], $partes[1], $partes[0]);
        if ($claveIni >= sprintf('%04d0101', $anio)) {
            $datos['fechaini'] = sprintf('%02d/%02d/%04d', $partes[0], $partes[1], $partes[2]);
        } else {
            $errores['fechaini'] = "La fecha de inicio no puede ser anterior al 01/01/$anio.";
        }
    } else {
        $errores['fechaini'] = 'La fecha de inicio no es válida (dd/mm/aaaa).';
    }

    // Fecha de fin de venta
    $partes = explode('/', $texto('fechafin'));
    if (count($partes) === 3 && ctype_digit(implode('', $partes)) && checkdate((int) $partes[1], (int) $partes[0], (int) $partes[2])) {
        $claveFin = sprintf('%04d%02d%02d', $partes[2], $partes[1], $partes[0]);
        if (!isset($claveIni) || !isset($datos['fechaini']) || $claveFin >= $claveIni) {
            $datos['fechafin'] = sprintf('%02d/%02d/%04d', $partes[0], $partes[1], $partes[2]);
        } else {
            $errores['fechafin'] = 'La fecha de fin no puede ser anterior a la de inicio.';
        }
    } else {
        $errores['fechafin'] = 'La fecha de fin no es válida (dd/mm/aaaa).';
    }

    // Precio
    $precioTxt = str_replace(',', '.', $texto('precio'));
    if (is_numeric($precioTxt) && (float) $precioTxt >= 30) {
        $datos['precio'] = (float) $precioTxt;
    } else {
        $errores['precio'] = 'El precio debe ser un número no menor de 30.';
    }

    // Propiedades propias de cada tipo
    if ($mueble instanceof MuebleReciclado) {
        $porcTxt = $texto('porcentaje');
        if (ctype_digit($porcTxt) && (int) $porcTxt >= 0 && (int) $porcTxt <= 100) {
            $datos['porcentaje'] = (int) $porcTxt;
        } else {
            $errores['porcentaje'] = 'El porcentaje debe ser un entero entre 0 y 100.';
        }
    } else {
        $pesoTxt = str_replace(',', '.', $texto('peso'));
        if (is_numeric($pesoTxt) && (float) $pesoTxt >= 15 && (float) $pesoTxt <= 300) {
            $datos['peso'] = (float) $pesoTxt;
        } else {
            $errores['peso'] = 'El peso debe ser un número entre 15 y 300.';
        }
        if ($texto('serie') !== '') {
            $datos['serie'] = $texto('serie');
        } else {
            $errores['serie'] = 'La serie no puede estar vacía.';
        }
    }

    return [$errores, $datos];
}

/**
 * Actualiza el mueble con los datos ya validados.
 */
function aplicarDatos(MuebleBase $mueble, array $d): void
{
    $mueble->setNombre($d['nombre']);
    $mueble->setFabricante($d['fabricante']);
    $mueble->setPais($d['pais']);
    $mueble->setAnio($d['anio']);          // el año va antes que las fechas
    $mueble->setFechaIniVenta($d['fechaini']);
    $mueble->setFechaFinVenta($d['fechafin']);
    $mueble->setPrecio($d['precio']);
    if ($mueble instanceof MuebleReciclado) {
        $mueble->setPorcentajeReciclado($d['porcentaje']);
    } else {
        $mueble->setPeso($d['peso']);
        $mueble->setSerie($d['serie']);
    }
}

//controlador
$entrada = $_POST['mueble'] ?? '';
$indice = null;
if (is_string($entrada) && ctype_digit($entrada) && validaRango((int) $entrada, array_keys($muebles))) {
    $indice = (int) $entrada;
}

if ($indice === null || !(isset($_POST['modificar']) || isset($_POST['guardar']))) {
    paginaError("No se ha indicado un mueble valido");
    exit;
}

$mueble = $muebles[$indice];
$campos = dameCampos($mueble);
$valores = valoresDeMueble($mueble);
$errores = [];
$guardado = false;

if (isset($_POST['guardar'])) {
    // Mostramos lo que ha escrito el usuario si hay errores
    foreach ($campos as $campo => $etiqueta) {
        $valores[$campo] = is_string($_POST[$campo] ?? null) ? $_POST[$campo] : '';
    }
    [$errores, $datos] = validarDatos($mueble, $_POST);
    if (!$errores) {
        aplicarDatos($mueble, $datos);
        $guardado = true;
    }
}

$barraUbi = [
    ["TEXTO" => "Inicio", "LINK" => "/index.php"],
    ["TEXTO" => "Principal", "LINK" => "/aplicacion/principal/index.php"],
    ["TEXTO" => "Modificar mueble", "LINK" => "/aplicacion/principal/index.php"],
];

//dibuja la plantilla de la vista
inicioCabecera("LA TIENDA DE SOTILLO");
finCabecera();
inicioCuerpo("MODIFICAR MUEBLE", $barraUbi);
if ($guardado) {
    vistaResumen($campos, $datos);
} else {
    vistaFormulario($indice, $campos, $valores, $errores);
}
finCuerpo();
// **********************************************************

//vista
function vistaFormulario(int $indice, array $campos, array $valores, array $errores)
{
?>
    <br>
    <form action="modificar.php" method="post">
        <input type="hidden" name="mueble" value="<?php echo esc($indice); ?>">
        <?php foreach ($campos as $campo => $etiqueta) { ?>
            <p>
                <label for="<?php echo esc($campo); ?>"><?php echo esc($etiqueta); ?>:</label>
                <input type="text" name="<?php echo esc($campo); ?>" id="<?php echo esc($campo); ?>" value="<?php echo esc($valores[$campo]); ?>">
                <?php
                if (isset($errores[$campo])) {
                    echo "<br><span>" . esc($errores[$campo]) . "</span>";
                }
                ?>
            </p>
        <?php } ?>
        <input type="submit" name="guardar" value="Guardar cambios">
    </form>
    <br>
    <a href="index.php">Ir a Index.php</a>
<?php
}

//vista
function vistaResumen(array $campos, array $datos)
{
?>
    <h3>Datos recogidos</h3>
    <p>
        <?php
        foreach ($campos as $campo => $etiqueta) {
            echo esc($etiqueta) . ": " . esc($datos[$campo]) . "<br>\n";
        }
        ?>
    </p>
    <a href="index.php">Ir a Index.php</a>
<?php
}
