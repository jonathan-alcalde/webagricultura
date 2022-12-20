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
            function dron_registrado($user,$host,$password,$database,$nombre){
            $conexion = mysqli_connect($host, $user, $password, $database) or die("No se puede conectar a la base de datos");
            $instruccion = "SELECT * FROM dron WHERE nombre_dron = '$nombre'";
            $consulta = mysqli_query ($conexion, $instruccion)
            or die ("Fallo en la consulta buscar dron");
            $nfilas = mysqli_num_rows ($consulta);
            if($nfilas > 0){
                echo "Ya existe un dorn con ese nombre";
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
    
        <h1>Añadir dron</h1>
        <FORM ACTION="gestionDrones.php" method="post">
                Marca: <input type="text" name="marca">
                <br>
                Nombre: <input type="text" name="nombre_dron">
                <br>
                
                <input type="submit" value="Añadir" name="anadir"/>
                <input type="submit" value="cancelar" name="cancelar"/>
                <?php
                echo miretorno($_POST);
            if(isset($_POST['anadir'])){
                $correcto = TRUE;
                
                
                $marca = $_POST['marca'];
                $nombre = $_POST['nombre_dron'];
                
                if($_POST['marca'] == ""){
                $correcto = FALSE;
                echo "Escribe la marca del dron";
                }
                if($_POST['nombre_dron'] == ""){
                $correcto = FALSE;
                echo "Escribe el nombre del dron";
                }
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT id_usr , nombre FROM usuario WHERE username = '$usuario'";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario dron");
                while($fila = mysqli_fetch_array($consulta)){
                    $idusuario =$fila['id_usr'];
                }
                mysqli_close($conexion);
                
                
                $correcto = dron_registrado($user, $host, $password, $bd, $nombre);
                if($correcto == TRUE){
            
                    $conexion = mysqli_connect($host,$user,$password,$bd)
                    or die ("No se puede conectar con el servidor");

                    $instruccion = "insert into dron (nombre_dron,marca_dron,id_usr) values "
                    . "('$nombre','$marca',$idusuario)";

                    $consulta = mysqli_query ($conexion, $instruccion)
                    or die (" ".mysqli_error($conexion)." Fallo en la consulta insertar dron ");
                    mysqli_close ($conexion);  
                }
            }
            ?>
        </form>
        <form action="gestionDrones.php" method="POST">
        <h3>Eliminar Dron</h3>
            Nombre del dron: <select name="n_dron[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT id_dron , nombre_dron FROM dron, usuario WHERE usuario.id_usr = dron.id_usr AND ". 
                "nombre = '$usuario'";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                    ?><option value="<?php echo $fila['id_dron']; ?>"><?php echo $fila['nombre_dron']; ?>
            
        <?php
                }
                mysqli_close($conexion);
                ?>
                <input type='submit' name='borrar' value='borrar'>
                <?php
                    if(isset($_REQUEST['borrar'])){
                        $id_dron = $_REQUEST['n_dron'];
                foreach ($id_dron as $dron)
                $this_dron = $dron;

                $conexion = mysqli_connect($host,$user,$password,$bd)
                or die ("No se puede conectar con el servidor");
                    
                $instruccion = "delete from dron WHERE id_dron = $this_dron";
        
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta borrar dron");
                mysqli_close ($conexion); 
                    }
                ?>
            </select>
        <form>
        <br>
                <a href="menu.php">Volver al menu </a>
    </body>
</html>