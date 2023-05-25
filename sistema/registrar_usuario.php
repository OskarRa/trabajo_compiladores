<?php
    session_start();

    if (!isset($_SESSION['usuario'])) {
        echo '
            <script>
                alert("Por favor inicie sesión");
                window.location = "index.php";
            </script>
        ';
        session_destroy();
        die();
    }

    if (!empty($_POST)) {
        $alert = '';
        $nombre_completo = $_POST['nombre'];
        $correo = $_POST['correo'];
        $usuario = $_POST['usuario'];
        $contrasena = $_POST['contrasena'];
        $rol = $_POST['rol'];

        if (empty($nombre_completo) || empty($correo) || empty($usuario) || empty($contrasena) || empty($rol)) {
            $alert = '<p class="msg_error"> Todos los campos son obligatorios </p>';
            echo '
                <script>
                    alert("Todos los campos son obligatorios");
                </script>
            ';
        } else {
            include '../conexion_be.php';

            $contrasena_encriptada = hash('sha512', $contrasena);

            $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario' OR correo = '$correo'");
            $result = mysqli_fetch_array($query);

            if ($result) {
                $alert = '<p class="msg_error"> El correo o el usuario ya existe</p>';
                echo '
                    <script>
                        alert("El correo o el usuario ya existe");
                    </script>
                ';
            } else {
                $query_insert = mysqli_query($conexion, "INSERT INTO usuarios (nombre_completo, correo, usuario, contrasena, id_rol) 
                    VALUES ('$nombre_completo', '$correo', '$usuario', '$contrasena_encriptada', '$rol')");

                if ($query_insert) {
                    $alert = '<p class="msg_save"> Usuario creado correctamente</p>';
                    echo '
                        <script>
                            alert("Usuario creado correctamente");
                        </script>
                    ';
                } else {
                    $alert = '<p class="msg_error"> Error al crear el usuario</p>';
                    echo '
                        <script>
                            alert("Error al crear el usuario");
                        </script>
                    ';
                }
                mysqli_close($conexion);
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script type="text/javascript" src="sistema/js/function.js"></script>
    <?php include "includes/script.php";?>
    <title>Registro de Usuarios</title>
</head>
<body>
    <?php include "includes/header.php";?>
    <section id="container">
        <div class="form_register">
            <h1>Registro de usuario</h1>
            <hr>
            <div class="alert">
                <?php echo isset($alert) ? $alert : ''; ?>
            </div>
            <form action="" method="POST">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="nombre" placeholder="Nombre completo" required>

                <label for="correo">Correo Electrónico</label>
                <input type="text" name="correo" id="correo" placeholder="Correo electrónico" required>

                <label for="usuario">Usuario</label>
                <input type="text" name="usuario" id="usuario" placeholder="Usuario" required>

                <label for="contrasena">Contraseña</label>
                <input type="password" name="contrasena" id="contrasena" placeholder="Contraseña" required>

                <label for="rol">Tipo de Usuario</label>
                <select name="rol" id="rol" required>
                    <option value="1">Administrador</option>
                    <option value="2">Cliente</option>
                </select>
                <input type="submit" value="Crear Usuario" class="btn_save">
            </form>
        </div>
    </section>
    <?php include "includes/footer.php";?>
</body>
</html>
