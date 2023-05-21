<?php
    session_start();
    include 'conexion_be.php';

    $correo     = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $contrasena_encriptada = hash('sha512',$contrasena);

    $validar_login = mysqli_query($conexion, "SELECT * FROM usuarios WHERE 
                    correo = '$correo' and contrasena = '$contrasena_encriptada'");
    
    $filas = mysqli_fetch_array($validar_login);

    if (!is_null($filas) && $filas['id_rol'] == 1){ //administrador

        $_SESSION['usuario'] = $correo;
        header("location: ../admin.php");
        //header("location: ..//menu_admin/admin.php");

    }else if(!is_null($filas) && $filas['id_rol'] == 2){ //cliente

        $_SESSION['usuario'] = $correo;
        header("location: ../cliente.php");
        
    } else{
        echo '
            <script>
                alert("Usuario o contraseña incorrectos 123");
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