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
        $host = "localhost";
        $user = "root";
        $password = "";
        $bd = "agricultura";

        $mostrado_drones = false;
        $mostrado_usuarios = false;
        $mostrado_parcelas = false;
        
        if(isset($_REQUEST['salir'])){
            exit();
            session_destroy();
            header("location:index.php");
        }
        $usuario= $_SESSION['usuario_valido'];
        $_SESSION['usuario_valido'] = $usuario;

        if(isset($_REQUEST['salir'])){
            header("location:index.php");
        }
        else if(isset($_REQUEST['gestiondron'])){
            $_SESSION['usuario_valido'] = $usuario;
            header("location:gestionDrones.php") or die('died');
        }
        else if(isset($_REQUEST['gestionparcelas'])){
            $_SESSION['usuario_valido'] = $usuario;
            header("location:gestionParcelas.php") or die('died');
        }
        else if(isset($_REQUEST['gestiontrabajos'])){
            $_SESSION['usuario_valido'] = $usuario;
            header("location:gestionTrabajos.php") or die('died');
        }
        else if(isset($_REQUEST['gestiontrabajodron'])){
            $_SESSION['usuario_valido'] = $usuario;
            header("location:gestionpilotoTrabajos.php") or die('died');
        }
        else if(isset($_REQUEST['gestionrolusuario'])){
            $_SESSION['usuario_valido'] = $usuario;
            header("location:gestionUsuarioRoles.php") or die('died');
        }
        else if(isset($_REQUEST['gestionusuario'])){
            $_SESSION['usuario_valido'] = $usuario;
            header("location:gestionUsuario.php") or die('died');
        }
            
        if (isset($_SESSION['usuario_valido']))
        {
            echo"<h1>Bienvenido ".$usuario."</h1>";
            $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
            $instruccion = "SELECT * FROM usuario,usuario_rol WHERE usuario.id_usr = usuario_rol.id_usr AND username = '$usuario'";
            $consulta = mysqli_query ($conexion, $instruccion)
            or die ("Fallo en la consulta buscar usuario");
            while($fila = mysqli_fetch_array($consulta)){
                if($mostrado_drones == FALSE && $fila['id_rol'] == 1 || $mostrado_drones == FALSE && $fila['id_rol'] == 3){
                $mostrado_drones = TRUE;
                ?>
                        <FORM ACTION='menu.php' method='post'>
                            <input type='submit' name=gestiondron value='GESTIÓN DE DRONES'>
                        </FORM>
                        
                        <FORM ACTION='menu.php' method='post'>
                            <input type='submit' name=gestiontrabajodron value='VER TRABAJOS'>
                        </FORM>
                    <?php
                }
<<<<<<< HEAD
                if($mostrado_parcelas == FALSE && $fila['id_rol'] == 2 || $mostrado_parcelas == FALSE && $fila['id_rol'] == 1){
=======

                if($mostrado_parcelas == FALSE && $fila['id_rol'] == 2 || $mostrado_parcelas == FALSE && $fila['id_rol'] == 1 && $fila['id_rol'] == 3){
>>>>>>> 0afbfd229b230539f22a3e7c4e94fbdba6b6cf19
                    $mostrado_parcelas = TRUE;
                    ?>
                        <FORM ACTION='menu.php' method='post'>
                            <input type='submit' name=gestionparcelas value='GESTIÓN DE PARCELAS'>
                        </FORM>

                        <FORM ACTION='menu.php' method='post'>
                            <input type='submit' name=gestiontrabajos value='AÑADIR TRABAJOS'>
                        </FORM>
                    <?php
                }
                if($mostrado_usuarios == FALSE && $fila['id_rol'] == 1){
                    $mostrado_usuarios = TRUE;
                    ?>
                        <FORM ACTION='menu.php' method='post'>
                            <input type='submit' name=gestionrolusuario value='GESTION_DE_ROLES_USUARIOS'>
                        </FORM>
                    <?php
                }
            }

        ?>
            <FORM ACTION='menu.php' method='post'>
                            <input type='submit' name=gestionusuario value='GESTIÓN_DE_USUARIO'>
            </FORM>

            <FORM ACTION='index.php' method='post'>
                <input type='submit' value='salir'>
            </FORM>
            <?php
        }
        else{
            print'<h1>NO TIENES ACCESO</h1>';
            ?>
            <FORM ACTION='menu.php' method='post'>
                <input type='submit' name="salir" value='salir'>
            </FORM>
            <?php
            
        }
        ?>
    </body>
</html>