<?php
    session_start();

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
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<?php
		include "includes/script.php";
	?>
	

	<title>Sistema Ventas</title>
</head>
<body>
	<?php include "includes/header.php";?>
	<section id="container">
		<h1>Bienvenido al sistema admin /sistema</h1>
	</section>

	<?php	include "includes/footer.php";?>


</body>
</html>