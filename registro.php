<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
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
    
        <h1>ALTA DE USUARIOS</h1>
        <FORM ACTION="registro.php" method="post">
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
                <input type="submit" value="Añadir" name="anadir"/>
                <input type="submit" value="cancelar" name="cancelar"/>
                <?php
                echo miretorno($_POST);
            if(isset($_POST['anadir'])){
                $correcto = TRUE;
                
                
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
                if($_POST['contrasena'] == ""){
                $correcto = FALSE;
                echo "Escribe una contraseña";
                }
                if($_POST['email'] == ""){
                $correcto = FALSE;
                echo "Escribe un correo electrónico";
                }
                if($_POST['dni'] == ""){
                $correcto = FALSE;
                echo "Escribe tu DNI";
                }
                
                
                $correcto = registrado($user, $host, $password, $bd, $usuario, $contrasena);
                if($correcto == TRUE){
            
                    $conexion = mysqli_connect($host,$user,$password,$bd)
                    or die ("No se puede conectar con el servidor");

                    $instruccion = "insert into usuario (username,nombre,apellidos,dni,email,contrasena) values "
                    . "('$usuario','$nombre','$apellidos','$dni','$email','$contrasena')";

                    $consulta = mysqli_query ($conexion, $instruccion)
                    or die (" ".mysqli_error($conexion)." Fallo en la consulta insertar usuario ");
                    mysqli_close ($conexion); 
                    
                    $conexion = mysqli_connect($host,$user,$password,$bd)
                    or die ("No se puede conectar con el servidor");

                    $instruccion = "SELECT * FROM usuario WHERE username = '$usuario'"
                    or die("");
                    $consulta = mysqli_query ($conexion, $instruccion)
                    or die (" ".mysqli_error($conexion));
                    while($fila = mysqli_fetch_array($consulta)){
                        $this_id = $fila['id_usr'];
                        $this_id = intval($this_id,$base = 10);
                        $instruccion = "insert into usuario_rol (id_usr,id_rol) values ".
                        "($this_id,2)";

                    $consulta = mysqli_query ($conexion, $instruccion)
                    or die (" ".mysqli_error($conexion)." Fallo en la consulta insertar rol usuario ");
                    mysqli_close ($conexion); 
                    
                    }
                    mysqli_close ($conexion); 
                }
            }
            ?>
        </form>
                <a href="index.php">Inicio</a>
    </body>
</html>