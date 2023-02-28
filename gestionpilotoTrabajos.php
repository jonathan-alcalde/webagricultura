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
            include 'lib/misfunciones.php';
            function trabajo_registrado($user,$host,$password,$database,$nparcela){
            $conexion = mysqli_connect($host, $user, $password, $database) or die("No se puede conectar a la base de datos");
            $instruccion = "SELECT * FROM parcelas WHERE nparcela = '$nparcela'";
            $consulta = mysqli_query ($conexion, $instruccion)
            or die ("Fallo en la consulta buscar dron");
            $nfilas = mysqli_num_rows ($consulta);
            if($nfilas > 0){
                echo "Ya existe una parcela con ese número";
                mysqli_close ($conexion);
                return FALSE;
            }
            else{
                mysqli_close ($conexion);
                return TRUE;
            }
            }
            $usuario = $_SESSION['usuario_valido'];
            $host = "localhost";
            $user = "root";
            $password = "";
            $bd = "agricultura" ;
            
        ?>   
    
        <h1>Actualizar Trabajo</h1>
        <FORM ACTION="resultado.php" method="post">
        <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT * FROM usuario , trabajo WHERE usuario.id_usr = trabajo.id_piloto ".
                "AND username = '$usuario'";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                    echo"<input type='submit' value=".$fila['id_trabajo']." name=nombretrabajo>".$fila['nombre_Trabajo']."</button><br>";
                }
                mysqli_close($conexion);
                ?>
        </FORM>
                <a href="menu.php">Volver al menu </a>
    </body>
</html>