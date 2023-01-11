<?php
function conexion(){
    
    // credenciales del usuario
        
        $host = "localhost";
        $user = "root";
        $password = "";
        $bd = "agricultura";
        
        $conexion = mysqli_connect($host, $user, $password,$bd)
                or die ("No se puede conectar con el servidor");
        return $conexion;

        
}

function getIdUsuario ($nombre){
    $conexion = conexion();
    $instruccion1 = "select usuario.username from usuario_rol,usuario where usuario.username= '$nombre'";
    $resultado = mysqli_query($conexion, $instruccion1);
    $fila = mysqli_fetch_array($resultado);
    return $fila['id_usuario']; 
}



function addRolesUsuario($nombre){
    $conexion = conexion(); 
    $correcto = true;
    //Primero hacemos la insercion de la tabla carrera 
    $id_usuario = getIdUsuario($nombre);
    $instruccion1 = "insert into usuario_rol (id_usuario,id_rol) values ('{$id_usuario}',2)";
    if (@mysqli_query ($conexion,$instruccion1)) {
        
    }else{
        $correcto = false;
    }
    
    mysqli_close($conexion);
    return $correcto;
    
}

?>