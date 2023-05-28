<?php
    session_start();

    include '../conexion_be.php';

    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Porfavor Inicie session");
                window.location = "index.php";
            </script>
        ';
        session_destroy();
        die();
    }

    
    if(!empty($_POST)){
        $alert='';
        if(empty($_POST['nombre']) || empty($_POST['correo']) || empty($_POST['usuario']) 
        || empty($_POST['rol'])){

            $alert ='<p class="msg_error"> Todos los campos son obligatorios </p>';
            echo '
            <script>
                alert("Todos los campos son obligatorios ");
            </script>
        ';
        }else{

            $idUsuario          = $_POST['idUsuario'];

            $nombre_completo    = $_POST['nombre'];
            $correo             = $_POST['correo'];
            $usuario            = $_POST['usuario'];
            $contrasena         = $_POST['contrasena'];
            $rol                = $_POST['rol'];

            $contrasena_encriptada = hash('sha512', $contrasena);

            $query = mysqli_query($conexion,"SELECT * FROM usuarios 
                                            WHERE (usuario = '$usuario' AND id != 30 ) 
                                            OR (correo = '$correo' AND id != 30)");

            $result = mysqli_fetch_array($query);

            
            if($result > 0 ){
                $alert ='<p class="msg_error"> El correo o el usuario ya existe</p>';
                echo '
                <script>
                    alert("El correo o el usuario ya existe");
                </script>
                ';
            } else{

                if(empty($_POST['contraseña'])){

                    $sql_update = mysqli_query($conexion, "UPDATE usuarios
                                                            SET nombre_completo = '$nombre_completo',correo = '$correo',
                                                            usuario = '$usuario', id_rol = '$rol'
                                                            WHERE id = $idUsuario");

                }else{

                    $sql_update = mysqli_query($conexion, "UPDATE usuarios
                                                            SET nombre_completo = '$nombre',correo = '$correo',
                                                            usuario = '$usuario', contrasena = '$contrasena', id_rol = '$rol'
                                                            WHERE id = $idUsuario");

                }


                if($sql_update){
                    $alert='<p class="msg_save"> Usuario actualizado</p>';
                    echo '
                    <script>
                        alert("Usuario actualizado correctamente");
                    </script>
                    ';                    
                }else{
                    $alert='<p class="msg_error"> Error al actualizar el usuario</p>';
                    echo '
                    <script>
                        alert("Erro al actualizar el usuario");
                    </script>
                    ';                    
                }
            }
        }
    }

    //Recuperacion de datos y mostrarlos en actualiza
    if(empty($_GET['id'])){
        echo '
            <script>
                alert("No existe id");
                window.location = "lista_usuario.php"; // no existe id
            </script>
        ';
    }

        $iduser = $_GET['id'];

        $sql = mysqli_query($conexion, "SELECT u.id, u.nombre_completo, u.correo, u.usuario, (u.id_rol) AS id_rol, (r.descripcion) AS roles 
                                        FROM usuarios u 
                                        INNER JOIN roles r 
                                        ON u.id_rol = r.id_r 
                                        WHERE id = $iduser;");

        $result_sql = mysqli_num_rows($sql);
        //validando el resultado
        if($result_sql == 0){
            header('Location: lista_usuario.php');
        }else{

            $option = '';

            while ($data    = mysqli_fetch_array($sql)){
                $iduser     = $data['id'];
                $nombre     = $data['nombre_completo'];
                $correo     = $data['correo'];
                $usuario    = $data['usuario'];
                $id_rol     = $data['id_rol'];
                

                if($id_rol == 1){
                    $option = '<option value="' . $id_rol . '"select>Administrador</option>';
                }else if($id_rol == 2){
                    $option = '<option value="' . $id_rol . '"select>Cliente</option>';
                }

            }
        }


?>




<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
	<script type= "text/javascript" src="sistema/js/function.js"></script>
    <?php include "includes/script.php";?>
	<title>Actualizar Usuarios</title>


</head>
<body>
	<?php include "includes/header.php";?>
	<section id="container">
        <div class="form_register">
            <h1>Actualizar Usuarios</h1>
            <hr>
            <div class="alert">
                <?php echo isset($alert) ? $alert :'' ; ?>
            </div>


            <form action="" method = "POST">

                <input type="hidden" name = "idUsuario" value = "<?php echo $iduser; ?>">

                <label for="nombre">Nombre</label>
                <input type="text" name ="nombre" id="nombre" placeholder= "Nombre completo"  value = "<?php echo $nombre?>">

                <label for="correo">Correo Electronico</label>
                <input type="text" name ="correo" id="correo" placeholder= "Correo electronico" value = "<?php echo $correo?>">

                <label for="usuario">Usuario</label>
                <input type="text" name ="usuario" id="usuario" placeholder= "Usuario" value = "<?php echo $usuario?>">

                <label for="contrasena">contrasena</label>
                <input type="password" name ="contrasena" id="contrasena" placeholder= "Contrasena" >

                <label for="rol">Tipo de Usuario</label>

                <?php
                    $query_rol = mysqli_query($conexion,"SELECT * FROM roles");
                    $result_rol = mysqli_num_rows($query_rol);
                
                ?>

                <select name="rol" id="rol" class = "notItemOne">

                    <?php
                        echo $option;
                        if($result_rol > 0){
                            while($rol = mysqli_fetch_array($query_rol)){
                    ?>  
                        <option value = "<?php echo $rol["id_r"];?>"><?php echo $rol["descripcion"]?></option>    
                    <?php   
                            #code..
                            }
                        }
                    ?>  
                    
                </select>
                <input type="submit" value="Actualizar Usuarios" class="btn_save">

            </form>
        </div>




	</section>

	<?php	include "includes/footer.php";?>
    <?php
        mysqli_close($conexion);
    ?>


</body>
</html>
