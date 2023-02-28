<?php

function conexion() {

    // credenciales del usuario

    $host = "localhost";
    $user = "root";
    $password = "";
    $bd = "agricultura";

    $conexion = mysqli_connect($host, $user, $password, $bd)
            or die("No se puede conectar con el servidor");
    return $conexion;
}

function addCoordenadas($longitud,$latitud) {
    $conexion = conexion();
    $correcto = true;
    //Primero hacemos la insercion de la tabla carrera 
    $instruccion1 = "insert into ruta (latitud,longitud) values ($latitud,$longitud)";
    if (@mysqli_query($conexion, $instruccion1)) {
        
    } else {
        $correcto = false;
    }

    mysqli_close($conexion);
    return $correcto;
}

?>