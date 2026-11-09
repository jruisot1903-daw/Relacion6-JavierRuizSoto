<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador
/**
 * Cada elemento es un array de dos posiciones asociativas
 * TEXTO : texto a mostrar en el elemento
 * LINK: Enlace a la pagina
 */

$barraUbi = [
    [
        "TEXTO" => "Inicio",
        "LINK" => "/index.php"
    ],
    [
        "TEXTO" => "pruebas",
        "LINK" => "/aplicacion/pruebas/index.php"
    ],
    [
        "TEXTO" => "string",
        "LINK" => "/aplicacion/pruebas/string.php"
    ]
];


//dibuja la plantilla de la vista
inicioCabecera("APLICACION PRIMER TRIMESTRE");
cabecera();
finCabecera();
inicioCuerpo("Pruebas",$barraUbi);
cuerpo(); //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}
//vista
function cuerpo()
{
?>
<br>
   El niñ&ntilde;o me ha escrito una carta,
   Qué&eacute; &lt; &gt; bonita
<?php
}
