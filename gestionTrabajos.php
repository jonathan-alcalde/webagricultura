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
    </body>
</html>