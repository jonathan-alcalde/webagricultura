<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <link rel="stylesheet" href="estilos.css">
    </head>
    <body>
        <?php
            include 'lib/misfunciones.php';
            $host = "localhost";
            $user = "root";
            $password = "";
            $bd = "agricultura";
            $usuario = $_SESSION['usuario_valido'];
            $idtrabajo = $_REQUEST['nombretrabajo'];
        ?>
            <form ACTION="resultado.php" method = "POST">
        
        <?php
            $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
            $instruccion = "SELECT * FROM trabajo,usuario WHERE usuario.id_usr = trabajo.id_piloto and usuario.username = '$usuario'
            and trabajo.id_trabajo =  $idtrabajo";
            $consulta = mysqli_query ($conexion, $instruccion)
            or die ("Fallo en la consulta buscar usuario");
            while($fila = mysqli_fetch_array($consulta)){
                echo"Nombre Trabajo: <input class='sinfondo' type='text' name='nombretrabajo' value=".$fila['nombre_Trabajo']."><br>";
                echo"ID PARCELA: <input class='sinfondo' type='text' name='idparcela' value=".$fila['id_parcela']."><br>";
                echo"ID_TAREA: <input class='sinfondo' type='text' name='idtarea' value=".$fila['id_tarea']."><br>";
                echo"ID_PILOTO: <input class='sinfondo' type='text' name='idpiloto' value=".$fila['id_piloto']."><br>";
            }
        ?>
            Dron:<select name="n_dron[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT * FROM usuario, dron WHERE dron.id_usr = usuario.id_usr
                AND usuario.username = '$usuario'";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                ?><option value="<?php echo $fila['id_dron'] ?>"><?php echo $fila['nombre_dron'] ?>
            
            <?php
                }
                mysqli_close($conexion);
                ?>
            </select>
            <br>
                <input type="submit" value="actualizar_trabajo" name="actualizar_trabajo">
            </form>
                <a href="menu.php">Volver al menu </a>
            <?php
                

            if (isset($_POST['actualizar_trabajo'])){
                $drones = $_REQUEST['n_dron'];
                foreach ($drones as $dron){
                    $this_dron = $dron;
                }
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "UPDATE trabajo 
                set id_dron = ".$this_dron."
                where id_trabajo = ".$idtrabajo;
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta actualizar dron");
                mysqli_close($conexion);
            }
            ?>
    </body>
</html>