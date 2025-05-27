<?php
// Parámetros de conexión
include_once "conn.php";
session_start();
// Solo aumentar si no fue contado en esta sesión
if (!isset($_SESSION['visita_contada'])) {
    $resulvisitas = $conn->query("SELECT visitas FROM ingreso WHERE idvisita = 1");
    $filavisitas = $resulvisitas->fetch_assoc();
    $contador_anonimas = $filavisitas['visitas'] + 1;

    $conn->query("UPDATE ingreso SET visitas = $contador_anonimas WHERE idvisita = 1");

    // Marcar como contada
    $_SESSION['visita_contada'] = true;
} else {
    // Si ya fue contada, solo obtenemos el número actual
    $resulvisitas = $conn->query("SELECT visitas FROM ingreso WHERE idvisita = 1");
    $filavisitas = $resulvisitas->fetch_assoc();
    $contador_anonimas = $filavisitas['visitas'];
}
function nav() {
date_default_timezone_set('America/Bogota');
?>

<nav class="navbar navbar-expand-lg fixed-top" style="font-size: 20px; background-color: #F4FEFC; border-radius: 10px; padding: 0px;">
	<div class="container-fluid">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			<strong><a href="index.php" title="INICIO"><img src="php/img/iconjr.jpg" alt="Icono" style="width: auto; height: 35px; vertical-align: middle;"></a></strong>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto">
				<li class="nav-item active">
					<a class="nav-link" href="index.php" title="INICIO"><img src="php/img/iconjr.jpg" alt="Icono" style="width: auto; height: 35px; vertical-align: middle;"></a>
				</li>
				<li class="nav-item"><a class="nav-link" href="consultas/index.php">Consultas</a></li>
				
			</ul>
			<?php
			// Verificar si el usuario ha iniciado sesión
			if (isset($_SESSION['usuario'])) {
				// Si está logueado, mostrar los botones habilitados
				echo '<form action="php/consultas.php" method="POST">
						<button type="submit" name="logout" style="border: none; background: transparent;">
							<img src="php/img/log-out.png" alt="Icono" width="50" height="50" style="cursor: pointer;">
						</button>
					  </form>';

				// Verificar si el user_id está en la sesión
				if (isset($_SESSION['user_id'])) {
					$user_id = $_SESSION['user_id'];
					global $conn; // Acceder a la variable $conn dentro de la función
					// Consultar el rol del usuario desde la base de datos de manera segura
					$sqlrol = "SELECT rol FROM users WHERE iduser = ?";
					if ($obtrol = $conn->prepare($sqlrol)) {
						$obtrol->bind_param("i", $user_id);
						$obtrol->execute();
						$resultrol = $obtrol->get_result();

						if ($resultrol->num_rows > 0) {
							// Obtener el rol del usuario
							$rowrol = $resultrol->fetch_assoc();
							$rol = $rowrol['rol'];  // Acceder correctamente al rol

							// Aquí puedes utilizar la variable $rol para limitar opciones según el rol
							if ($rol == 1) {
								echo '<a class="nav-link" href="registrar.php" title="Registrar">
										<img src="php/img/registrar.png" alt="Icono" width="50" height="50" style="cursor: pointer;">
									  </a>';
							}
						}
					} else {
						// Manejo de error si la consulta no se puede preparar
						echo "Error al ejecutar la consulta.";
					}
				}
			} else {
				// Si no está logueado, mostrar los botones deshabilitados
				echo '<form class="d-flex">
						<a class="nav-link" data-bs-toggle="modal" data-bs-target="#login" title="Iniciar sesión">
							<img src="php/img/login.png" alt="Icono" width="50" height="50" style="cursor: pointer;">
						</a>
					  </form>';
			}
			?>
		</div>
	</div>
</nav>
<div class="modal fade" id="login" data-bs-backdrop="static">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content"><br>
			<div class="text-center">
				<img src="php/img/iconjr.jpg" class="img-fluid" style="max-width: 200px; height: auto;">
			</div>
			<div class="modal-header" style="display: flex; justify-content: center; align-items: center;">
				<h3 class="modal-title">Iniciar Sesión</h3><br>
			</div>
			<form action="php/consultas.php" method="POST">
				<div class="modal-body">
					<input class="form-control" type="text" name="user" placeholder="Usuario" required><br>
					<input class="form-control" type="password" name="pass" placeholder="Contraseña" required><br>
				</div>
				<div class="modal-footer">
					<button type="submit" name="login" class="btn btn-primary">Iniciar Sesión</button>
					<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<?php
}
function inicio () {

date_default_timezone_set('America/Bogota');
global $conn; // Acceder a la variable $conn dentro de la función

if (isset($_SESSION['usuario'])) {
$user_id = $_SESSION['user_id'];
// Consultar el rol del usuario desde la base de datos de manera segura

$sqlrol = "SELECT rol FROM users WHERE iduser = ?";
if ($obtrol = $conn->prepare($sqlrol)) {
	$obtrol->bind_param("i", $user_id);
	$obtrol->execute();
	$resultrol = $obtrol->get_result();

	if ($resultrol->num_rows > 0) {
		// Obtener el rol del usuario
		$rowrol = $resultrol->fetch_assoc();
		$rol = $rowrol['rol'];  // Acceder correctamente al rol
	}
}
} else {
	echo "No se ha iniciado la sesión";
}
?>
<script>
	function confirmarEnvio() {
        return confirm("¿Estás seguro de que deseas entregar?");
    }
</script>

<meta charset="UTF-8">
<div class="container fixed-top" style="margin-top: 60px;">
	<div class="row">
		<div class="col-12" style="max-height: 750px; overflow-y: auto; background-color: #FFFDFD; border-radius: 10px; font-size: 20px;">
			<ul class="nav nav-pills" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="juridica-tab" data-bs-toggle="pill" href="#juridica">Jurídica</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="contratacion-tab" data-bs-toggle="pill" href="#contratacion">Contratación</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="colombiacompra-tab" data-bs-toggle="pill" href="#colombiacompra">Colombia Compra</a>
				</li>
			</ul>
		</div>
	</div>
</div>
<div class="container-fluid" style="margin-top: 100px; background-color: #F4FEFC;">
	<div class="tab-content">
		<div id="juridica" class="tab-pane fade show active">
			<div class="table-responsive">
				<table class="table table-hover">
				<thead>
					<tr>
						<th colspan="6">
						<h3>Registrar entrada de documento
						<?php
						// Verificar si el usuario ha iniciado sesión
						if (isset($_SESSION['usuario']) && ($rol == 1 || $rol == 3)) {
							echo '<a data-bs-toggle="modal" data-bs-target="#modalregent">
										<img src="php/img/mas.png" width="50" height="50" style="cursor: pointer;">
									</a>';
						} else {
							echo '<a><img src="php/img/mas.png" width="50" height="50" style="cursor: pointer;"></a>';
						}
						?>
						</h3>
						</th>
					</tr>
					<tr>
						<th colspan="6"><h2 align="center">Documentos ingresados</h2></th>
					</tr>
					<tr>
						<th colspan="2"><input type="search" id="searchInput" class="form-control" placeholder="Escribe para buscar"></th>
						<th colspan="4"><input type="date" id="dateInput" class="form-control"></th>
					</tr>
					<tr>
						<th>Registro</th>
						<th>Responsable</th>
						<th>Registró</th>
						<th>Entrada</th>
						<th>Estado</th>
						<th>Salida</th>
					</tr>
				</thead>
				<tbody id="documentos">
						<?php
						$traerdoc = "SELECT iddocumentos, documento, encargado, registro, date, salida, estado FROM entradas ORDER BY iddocumentos DESC"; // Modifica la consulta según tu tabla
						// Ejecutar la consulta
						$resultadoc = $conn->query($traerdoc);
						// Verificar si la consulta devolvió resultados
						if ($resultadoc->num_rows > 0) {
							setlocale(LC_TIME, 'es_ES.UTF-8');
						// Recorrer y mostrar los resultados
						while ($fila = $resultadoc->fetch_assoc()) {
								$estado = $fila['estado'];
								$fecha = $fila['date'];
								$fecha_solo_dia = date("Y-m-d", strtotime($fecha));
								$fecha_dia_completo = utf8_encode(strftime("%A %d de %B de %Y a las %H:%M:%S", strtotime($fecha)));
								$salida = $fila['salida'];
								$iddoc = $fila['iddocumentos'];

							if($salida == "1999-01-01 01:01:01"){
								$salida = "Sin entregar";
							} else {
								$salida = $fechasalida = utf8_encode(strftime("%A %d de %B de %Y a las %H:%M:%S", strtotime($salida)));
							}

						echo "<tr>";
						if (isset($_SESSION['usuario'])) {
							echo "<td class='editable-cell' data-campo='documento' data-id='{$iddoc}'><span class='text'>" . htmlspecialchars($fila['documento']) . "</span></td>";
						} else {
							echo "<td><span class='text'>" . htmlspecialchars($fila['documento']) . "</span></td>";
						}
						echo "<td>" . $fila['encargado'] . "</td>";
						echo "<td>" . $fila['registro'] . "</td>";
						echo "<td data-fecha=\"" . $fecha_solo_dia . "\">" . $fecha_dia_completo . "</td>";
						if($estado == "0"){
								echo $estado = "<td class='table-success'>Entregado</td>";

						} elseif (isset($_SESSION['usuario']) && ($rol == 1 || $rol == 3)) {
							echo $estado = 
							"<form action='php/consultas.php' method='POST'>
								<input type='hidden' name='iddoc' value='" . htmlspecialchars($iddoc) . "'>
								<td><input class='btn btn-info' type='submit' name='newestado' value='Entregar' onclick='return confirmarEnvio();'></td>
							</form>";
						} else {
							echo "<td>Por entregar</td>";
						}
						echo "<td>" . $salida . "</td>";
						echo "</tr>";
						}
						} else {
						echo "<tr><td colspan='6' class='table-danger'>Sin registros</td></tr>";
						}
						?>
				</tbody>
			</table>
			</div>
		</div>
		<div id="contratacion" class="tab-pane fade">
			<!-- ENCABEZADO FUERA DE LA TABLA -->
			<div class="d-flex justify-content-between align-items-center px-3 py-2">
				<!-- IZQUIERDA: Título + botón -->
				<div class="d-flex align-items-center">
					<h3 class="mb-0 me-2">Pendiente por cronograma</h3>
					<?php
						if (isset($_SESSION['usuario']) && ($rol == 1 || $rol == 2)) {
							echo '<a data-bs-toggle="modal" data-bs-target="#modalpend">
									<img src="php/img/mas.png" width="50" height="50" style="cursor: pointer;">
								  </a>';
						} else {
							echo '<a>
									<img src="php/img/mas.png" width="50" height="50" style="cursor: pointer;">
								  </a>';
						}
					?>
				</div>

				<!-- DERECHA: Fecha y hora -->
				<div class="d-flex gap-2">
					<div class="card text-center p-2 shadow">
						<p class="fs-6 mb-0"><strong id="fecha"></strong></p>
					</div>
					<div class="card text-center p-2 shadow">
						<p class="fs-6 mb-0 "><strong id="hora"></strong></p>
					</div>
				</div>
			</div>

					<!-- TABLA -->
					<table class="table">
						<thead>
							<tr>
								<td colspan="3">
									<ul class="nav nav-pills" role="tablist">
										<li class="nav-item">
											<a class="nav-link active" id="inicio-tab" data-bs-toggle="pill" href="#pendiente">Pendiente</a>
										</li>
										<li class="nav-item">
											<a class="nav-link" id="adjudicados-tab" data-bs-toggle="pill" href="#publicado">Publicado</a>
										</li>
									</ul>
								</td>
							</tr>
						</thead>
					</table>
					
					<table class="table table-hover">
								<thead>
									<tr>
										<th colspan="2"><input type="search" id="searchInputcro" class="form-control" placeholder="Escribe para buscar"></th>
										<th colspan="3"><input type="date" id="dateInputcro" class="form-control"></th>
									</tr>
								</thead>
							</table>
					<!-- Aquí va el contenido de las pestañas, fuera de <tbody> -->
					<div class="tab-content" style="max-height: 600px; overflow-y: auto;">
						<!-- Pestaña En Página -->
						<div id="pendiente" class="container-fluid tab-pane fade show active">
							<table class="table table-hover">
									<tr>
										<th>Proceso</th>
										<th>Evento</th>
										<th>Fecha y Hora</th>
										<th>Estado</th>
									</tr>
								<tbody id="eventoscro">
									
									<?php
									$traerpencro = "SELECT p.idpencro, p.pendiente, p.fechahora, p.estadopen, p.idprocesos, pr.numpro 
									FROM pendientecro p
									INNER JOIN procesos pr ON p.idprocesos = pr.idprocesos
									WHERE p.estadopen = '0'
									ORDER BY p.fechahora ASC";
									$resultpenpro = $conn->query($traerpencro);

									if ($resultpenpro->num_rows > 0) {
										setlocale(LC_TIME, 'es_ES', 'es', 'es.UTF-8');
										$fecha_actual = date('Y-m-d');
										// Obtener la fecha de ayer
										$fecha_mas = date('Y-m-d', strtotime('+1 day'));
										$fecha_ayer = date('Y-m-d', strtotime('-1 day'));
										while ($obtpencro = $resultpenpro->fetch_assoc()) {
											$idpencro = htmlspecialchars($obtpencro['idpencro']);
											$pendiente = htmlspecialchars($obtpencro['pendiente']);
											$fechahora = htmlspecialchars($obtpencro['fechahora']);
											$fechaenletras = utf8_encode(strftime("%A %d de %B de %Y a las %H:%M:%S", strtotime($fechahora)));
											$fechaISO = date('Y-m-d\TH:i', strtotime($fechahora)); // ejemplo: "2025-04-28T18:59"
											// Obtener la fecha y hora actual
											$fecha_fila = date("Y-m-d", strtotime($fechahora));
											
											
											// Comparar la fecha y hora de la fila con la fecha actual
											if ($fecha_fila	 === $fecha_actual) {
												// Si coinciden, agregar una clase especial (ej. 'bg-warning' para color naranja)
												$clase = 'table-danger';  // Clase de Bootstrap para el color de fondo naranja
											} elseif ($fecha_fila === $fecha_mas) {
												// Si las fechas coinciden con la fecha de ayer, asignar la clase 'bg-success' (verde)
												$clase = 'table-warning';  // Clase de Bootstrap para el color de fondo verde
											}	elseif ($fecha_fila === $fecha_ayer){
												// Si no coinciden, puedes dejarla vacía o darle otra clase
												$clase = 'table-dark';
											} else {
												$clase = '';
											}
											
											$numpro = htmlspecialchars($obtpencro['numpro']);
											if (isset($_SESSION['usuario']) && ($rol == 1 || $rol == 2)) {
											$estadopencro = "<form action='php/consultas.php' method='POST'>
															 <input type='hidden' name='idpencro' value='" . $idpencro . "'>
															 <input class='btn btn-info' type='submit' name='newestadopencro' value='Publicar'>
															 </form>";
											} else {
												$estadopencro = "Publicar";
											}

											echo "<tr class='$clase'>";
											echo "<td>" . $numpro . "</td>";
											echo "<td>" . $pendiente . "</td>";
											if (isset($_SESSION['usuario']) && ($rol == 1 || $rol == 2)) {
											echo "<td class='editable-cell' data-campo='fecha1' data-id='{$idpencro}' data-fecha='{$fechaISO}'>
													<span class='text'>" . htmlspecialchars($fechaenletras) . "</span>
											  </td>";
											} else {
											echo "<td>
													<span>" . htmlspecialchars($fechaenletras) . "</span>
												</td>";
											}
											echo "<td>" . $estadopencro . "</td>";
											echo "</tr>";
										}
									} else {
										echo "<tr class='table-success'><td colspan='4'>Todo publicado</td></tr>";
									}
									?>
								</tbody>
							</table>
						</div>

						<div id="publicado" class="container-fluid tab-pane fade">
							<table class="table table-hover">
								<tbody>
									<tr>
										<th>Proceso</th>
										<th>Evento</th>
										<th>Estado</th>
									</tr>
									<?php
									// Consulta para obtener los procesos en estado '0' (inicial)
									$traerpencro = "SELECT p.idpencro, p.pendiente, p.fechahora, p.estadopen, p.idprocesos, pr.numpro 
													FROM pendientecro p
													INNER JOIN procesos pr ON p.idprocesos = pr.idprocesos
													WHERE p.estadopen = '1'
													ORDER BY p.idprocesos DESC";
									$resultpenpro = $conn->query($traerpencro);

									if ($resultpenpro->num_rows > 0) {
										setlocale(LC_TIME, 'es_ES', 'es', 'es.UTF-8');

										while ($obtpencro = $resultpenpro->fetch_assoc()) {
											$idpencro = htmlspecialchars($obtpencro['idpencro']);
											$pendiente = htmlspecialchars($obtpencro['pendiente']);
											$fechahora = htmlspecialchars($obtpencro['fechahora']);
											$numpro = htmlspecialchars($obtpencro['numpro']);
											if (isset($_SESSION['usuario']) && ($rol == 1 || $rol == 2)) {
											$estadopencro = "<form action='php/consultas.php' method='POST'>
															 <input type='hidden' name='idpencro' value='" . $idpencro . "'>
															 <input class='btn btn-info' type='submit' name='newestadopencro2' value='Publicado'>
															 </form>";
											} else {
												$estadopencro = "Publicado";
											}

											echo "<tr class='table-success'>";
											echo "<td>" . $numpro . "</td>";
											echo "<td>" . $pendiente . "</td>";
											echo "<td>" . $estadopencro . "</td>";
											echo "</tr>";
										}
									} else {
										echo "<tr class='table-danger'><td colspan='3'>Todos los pendientes estan sin publicar</td></tr>";
									}
									?>
								</tbody>
							</table>
						</div>								
				</div>
				<!-- ENCABEZADO VISUAL: Título, botón, cantidad, fecha y hora -->
				<div class="d-flex justify-content-between align-items-center px-3 py-2">
					<!-- IZQUIERDA: Título + botón + cantidad -->
					<div>
						<div class="d-flex align-items-center">
							<h3 class="mb-0 me-2">Contratación - Procesos en página</h3>
							<?php
								if (isset($_SESSION['usuario']) && ($rol == 1 || $rol == 2)) {
									echo '<a data-bs-toggle="modal" data-bs-target="#modalproces">
											<img src="php/img/mas.png" width="50" height="50" style="cursor: pointer;">
										  </a>';
								} else {
									echo '<a>
											<img src="php/img/mas.png" width="50" height="50" style="cursor: pointer;">
										  </a>';
								}
							?>
						</div>
					</div>

					<!-- DERECHA: Fecha y hora -->
					<div class="d-flex gap-2">
						<!-- CANTIDAD (PHP) -->
						<div class="card p-1 mt-1 shadow">
							<?php
								$estadopropag = "0";
								$contarpropag = "SELECT COUNT(*) AS idprocesos FROM procesos WHERE estadopro = ?";
								$obtpropag = $conn->prepare($contarpropag);
								$obtpropag->bind_param("s", $estadopropag);
								$obtpropag->execute();
								$resultpropag = $obtpropag->get_result();
								$rowpropag = $resultpropag->fetch_assoc();
								echo "Procesos en Página: " . $rowpropag['idprocesos'];
							?>
						</div>
					</div>
				</div>

				<!-- TABLA -->
				<table class="table table-hover">
					<thead>
						<tr>
							<td>
								<ul class="nav nav-pills" role="tablist">
									<li class="nav-item">
										<a class="nav-link active" id="inicio-tab" data-bs-toggle="pill" href="#inicio">En página</a>
									</li>
									<li class="nav-item">
										<a class="nav-link" id="adjudicados-tab" data-bs-toggle="pill" href="#adjudicados">Adjudicados</a>
									</li>
								</ul>
							</td>
						</tr>
					</thead>
				</table>
				<!-- Aquí va el contenido de las pestañas, fuera de <tbody> -->
				<div class="tab-content" style="max-height: 600px; overflow-y: auto; padding-bottom: 30px;">
					<!-- Pestañaa En Página -->
					<div id="inicio" class="container-fluid tab-pane fade show active">
						<table class="table table-hover">
							<tbody>
								<tr>
									<th>Número</th>
									<th>Objeto</th>
									<th>Estado</th>
								</tr>
								<?php
								// Consulta para obtener los procesos en estado '0' (inicial)
								$traerpro = "SELECT idprocesos, numpro, objeto, estadopro FROM procesos WHERE estadopro = '0' ORDER BY idprocesos DESC";
								$resultpro = $conn->query($traerpro);

								if ($resultpro->num_rows > 0) {
									setlocale(LC_TIME, 'es_ES', 'es', 'es.UTF-8');

									while ($obtpro = $resultpro->fetch_assoc()) {
										$idpro = htmlspecialchars($obtpro['idprocesos']);
										$numpro = htmlspecialchars($obtpro['numpro']);
										$objeto = htmlspecialchars($obtpro['objeto']);
										
										
										if (isset($_SESSION['usuario']) && ($rol == 1 || $rol == 2)) {
											$estadopro = "<form action='php/consultas.php' method='POST'>
															<input type='hidden' name='idpro' value='" . $idpro . "'>
															<input class='btn btn-info' type='submit' name='newestadopro' value='En Página'>
														  </form>";
										} else {
											$estadopro = "En Página";
										}

										echo "<tr>";
										echo "<td>" . $numpro . "</td>";
										echo "<td>" . $objeto . "</td>";
										echo "<td>" . $estadopro . "</td>";
												
										echo "</tr>";
									}
								} else {
									echo "<tr><td colspan='3' class='table-success'>Todos los procesos en página adjudicados</td></tr>";
								}
								?>
							</tbody>
						</table>
					</div>

					<!-- Pestaña Adjudicados -->
					<div id="adjudicados" class="container-fluid tab-pane fade">
						<table class="table table-hover">
							<tbody>
								<tr>
									<th>Número</th>
									<th>Objeto</th>
									<th>Estado</th>
								</tr>
								<?php
								$traerproadj = "SELECT idprocesos, numpro, objeto, estadopro FROM procesos WHERE estadopro = '1' ORDER BY idprocesos DESC";
								$resultproadj = $conn->query($traerproadj);

								if ($resultproadj->num_rows > 0) {
									while ($obtproadj = $resultproadj->fetch_assoc()) {
										$idproadj = htmlspecialchars($obtproadj['idprocesos']);
										$numproadj = htmlspecialchars($obtproadj['numpro']);
										$objetoadj = htmlspecialchars($obtproadj['objeto']);
										if (isset($_SESSION['usuario']) && ($rol == 1 || $rol == 2)) {
											$estadoproadj = "<form action='php/consultas.php' method='POST'>
															<input type='hidden' name='idproadj' value='" . $idproadj . "'>
															<input class='btn btn-info' type='submit' name='newestadoproadj' value='Adjudicado'>
														  </form>";
										} else {
											$estadoproadj = "Adjudicado";
										}

										echo "<tr>";
										echo "<td>" . $numproadj . "</td>";
										echo "<td>" . $objetoadj . "</td>";
										echo "<td>" . $estadoproadj . "</td>";
										echo "</tr>";
									}
								} else {
									echo "<tr><td colspan='3' class='table-danger'>Todos los procesos sin adjudicar</td></tr>";
								}
								?>
							</tbody>
						</table>
					</div>
			</div>
<!-------------------------------------------SCRIPT PARA MOSTRAR FECHA Y HORA---------------------------------------------------->
<script>
	function actualizarFechaHora() {
		const ahora = new Date();
    
    // Fecha en español
    const dias = ['Dom', 'Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb'];
    const meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    const diaSemana = dias[ahora.getDay()]; // Día de la semana
    const dia = ahora.getDate();            // Día del mes
    const mes = meses[ahora.getMonth()];    // Mes
    const año = ahora.getFullYear();       // Año

    // Creando la fecha en formato "Día de la semana, Día de mes de Año"
    const fecha = `${diaSemana}, ${dia} de ${mes} de ${año}`;
    
    // Hora en formato 24 horas
    const hora = ahora.toLocaleTimeString('es-MX', { hour12: false });

    // Mostrando la fecha y hora en el DOM
    document.getElementById('fecha').textContent = fecha;
    document.getElementById('hora').textContent = hora;
}

actualizarFechaHora();
setInterval(actualizarFechaHora, 1000);
</script>
<!-------------------------------------------FIN SCRIPT PARA MOSTRAR FECHA Y HORA---------------------------------------------------->
				
<script>
$(document).ready(function () {
    function filterTable() {
        var textValue = $("#searchInputcro").val()?.toLowerCase() || "";
        var dateValue = $("#dateInputcro").val(); // formato: YYYY-MM-DD

        $("#eventoscro tr").filter(function () {
            var rowText = $(this).text().toLowerCase();

            // Extraemos la fecha (YYYY-MM-DD) desde data-fecha que es tipo: 2025-04-28T18:59
            var fullDate = $(this).find("td[data-fecha]").attr("data-fecha") || "";
            var rowDate = fullDate.split("T")[0]; // Extrae solo '2025-04-28'

            var textMatch = rowText.indexOf(textValue) > -1;
            var dateMatch = !dateValue || rowDate === dateValue;

            $(this).toggle(textMatch && dateMatch);
        });
    }

    $("#searchInputcro, #dateInputcro").on("keyup change", filterTable);
});
</script>
						
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.editable-cell').forEach(function (cell) {
        cell.addEventListener('click', function () {
            const originalFecha = cell.dataset.fecha;
            const textElement = cell.querySelector('.text');
            const originalTexto = textElement ? textElement.innerText : originalFecha;

            if (cell.querySelector('input')) return;

            const input = document.createElement('input');
            input.type = 'datetime-local';
            input.value = originalFecha;
            input.style.width = '100%';

            cell.innerHTML = '';
            cell.appendChild(input);
            input.focus();

            input.addEventListener('blur', () => {
                const nuevaFecha = input.value.trim();
                if (!nuevaFecha || nuevaFecha === originalFecha) {
                    cell.innerHTML = `<span class='text'>${originalTexto}</span>`;
                    return;
                }

                const id = cell.dataset.id;

                fetch('php/consultas.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `modificar_fecha=1&id=${id}&fecha=${encodeURIComponent(nuevaFecha)}`
                })
                .then(response => response.text())
                .then(data => {
                    console.log('Respuesta del servidor:', data);

                    if (data.includes('Fecha actualizada')) {
                        const fechaFormateada = new Date(nuevaFecha).toLocaleString('es-ES', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit',
                            second: '2-digit'
                        });

                        cell.innerHTML = `<span class='text'>${fechaFormateada}</span>`;
                        cell.dataset.fecha = nuevaFecha;
                    } else {
                        alert("Error: " + data);
                        cell.innerHTML = `<span class='text'>${originalTexto}</span>`;
                    }
                })
                .catch(err => {
                    console.error('Error:', err);
                    alert("Error al actualizar la fecha.");
                    cell.innerHTML = `<span class='text'>${originalTexto}</span>`;
                });
            });
        });
    });
});
</script>
<!---------------------------------------------------SCRIPT ENVIAR DATOS PENDIENTE POR CRONOGRAMA------------------------------------------------------------->
<script>
$(document).ready(function() {
    $('#formPendCro').submit(function(e) {
        e.preventDefault(); // Previene el envío tradicional

        // Limpiar mensajes anteriores
        $('#respuestaAjax').html('');

        // Serializar el formulario + agregar regpencro manualmente
        let datosFormulario = $(this).serialize() + '&regpencro=1';

        $.ajax({
            url: 'php/consultas.php',
            method: 'POST',
            data: datosFormulario,
            success: function(response) {
                response = response.trim(); // Elimina espacios innecesarios

                if (response === "success") {
                    $('#respuestaAjax').html(`
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Éxito</strong> El registro fue guardado correctamente.
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    `);
                    $('#formPendCro')[0].reset(); // Limpia el formulario
                } else {
                    $('#respuestaAjax').html(`
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error:</strong> ${response}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                        </div>
                    `);
                }
            },
            error: function(xhr, status, error) {
                $('#respuestaAjax').html(`
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error de red:</strong> ${error}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                `);
            }
        });
    });
});
</script>
<!---------------------------------------------------SCRIPT ENVIAR DATOS PENDIENTE POR CRONOGRAMA------------------------------------------------------------->	

			<div class="modal fade" id="modalregent" data-bs-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Registrar entrada de documento</h4>
						</div>
						<form action="php/consultas.php" method="POST">
							<div class="modal-body">
								<input class="form-control" type="text" name="documento" placeholder="Documento que ingresa" required><br>
								<input class="form-control" type="text" name="persona" placeholder="Persona que entrega" required><br>
							</div>
							<div class="modal-footer">
								<button type="submit" name="regdocumento" class="btn btn-primary">Registrar</button>
								<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="modal fade" id="modalproces" data-bs-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Registrar proceso en página</h4>
						</div>
						<form action="php/consultas.php" method="POST">
							<div class="modal-body">
								<input class="form-control" type="text" name="numero" placeholder="Número del proceso" required><br>
								<input class="form-control" type="text" name="objeto" placeholder="Objeto del proceso" required><br>
							</div>
							<div class="modal-footer">
								<button type="submit" name="regproceso" class="btn btn-primary">Registrar</button>
								<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
			<div class="modal fade" id="modalpend" data-bs-backdrop="static">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">Registrar pendiente por cronograma</h4>
						</div>
						<div class="modal-body">
							<form id="formPendCro" method="POST">
								<div id="respuestaAjax"></div> <!-- Mensajes AJAX -->

								<select class="form-select" name="idpropencro" required>
									<option value="" disabled selected>Selecciona un proceso</option>
									<?php
									$traerpropag = "SELECT idprocesos, numpro FROM procesos WHERE estadopro = '0' ORDER BY idprocesos DESC";
									$resultpropag = $conn->query($traerpropag);
									if ($resultpropag->num_rows > 0) {
										while ($obtproc = $resultpropag->fetch_assoc()) {
											$idpropencro = htmlspecialchars($obtproc['idprocesos']);
											$numproc = htmlspecialchars($obtproc['numpro']);
											echo "<option value=\"$idpropencro\">$numproc</option>";
										}
									} else {
										echo "<option>No hay procesos registrados</option>";
									}
									?>
								</select><br>

								<input class="form-control" type="text" name="pend" placeholder="Pendiente" required><br>
								<input class="form-control" type="datetime-local" name="fechaevento" required><br>

								<div class="modal-footer">
									<button type="submit" class="btn btn-primary">Registrar</button>
									<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div id="colombiacompra" class="tab-pane fade" style="margin-bottom: 1cm;">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12" style="margin-top: 10px; margin-bottom: 1cm;">
						<div class="row">
							<h1 style="text-align: center;">Accesos Directos</h1><br>
							<div class="col-2">
							<a href="https://meet.google.com/hno-nqta-ujd" target="_blank"><img src="php/img/audiencias.png" width="100%" height="100%" style="cursor: pointer; border-radius: 20px;"></a>
							</div>
							<div class="col-2">
							<a href="https://community.secop.gov.co/STS/Users/Login/Index?SkinName=CCE" target="_blank"><img src="php/img/secopii.png" width="100%" height="100%" style="cursor: pointer; border-radius: 20px;"></a>
							</div>
							<div class="col-2">
							<a href="https://www.contratos.gov.co/entidades/entLogin.html" target="_blank"><img src="php/img/secopi.png" width="100%" height="100%" style="cursor: pointer;  border-radius: 20px;"></a>
							</div>
							<div class="col-2">
							<a href="https://www.colombiacompra.gov.co/secop/secop-ii/como-usar-el-secop-ii-comprador" target="_blank"><img src="php/img/ayuda.png" width="100%" height="100%" style="cursor: pointer;  border-radius: 20px;"></a>
							</div>
							<div class="col-2">
							<a href="https://colombiacompra.coupahost.com/sessions/new" target="_blank"><img src="php/img/tvecing.png" width="100%" height="100%" style="cursor: pointer; border-radius: 20px;"></a>
							</div>
							<div class="col-2">
							<a href="https://www.colombiacompra.gov.co/secop/tvec" target="_blank"><img src="php/img/tvec1.png" width="100%" height="100%" style="cursor: pointer; border-radius: 20px;"></a>
							</div>
						</div>
					</div>
					<div class="col-12">
						<div class="row">
							<div class="col-2">
							<a href="https://operaciones.colombiacompra.gov.co/soporte/formulario-de-soporte?nocache=1" target="_blank"><img src="php/img/soporteclmb.png" width="100%" height="100%" style="cursor: pointer; border-radius: 20px;"></a>
							</div>
							<div class="col-2">
							<a href="https://operaciones.colombiacompra.gov.co/solicitud-publicacion-documentos-adicionales" target="_blank"><img src="php/img/doctvec.png" width="100%" height="100%" style="cursor: pointer; border-radius: 20px;"></a>
							</div>
							<div class="col-2">
							<a href="https://mesadeservicio.colombiacompra.gov.co/" target="_blank"><img src="php/img/mesaservicio.png" width="100%" height="100%" style="cursor: pointer; border-radius: 20px;"></a>
							</div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>	
</div>
<script>
	$(document).ready(function () {
	function filterTable() {
	var textValue = $("#searchInput").val()?.toLowerCase() || "";
	var dateValue = $("#dateInput").val();

	$("#documentos tr").filter(function () {
	var rowText = $(this).text().toLowerCase();
	var rowDateAttr = $(this).find("td:eq(3)").data("fecha");

	var textMatch = rowText.indexOf(textValue) > -1;
	var dateMatch = !dateValue || rowDateAttr === dateValue;

	$(this).toggle(textMatch && dateMatch);
	});
	}

	$("#searchInput, #dateInput").on("keyup change", filterTable);
	});
</script>

<script>
$(document).ready(function () {
	// Al hacer clic en la celda
	$('.editable-cell').on('click', function () {
		const $cell = $(this); // Obtener la celda que fue clickeada
		const campo = $cell.data('campo'); // Obtener el campo (documento)
		const id = $cell.data('id'); // Obtener el ID (de la base de datos)
		const valorOriginal = $cell.find('.text').text().trim(); // Obtener el texto actual del campo

		// Evitar crear más de un input en la misma celda
		if ($cell.find('input').length === 0) {
			// Reemplazar el texto por un input con el valor actual
			$cell.html(`<input type='text' class='input-inline' value='${valorOriginal}' />`);
			const $input = $cell.find('input'); // Seleccionar el nuevo input
			$input.focus(); // Focar el input para que el usuario empiece a editar

			// Cuando se presiona Enter o se pierde el foco (blur)
			$input.on('keydown blur', function (e) {
				if (e.type === 'blur' || e.key === 'Enter') {
					const nuevoValor = $input.val().trim(); // Obtener el nuevo valor

					// Restaurar el contenido de la celda a un <span> con el nuevo valor
					$cell.html(`<span class='text'>${nuevoValor}</span>`);

					// Enviar los datos por AJAX a consultas.php para actualizar la base de datos
					$.post('php/consultas.php', {
						modificar_documento: true, // Indicamos que queremos modificar el documento
						id: id, // El ID de la fila que estamos modificando
						documento: nuevoValor // El nuevo valor que el usuario ha ingresado
					});
				}
			});
		}
	});
});
</script>

<?php }

function piepag() { ?>
	<div class="container-fluid" id="piepagina">
		<a class="btn btn-"><strong>Desarrollado por IngELzandy</strong></a>
	</div>
<?php } ?>
