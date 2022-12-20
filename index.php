<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //echo $_SESSION['usuario_valido'];
        $host = "localhost";
        $user = "root";
        $password = "";
        $bd = "agricultura";
        function registrado($user,$host,$password,$database,$usuario,$contrasena){
            $conexion = mysqli_connect($host, $user, $password, $database) or die("No se puede conectar a la base de datos");
            $instruccion = "SELECT * from usuario WHERE username = '$usuario' AND contrasena = '$contrasena'";
            $consulta = mysqli_query ($conexion, $instruccion)
            or die ("Fallo en la consulta buscar usuario");
            $nfilas = mysqli_num_rows ($consulta);
            if($nfilas > 0){
                mysqli_close ($conexion);
                return TRUE;
            }
            else{
                echo "El usuario no existe";
                mysqli_close ($conexion);
                return FALSE;
            }
        }
        if(isset($_POST['salir'])){
            exit();
            session_destroy();
        }
            if(isset($_REQUEST['entrar'])){
                $usuario = $_POST['usuario'];
                $contrasena = $_POST['contrasena'];
                $correcto = registrado($user, $host, $password, $bd, $usuario, $contrasena);
                if($correcto == TRUE){                    
                    $_SESSION['usuario_valido'] = $usuario;
                    $_SESSION['contrasena_actual'] = $contrasena;
                    header("location:./menu.php");
                }
            }
        ?>
        <h1>APLICACIÓN EXAMEN PRIMERA EVALUACIÓN</h1>
        <form action="index.php" method="POST">
            USUARIO :     <input type="text" name="usuario"/>
                <br>
            CONTRASEÑA :  <input type="password" name="contrasena" >
            
                <br>
                <a href="registro.php">Registrate!!</a><input type="submit" value="entrar" name="entrar"/>
        </form>
    </body>
</html>