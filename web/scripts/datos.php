<?php
/**
 * Array de muebles (índices a partir de 1), definido en un único punto.
 * Se incluye desde cabecera.php para que esté accesible en todas las páginas.
 */
$muebles = [
    1 => new MuebleReciclado('Estantería nórdica', 'FaMu:Eco', 'ESPAÑA', 2021, '01/03/2021', '31/12/2035', 120, 60),
    2 => new MuebleTradicional('Armario castellano', 'FaMu:Roble', 'PORTUGAL', 2020, '01/01/2020', '31/12/2040', 450, 120.5, 'S05'),
    3 => new MuebleReciclado('Mesa de palés', 'FaMu:Palet', 'ESPAÑA', 2022, '15/06/2022', '31/12/2038', 85, 90),
    4 => new MuebleTradicional('Cómoda clásica', 'FaMu:Clasica', 'ITALIA', 2023, '01/02/2023', '31/12/2040', 310, 75, 'S02'),
    5 => new MuebleReciclado('Silla de neumático', 'FaMu:Rueda', 'FRANCIA', 2024, '10/01/2024', '31/12/2036', 55, 40),
];

$muebles[1]->anadirCaracteristicas('material', 'madera de palé', 'patas', 4);
$muebles[2]->anadirCaracteristicas('material', 'roble', 'puertas', 3, 'tallado', true);
$muebles[3]->anadirCaracteristicas('material', 'madera reciclada', 'saliente', true);
$muebles[4]->anadirCaracteristicas('material', 'nogal', 'cajones', 4);
$muebles[5]->anadirCaracteristicas('material', 'caucho', 'color', 'negro');
