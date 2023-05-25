<?php
    session_start();
    include '../conexion_be.php';

    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena_encriptada = hash('sha512', $contrasena);

    $query = "SELECT * FROM usuarios WHERE correo = '$correo' AND contrasena = '$contrasena_encriptada'";
    $resultado = mysqli_query($conexion, $query);

    if (mysqli_num_rows($resultado) > 0) {
        $fila = mysqli_fetch_assoc($resultado);
        $id_rol = $fila['id_rol'];

        $_SESSION['usuario'] = $correo;

        if ($id_rol == 1) {
            header("Location: ../sistema/admin.php");
            exit;
        } elseif ($id_rol == 2) {
            header("Location: ../sistema/cliente.php");
            exit;
        }
    } else {
        echo '
            <script>
                alert("Usuario o contraseña incorrectos");
                window.location = "../index.php";
            </script>
        ';
        exit;
    }



/*
    if(mysqli_num_rows($validar_login) > 0){
        $_SESSION['usuario'] = $correo;
        header("location: ../admin.php");  
        exit;      
    }else{
        echo '
            <script>
                alert("Usuario o contraseña incorrectos");
                window.location = "../index.php";
            </script>
        ';
        exit;           
    }
*/
?>