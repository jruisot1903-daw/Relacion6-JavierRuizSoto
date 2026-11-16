<?php
/**
 * Array de muebles (índices a partir de 1), definido en un único punto.
 * Se incluye desde cabecera.php para que esté accesible en todas las páginas.
 */

// Obtener todos los casos posibles del enum
$material = Materiales::casos();

// Elegir uno aleatorio
$materialAleatorio1 = $material[array_rand($material)];

$materialAleatorio2 = $material[array_rand($material)];

$materialAleatorio3 = $material[array_rand($material)];

$materialAleatorio4 = $material[array_rand($material)];

$materialAleatorio5 = $material[array_rand($material)];


$muebles = [
    1 => new MuebleReciclado('Estantería nórdica', 'FaMu:Eco', 'ESPAÑA', 2021, '01/03/2021', '31/12/2035', 120,$materialAleatorio1, 60,),
    2 => new MuebleTradicional('Armario castellano', 'FaMu:Roble', 'PORTUGAL', 2020, '01/01/2020', '31/12/2040', 450, 120.5, $materialAleatorio2,'S05',),
    3 => new MuebleReciclado('Mesa de palés', 'FaMu:Palet', 'ESPAÑA', 2022, '15/06/2022', '31/12/2038',85,$materialAleatorio3, 90),
    4 => new MuebleTradicional('Cómoda clásica', 'FaMu:Clasica', 'ITALIA', 2023, '01/02/2023', '31/12/2040', 310,75,$materialAleatorio4, 'S02'),
    5 => new MuebleReciclado('Silla de neumático', 'FaMu:Rueda', 'FRANCIA', 2024, '10/01/2024', '31/12/2036', 55, $materialAleatorio5,40),
];

$muebles[1]->anadirCaracteristicas('patas', 4);
$muebles[2]->anadirCaracteristicas('puertas', 3, 'tallado', true);
$muebles[3]->anadirCaracteristicas('saliente', true);
$muebles[4]->anadirCaracteristicas('cajones', 4);
$muebles[5]->anadirCaracteristicas('color', 'negro');
