<?php
        session_start();

        $host = "localhost";
        $user = "root";
        $password = "";
        $bd = "agricultura";

        $usuario= $_SESSION['usuario_valido'];
        $_SESSION['usuario_valido'] = $usuario;

        if(isset($_REQUEST['salir'])){
            header("location:menu.php");
        }

        if(isset($_POST['AsignarRol'])){
            $id_usuario = $_REQUEST['n_usuario'];
            $id_rol = $_REQUEST['rol'];
            foreach ($id_usuario as $usuario)
            $this_usuario = $usuario;
            
            foreach ($id_rol as $rol)
            $this_rol = $rol;
            $conexion = mysqli_connect($host,$user,$password,$bd)
            or die ("No se puede conectar con el servidor");
                
            $instruccion = "insert into usuario_rol (id_usr, id_rol) values "
            . "($this_usuario, $this_rol)";
    
            $consulta = mysqli_query ($conexion, $instruccion)
            or die ("Fallo en la consulta insertar usuario-rol");
            mysqli_close ($conexion); 
            
            }
        

            if(isset($_POST['borrar'])){
                $id_usuario = $_REQUEST['n_usuario'];
                foreach ($id_usuario as $usuario)
                $this_usuario = $usuario;

                $conexion = mysqli_connect($host,$user,$password,$bd)
                or die ("No se puede conectar con el servidor");
                    
                $instruccion = "delete from usuario WHERE id_usr = $this_usuario";
        
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta eliminar usuario");
                mysqli_close ($conexion); 
                    /////   /////////////////////
                $conexion = mysqli_connect($host,$user,$password,$bd)
                or die ("No se puede conectar con el servidor");
                    
                $instruccion = "delete from dron WHERE id_usr = $this_usuario";
        
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo al eliminar los drones del usuario");
                mysqli_close ($conexion); 
                
                $conexion = mysqli_connect($host,$user,$password,$bd)
                or die ("No se puede conectar con el servidor");
                    
                $instruccion = "delete from parcelas WHERE id_usr = $this_usuario";
        
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo al eliminar las parcelas del usuario");
                mysqli_close ($conexion); 
            }


?>
<form action="gestionUsuarioRoles.php" method="POST">
    <h3>Borrar Usuario:</h3>
    Usuario:<select name="n_usuario[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT id_usr , nombre FROM usuario WHERE username != '$usuario'";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                ?><option value="<?php echo $fila['id_usr'] ?>"><?php echo $fila['nombre'] ?>
            
            <?php
                }
                mysqli_close($conexion);
                ?>
    </select>
    </label>
    <input type="submit" value="borrar" name="borrar">
    <input type="submit" value="cancelar" name="cancelar">
</form>

<form action="gestionUsuarioRoles.php" method="POST">
            <h3>Asignar Roles a Usuario</h3>
            Nombre del Usuario: <select name="n_usuario[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT id_usr , nombre FROM usuario";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                    ?><option value="<?php echo $fila['id_usr'] ?>"><?php echo $fila['nombre'] ?>
            
            <?php
                }
                mysqli_close($conexion);
                ?>
            </select>
            Rol propuesto:<select name="rol[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT * FROM roles";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                ?><option value="<?php echo $fila['id_rol'] ?>"><?php echo $fila['nombre_rol'] ?>
        <?php
        }
        mysqli_close($conexion);
        ?>
        </select>
    <input type="submit" value="Asignar Rol" name="AsignarRol">
    <input type="submit" value="cancelar" name="cancelar">
</form>
<form action="gestionUsuarioRoles.php" method="POST">
            <h3>Eliminar Roles a Usuario</h3>
            Nombre del Usuario: <select name="n_usuario[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT id_usr , nombre FROM usuario";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                    ?><option value="<?php echo $fila['id_usr'] ?>"><?php echo $fila['nombre'] ?>
            
            <?php
                }
                mysqli_close($conexion);
                ?>
            </select>
            Rol que se quiere eliminar:<select name="rol[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT * FROM roles";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                ?><option value="<?php echo $fila['id_rol'] ?>"><?php echo $fila['nombre_rol'] ?>
        <?php
        }
        mysqli_close($conexion);
        ?>
        </select>
    <input type="submit" value="Eliminar Rol" name="eliminarrol">
    <input type="submit" value="cancelar" name="cancelar">
</form>

<FORM ACTION='menu.php' method='post'>
    <input type='submit' value='salir'>
</FORM>