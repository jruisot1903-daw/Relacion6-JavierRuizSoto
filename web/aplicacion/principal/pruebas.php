<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");

//controlador
$barraUbi = [
    ["TEXTO" => "Inicio", "LINK" => "/index.php"],
    ["TEXTO" => "Principal", "LINK" => "/aplicacion/principal/index.php"],
    ["TEXTO" => "Pruebas", "LINK" => "/aplicacion/principal/pruebas.php"],
];

//dibuja la plantilla de la vista
inicioCabecera("LA TIENDA DE SOTILLO");
finCabecera();
inicioCuerpo("PRUEBAS", $barraUbi);
cuerpo();  //llamo a la vista
finCuerpo();
// **********************************************************

/** Escribe una línea de resultado (los booleanos se muestran como true/false). */
function linea(string $texto, mixed $valor = null): void
{
    if (is_bool($valor)) {
        $valor = $valor ? 'true' : 'false';
    }
    echo htmlspecialchars($texto . ($valor === null ? '' : ': ' . $valor), ENT_QUOTES, 'UTF-8') . "\n";
}

//vista
function cuerpo()
{
    echo "<pre>\n";

    // ---------- Constructor, valores por defecto y __toString ----------
    linea("== MuebleReciclado con valores por defecto (solo nombre) ==");
    $r = new MuebleReciclado('mesa baja');
    linea("toString", (string) $r);

    linea("== MuebleTradicional con valores incorrectos (se asignan los de por defecto) ==");
    $t = new MuebleTradicional('Aparador', 'Rustico', 'UN PAIS CON UN NOMBRE DEMASIADO LARGO', 1999, '32/13/2021', '01/01/2000', 5, 1000, '');
    linea("toString", (string) $t);

    linea("== Nombre vacío: lanza excepción ==");
    try {
        new MuebleReciclado('   ');
    } catch (Exception $e) {
        linea("Excepción", $e->getMessage());
    }

    // ---------- Métodos set/get de MuebleBase ----------
    linea("== set/get de MuebleBase (true = asigna, false = no asigna) ==");
    linea("setNombre('sofá cama')", $r->setNombre('sofá cama'));
    linea("getNombre", $r->getNombre());
    linea("setNombre('')", $r->setNombre(''));
    linea("getNombre (no cambia)", $r->getNombre());
    linea("setFabricante('Nordico')", $r->setFabricante('Nordico'));
    linea("getFabricante", $r->getFabricante());
    linea("setPais('PORTUGAL')", $r->setPais('PORTUGAL'));
    linea("getPais", $r->getPais());
    linea("setPais('PAIS DEMASIADO LARGO PARA SER VALIDO')", $r->setPais('PAIS DEMASIADO LARGO PARA SER VALIDO'));
    linea("setAnio(2022)", $r->setAnio(2022));
    linea("getAnio", $r->getAnio());
    linea("setAnio(2010)", $r->setAnio(2010));
    linea("setFechaIniVenta('01/05/2022')", $r->setFechaIniVenta('01/05/2022'));
    linea("getFechaIniVenta", $r->getFechaIniVenta());
    linea("setFechaIniVenta('01/05/2021') (anterior al año)", $r->setFechaIniVenta('01/05/2021'));
    linea("setFechaFinVenta('01/01/2022') (anterior al inicio)", $r->setFechaFinVenta('01/01/2022'));
    linea("setFechaFinVenta('31/12/2030')", $r->setFechaFinVenta('31/12/2030'));
    linea("getFechaFinVenta", $r->getFechaFinVenta());
    linea("setPrecio(20)", $r->setPrecio(20));
    linea("setPrecio(99.5)", $r->setPrecio(99.5));
    linea("getPrecio", $r->getPrecio());

    // ---------- Propiedades de las clases hijas ----------
    linea("== MuebleReciclado ==");
    linea("setPorcentajeReciclado(150)", $r->setPorcentajeReciclado(150));
    linea("setPorcentajeReciclado(75)", $r->setPorcentajeReciclado(75));
    linea("getPorcentajeReciclado", $r->getPorcentajeReciclado());
    linea("damePropiedadesAdicionales", implode(', ', $r->damePropiedadesAdicionales()));

    linea("== MuebleTradicional ==");
    linea("setPeso(10)", $t->setPeso(10));
    linea("setPeso(120.5)", $t->setPeso(120.5));
    linea("getPeso", $t->getPeso());
    linea("setSerie('S09')", $t->setSerie('S09'));
    linea("getSerie", $t->getSerie());
    linea("damePropiedadesAdicionales", implode(', ', $t->damePropiedadesAdicionales()));

    // ---------- Propiedades dinámicas ----------
    linea("== Sobrecarga dinámica de propiedades ==");
    try {
        $r->color = 'rojo';
    } catch (Error $e) {
        linea("Error", $e->getMessage());
    }
    try {
        echo $r->nombre;
    } catch (Error $e) {
        linea("Error", $e->getMessage());
    }

    // ---------- Características ----------
    linea("== Características ==");
    linea("anadirCaracteristicas('saliente', true, 'precio', 300, 'sobrante')", $r->anadirCaracteristicas('saliente', true, 'precio', 300, 'sobrante'));
    $car = $r->getCaracteristicas();
    linea("getCaracteristicas (cadena)", (string) $car);
    linea("Recorrido con foreach (orden inverso):");
    foreach ($car as $nombre => $valor) {
        linea("  $nombre", is_bool($valor) ? ($valor ? 'true' : 'false') : $valor);
    }
    linea("Característica 'precio' modificada a 350");
    $car->precio = 350;
    linea("Característica nueva con ULTIMA", $r->anadirCaracteristicas('color', 'azul', 'ULTIMA', 1));
    try {
        $r->anadirCaracteristicas('otra', 5);
    } catch (LogicException $e) {
        linea("Error al añadir tras ULTIMA", $e->getMessage());
    }
    $car->color = 'verde';
    linea("Modificar una existente sí se puede (color)", $car->color);
    linea("toString del mueble con características", (string) $r);

    // ---------- Instancias creadas ----------
    linea("== Control del número de muebles ==");
    linea("MAXIMO_MUEBLES", MuebleBase::MAXIMO_MUEBLES);
    linea("puedeCrear", MuebleBase::puedeCrear($quedan));
    linea("Muebles que aún se pueden crear", $quedan);
    try {
        while (MuebleBase::puedeCrear()) {
            new MuebleTradicional('RELLENO');
        }
        linea("puedeCrear", MuebleBase::puedeCrear($quedan));
        linea("Muebles que aún se pueden crear", $quedan);
        new MuebleTradicional('UNO MAS');
    } catch (RuntimeException $e) {
        linea("Excepción", $e->getMessage());
    }

    echo "</pre>\n";
    echo "<a href=\"index.php\">Ir a Index.php</a>\n";
}
