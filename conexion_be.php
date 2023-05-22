<?php
    
    $host = 'localhost';
    $usuario = 'root';
    $contrasena = '';
    $nombre_bd = 'login_register_db';


    $conexion = mysqli_connect($host, $usuario, $contrasena , $nombre_bd); //url, usuario,contraseña, nombre bd

/*    if($conexion)   echo 'Conectado exitosamente a la base de datos';
    else    echo 'No se ah podido conectar a la base de datos';
*/



?>