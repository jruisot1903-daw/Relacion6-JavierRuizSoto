<?php   

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
{  // creamos un array con los valores maximos y los minimos , para comprobar posteriormente si el numero esta entre ellos 
    $option = array(
        'options' => array(
            'min_range' => $min,
            'max_range' => $max,
        )
    );

    if(filter_var($var, FILTER_VALIDATE_INT,$option) !== FALSE){
        return true;
    }else {
        $var = $defecto;
        return false;
    }
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
    $option = array(
        'options' => array(
            'min_range' => $min,
            'max_range' => $max,
        )
    );

    if(filter_var($var, FILTER_VALIDATE_FLOAT,$option) !== FALSE){
        return true;
    }else {
        $var = $defecto;
        return false;
    }

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
    // Separar la fecha por "/"
    $fec = mb_split("/", $var);

    // Validar que tenga exactamente 3 partes
    if (count($fec) == 3) {
        $dia = (int)$fec[0];
        $mes = (int)$fec[1];
        $anio = (int)$fec[2];

        // Verificar si la fecha es válida
        if (checkdate($mes, $dia, $anio)) {
            // sprintf lo utilizamos para darle formato en la salida de la fecha
            $var = sprintf("%02d/%02d/%04d", $dia, $mes, $anio);
            return true;
        }
    }
    $var = $defecto;
    return false;
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
    $tiempo = mb_split(":", $var);

    if (count($tiempo) === 3) {
        $hora = (int) $tiempo[0];
        $min = (int) $tiempo[1];
        $seg = (int) $tiempo[2];

        if (
            $hora >= 0 && $hora <= 23 &&
            $min >= 0 && $min <= 59 &&
            $seg >= 0 && $seg <= 59
        ) {
            //sprintf lo utilizamos para formatear la salida de la hora 
            $var = sprintf('%02d:%02d:%02d', $hora, $min, $seg);
            return true;
        }
    }
    $var = $defecto;
    return false;
}

/**
 * Funcion validaEmail , es una funcion comprueba que $var contenga un email correcto en el formato "aaaaa@bbbb.ccc".<br>
 * Tenemos dos variables:<br>
 * $var --> Donde metemos un string con el email que queremos comprobar<br>
 * $defecto --> Asigna a $var lo que tenga $defecto <br>
 * Devuelve un boolean , true si sale todo bien , por el contrario devuelve false
 */

function validaEmail(string &$var, string $defecto): bool{

    if(filter_var($var,FILTER_VALIDATE_EMAIL)){
        return true;
    }else{
        $var = $defecto;
        return false;
    }
}

/**
 * Funcion validaCadena, esta funcion comprueba que en $var contenga una cadena de longitud maxima $longitud<br>
 * Tenemos 3 variables:<br>
 * $var --> Es la cadena que queremos comprobar.<br>
 * $longitud --> Es la longitud maxima de la cadena.<br>
 * $defecto --> Es el valor que le vamos a asignar a $var en el caso de que falle.<br>
 * La funcion devuelve un boolean true si todo se cumple, y por lo contrario devuelve false si falla.
 */

function validaCadena(string &$var, int $long, string $defecto): bool
{
    if (strlen($var) <= $long) {
        return true;
    } else {
        $var = $defecto;
        return false;
    }
}

/**
 * Funcion validaExpresion , esta funcion la vamos a utilizar para comprobar si $var cumple la expresion regular que le pongamos en $expresion<br>
 * Tendremos 3 parametros:<br>
 * $var --> Tenemos la cadena a la que queremos comprobar si coincide con la expresion<br>
 * $expresion --> Tenemos la expresion regular con la que vamos a comprobar<br>
 * $defecto --> tenemos un valor por defecto que en caso de fallar se almacenaria en $var
 */

function validaExpresion(string &$var, string $expresion, string $defecto) {
    
    $opciones = [
        "options" => [
            "regexp" => $expresion
        ]
    ];


    if(filter_var($var,FILTER_VALIDATE_REGEXP,$opciones)){
        return true;
    }else{
        $var = $defecto;
        return false;
    }
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

function validaRango(mixed $var, array $posibles, int $tipo = 1): bool {
    if ($tipo === 1) {
        // Compara con los valores del array
        foreach ($posibles as $valor) {
            if ($valor === $var) {
                return true;
            }
        }
    } elseif ($tipo === 2) {
        // Compara con las claves del array
        foreach (array_keys($posibles) as $clave) {
            if ($clave === $var) {
                return true;
            }
        }
    }

    return false;
}