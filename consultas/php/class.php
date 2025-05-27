<?php
function nav() {
?>
<nav class="navbar navbar-expand-lg fixed-top" style="font-size: 20px; background-color: #F4FEFC; border-radius: 10px;">
	<div class="container-fluid">
		<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			<strong><a>DM JURÍDICA</a></strong>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav me-auto">
				<li class="nav-item active">
					<a class="nav-link" href="../index.php" title="INICIO"><img src="php/img/iconjr.jpg" alt="Icono" style="width: auto; height: 35px; vertical-align: middle;"></a>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Antecedentes Disciplinarios</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="https://www.contraloria.gov.co/es/web/guest/control-fiscal/responsabilidad-fiscal/certificado-de-antecedentes-fiscales" target="_blank">Contraloria</a></li>
						<li><a class="dropdown-item" href="https://www.procuraduria.gov.co/Pages/Consulta-de-Antecedentes.aspx" target="_blank">Procuraduria</a></li>
						<li><a class="dropdown-item" href="https://antecedentes.policia.gov.co:7005/WebJudicial/" target="_blank">Policia</a></li>
						<li><a class="dropdown-item" href="index.php?pagina=rnmc">RNMC</a></li>
						<li><a class="dropdown-item" href="index.php?pagina=delitossexuales">Delitos Sexuales</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Requisitos Jurídicos</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="https://tramites.copnia.gov.co/Copnia_Microsite/CertificateOfGoodStanding/CertificateOfGoodStandingStart" target="_blank">Certificado vigente COPNIA</a></li>
						<li><a class="dropdown-item" href="https://sgr.jcc.gov.co:8181/apex/f?p=117:1:::NO:1,2::" target="_blank">JC Contadores</a></li>
						<li><a class="dropdown-item" href="index.php?pagina=rues">RUES</a></li>
						<li><a class="dropdown-item" href="https://www.colombiacompra.gov.co/clasificador-de-bienes-y-servicios" target="_blank">Clasificador Codigos UNSPSC</a></li>
						<li><a class="dropdown-item" href="https://muisca.dian.gov.co/WebRutMuisca/DefConsultaEstadoRUT.faces" target="_blank">RUT</a></li>
						<li><a class="dropdown-item" href="https://sii.confecamaras.co/vista/plantilla/cv.php?empresa=56" target="_blank">Camara de Comercio</a></li>
						<li><a class="dropdown-item" href="index.php?pagina=ciiu">Codigo CIIU</a></li>
						<li><a class="dropdown-item" href="https://certificados.sena.edu.co/CertificadoDigital/com.sena.consultacer" target="_blank">Certificado Sena</a></li>
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Aportes </a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="https://servicio.nuevosoi.com.co/soi/consultaSoportePago.do" target="_blank">SOI</a></li>
						<li><a class="dropdown-item" href="https://www.enlace-apb.com/interssi/descargarCertificacionPago.jsp" target="_blank">Asopagos</a></li>
						<li><a class="dropdown-item" href="https://www.aportesenlinea.com/autoservicio/VerificarPlanilla.aspx" target="_blank">Aportes en Linea</a></li>
						<li><a class="dropdown-item" href="https://ruaf.sispro.gov.co/Filtro.aspx" target="_blank">RUAF</a></li>
						<li><a class="dropdown-item" href="https://www.adres.gov.co/consulte-su-eps" target="_blank">ADRESS</a></li>
						
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Pólizas </a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="https://poliza-rce.fondosoldicom.com/?_gl=1*1vd560z*_ga*MTc4OTQ1MDg5My4xNzE3MTA1NzAx*_ga_73SSX8P2TQ*MTcxNzEwNTcwMC4xLjEuMTcxNzEwNTcxNS4wLjAuMA.." target="_blank">COMCE POLIZAS</a></li>
						<li><a class="dropdown-item" href="https://consultapoliza.segurosdelestado.com/ConsultaPoliza/" target="_blank">Seguros del Estado</a></li>
						<li><a class="dropdown-item" href="https://www.solidaria.com.co/Patrimoniales/Consulta/frm_ingdatos.aspx" target="_blank">Aseguradora Solidaria</a></li>
						<li><a class="dropdown-item" href="https://productos.mundialseguros.com.co/" target="_blank">Seguros Mundial</a></li>
						<li><a class="dropdown-item" href="https://www.aportesenlinea.com/autoservicio/VerificarPlanilla.aspx" target="_blank">Aportes en Linea</a></li>
						<li><a class="dropdown-item" href="https://ruaf.sispro.gov.co/Filtro.aspx" target="_blank">RUAF</a></li>
						<li><a class="dropdown-item" href="https://www.adres.gov.co/consulte-su-eps" target="_blank">ADRESS</a></li>
						
					</ul>
				</li>
				<li class="nav-item dropdown">
					<a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Colombia Compra</a>
					<ul class="dropdown-menu">
						<li><a class="dropdown-item" href="https://portal.paco.gov.co/" target="_blank">Portal Paco</a></li>
						<li><a class="dropdown-item" href="https://colombiacompra.gov.co/transparencia/conjuntos-de-datos-abiertos" target="_blank">Datos Abiertos</a></li>
						<li><a class="dropdown-item" href="https://www.colombiacompra.gov.co/secop/tvec" target="_blank">Tienda Virtual</a></li>
						<li><a class="dropdown-item" href="https://community.secop.gov.co/STS/Users/Login/Index?SkinName=CCE&currentLanguage=es-CO&Page=login&Country=CO" target="_blank">Secop 2</a></li>
					</ul>
				</li>	
			</ul>
		</div>
	</div>
</nav>
<?php
}

function ciiu() { ?>
	<div class="container" style="margin-top:130px;">
		<div id="iframe-container">
			<iframe src="https://linea.ccb.org.co/descripcionciiu/" width="100%" height="100%" frameborder="0"></iframe>
		</div>
	</div>
	
<?php }

function rnmc() { ?>
	<div class="container" style="margin-top:70px;">
		<a class="btn btn-primary" href="https://srvcnpc.policia.gov.co/PSC/frm_cnp_consulta.aspx" target="_blank">Si no se carga correctamente, accede con un click aquí</a>
		<div id="iframe-container" style="margin-top:10px;">
			<iframe src="https://srvcnpc.policia.gov.co/PSC/frm_cnp_consulta.aspx" width="100%" height="100%" frameborder="0"></iframe>
		</div>
	</div>
	
<?php }

function delitossexuales() { ?>
	<div class="container" style="margin-top:70px;">
		<a class="btn btn-primary" href="https://inhabilidades.policia.gov.co:8080/consulta" target="_blank">Si no se carga correctamente, accede con un click aquí</a>
		<div id="iframe-container" style="margin-top:10px;">
			<iframe src="https://inhabilidades.policia.gov.co:8080/consulta" width="100%" height="100%" frameborder="0"></iframe>
		</div>
	</div>
	
<?php }

function rues() { ?>
	<div class="container" style="margin-top:130px;">
		<div id="iframe-container">
			<iframe src="https://ruesfront.rues.org.co/" width="100%" height="100%" frameborder="0"></iframe>
		</div>
	</div>
	
<?php }

function calendario() { ?>
	<div class="container" style="margin-top:70px;">
		<a target="_blank" style="display: block; position: relative;" title="Click aquí"><iframe id="iframehora" src="https://horalegal.inm.gov.co/inm/" scrolling="no" style="background: #FFFFFF; pointer-events: none;"></iframe></a>
	</div>
	
	<div class="container-fluid">
		<img src="php/img/calendario_es_2025_4100625.png" alt="Icono" width="100%" height="100%" style="cursor: pointer;">
	</div>
	
 <?php }

function piepag() { ?>
	<div class="container-fluid" id="piepagina">
		<a class="btn btn-"><strong>Desarrollado por IngELzandy</strong></a>
	</div>
<?php } ?>
