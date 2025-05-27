
<?php
	$hostname = "localhost";
	$username = "root";
	$password = "";
	$dbname = "juridica";

	// Utilizar una conexión segura mediante el uso de mysqli con la opción "mysqli_report"
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	try {
		$conn = new mysqli($hostname, $username, $password, $dbname);
		$conn->set_charset("utf8mb4"); // Establecer el conjunto de caracteres adecuado

		// Verificar si hay errores en la conexión
		if ($conn->connect_error) {
			die("Database connection error: " . $conn->connect_error);
		}


	} catch (Exception $e) {
		// Manejar cualquier excepción que se produzca al intentar conectar a la base de datos
		die("Database connection error: " . $e->getMessage());
	}


?>