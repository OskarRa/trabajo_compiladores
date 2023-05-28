<?php
    include '../conexion_be.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/script.php"; ?>
    <title>Lista Usuarios</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">

        <?php
            $busqueda = strtolower($_REQUEST['busqueda']);
            if(empty($busqueda)){
                header("location:lista_usuario.php");
                mysqli_close($conexion);
            }
        ?>
        <h1>Buscar de Usuarios</h1>
        <a href="registrar_usuario.php" class="btn_new">Crear Usuario</a>

        <form action="buscar_usuario.php" method="GET" class="form_search">
            <input type="text" name = "busqueda" id="busqueda" placeholder= "Buscar" value="<?php  echo  $busqueda;?>">
            <input type="submit" value="Buscar" class="btn_search">
        </form>

        <table> 
            <tr>
                <th>ID</th>
                <th>NOMBRE</th>
                <th>CORREO</th>
                <th>USUARIO</th>
                <th>ROL</th>
                <th>ACCIONES</th>
            </tr>
            <?php
                //Paginador
                $rol='';
                if($busqueda == 'administrador'){
                    $rol = " OR id_rol LIKE '%1%'";
                }else if($busqueda == 'cliente'){
                    $rol = " OR id_rol LIKE '%2%'";
                }

                $sql_registe = mysqli_query($conexion,"SELECT COUNT(*) as total_registro FROM usuarios 
                                WHERE ( id LIKE '%$busqueda%' OR 
                                nombre_completo LIKE '%$busqueda%' OR 
                                correo LIKE '%$busqueda%' OR 
                                usuario LIKE '%$busqueda%' $rol) AND estatus = 1;");
                $result_register = mysqli_fetch_array($sql_registe);
                $total_registro = $result_register['total_registro'];

                $por_pagina = 1;

                if(empty($_GET['pagina'])){
                    $pagina = 1;
                }else{
                    $pagina = $_GET['pagina'];
                }

                $desde = ($pagina-1) * $por_pagina;
                $total_paginas = ceil($total_registro / $por_pagina);

                $query = "SELECT u.id, u.nombre_completo, u.correo, u.usuario, u.id_rol, r.id_r 
                        FROM usuarios u INNER JOIN roles r ON u.id_rol = r.id_r  
                        WHERE 
                        ( u.id LIKE '%$busqueda%' OR 
                                u.nombre_completo LIKE '%$busqueda%' OR 
                                u.correo LIKE '%$busqueda%' OR 
                                usuario LIKE '%$busqueda%' OR r.id_r LIKE '%$busqueda%')
                        AND
                        estatus = 1
                        ORDER BY id ASC LIMIT $desde,$por_pagina"; //ASC = ASCENDENTE DESC = DESENDENTE


                $result = mysqli_query($conexion, $query);
                mysqli_close($conexion);
                if(mysqli_num_rows($result) > 0) {
                    while($data = mysqli_fetch_array($result)) {
            ?>
            <tr>
                <td><?php echo $data["id"]; ?></td>
                <td><?php echo $data["nombre_completo"]; ?></td>
                <td><?php echo $data["correo"]; ?></td>
                <td><?php echo $data["usuario"]; ?></td>
                <td><?php if($data["id_rol"] == 1){ echo "Administrador";} else { echo "Cliente";}; ?></td>
                <td>
                    <a class="link_edit" href="editar_usuario.php?id=<?php echo $data["id"]; ?>">Editar</a>

                    <?php
                    
                        if($data['id'] != 1){
                    
                    ?>

                    <a class="link_delete" href="eliminar_usuario.php?id=<?php echo $data["id"]; ?>">Eliminar</a>
                    <?php  } ?>
                </td>
            </tr>
            <?php
                    }
                }
            ?>
        </table>


        <div class="paginador">

            <?php
                if($total_paginas != 0){

            ?>
            <ul>

            <?php 
                if($pagina != 1){
            ?>
                <li><a href="?pagina=<?php echo 1; ?>&busqueda=<?php echo $busqueda; ?>">|<</a></li>
                <li><a href="?pagina=<?php echo $pagina-1; ?>&busqueda=<?php echo $busqueda; ?>"><<</a></li>
                <?php
                }
                    for ($i=1; $i <= $total_paginas; $i++){
                        if($i == $pagina){
                            echo '<li class="pageSelected">'.$i.'</li>';
                        }else{
                            echo '<li><a href="?pagina='.$i.'&busqueda='.$busqueda.'">'.$i.'</a></li>';
                        }
                    }
                    if($pagina != $total_paginas){
                ?>
                <li><a href="?pagina=<?php echo $pagina+1; ?>&busqueda=<?php echo $busqueda; ?>">>></a></li>
                <li><a href="?pagina=<?php echo $total_paginas; ?>&busqueda=<?php echo $busqueda; ?>">>|</a></li>
                <?php  }  ?>
            </ul>
        </div>

        <?php
                }
        ?>
    </section>

    <?php include "includes/footer.php"; ?>

</body>
</html>