//**<?php
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
    
        <h1>Añadir Trabajo</h1>
        <FORM ACTION="gestionTrabajos.php" method="post">
        
            Nombre Trabajo:<input type="text" value="" name="nombret"/>
            <br>
            Parcela: <select name="n_parcela[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT * FROM usuario , parcelas WHERE usuario.id_usr = parcelas.id_usr ".
                "AND username = '$usuario'";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                    ?><option value="<?php echo $fila['id_parcela'] ?>"><?php echo $fila['nparcela'] ?>
            
            <?php
                }
                mysqli_close($conexion);
                ?>
            </select>
            
            <br>
            Tarea:<select name="tarea[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT * FROM tarea";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                ?><option value="<?php echo $fila['id_tarea'] ?>"><?php echo $fila['nombre_tarea'] ?>
        <?php
        }
        mysqli_close($conexion);
        ?>
        </select>
        <br>
        Piloto:<select name="piloto[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT * FROM usuario,usuario_rol,roles WHERE usuario.id_usr = usuario_rol.id_usr ".
                "AND roles.id_rol = usuario_rol.id_rol AND nombre_rol = 'piloto'";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                ?><option value="<?php echo $fila['id_usr'] ?>"><?php echo $fila['username'] ?>
        <?php
        }
        mysqli_close($conexion);
        ?>
        </select>
        <br>
                <input type="submit" value="Añadir" name="anadir"/>
                <input type="submit" value="cancelar" name="cancelar"/>
                <?php
            if(isset($_POST['anadir'])){
                $correcto = TRUE;
                
                
                $parcelas = $_POST['n_parcela'];
                $tareas = $_POST['tarea'];
                $pilotos = $_POST['piloto'];
                $nombretrabajo = $_POST['nombret'];
                
                foreach ($parcelas as $parcela)
                $this_parcela = $parcela;
            
                foreach ($tareas as $tarea)
                $this_tarea = $tarea;

                foreach ($pilotos as $piloto)
                $this_piloto = $piloto;
                    $conexion = mysqli_connect($host,$user,$password,$bd)
                    or die ("No se puede conectar con el servidor");

                    $instruccion = "insert into trabajo (id_parcela,id_tarea,id_piloto,nombre_Trabajo) values "
                    . "($this_parcela,$this_tarea,$this_piloto,'$nombretrabajo')";

                    $consulta = mysqli_query ($conexion, $instruccion)
                    or die (" ".mysqli_error($conexion)." Fallo en la consulta insertar trabajo ");
                    mysqli_close ($conexion);  
            }
            
            ?>
            </form>
                <a href="menu.php">Volver al menu </a>
    </body>
</html>*/