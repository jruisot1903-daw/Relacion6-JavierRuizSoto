<?php

namespace VALFILTER;

/**
 * Funcion validaEntero, esta funcion la vamos a utilizar para validar si un numero es un entero si su valor esta entre un min y un max.<br>
 * Tenemos 4 varibles que podemos utilizar dentro de l funcion:<br>
 * $var --> Contiene el numero que queremos validar.<br>
 * $min --> Un numero entero que vamos a utilizar para marcar el minimo del rango.<br>
 * $min --> Un numero entero que vamos a utilizar para marcar el maximo del rango.<br>
 * $defecto --> En el caso de que no este en el rango que le pongamos lo utilizamos para meterle a $var un numero por defecto.<br>
 * La función devuelve true si es correcto o false si no es correcto.<br>
 * En el caso de que sea false tenemos que asignarle a $var el valor de $defecto
 */
function validaEntero(int &$var, int $min, int $max, int $defecto): bool
{
    $resultado = false;

    if (filter_var($var, FILTER_VALIDATE_INT) !== false &&
        $var > $min && $var < $max) {

        $resultado = true;

    } else {
        $var = $defecto;
        $resultado = false;
    }

    return $resultado;
}

/**
 * Funcion validaReal, esta funcion la vamos a utilizar para validar si un numero es un real si su valor esta entre un min y un max.<br>
 * Tenemos 4 varibles que podemos utilizar dentro de la funcion:<br>
 * $var --> Contiene el numero que queremos validar.<br>
 * $min --> Un numero entero que vamos a utilizar para marcar el minimo del rango.<br>
 * $min --> Un numero entero que vamos a utilizar para marcar el maximo del rango.<br>
 * $defecto --> En el caso de que no este en el rango que le pongamos lo utilizamos para meterle a $var un numero por defecto.<br>
 * La función devuelve true si es correcto o false si no es correcto.<br>
 * En el caso de que sea false tenemos que asignarle a $var el valor de $defecto.
 */

function validaReal(float &$var, float $min, float $max, float $defecto): bool
{
    $resultado = false;

    if (filter_var($var, FILTER_VALIDATE_FLOAT) !== false &&
        $var > $min && $var < $max) {

        $resultado = true;

    } else {
        $var = $defecto;
        $resultado = false;
    }

    return $resultado;
}
/**
 * Funcion validaFecha , esta funcion comprueba que en $var contiene una fecha correcta en formato "dd/mm/aaaa".<br>
 * Tenemos 2 varibales:
 * $var --> En el cual vamos a meterle un string con la fecha que vamos a comprobar.<br>
 * $defecto --> Asigna en $var lo que contenga $defecto
 * La funcion devuelve true si todo sale bien , si no devuelve false
 */

function validaFecha(string &$var, string $defecto): bool
{
    $resultado = false;

    $fec = explode("/", $var);

    if (count($fec) == 3) {

        $dia = filter_var($fec[0], FILTER_VALIDATE_INT);
        $mes = filter_var($fec[1], FILTER_VALIDATE_INT);
        $anio = filter_var($fec[2], FILTER_VALIDATE_INT);

        if ($dia !== false && $mes !== false && $anio !== false &&
            checkdate($mes, $dia, $anio)) {

            $var = sprintf('%02d/%02d/%04d', $dia, $mes, $anio);
            $resultado = true;
        }
    }

    if (!$resultado) {
        $var = $defecto;
    }

    return $resultado;
}

/**
 * Funcion validaHora , esta funcion comprueba que en $var contiene una hora correcta en formato " hh:mm:ss".<br>
 * Tenemos 2 varibales:
 * $var --> En el cual vamos a meterle un string con la hora que vamos a comprobar.<br>
 * $defecto --> Asigna en $var lo que contenga $defecto
 * La funcion devuelve true si todo sale bien , si no devuelve false
 */

function validaHora(string &$var, string $defecto): bool
{
    $resultado = false;

    $tiempo = explode(":", $var);

    if (count($tiempo) == 3) {

        $hora = filter_var($tiempo[0], FILTER_VALIDATE_INT);
        $min = filter_var($tiempo[1], FILTER_VALIDATE_INT);
        $seg = filter_var($tiempo[2], FILTER_VALIDATE_INT);

        if ($hora !== false && $min !== false && $seg !== false &&
            $hora >= 0 && $hora <= 23 &&
            $min >= 0 && $min <= 59 &&
            $seg >= 0 && $seg <= 59) {

            $var = sprintf('%02d:%02d:%02d', $hora, $min, $seg);
            $resultado = true;
        }
    }

    if (!$resultado) {
        $var = $defecto;
    }

    return $resultado;
}

/**
 * Funcion validaEmail , es una funcion comprueba que $var contenga un email correcto en el formato "aaaaa@bbbb.ccc".<br>
 * Tenemos dos variables:<br>
 * $var --> Donde metemos un string con el email que queremos comprobar<br>
 * $defecto --> Asigna a $var lo que tenga $defecto <br>
 * Devuelve un boolean , true si sale todo bien , por el contrario devuelve false
 */

function validaEmail(string &$var, string $defecto): bool
{
    $resultado = false;

    $email = filter_var($var, FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $var = $email;
        $resultado = true;
    } else {
        $var = $defecto;
        $resultado = false;
    }

    return $resultado;
}

/**
 * Funcion validaCadena, esta funcion comprueba que en $var contenga una cadena de longitud maxima $longitud<br>
 * Tenemos 3 variables:<br>
 * $var --> Es la cadena que queremos comprobar.<br>
 * $longitud --> Es la longitud maxima de la cadena.<br>
 * $defecto --> Es el valor que le vamos a asignar a $var en el caso de que falle.<br>
 * La funcion devuelve un boolean true si todo se cumple, y por lo contrario devuelve false si falla.
 */

function validaCadena(string &$var, int $longitud, string $defecto): bool
{
    $resultado = false;

    $cadena = filter_var($var, FILTER_UNSAFE_RAW);

    if (mb_strlen($cadena, 'UTF-8') <= $longitud) {
        $resultado = true;
    } else {
        $var = $defecto;
        $resultado = false;
    }

    return $resultado;
}

/**
 * Funcion validaExpresion , esta funcion la vamos a utilizar para comprobar si $var cumple la expresion regular que le pongamos en $expresion<br>
 * Tendremos 3 parametros:<br>
 * $var --> Tenemos la cadena a la que queremos comprobar si coincide con la expresion<br>
 * $expresion --> Tenemos la expresion regular con la que vamos a comprobar<br>
 * $defecto --> tenemos un valor por defecto que en caso de fallar se almacenaria en $var
 */

function validaExpresion(string &$var, string $expresion, string $defecto): bool
{
    $resultado = false;

    $cadena = filter_var($var, FILTER_UNSAFE_RAW);

    if (preg_match($expresion, $cadena)) {
        $resultado = true;
    } else {
        $var = $defecto;
        $resultado = false;
    }

    return $resultado;
}

/**
 * Funcion validaRango , esta funcion la vamos a utilizar para comprobar que $var se encentra dentro de algunos de los valores del array $posibles.<br>
 * Tendremos 3 parametros:<br>
 * $var --> Dato que queremos comprobar<br>
 * $posibles --> Array con datos para comprobar el dato de $var<br>
 * $tipo --> 1 : $var tiene que ser igual a uno de los valores del array , 2: $var tiene que ser igual a uno de las claves del array.<br>
 * La funcion devuelve true si dentro del array esta el dato a comprobar , por el contrario devuelve false.
 *
 */

function validaRango(mixed $var, array $posibles, int $tipo = 1): bool
{
    if ($tipo === 1) {

        if (in_array($var, $posibles, true)) {
            return true;
        }

    } elseif ($tipo === 2) {

        if (in_array($var, array_keys($posibles), true)) {
            return true;
        }
    }

    return false;
}
