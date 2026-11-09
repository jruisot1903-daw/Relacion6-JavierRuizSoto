<?php
include_once(dirname(__FILE__) . "/cabecera.php");
//controlador

//dibuja la plantilla de la vista
inicioCabecera("LA TIENDA DE SOTILLO");
cabecera();
finCabecera();
inicioCuerpo("TIENDA");
cuerpo();  //llamo a la vista
finCuerpo();
// **********************************************************

//vista
function cabecera() {}

//vista
function cuerpo()
{
?>
    <br><br>
    <a href="./aplicacion/pruebas/index.php">Pruebas</a>
<?php
}
