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
    
        <h1>Añadir Trabajo-</h1>
        <FORM ACTION="gestionTrabajos.php" method="post">
                Nombre del trabajo: <input type="text" name="nombre_trabajo">
                <br>
                municipio: <input type="text" name="municipio">
                <br>
                provincia: <input type="text" name="provincia">
                <br>
                npoligono: <input type="text" name="npoligono">
                <br>
                Fichero json 
                <INPUT TYPE="hidden" name="max_file_size" value="10240000">
                <input TYPE="file" size="44" name="geojson">
                
                <input type="submit" value="Añadir" name="anadir"/>
                <input type="submit" value="cancelar" name="cancelar"/>
                <?php
            if(isset($_POST['anadir'])){
                $correcto = TRUE;
                
                
                $nparcela = $_POST['nparcela'];
                $municipio = $_POST['municipio'];
                $provincia = $_POST['provincia'];
                $npoligono = $_POST['npoligono'];

                
                if($_POST['nparcela'] == ""){
                $correcto = FALSE;
                echo "Escribe el número de parcela";
                }
                if($_POST['municipio'] == ""){
                $correcto = FALSE;
                echo "Escribe el nombre del municipio";
                }
                if($_POST['npoligono'] == ""){
                    $correcto = FALSE;
                    echo "Escribe el nombre del polígono";
                }
                if($_POST['provincia'] == ""){
                    $correcto = FALSE;
                    echo "<p>Escribe el nombre de la provincia</p>";
                }

                if(is_uploaded_file($_FILES['geojson']['tmp_name']))
                {
                    $nombreDirectorio = "geojson/";
                    $nombreFichero = $_FILES['geojson']['name'];
    
                    $nombreCompleto = $nombreDirectorio . $nombreFichero;
                    if(is_file($nombreCompleto))
                    {
                        $idUnico = time();
                        $nombreFichero  = $idUnico . "-" . $nombreFichero;
                    }
                
    
                move_uploaded_file($_FILES['geojson']['tmp_name'], $nombreDirectorio . $nombreFichero);
                }
                else {
                    print("No se ha podido subir el fichero\n");
                    $correcto = FALSE;
                }
                
                $correcto = parcela_registrada($user, $host, $password, $bd, $nparcela);
                if($correcto == TRUE){
            
                    $conexion = mysqli_connect($host,$user,$password,$bd)
                    or die ("No se puede conectar con el servidor");

                    $instruccion = "insert into parcelas (nparcela,municipio,provincia,npoligono,id_usr) values "
                    . "($nparcela,'$municipio','$provincia',$npoligono,$idusuario)";

                    $consulta = mysqli_query ($conexion, $instruccion)
                    or die (" ".mysqli_error($conexion)." Fallo en la consulta insertar dron ");
                    mysqli_close ($conexion);  
                }
            }
            ?>
        </form>
        <form action="gestionParcelas.php" method="POST">
        <h3>Eliminar Parcela</h3>
            Identificador de parcela: <select name="n_parcela[]">
                <?php
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT id_parcela , nparcela FROM parcelas, usuario WHERE usuario.id_usr = parcelas.id_usr AND ". 
                "nombre = '$usuario'";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario");
                while($fila = mysqli_fetch_array($consulta)){
                    ?><option value="<?php echo $fila['id_parcela']; ?>"><?php echo $fila['nparcela']; ?>
            
        <?php
                }
                mysqli_close($conexion);
                ?>
                <input type='submit' name='borrar' value='borrar'>
                <?php
                    if(isset($_REQUEST['borrar'])){
                        $id_parcela = $_REQUEST['n_parcela'];
                foreach ($id_parcela as $parcela)
                $this_parcela = $dron;

                $conexion = mysqli_connect($host,$user,$password,$bd)
                or die ("No se puede conectar con el servidor");
                    
                $instruccion = "delete from parcelas WHERE id_parcela = $this_parcela";
        
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