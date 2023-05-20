<?php
    session_start();
    include 'conexion_be.php';

    $correo     = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena_encriptada = hash('sha512',$contrasena);

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE 
                    correo = '$correo' and contrasena = '$contrasena_encriptada'");


    if(mysqli_num_rows($validar_login) > 0){
        $_SESSION['usuario'] = $correo;
        header("location: ../bienvenida.php");  
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

?>