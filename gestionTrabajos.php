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
        $arrayParcelas = getParcelas();
        $arrayTareas = getTareas();
        $arrayPilotos = getPilotoFromIdRol(2);
        $id_parce = 1;
        $id_task = 1;
        $id_pilot = 1;

        $usuario = $_SESSION['usuario_valido'];
        $host = "localhost";
        $user = "root";
        $password = "";
        $bd = "agricultura";
        ?>   
<<<<<<< HEAD
    
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
=======

        <h1>Añadir Trabajo</h1>
        <FORM ACTION="gestionTrabajos.php" method="post">
            <label>Parcela:</label>
            <select name="parce">
                <?php
                $id_parce = $parcela['id_parcela'];
                foreach ($arrayParcelas as $parcela) {
                    echo "<option value='" . $parcela['id_parcela'] . "' selected>" . $parcela['municipio'] . ", " . $parcela['provincia'] . " </option>";
                }
                ?>
            </select>
            <br>
            <label>Tareas :</label>
            <select name="tareas">
                <?php
                if (count($arrayParcelas) == 0) {
                    echo "No hay parcelas";
                }
                foreach ($arrayTareas as $tarea) {
                    echo "<option value='" . $tarea['id_tarea'] . "' selected>" . $tarea['nombre_tarea'] . " </option>";
                }
                ?>
            </select>
            <br>
            <label>Pilotos: </label>
            <select name="pilotos">
                <?php
                foreach ($arrayPilotos as $pilotoMacQueen) {
                    echo "<option value='" . $pilotoMacQueen['id_usr'] . "' selected>" . $pilotoMacQueen['nombre'] . " </option>";
                }
                ?>
            </select>
            <br>

            <br>
            <input type="submit" value="Añadir" name="anadir"/>
            <input type="submit" value="cancelar" name="cancelar"/>
            <br>
        </form>
        <?php
        if (isset($_POST['anadir'])) {
            global $arrayParcelas, $arrayPilotos, $arrayTareas;
            global $id_parce, $id_task, $id_pilot;
            if (count($arrayParcelas) == 0) {
                echo "No hay parcelas disponibles";
                $id_parce = 1;
            } else {
                $id_parce = $_POST['parcelas'];
            }
            if (count($arrayTareas) == 0) {
                echo "No hay tareas disponibles";
                $id_task = 1;
            } else {
                $id_task = $_POST['tareas'];
            }
            if (count($arrayPilotos) == 0) {
                echo "No hay pilotos disponibles";
                $id_pilot = 1;
            } else {
                $id_pilot = 5;//$_POST['pilotos'];
            }







            $conexion = mysqli_connect($host, $user, $password, $bd)
                    or die("No se puede conectar con el servidor");

            $instruccion = "insert into trabajo (id_parcela,id_tarea,id_piloto) values "
                    . "($id_parce,$id_task,$id_pilot)";
            echo $instruccion;

            $consulta = mysqli_query($conexion, $instruccion)
                    or die(" " . mysqli_error($conexion) . " Fallo en la consulta insertar dron ");
            mysqli_close($conexion);
            header('location:menu.php');
        }
        ?>

        <a href="menu.php">Volver al menu </a>
>>>>>>> 0afbfd229b230539f22a3e7c4e94fbdba6b6cf19
    </body>
</html>*/