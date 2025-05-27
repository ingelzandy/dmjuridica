<?php
session_start();

// Verifica si hay una sesión activa
if (!isset($_SESSION['usuario']) || !isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

include_once "php/conn.php";
global $conn;

$user_id = $_SESSION['user_id'];

// Consultar el rol del usuario desde la base de datos
$sqlrol = "SELECT rol FROM users WHERE iduser = ?";
if ($stmt = $conn->prepare($sqlrol)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $rol = $row['rol'];

        // Verifica si el usuario no tiene rol 1
        if ($rol != 1) {
            header("Location: index.php");
            exit;
        }
    } else {
        // Usuario no encontrado, redirigir
        header("Location: index.php");
        exit;
    }
} else {
    // Error en la consulta
    die("Error al preparar la consulta");
}

// Si hay sesión, el resto de la página se carga normalmente
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="css/estilos.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa; /* Gris claro de Bootstrap */
    }
  </style>
  <title>Registro de Usuario</title>
</head>
<body>

<div class="container mt-5">
  <div class="row justify-content-center">
	
    <div class="col-md-6">
      <div class="card">
        <div class="card-header">
          <h3 class="text-center">Registro de Usuario</h3>
        </div>
        <div class="card-body">
		  <form class="table-responsive" action="php/consultas.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
              <label for="nombre">Nombre:</label>
              <input type="text" class="form-control" name="nombre" placeholder="Ingrese su nombre" required>
            </div>
            <div class="form-group">
              <label for="contrasena">Contraseña:</label>
              <input type="password" class="form-control" name="password" placeholder="Ingrese su contraseña" required>
            </div>
			<div class="form-group">
				<label for="rol">Rol</label>
				<select class="form-control" name="idrol" required>
				<option value="" disabled selected>Seleccionar rol</option>
				<?php
				// Parámetros de conexión
				include_once "php/conn.php";
				global $conn; // Acceder a la variable $conn dentro de la función
				$traerrol = "SELECT * FROM rol";
				$resultrol = $conn->query($traerrol);

				if ($resultrol->num_rows > 0) {
					while ($obtrol = $resultrol->fetch_assoc()) {
						$idrol = htmlspecialchars($obtrol['idrol']);  // Escapando el id
						$rol = htmlspecialchars($obtrol['rol']);  // Escapando el número de proceso

						echo "<option name='idrol' value=\"$idrol\">" . $rol . "</option>";  // Estableciendo el idproc como valor
					}
				}
				?>
			</select><br>
			</div>
            <button type="submit" class="btn btn-primary btn-block" name="reguser">Registrar</button>
			<a href="index.php" class="btn btn-primary btn-block">Volver</a>
          </form>
        </div>
      </div>
	</div>
	<div class="col-md-6">
		<div class="card">
			<div class="card-header text-info">
			  <h3 class="text-center">Usuarios Registrados</h3>
			</div>
			<div class="card-body" style="max-height: 500px; overflow-y: auto;">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Nombre</th>
							<th>Contraseña</th>
							<th>Opción</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$traeruser = "SELECT * FROM users";
						$resultuser = $conn->query($traeruser);
						if ($resultuser->num_rows > 0){
							while ($obtuser = $resultuser->fetch_assoc()){
								$iduser = htmlspecialchars($obtuser['iduser']);
								$user = htmlspecialchars($obtuser['user']);
								echo "<form action='php/consultas.php' method='POST'>";
								echo "<input type='hidden' name='iduser' value='" . $iduser . "'>";
								echo "<tr>";
								echo "<td><input name='nomuser' class='form-control' value='" . htmlspecialchars($user, ENT_QUOTES, 'UTF-8') . "' required></td>";
								echo "<td><input name='pass' type='text' class='form-control' placeholder='Cambiar Contraseña'></td>";
								echo "<td><input type='submit' name='moduser' class='form-control' value='Cambiar'></td>";
								echo "</tr>";
								echo "</form>";
							}
						}
						
						
						?>
					</tbody>
				</table>
			</div>
		</div>
		  
	</div>
  </div>
</div>

</body>
</html>