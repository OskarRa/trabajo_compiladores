<?php
    include "../conexion_be.php";

    if (!empty($_POST)) {

        if($_POST['id'] == 1){
            header('Location: lista_usuario.php');
            exit;
        }
        $idusuario = $_POST['idusuario'];

       // $query_delete = mysqli_query($conexion, "DELETE FROM usuarios WHERE id = $idusuario");
        $query_delete = mysqli_query($conexion, "UPDATE usuarios SET estatus = 0 WHERE id = $idusuario");


        if ($query_delete) {
            header('Location: lista_usuario.php');
            exit;
        } else {
            echo "Error al eliminar el usuario.";
        }
    }

    if (empty($_REQUEST['id']) || $_REQUEST['id'] == 1) {
        header("Location: lista_usuario.php");
        exit;
    }

    $id_usuario_eliminar = $_REQUEST['id'];

    $query = mysqli_query($conexion, "SELECT u.nombre_completo, u.usuario, r.id_r
                                        FROM usuarios u
                                        INNER JOIN roles r ON u.id_rol = r.id_r
                                        WHERE u.id = $id_usuario_eliminar");

    $result = mysqli_num_rows($query);

    if ($result > 0) {
        $data = mysqli_fetch_assoc($query);
        $nombre_completo = $data['nombre_completo'];
        $usuario = $data['usuario'];
        $id_rol = $data['id_r'];
    } else {
        header("Location: lista_usuario.php");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include "includes/script.php"; ?>
    <title>Eliminar Usuario</title>
</head>
<body>
    <?php include "includes/header.php"; ?>
    <section id="container">
        <div class="data_delete">
            <h2>¿Estás seguro de eliminar el siguiente usuario?</h2>
            <p>Nombre: <span><?php echo $nombre_completo; ?></span></p>
            <p>Usuario: <span><?php echo $usuario; ?></span></p>
            <p>Rol: <span><?php if ($id_rol == 1){ echo "Administrador";} else{ echo "Cliente";}; ?></span></p>

            <form method="POST">
                <input type="hidden" name="idusuario" value="<?php echo $id_usuario_eliminar; ?>">
                <a href="lista_usuario.php" class="btn_cancel">Cancelar</a>
                <input type="submit" value="Aceptar xd" class="btn_ok">
            </form>
        </div>
    </section>

    <?php include "includes/footer.php"; ?>
</body>
</html>
