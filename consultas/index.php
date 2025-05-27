<!doctype html>
<html>
<head>
<meta charset="utf-8">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<link href="css/estilos.css" rel="stylesheet">
<link rel="icon" href="php/img/house.png" type="image/png"
<script src="js/pruebaia.js"></script>
<title>Consultas Jurídica</title>
</head>

<body>
		<div class="container" id="index">
					<?php
					require_once "php/class.php";
					echo nav();
					// Obtener el parámetro de URL para determinar qué página mostrar
					$pagina = isset($_GET['pagina']) ? $_GET['pagina'] : '';
					if ($pagina === '') {
						echo calendario();
						}
					if ($pagina === 'ciiu') {
						echo ciiu();
						}
					if ($pagina === 'unspsc') {
						echo unspsc();
						}
					if ($pagina === 'jccontadores') {
						echo jccontadores();
						}
					if ($pagina === 'rnmc') {
						echo rnmc();
						}
					if ($pagina === 'delitossexuales') {
						echo delitossexuales();
						}
					if ($pagina === 'rues') {
						echo rues();
						} 
					if ($pagina === 'ruaf') {
						echo ruaf();
						} ?>
		</div>
		<?php echo piepag(); ?>
</body>
</html>