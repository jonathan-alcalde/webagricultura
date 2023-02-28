<?php
    function getData(){
        return json_encode(file_get_contents(__DIR__.'/'),true);
    }

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

function trabajo_registrado($user, $host, $password, $database, $nparcela) {
    $conexion = mysqli_connect($host, $user, $password, $database) or die("No se puede conectar a la base de datos");

    $instruccion = "SELECT * FROM parcelas WHERE nparcela = '$nparcela'";
    $consulta = mysqli_query($conexion, $instruccion)
            or die("Fallo en la consulta buscar dron");
    $nfilas = mysqli_num_rows($consulta);
    if ($nfilas > 0) {
        echo "Ya existe una parcela con ese número";
        mysqli_close($conexion);
        return FALSE;
    } else {
        mysqli_close($conexion);
        return TRUE;
    }
}

function getParcelas() {
    $array = array();
    $conexion = conexion();
    $instruccion1 = "select * from parcelas";
    $resultado = mysqli_query($conexion, $instruccion1);
    while ($fila = mysqli_fetch_array($resultado)) {
        array_push($array, $fila);
    }
    mysqli_close($conexion);
    return $array;
}
function getTareas() {
    $array = array();
    $conexion = conexion();
    $instruccion1 = "select * from tarea";
    $resultado = mysqli_query($conexion, $instruccion1);
    while ($fila = mysqli_fetch_array($resultado)) {
        array_push($array, $fila);
    }
    mysqli_close($conexion);
    return $array;
}
function getPilotoFromIdRol($idRol) {
    $array = array();
    $conexion = conexion();
    $instruccion1 = "SELECT usuario.nombre FROM usuario
                    INNER JOIN usuario_rol
                    ON usuario.id_usr = usuario_rol.id_usr 
                    WHERE usuario_rol.id_rol=$idRol;";
    echo $instruccion1;
    $resultado = mysqli_query($conexion, $instruccion1);
    while ($fila = mysqli_fetch_array($resultado)) {
        array_push($array, $fila);
    }
    mysqli_close($conexion);
    return $array;
}

?>
