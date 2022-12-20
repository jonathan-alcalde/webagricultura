<?php
        session_start();

        $host = "localhost";
        $user = "root";
        $password = "";
        $bd = "agricultura";

        $usuario_actual = $_SESSION['usuario_valido'];

        if(isset($_REQUEST['cancelar'])){
            header("location:menu.php");
        }

        if(isset($_POST['actualizar'])){
            
        }


            include 'lib/misfunciones.php';
            function registrado($user,$host,$password,$database,$usuario,$contrasena){
            $conexion = mysqli_connect($host, $user, $password, $database) or die("No se puede conectar a la base de datos");
            $instruccion = "SELECT * FROM usuario WHERE username = '$usuario' AND contrasena = '$contrasena'";
            $consulta = mysqli_query ($conexion, $instruccion)
            or die ("Fallo en la consulta buscar usuario");
            $nfilas = mysqli_num_rows ($consulta);
            if($nfilas > 0){
                echo "El usuario ya existe";
                mysqli_close ($conexion);
                return FALSE;
            }
            else{
                mysqli_close ($conexion);
                return TRUE;
            }
            }
            
            $host = "localhost";
            $user = "root";
            $password = "";
            $bd = "agricultura" ;
            
        ?>   
    
        <h1>ACTUALIZAR USUARIO</h1>
        <FORM ACTION="gestionUsuario.php" method="post">
                Usuario: <input type="text" name="usuario">
                <br>
                DNI: <input type="text" name="dni">
                <br>
                Nombre:
                <input type = "text" name="nombre">
                <br>
                Apellidos:
                <input type = "text" name="apellidos">
                <br>
                Email:
                <input type = "text" name="email">
                <br>
                Contraseña:
                <input type = "text" name="contrasena">
                <br>
                <input type="submit" value="actualizar" name="actualizar"/>
                <input type="submit" value="cancelar" name="cancelar"/>
                <?php
                echo miretorno($_POST);
            if(isset($_POST['anadir'])){
                $correcto = TRUE;
                $string_campos = "(";
                $string_values = "(";
                
                $usuario = $_POST['usuario'];
                $dni = $_POST['dni'];
                $nombre = $_POST['nombre'];
                $apellidos = $_POST['apellidos'];
                $email = $_POST['email'];
                $contrasena = $_POST['contrasena'];
                
                if($_POST['usuario'] == ""){
                $correcto = FALSE;
                echo "Escribe el nombre de usuario";
                }
                else{
                    $string_campos = $string_campos."username";
                    $string_values = $string_values."'$usuario'";
                }

                if($_POST['contrasena'] == ""){
                $correcto = FALSE;
                echo "Escribe una contraseña";
                }
                else{
                    $string_campos = $string_campos."contrasena";
                    $string_values = $string_values."'$contrasena'";
                }

                if($_POST['email'] == ""){
                $correcto = FALSE;
                echo "Escribe un correo electrónico";
                }
                else{
                    $string_campos = $string_campos."email";
                    $string_values = $string_values."'$email'";
                }
                if($_POST['dni'] == ""){
                $correcto = FALSE;
                echo "Escribe tu DNI";
                }else{
                    $string_campos = $string_campos."dni";
                    $string_values = $string_values."'$dni'";
                }
                $string_campos = $string_campos.")";
                $string_values = $string_values."')'";
                $correcto = registrado($user, $host, $password, $bd, $usuario, $contrasena);
                if($correcto == TRUE){
            
                    $conexion = mysqli_connect($host,$user,$password,$bd)
                    or die ("No se puede conectar con el servidor");

                    $instruccion = "UPDATE usuario".$string_campos." values ".$string.values.
                    " WHERE username = '$usuario_actual'";
                    if($_POST['usuario'] != ""){
                        $usuario_actual = $usuario;
                        $_SESSION['usuario_valido'] = $usuario_actual;
                    }
                    
                    $consulta = mysqli_query ($conexion, $instruccion)
                    or die (" ".mysqli_error($conexion)." Fallo en la consulta insertar usuario ");
                    mysqli_close ($conexion);  
                }
            }
            ?>
        </form>

        
