<?php
include_once(dirname(__FILE__) . "/../../cabecera.php");
//controlador

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
        "TEXTO" => "Pasopar",
        "LINK" => "/aplicacion/pruebas/pasopar.php"
    ]
];

//datos basicos
$nombre="Vicente";
$edad=30;

$basicos=[
    "nombre"=>$nombre,
    "edad"=>$edad
];

//relleno otras
$otras=rellenarOtras();



//dibuja la plantilla de la vista
inicioCabecera("Mi aplicacion");
cabecera();
finCabecera();
inicioCuerpo("PASO PARAMETROs",$barraUbi);
cuerpo($basicos, $otras);  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() 
{
    ?>
    <!-- esto va en el head -->
     <?php   



}

//vista
function cuerpo($bas, $ot)
{
?>
    <br><br>

<?php


    echo "Mi nombre es {$bas["nombre"]} de {$bas["edad"]} años".PHP_EOL;
    "Con otros datos {$ot}";

}


function rellenarOtras(){
    return "de 2 DAW";
}