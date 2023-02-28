<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script src="./js.js"></script>
        <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
        <link rel="stylesheet" href="./estilos.css">
    </head>
    <body>
        <?php
            include 'lib/misfunciones.php';
            function parcela_registrada($user,$host,$password,$database,$nparcela){
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
    
        <h1>Añadir Parcela-</h1>
        <FORM id = "addparcela" ACTION="gestionParcelas.php" method="post">
                Fichero geojson :
                <INPUT TYPE="hidden" name="max_file_size" value="10240000">
<<<<<<< HEAD
                <input id="geolector" TYPE="file" size="44" name="geojson" accept=".geojson">
                <br>
                nparcela: <input class="sinfondo" id="nparcela" type="text" name="nparcela" readonly=true>
                <br>
                municipio: <input class="sinfondo" id="municipio" type="text" name="municipio" readonly=true>
                <br>
                provincia: <input class="sinfondo" id="provincia" type="text" name="provincia" readonly=true>
                <br>
                npoligono: <input class="sinfondo" id="npoligono" type="text" name="npoligono" readonly=true>
                <br>
                coordenadas: <input class="sinfondo" id="coordenadas" type="text" name="coordenadas" readonly=true>
                <br>
                
=======
                <input TYPE="file" size="44" name="geojson">
                <br>
>>>>>>> 0afbfd229b230539f22a3e7c4e94fbdba6b6cf19
                <input type="submit" value="Añadir" name="anadir"/>
                <input type="submit" value="Cancelar" name="cancelar"/>
                <input type="submit" value="Mostrar Mapa" id="btnMapa" name="mapa"/>
                <?php

            if(isset($_POST['mapa'])){
                header('location:mapa.html');
            }
       

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
                
                $conexion = mysqli_connect($host, $user, $password, $bd) or die("No se puede conectar a la base de datos");
                $instruccion = "SELECT id_usr , nombre FROM usuario WHERE username = '$usuario'";
                $consulta = mysqli_query ($conexion, $instruccion)
                or die ("Fallo en la consulta buscar usuario dron");
                while($fila = mysqli_fetch_array($consulta)){
                    $idusuario =$fila['id_usr'];
                }
                mysqli_close($conexion);

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
                $this_parcela = $parcela;

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