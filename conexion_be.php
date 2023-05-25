<?php
    $host = 'localhost';
    $usuario = 'root';
    $contrasena = '';
    $nombre_bd = 'login_register_db';

    $conexion = mysqli_connect($host, $usuario, $contrasena, $nombre_bd);

    if (!$conexion) {
        die('No se pudo conectar a la base de datos: ' . mysqli_connect_error());
    }
?>
