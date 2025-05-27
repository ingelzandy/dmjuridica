<!doctype html>
<html><head>
<meta charset="utf-8">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="bootstrap/js/jquery-3.6.0.min.js"></script>
<link href="css/estilos.css" rel="stylesheet">
<link rel="icon" href="php/img/house.png" type="image/png">
<title>Jurídica</title>
<?php require_once "php/class.php"; ?>
</head>

<body>
<?php
date_default_timezone_set('America/Bogota');
echo nav();
echo inicio();
echo piepag(); 
?>
</body>
</html>