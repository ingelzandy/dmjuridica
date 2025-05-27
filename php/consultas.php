<?php
// Parámetros de conexión
include_once "conn.php";
global $conn; // Acceder a la variable $conn dentro de la función

if ($_SERVER["REQUEST_METHOD"] == "POST") {
date_default_timezone_set('America/Bogota');
	
	if (isset($_POST['reguser'])){
	include_once "conn.php"; // Incluir archivo de configuración fuera de la función
	global $conn; // Acceder a la variable $conn dentro de la función
	// Recibir datos del formulario
	$idrol = $_POST['idrol'];
	$nombre = mysqli_real_escape_string($conn, $_POST['nombre']);
	$contrasena = mysqli_real_escape_string($conn, $_POST['password']);
	$encrypt_pass = password_hash($contrasena, PASSWORD_BCRYPT);
	
	if (!empty($nombre) && !empty($encrypt_pass)){
		$sql = mysqli_query($conn, "SELECT * FROM users WHERE user = '{$nombre}'");
       
			$insert_query = $conn->prepare("INSERT INTO users (user, password, rol) VALUES (?, ?, ?)");
			$insert_query->bind_param("sss", $nombre, $encrypt_pass, $idrol);
		
		
	if ($insert_query->execute()) {
			$insert_query->close();
			echo "Registro exitoso";
			header("Location: ../registrar.php");
			
		}  else {
		echo "Error al registrar usuario: " . $conn->error;
	}

	}
}
	
if (isset($_POST['login'])) {
    $user = filter_input(INPUT_POST, 'user', FILTER_SANITIZE_STRING);
    $password = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);

    // Preparar la consulta SQL para verificar si el usuario existe
    $sql = "SELECT * FROM users WHERE user = ?";
    if ($stmt = $conn->prepare($sql)) {
        // Enlazar los parámetros y ejecutar la consulta
        $stmt->bind_param('s', $user);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $pass = $row['password'];
         
            // Verificar la contraseña
            if (password_verify($password, $pass)) {
				session_start(); // Inicia la sesión
                session_regenerate_id(true);

                $_SESSION['usuario'] = $row['user']; // Asegúrate de que esta columna existe en tu base de datos
				$_SESSION['user_id'] = $row['iduser']; // Asegúrate de que esta columna existe en tu base de datos
				
				
				
								// Verificamos si el usuario está logueado
				if (isset($_SESSION['usuario'])) {

					// Solo contar si aún no se contó esta sesión
					if (!isset($_SESSION['login_contado'])) {
						$resulLogin = $conn->query("SELECT visitaslogin FROM ingreso WHERE idvisita = 1");
						$filaLogin = $resulLogin->fetch_assoc();
						$contador_login = $filaLogin['visitaslogin'] + 1;

						$conn->query("UPDATE ingreso SET visitaslogin = $contador_login WHERE idvisita = 1");

						// Marcar como contada esta sesión
						$_SESSION['login_contado'] = true;
					} else {
						// Si ya se contó, solo obtenemos el número actual
						$resulLogin = $conn->query("SELECT visitaslogin FROM ingreso WHERE idvisita = 1");
						$filaLogin = $resulLogin->fetch_assoc();
						$contador_login = $filaLogin['visitaslogion'];
					}
				}
				
                // Redirigir a una página de bienvenida o inicio
                header("Location: ../index.php");
                exit;
            } else {
                echo "
                <script>
                    alert('Credenciales incorrectas');
                    window.location.href = '../index.php';
                </script>
                ";
            }
        } else {
            echo "
            <script>
                alert('Credenciales incorrectas');
                window.location.href = '../index.php';
            </script>
            ";
        }

        // Cerrar la declaración
        $stmt->close();
    } else {
        // Manejo de errores en caso de que prepare falle
        echo "<script>alert('Error al preparar la consulta');</script>";
    }
}
	
	if(isset($_POST['logout'])){

		// Iniciar la sesión
		session_start();

		// Eliminar todas las variables de sesión
		session_unset();

		// Destruir la sesión
		session_destroy();

		// Redirigir a otra página, como la página de inicio
		header("Location: ../index.php");
		exit();

	}
	
	if (isset($_POST['regdocumento'])) {
		$documento = $_POST['documento'];
		$encargado = $_POST['persona'];
		$registro = "Jurídica";
		$fecha = date ("Y-m-d H:i:s");
		$salida = "1999/01/01 01:01/01";
		$estado = "1";

		$stmt = $conn->prepare("INSERT INTO entradas (documento, encargado, registro, date, salida, estado) VALUES (?, ?, ?, ?, ?, ?)");
		$stmt->bind_param("ssssss", $documento, $encargado, $registro, $fecha, $salida, $estado); // "ss" indica que ambos parámetros son cadenas (strings)
		
		if ($stmt->execute()) {
			header("Location: ../index.php"); // Cambia "pagina_destino.php" por la URL que desees
			exit(); // Asegúrate de usar exit() para evitar que el código posterior se ejecute
		} else {
			echo "Error al actualizar el registro: " . $stmt->error;
		}

}

	if (isset($_POST['newestado'])) {
        $iddoc = $_POST['iddoc'];
        $fecha = date("Y-m-d H:i:s");
        
        // Sentencia SQL para actualización del estado
        $stmt = $conn->prepare("UPDATE entradas SET estado = 0 WHERE iddocumentos = ?");
        $stmt->bind_param("s", $iddoc); // "s" para el tipo de parámetro (string)
            
		// Ejecutamos la sentencia
		if ($stmt->execute()) {
			// Ahora actualizamos la fecha de salida
			$stmtsal = $conn->prepare("UPDATE entradas SET salida = ? WHERE iddocumentos = ?");
            $stmtsal->bind_param("ss", $fecha, $iddoc); // "ss" para dos parámetros string
                    
			// Ejecutamos la sentencia de salida
			if ($stmtsal->execute()) {
				header("Location: ../index.php"); // Cambiar por la URL adecuada
				exit(); // Asegurarse de que el código posterior no se ejecute
			} else {
				echo "Error al ejecutar la actualización de salida: " . $stmtsal->error;
			}
		}
	}
	
	if (isset($_POST['regproceso'])){
		$numpro = $_POST['numero'];
		$objeto = $_POST['objeto'];
		$estadopro = "0";
		
		$stmt = $conn->prepare("INSERT INTO procesos (numpro, objeto, estadopro) VALUES (?, ?, ?)");
		$stmt->bind_param("sss", $numpro, $objeto, $estadopro); // "ss" indica que ambos parámetros son cadenas (strings)
		
		if ($stmt->execute()) {
			header("Location: ../index.php"); // Cambia "pagina_destino.php" por la URL que desees
			exit(); // Asegúrate de usar exit() para evitar que el código posterior se ejecute
		} else {
			echo "Error al actualizar el registro: " . $stmt->error;
		}
	}
	
		if (isset($_POST['newestadopro'])) {
        $idpro = $_POST['idpro'];
        // Sentencia SQL para actualización del estado
        $stmt = $conn->prepare("UPDATE procesos SET estadopro = 1 WHERE idprocesos = ?");
        $stmt->bind_param("s", $idpro); // "s" para el tipo de parámetro (string)
            
		// Ejecutamos la sentencia
		if ($stmt->execute()) {
				header("Location: ../index.php"); // Cambiar por la URL adecuada
				exit(); // Asegurarse de que el código posterior no se ejecute
			} else {
				echo "Error al ejecutar la actualización de salida: " . $stmtsal->error;
			}
		}
	
	if (isset($_POST['newestadoproadj'])) {
        $idproadj = $_POST['idproadj'];
        // Sentencia SQL para actualización del estado
        $stmt = $conn->prepare("UPDATE procesos SET estadopro = 0 WHERE idprocesos = ?");
        $stmt->bind_param("s", $idproadj); // "s" para el tipo de parámetro (string)
            
		// Ejecutamos la sentencia
		if ($stmt->execute()) {
				header("Location: ../index.php"); // Cambiar por la URL adecuada
				exit(); // Asegurarse de que el código posterior no se ejecute
			} else {
				echo "Error al ejecutar la actualización de salida: " . $stmtsal->error;
			}
		}
	
if (isset($_POST['regpencro'])) {
    $idpropencro = $_POST['idpropencro'];
    $pend = $_POST['pend'];
    $fechaevento = $_POST['fechaevento'];
    $estadopendpro = "0";

    $sqlpendcro = $conn->prepare("INSERT INTO pendientecro (pendiente, fechahora, estadopen, idprocesos) VALUES (?, ?, ?, ?)");
    $sqlpendcro->bind_param("ssss", $pend, $fechaevento, $estadopendpro, $idpropencro);

    if ($sqlpendcro->execute()) {
        echo "success";
    } else {
        echo "Error al registrar: " . $conn->error;
    }
}
	if (isset($_POST['newestadopencro'])) {
        $idpropencro = $_POST['idpencro'];
        // Sentencia SQL para actualización del estado
        $stmt = $conn->prepare("UPDATE pendientecro SET estadopen = 1 WHERE idpencro = ?");
        $stmt->bind_param("s", $idpropencro); // "s" para el tipo de parámetro (string)
            
		// Ejecutamos la sentencia
		if ($stmt->execute()) {
				header("Location: ../index.php"); // Cambiar por la URL adecuada
				exit(); // Asegurarse de que el código posterior no se ejecute
			} else {
				echo "Error al ejecutar la actualización de salida: " . $stmtsal->error;
			}
		}
	
	if (isset($_POST['newestadopencro2'])) {
        $idpropencro = $_POST['idpencro'];
        // Sentencia SQL para actualización del estado
        $stmt = $conn->prepare("UPDATE pendientecro SET estadopen = 0 WHERE idpencro = ?");
        $stmt->bind_param("s", $idpropencro); // "s" para el tipo de parámetro (string)
            
		// Ejecutamos la sentencia
		if ($stmt->execute()) {
				header("Location: ../index.php"); // Cambiar por la URL adecuada
				exit(); // Asegurarse de que el código posterior no se ejecute
			} else {
				echo "Error al ejecutar la actualización de salida: " . $stmtsal->error;
			}
		}
	
		// Verifica si la solicitud es POST y si se está intentando modificar el documento
		if (isset($_POST['modificar_documento'])) {
			// Obtener el ID del documento y el nuevo valor
			$id = $_POST['id'];
			$documento = $_POST['documento'];
			// Preparar la consulta SQL para actualizar el documento
			// Preparar la consulta SQL para actualizar el documento
			$stmt = $conn->prepare("UPDATE entradas SET documento = ? WHERE iddocumentos = ?");

			if ($stmt === false) {
				// Si hubo un error preparando la consulta, muestra un mensaje de error
				echo "Error al preparar la consulta: " . $conn->error;
				exit;  // Termina el script para evitar más problemas
			}

			// Vincula los parámetros
			$stmt->bind_param("si", $documento, $id);

			// Ejecuta la consulta
			if ($stmt->execute()) {
				// Si la ejecución fue exitosa, muestra un mensaje de éxito
				echo "Documento actualizado correctamente";
			} else {
				// Si hubo un error al ejecutar la consulta, muestra el error
				echo "Error al ejecutar la consulta: " . $stmt->error;
			}
		}
	
	
	// Verifica si la solicitud es POST y si se está intentando modificar la fecha
if (isset($_POST['modificar_fecha'])) {
    // Obtener el ID y la nueva fecha
    $id = $_POST['id'];
    $fecha = $_POST['fecha'];

    // Formato adecuado para la base de datos
    $fechaFormatoBaseDatos = date('Y-m-d H:i:s', strtotime($fecha));

    $stmt = $conn->prepare("UPDATE pendientecro SET fechahora = ? WHERE idpencro = ?");

    if ($stmt === false) {
        echo "Error al preparar la consulta: " . $conn->error;
        exit;
    }

    $stmt->bind_param("si", $fechaFormatoBaseDatos, $id);

    if ($stmt->execute()) {
        echo "Fecha actualizada correctamente";
    } else {
        echo "Error al ejecutar la consulta: " . $stmt->error;
    }
}
	if (isset($_POST['moduser'])) {
    $id = $_POST['iduser'];
    $nomuser = $_POST['nomuser'];
    $pass = $_POST['pass'];

    // Prepara la consulta base
    if (!empty($pass)) {
        $encrypt_pass = password_hash($pass, PASSWORD_BCRYPT);
        $sqlmoduser = $conn->prepare("UPDATE users SET user = ?, password = ? WHERE iduser = ?");
        $sqlmoduser->bind_param("ssi", $nomuser, $encrypt_pass, $id);
    } else {
        // Si la contraseña está vacía, solo actualiza el nombre de usuario
        $sqlmoduser = $conn->prepare("UPDATE users SET user = ? WHERE iduser = ?");
        $sqlmoduser->bind_param("si", $nomuser, $id);
    }

    // Ejecuta la consulta
    if ($sqlmoduser->execute()) {
        header("Location: ../registrar.php"); // Cambiar por la URL adecuada
        exit(); // Asegurarse de que el código posterior no se ejecute
    }
}

	

}
?>