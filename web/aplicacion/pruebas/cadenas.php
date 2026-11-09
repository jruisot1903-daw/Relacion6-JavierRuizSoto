<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
$barraUbi = [
    [
        "TEXTO" => "inicio",
        "LINK" => "/index.php"
    ],
    [
        "TEXTO" => "Pruebas",
        "LINK" => "/aplicacion/pruebas/index.php"
    ],
    [
        "TEXTO" => "Cadenas",
        "LINK" => "/aplicacion/pruebas/cadenas.php"
    ]
];

define("NUME",25);
const NUME1=56;
        
        
//controlador
//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("CADENAS",$barraUbi);
cuerpo(); //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}
//vista
function cuerpo()
{
   ?>

El niñ&ntilde;o me ha escrito una carta.
Qué&eacute;  &lt;&gt; bonita

<?php
 }


