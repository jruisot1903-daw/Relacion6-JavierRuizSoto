<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

/**
 * Escapa un texto para mostrarlo en HTML.
 */
function esc(mixed $texto): string
{
    return htmlspecialchars((string) $texto, ENT_QUOTES, 'UTF-8');
}

//controlador
$seleccion = null;
$mensajeError = '';

if (isset($_POST['mostrar'])) {
    $indice = $_POST['mueble'] ?? '';
    // Comprobamos que el índice recibido es uno de los índices del array
    if (is_string($indice) && ctype_digit($indice) && validaRango((int) $indice, array_keys($muebles))) {
        $seleccion = (int) $indice;
    } else {
        $mensajeError = 'El mueble seleccionado no existe.';
    }
}

$barraUbi = [
    ["TEXTO" => "Inicio", "LINK" => "/index.php"],
    ["TEXTO" => "Principal", "LINK" => "/aplicacion/principal/index.php"],
];

//dibuja la plantilla de la vista
inicioCabecera("LA TIENDA DE SOTILLO");
finCabecera();
inicioCuerpo("MUEBLES", $barraUbi);
cuerpo($muebles, $seleccion, $mensajeError);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cuerpo(array $muebles, ?int $seleccion, string $mensajeError)
{
?>
    <br>
    <table border="1" cellpadding="4">
        <tr>
            <th>Índice</th>
            <th>Tipo</th>
            <th>Nombre</th>
            <th>Fabricante</th>
            <th>País</th>
            <th>Precio</th>
            <th>Material</th>
        </tr>
        <?php foreach ($muebles as $indice => $mueble) { ?>
            <tr>
                <td><?php echo esc($indice); ?></td>
                <td><?php echo esc(get_class($mueble)); ?></td>
                <td><?php echo esc($mueble->getNombre()); ?></td>
                <td><?php echo esc($mueble->getFabricante()); ?></td>
                <td><?php echo esc($mueble->getPais()); ?></td>
                <td><?php echo esc($mueble->getPrecio()); ?></td>
                <td><?php echo esc($mueble->getMaterial());?></td>
            </tr>
        <?php } ?>
    </table>
    <br>

    <form action="index.php" method="post">
        <label for="mueble">Mueble:</label>
        <select name="mueble" id="mueble">
            <?php foreach ($muebles as $indice => $mueble) { ?>
                <option value="<?php echo esc($indice); ?>" <?php echo ($indice === $seleccion) ? 'selected' : ''; ?>>
                    <?php echo esc("$indice - " . get_class($mueble) . " - " . $mueble->getNombre()); ?>
                </option>
            <?php } ?>
        </select>
        <input type="submit" name="mostrar" value="Mostrar Mueble">
        <!-- El segundo botón envía el mismo formulario a otra página y en una ventana nueva -->
        <input type="submit" name="modificar" value="Modificar Mueble" formaction="modificar.php" formtarget="_blank">
    </form>

    <?php
    if ($mensajeError !== '') {
        echo "<p>" . esc($mensajeError) . "</p>\n";
    }
    if ($seleccion !== null) {
        mostrarMueble($muebles[$seleccion]);
    }
    ?>
    <br>
    <a href="pruebas.php">Pruebas</a>
<?php
}

/**
 * Muestra todas las propiedades y características de un mueble (sin usar la conversión a cadena).
 */
function mostrarMueble(MuebleBase $mueble)
{
?>
    <h3>Datos del mueble</h3>
    <p>
        Tipo: <?php echo esc(get_class($mueble)); ?><br>
        Nombre: <?php echo esc($mueble->getNombre()); ?><br>
        Fabricante: <?php echo esc($mueble->getFabricante()); ?><br>
        País: <?php echo esc($mueble->getPais()); ?><br>
        Año de inicio de fabricación: <?php echo esc($mueble->getAnio()); ?><br>
        Inicio de venta: <?php echo esc($mueble->getFechaIniVenta()); ?><br>
        Fin de venta: <?php echo esc($mueble->getFechaFinVenta()); ?><br>
        Precio: <?php echo esc($mueble->getPrecio()); ?><br>
        Material: <?php echo esc($mueble->getMaterial());?><br>
        <?php
        // Propiedades adicionales, obtenidas con el método damePropiedadesAdicionales
        foreach ($mueble->damePropiedadesAdicionales() as $propiedad) {
            echo esc($propiedad) . ": " . esc($mueble->{'get' . $propiedad}()) . "<br>\n";
        }
        ?>
    </p>
    <h3>Características</h3>
    <p>
        <?php
        foreach ($mueble->getCaracteristicas() as $nombre => $valor) {
            if (is_bool($valor)) {
                $valor = $valor ? 'true' : 'false';
            }
            echo esc($nombre) . ": " . esc($valor) . "<br>\n";
        }
        ?>
    </p>
<?php
}
