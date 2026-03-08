<?php

	function muestra_login()
	{
		liberar_bd();
		$selecDatosEmpresa = "CALL sp_sistema_select_datos_empresa();";
		$datosEmpresa = consulta($selecDatosEmpresa);
		$empresa = siguiente_registro($datosEmpresa);

		//CARGAMOS CONFIGURACIONES INICALES
		liberar_bd();
		$selectConfigSistema = 'CALL sp_sistema_select_datos_configuracion();';
		$configSistema = consulta($selectConfigSistema);
		$confSis = siguiente_registro($configSistema);

		$formulario = '	<!DOCTYPE html>
						<html lang="en">
							<head>
								<meta charset="UTF-8">
								<title>.::Validación y Auditoría::.</title>
								<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
								<meta http-equiv="expires" content="Mon, 26 Jul 1997 05:00:00 GMT"/>
								<meta http-equiv="pragma" content="no-cache" />
								<link rel="stylesheet" href="font/iconsmind-s/css/iconsminds.css" />
								<link rel="stylesheet" href="font/simple-line-icons/css/simple-line-icons.css" />
								<link rel="stylesheet" href="css/vendor/bootstrap.min.css" />
								<link rel="stylesheet" href="css/vendor/bootstrap.rtl.only.min.css" />
								<link rel="stylesheet" href="css/vendor/bootstrap-float-label.min.css" />
								<link rel="stylesheet" href="css/vendor/select2.min.css" />
								<link rel="stylesheet" href="css/vendor/select2-bootstrap.min.css" />
								<link rel="stylesheet" href="css/main.css" />
								<link rel="shortcut icon" href="imagenes/empresa/logo.png">
							</head>
							<body class="background show-spinner no-footer">
								<div class="fixed-background"></div>
								<main>
									<div class="container">
										<div class="row h-100">
											<div class="col-12 col-md-10 mx-auto my-auto">
												<div class="card auth-card">
													<div class="position-relative image-side"></div>
													<div class="form-side">
														<span class="logo-single"></span>
														<form id="frmAcceso" name="frmAcceso" method="post" action="./">
															<div class="alert alert-success alert-dismissable" id="alertSuccess" style="display: none;">
																<button type="button" class="close" data-hide="alertSuccess">×</button>
																<i class="fa fa-check pr10"></i>
																<span id="txtAlertSuccess"></span>
															</div>
															<div class="alert alert-danger alert-dismissable" id="alertDanger" style="display: none;">
																<button type="button" class="close" data-hide="alertDanger">×</button>
																<i class="fa fa-remove pr10"></i>
																<span id="txtAlertDanger"></span>
															</div>
															<label class="form-group has-float-label mb-4">
																<input name="txtUsuario" id="txtUsuario" class="form-control" />
																<span>Usuario</span>
															</label>
															<div class="special-alerts">
																<div class="alert alert-dark light alert-dismissable" id="alertUsuario" style="display: none;">
																	<button type="button" class="close" data-hide="alertUsuario">×</button>
																	<i class="fa fa-warning pr10"></i>
																	Capture su usuario
																</div>
															</div>
															<label class="form-group has-float-label mb-4">
																<input name="txtPassword" id="txtPassword" class="form-control" type="password" placeholder="" />
																<span>Contrase&ntilde;a</span>
															</label>
															<div class="special-alerts">
																<div class="alert alert-dark light alert-dismissable" id="alertPassword" style="display: none;">
																	<button type="button" class="close" data-hide="alertPassword">×</button>
																	<i class="fa fa-warning pr10"></i>
																	Capture la contrase&ntilde;a
																</div>
															</div>
															<div class="d-flex justify-content-between align-items-center">
																<button type="button" id="btnEnvio" class="btn btn-primary btn-lg btn-shadow">Iniciar sesi&oacute;n</button>
															</div>
														</form>
													</div>
												</div>
											</div>
										</div>
									</div>
								</main>
								<script src="js/vendor/jquery-3.3.1.min.js"></script>
								<script src="js/vendor/bootstrap.bundle.min.js"></script>
								<script src="js/vendor/select2.full.js"></script>
								<script src="js/vendor/bootstrap-notify.min.js"></script>
								<script src="js/vendor/mousetrap.min.js"></script>
								'.scripttag("js/dore.script.js?v=".uniqid()).
								scripttag("script/portal/globales.js?v=".uniqid()).
								scripttag("script/portal/sistema.js?v=".uniqid()).
								scripttag("js/scripts.js?v=".uniqid()).
								scripttag("script/portal/gralLogin.js").'
							</body>
						</html>';

		return $formulario;
	}

	function muestra_screenlock()
	{
		$formulario = '	<!DOCTYPE html>
							<html lang="es">
								<head>
									<meta charset="UTF-8">
									<title>.::Validación y Auditoría::.</title>
									<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
									<meta name="viewport" content="width=device-width, initial-scale=1.0">
									<meta http-equiv="expires" content="Mon, 26 Jul 1997 05:00:00 GMT"/>
									<meta http-equiv="pragma" content="no-cache" />
									<link rel="stylesheet" href="font/iconsmind-s/css/iconsminds.css" />
									<link rel="stylesheet" href="font/simple-line-icons/css/simple-line-icons.css" />
									<link rel="stylesheet" href="css/vendor/bootstrap.min.css" />
									<link rel="stylesheet" href="css/vendor/bootstrap.rtl.only.min.css" />
									<link rel="stylesheet" href="css/vendor/bootstrap-float-label.min.css" />
									<link rel="stylesheet" href="css/main.css" />
									<link rel="shortcut icon" href="imagenes/empresa/logo.png">
								</head>
								<body class="background show-spinner no-footer">
									<div class="fixed-background"></div>
									<main>
										<div class="container">
											<div class="row h-100">
												<div class="col-12 col-md-10 mx-auto my-auto">
													<div class="card auth-card">
														<div class="position-relative image-side"></div>
														<div class="form-side">
															<span class="logo-single"></span>
															<h3 class="mb-4"> '.$_SESSION['usuario'].' <small> - desconectado </h3></small>
															<form id="frmAcceso" name="frmAcceso" method="post" action="./">
																<div class="alert alert-success alert-dismissable" id="alertSuccess" style="display: none;">
																	<button type="button" class="close" data-hide="alertSuccess">×</button>
																	<i class="fa fa-check pr10"></i>
																	<span id="txtAlertSuccess"></span>
																</div>
																<div class="alert alert-danger alert-dismissable" id="alertDanger" style="display: none;">
																	<button type="button" class="close" data-hide="alertDanger">×</button>
																	<i class="fa fa-remove pr10"></i>
																	<span id="txtAlertDanger"></span>
																</div>
																<label class="form-group has-float-label mb-4">
																	<input type="password" class="form-control" id="txtRePassword" name="txtRePassword" placeholder="Capture su contrase&ntilde;a"/>
																	<span>Contrase&ntilde;a</span>
																</label>
																<div class="special-alerts">
																	<div class="alert alert-dark light alert-dismissable" id="alertRePassword" style="display: none;">
																		<button type="button" class="close" data-hide="alertRePassword">×</button>
																		<i class="fa fa-warning pr10"></i>
																		Capture la contrase&ntilde;a
																	</div>
																</div>
																<div class="d-flex justify-content-end align-items-center">
																	<button class="btn btn-primary btn-lg btn-shadow" type="button" id="btnReEnvio">Conectar</button>
																</div>
																<div class="row">
																	<div class="col-12 col-md-12 pt-3">
																		<a onclick="sessLogOut(2)" href="javascript:;" class="btn-link float-right text-small pt-1" title="Credenciales falsas">No eres '.$_SESSION['usuario'].'?</a>
																	</div>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>
										</div>
									</main>
									<script src="js/vendor/jquery-3.3.1.min.js"></script>
									<script src="js/vendor/bootstrap.bundle.min.js"></script>
									<script src="js/dore.script.js"></script>
									<script src="js/scripts.js"></script>
									<script src="script/portal/globales.js?v='.uniqid().'"></script>
									<script src="script/portal/md5.js?v='.uniqid().'"></script>
									<script src="script/portal/sistema.js?v='.uniqid().'"></script>
									'.scripttag("script/portal/gralLogin.js").'
								</body>
							</html>';

		return $formulario;
	}

	function muestra_sistema()
	{
		//CARGAMOS CONFIGURACIONES INICALES
		liberar_bd();
		$selectConfigSistema = 'CALL sp_sistema_select_datos_configuracion();';
		$configSistema = consulta($selectConfigSistema);
		$confSis = siguiente_registro($configSistema);

		$msj = '';
		if(trim($_POST['modulo'])=="-1")
		{
			cerrarSesion();
			$_SESSION["primerAcceso"] = 0;
			conectarSistema();
			$sistema = muestra_login();
		}
		else
		{
			if(trim($_POST['modulo']) != "")
				$_SESSION['mod'] = $_POST['modulo'];

			if($_POST['accion'] == "")
				$_POST['accion'] = "Inicio";

			$sistema = '<!DOCTYPE html>
							<html lang="es">
								<head>
									<meta charset="UTF-8">
									<title>.::Validación y Auditoría::.</title>
									<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
									<link rel="shortcut icon" href="imagenes/empresa/logo.png">
									'.head($_SESSION['mod'], $_POST['accion']).'
									<link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.css" media="all" rel="stylesheet" type="text/css" />
									<link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.brighttheme.css" media="all" rel="stylesheet" type="text/css" />
									<link href="https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.buttons.css" media="all" rel="stylesheet" type="text/css" />
								</head>
								<body id="app-container" class="menu-default show-spinner '.$styleMenu.'">
									<form name="frmSistema" id="frmSistema" method="post" action="./" enctype="multipart/form-data">
										<span name="campos" id="campos"></span>
										<input type="hidden" id="menuSelect" name="menuSelect" value="'.$_POST['menuSelect'].'" />
										<input type="hidden" id="modulo" name="modulo" value="'.$_SESSION['mod'].'" />
										<input type="hidden" id="idVA" name="idVA" value="'.$_SESSION['idVendedorActual'].'" />
										<nav class="navbar fixed-top">
											<div class="d-flex align-items-center navbar-left">';
												if($_SESSION['idPerfil'] <> 2)
												{
													$sistema.= '<a href="#" class="menu-button d-none d-md-block">
																	<svg class="main" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 9 17">
																		<rect x="0.48" y="0.5" width="7" height="1" />
																		<rect x="0.48" y="7.5" width="7" height="1" />
																		<rect x="0.48" y="15.5" width="7" height="1" />
																	</svg>
																	<svg class="sub" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18 17">
																		<rect x="1.56" y="0.5" width="16" height="1" />
																		<rect x="1.56" y="7.5" width="16" height="1" />
																		<rect x="1.56" y="15.5" width="16" height="1" />
																	</svg>
																</a>
																<a href="#" class="menu-button-mobile d-xs-block d-sm-block d-md-none">
																	<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 26 17">
																		<rect x="0.5" y="0.5" width="25" height="1" />
																		<rect x="0.5" y="7.5" width="25" height="1" />
																		<rect x="0.5" y="15.5" width="25" height="1" />
																	</svg>
																</a>';
												}
			$sistema.= '					</div>
											<a class="navbar-logo" href="javascript:;" onclick="navegar_modulo(0);">
												<span class="logo d-none d-xs-block"></span>
												<span class="logo-mobile d-block d-xs-none"></span>
											</a>
											<div class="navbar-right">
												<div class="header-icons d-inline-block align-middle">
													<div class="position-relative d-inline-block"></div>
													<button class="header-icon btn btn-empty d-none d-sm-inline-block" type="button" id="fullScreenButton">
														<i class="simple-icon-size-fullscreen"></i>
														<i class="simple-icon-size-actual"></i>
													</button>
												</div>
												<div class="user d-inline-block">
													<button class="btn btn-empty p-0" type="button" data-toggle="dropdown" aria-haspopup="true"
														aria-expanded="false">
														<span class="name">'.recortar_texto($_SESSION["usuario"], 20).'</span>
														<span>
															<img alt="Profile Picture" src="img/perfil_default.jpg" />
														</span>
													</button>
													<div class="dropdown-menu dropdown-menu-right mt-3">
														<a href="javascript:;" class="dropdown-item" onclick="navegar_modulo(10001);">Perfil</a>
														<a href="javascript:;" class="btnLogoutNow dropdown-item">Cerrar Sesi&oacute;n</a>
													</div>
												</div>
											</div>
										</nav>
										<div class="menu">
											'.muestra_menu($_SESSION['idPerfil']).'
										</div>
										<main>
											<div class="container-fluid">
												'.muestra_modulo($_SESSION['mod']).'
											</div>
											<div class="modal fade modal-right myModal" id="exampleModalRight" role="dialog" aria-labelledby="exampleModalRight" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content myModalContent" id="sidebar_right_content"></div>
												</div>
											</div>
										</main>
										<footer class="page-footer">
											<div class="footer-content">
												<div class="container-fluid">
													<div class="row">
														<div class="col-12 col-sm-6"></div>
													</div>
												</div>
											</div>
										</footer>
									</form>
									'.footer($_SESSION['mod'], $_POST['accion']).'
									<script type="text/javascript">
										$(document).ready(function()
										{
											if(typeof history.pushState === "function")
											{
												history.pushState("jibberish", null, null);
												window.onpopstate = function () {
													history.pushState("newjibberish", null, null);
													// Handle the back (or forward) buttons here
													// Will NOT handle refresh, use onbeforeunload for this.
												};
											}
											else
											{
												var ignoreHashChange = true;
												window.onhashchange = function ()
												{
													if (!ignoreHashChange) {
														ignoreHashChange = true;
														window.location.hash = Math.random();
														// Detect and redirect change here
														// Works in older FF and IE9
														// * it does mess with your hash symbol (anchor?) pound sign
														// delimiter on the end of the URL
													}
													else
													{
														ignoreHashChange = false;
													}
												};
											}

											initSessionMonitor();

											$(".btnLogoutNow").on("click", function()
											{
												sessLogOut(1);
											});
										});
									</script>
								</body>
								<audio class="audios" id="successAudio" controls preload="none">
								   <source src="sonidos/success.mp3" type="audio/mpeg">
								</audio>
								<audio class="audios" id="warningAudio" controls preload="none">
								   <source src="sonidos/warning.mp3" type="audio/mpeg">
								</audio>
								<audio class="audios" id="errorAudio" controls preload="none">
								   <source src="sonidos/error.mp3" type="audio/mpeg">
								</audio>
							</html>';
		}

		return $sistema;
	}

	function muestra_menu($idPerfil)
	{
		$arrayModDescart = array("11701", "11702");

		$menu = '<div class="main-menu"><div class="scroll"><ul class="list-unstyled">';
		$subMenu = '<div class="sub-menu"><div class="scroll">';

		liberar_bd();
		$selectModulosPadre = 'CALL sp_sistema_select_lista_modulos_padre();';
		$modulosPadre = consulta($selectModulosPadre);

		//REVISAR LOS PERMISOS CONCEDIDOS
		liberar_bd();
		$selectPermisosModulos = 'CALL sp_sistema_select_permisos_modulos('.$idPerfil.');';
		$permisosModulos = consulta($selectPermisosModulos);

		while($modulo = siguiente_registro($modulosPadre))
		{
			$checkedParent = false;
			while($p = siguiente_registro($permisosModulos))
			{
				if($p["id_modulo"] == $modulo["id_modulo"])
					$checkedParent = true;
			}
			mysqli_data_seek($permisosModulos,0);

			if($checkedParent == true)
			{
				$iconoMenu = '';
				if($modulo['icono_modulo'] != '')
					$iconoMenu = '<i class="'.$modulo['icono_modulo'].'"></i>';

				$refModulo = 'menuTypes'.$modulo["id_modulo"];

				//SUBMODULOS HIJO
				liberar_bd();
				$selectModulosHijo = 'CALL sp_sistema_select_modulos_hijo('.$modulo["id_modulo"].')';
				$modulosHijo = consulta($selectModulosHijo);
				$ctaModulosHijo = cuenta_registros($modulosHijo);
				if($ctaModulosHijo != 0)
				{
					$menu.= '<li>
								<a href="#'.$refModulo.'">
									'.$iconoMenu.'
									<span>'.utf8_convert($modulo['nombre_modulo']).'</span>
								</a>
							 </li>';

					$subMenu.='<ul class="list-unstyled" data-link="'.$refModulo.'">';

					while($subMod = siguiente_registro($modulosHijo))
					{
						if(!in_array($subMod["id_modulo"], $arrayModDescart))
						{
							//CHECAMOS SI TIENE NIETOS
							liberar_bd();
							$selectModulosNietos = 'CALL sp_sistema_select_modulos_hijo('.$subMod["id_modulo"].')';
							$modulosNietos = consulta($selectModulosNietos);
							$ctaModulosNietos = cuenta_registros($modulosNietos);

							if($ctaModulosNietos != 0)
							{
								$checkedSon = false;
								while($p = siguiente_registro($permisosModulos))
								{
									if($p["id_modulo"] == $subMod["id_modulo"])
									{
										$checkedSon = true;
									}
								}
								mysqli_data_seek($permisosModulos,0);

								if($checkedSon == true)
								{
									$iconoMenu = '';
									if($subMod['icono_modulo'] != '')
										$iconoMenu = '<i class="'.$subMod['icono_modulo'].'"></i>';

									$refSubModulo = 'menuTypes'.$subMod["id_modulo"];

									if($subMod['archivo_modulo'] == '')
									{
										$subMenu.=' <li>
														<a href="#" data-toggle="collapse" data-target="#'.$refSubModulo.'" aria-expanded="false"
															aria-controls="'.$refSubModulo.'" class="rotate-arrow-icon opacity-50 collapsed">
															<i class="simple-icon-arrow-down"></i> <span class="d-inline-block">'.utf8_convert($subMod['nombre_modulo']).'</span>
														</a>
														<div id="'.$refSubModulo.'" class="collapse">
															<ul class="list-unstyled inner-level-menu">';

										while($nietoMod = siguiente_registro($modulosNietos))
										{
											if(!in_array($nietoMod["id_modulo"], $arrayModDescart))
											{
												//CHECAMOS SI USARA UBICACION DE PRODUCTO
												if($nietoMod['id_padre'] == 2004 && $nietoMod["id_modulo"] >= 2008)
												{
													if($_SESSION['prodUbica'] == 1)
													{
														$checkedParent = false;
														while($p = siguiente_registro($permisosModulos))
														{
															if($p["id_modulo"] == $nietoMod["id_modulo"])
																$checkedParent = true;
														}
														mysqli_data_seek($permisosModulos,0);

														if($checkedParent == true)
														{
															$iconoMenu = '';
															if($nietoMod['icono_modulo'] != '')
																$iconoMenu = '<span class="'.$nietoMod['icono_modulo'].'"></span>';

															$subMenu.=' <li>
																			<a href="javascript:;" onclick="navegar_modulo('.$nietoMod['id_modulo'].',this.id);" id="menu_'.$nietoMod['id_padre'].'_'.$nietoMod['id_modulo'].'">
																				'.$iconoMenu.'
																				<span class="d-inline-block">'.utf8_convert($nietoMod['nombre_modulo']).'</span>
																			</a>
																		</li>';
														}
													}
												}
												else
												{
													$checkedParent = false;
													while($p = siguiente_registro($permisosModulos))
													{
														if($p["id_modulo"] == $nietoMod["id_modulo"])
															$checkedParent = true;
													}
													mysqli_data_seek($permisosModulos,0);

													if($checkedParent == true)
													{
														$iconoMenu = '';
														if($nietoMod['icono_modulo'] != '')
															$iconoMenu = '<i class="'.$nietoMod['icono_modulo'].'"></i>';

														$subMenu.=' <li>
																		<a href="javascript:;" onclick="navegar_modulo('.$nietoMod['id_modulo'].',this.id);" id="menu_'.$nietoMod['id_padre'].'_'.$nietoMod['id_modulo'].'">
																			'.$iconoMenu.'
																			<span class="d-inline-block">'.utf8_convert($nietoMod['nombre_modulo']).'</span>
																		</a>
																	</li>';
													}
												}
											}
										}

										$subMenu.='			</ul>
														</div>
													</li>';
									}
									else
									{
										$subMenu.=' <li>
														<a href="javascript:;" onclick="navegar_modulo('.$subMod['id_modulo'].',this.id);" id="menu_'.$subMod['id_padre'].'_'.$subMod['id_modulo'].'">
															'.$iconoMenu.'
															<span class="d-inline-block">'.utf8_convert($subMod['nombre_modulo']).'</span>
														</a>
													</li>';
									}

								}
							}
							else
							{
								$checkedSon = false;
								while($p = siguiente_registro($permisosModulos))
								{
									if($p["id_modulo"] == $subMod["id_modulo"])
									{
										$checkedSon = true;
									}
								}
								mysqli_data_seek($permisosModulos,0);

								if($checkedSon == true)
								{
									$iconoMenu = '';
									if($subMod['icono_modulo'] != '')
										$iconoMenu = '<i class="'.$subMod['icono_modulo'].'"></i>';

									$subMenu.=' <li>
													<a href="javascript:;" onclick="navegar_modulo('.$subMod['id_modulo'].',this.id);" id="menu_'.$subMod['id_padre'].'_'.$subMod['id_modulo'].'">
														'.$iconoMenu.'
														<span class="d-inline-block">'.utf8_convert($subMod['nombre_modulo']).'</span>
													</a>
												</li>';
								}
							}
						}
					}

					$subMenu.='</ul>';
				}
				elseif($modulo["archivo_modulo"] != "")
				{
					$menu.= '<li>
								<a href="javascript:;" onclick="navegar_modulo('.$modulo["id_modulo"].',this.id);">
									'.$iconoMenu.'
									<span>'.utf8_convert($modulo['nombre_modulo']).'</span>
								</a>
							 </li>';
				}
			}
		}

		$menu.= '</ul></div></div>';
		$subMenu.= '</div></div>';

		return $menu.$subMenu;
	}

	function muestra_modulo($id)
	{
		//VALIDAMOS PERMISOS MODULO
		liberar_bd();
		$selectPermisosModulos = 'CALL sp_sistema_select_permiso_modulo('.$_SESSION['idPerfil'].', '.$id.');';
		$permisosModulos = consulta($selectPermisosModulos);
		$ctaPerMod = cuenta_registros($permisosModulos);
		if($ctaPerMod != 0)
		{
			liberar_bd();
			$sql="SELECT archivo_modulo as archivo FROM _modulos WHERE id_modulo = " . $id;
			$res = consulta($sql);
			$ctaRes = cuenta_registros($res);
			$modulo='<input type="hidden" name="accion" />';
			if($ctaRes != 0)
			{
				$fila = siguiente_registro($res);
				if($fila["archivo"] != "")
					include_once($fila['archivo']);
				else
					include_once('./modulos/dashboard/comingsoon.php');
			}
			else
				include_once('./modulos/dashboard/inicio.php');
		}
		else
			include_once('./modulos/dashboard/inicio.php');

		return $modulo;
	}

	function footer($pageModu, $pageMode)
	{
		$scriptPaginaNew =  scripttag("js/vendor/jquery-3.3.1.min.js")
							.scripttag("js/vendor/bootstrap.bundle.min.js")
							.scripttag("js/vendor/moment.min.js")
							.scripttag("js/vendor/fullcalendar.min.js")
							.scripttag("js/vendor/datatables.min.js")
							.scripttag("js/vendor/perfect-scrollbar.min.js")
							.scripttag("js/vendor/bootstrap-notify.min.js")
							.scripttag("js/vendor/select2.full.js")
							.scripttag("js/vendor/bootstrap-datepicker.js")
							.scripttag("assets/plugins/daterange/daterangepicker.js")
							.scripttag("js/vendor/dropzone.min.js")
							.scripttag("js/vendor/bootstrap-tagsinput.min.js")
							.scripttag("js/vendor/nouislider.min.js")
							.scripttag("js/vendor/jquery.barrating.min.js")
							.scripttag("js/vendor/cropper.min.js")
							.scripttag("js/vendor/typeahead.bundle.js")
							.scripttag("js/vendor/mousetrap.min.js")
							.scripttag("js/dore-plugins/select.from.library.js")
							.scripttag("https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js")
							.scripttag("https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js")
							.scripttag("https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js")
							.scripttag("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js")
							.scripttag("https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js")
							.scripttag("https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js")
							.scripttag("https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js")
							.scripttag("https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.js")
							.scripttag("https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.confirm.js")
							.scripttag("https://cdnjs.cloudflare.com/ajax/libs/pnotify/3.2.1/pnotify.buttons.js")
							.scripttag('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/js/bootstrap-select.min.js')
							.scripttag("js/dore.script.js")
							.scripttag("script/portal/globales.js")
							.scripttag("script/portal/sistema.js")
							.scripttag("js/scripts.js")
							.scripttag("script/portal/jquery.numeric.js")
							.scripttag("script/portal/sessionTimeout.js")
							.scripttag("script/portal/gralLogin.js")
							.scripttag('assets/plugins/keyboardJS/dist/keyboard.js')
							.scripttag('assets/plugins/timedropper/timedropper.js')
							.scripttag('js/vendor/bootstrap-datepicker.js')
							.scripttag("assets/plugins/form-colorpicker/js/bootstrap-colorpicker.min.js")
							.scripttag("script/portal/gralSistema.js")
							.scripttag("https://cdn.jsdelivr.net/npm/flatpickr")
							.scripttag("https://npmcdn.com/flatpickr/dist/l10n/es.js")
							.scripttag("https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/index.js")
							.scripttag("js/vendor/glide.min.js");

		if($pageModu == 0)
			$scriptPaginaNew .=scripttag("script/portal/moduloInicio.js");

		if($pageModu == 10001 || $pageModu == 10002 || $pageModu == 11706)
			$scriptPaginaNew .=scripttag("script/portal/moduloSistema.js");

		if($pageModu == 11610)
			$scriptPaginaNew .=scripttag("script/portal/moduloCatalogos.js");

		if($pageModu == 11610)
			$scriptPaginaNew .= scripttag("js/vendor/quill.min.js")
								.scripttag("js/vendor/ckeditor5-build-classic/ckeditor.js");

		if($pageModu == 11704)
			$scriptPaginaNew .=scripttag("script/portal/moduloAdmon.js");

		return $scriptPaginaNew;
	}

	function head($pageModu, $pageMode)
	{
		$cssPaginaNew = linktag('css/vendor/bootstrap-datepicker3.min.css')
						.linktag('assets/plugins/daterange/daterangepicker.css')
						.linktag('font/iconsmind-s/css/iconsminds.css')
						.linktag('font/simple-line-icons/css/simple-line-icons.css')
						.linktag('https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css')
						.linktag('https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css')
						.linktag('css/vendor/dataTables.bootstrap4.min.css')
						.linktag('css/vendor/datatables.responsive.bootstrap4.min.css')
						.linktag('css/vendor/perfect-scrollbar.css')
						.linktag('css/vendor/bootstrap.min.css')
						.linktag('css/vendor/bootstrap.rtl.only.min.css')
						.linktag('css/vendor/fullcalendar.min.css')
						.linktag('css/vendor/bootstrap-float-label.min.css')
						.linktag('css/vendor/select2.min.css')
						.linktag('css/vendor/select2-bootstrap.min.css')
						.linktag('css/vendor/dropzone.min.css')
						.linktag('css/vendor/bootstrap-tagsinput.css')
						.linktag('css/vendor/component-custom-switch.min.css')
						.linktag('css/vendor/perfect-scrollbar.css')
						.linktag('css/vendor/nouislider.min.css')
						.linktag('css/vendor/bootstrap-stars.css')
						.linktag('css/vendor/cropper.min.css')
						.linktag('assets/plugins/timedropper/timedropper.css')
						.linktag('vendor/plugins/colorpicker/css/bootstrap-colorpicker.min.css')
						.linktag('css/main.css')
						.linktag('https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css')
						.linktag('https://npmcdn.com/flatpickr/dist/themes/dark.css')
						.linktag('https://cdn.jsdelivr.net/npm/flatpickr@latest/dist/plugins/monthSelect/style.css')
						.linktag('css/vendor/glide.core.min.css');

		if($pageModu == 11610)
			$cssPaginaNew .= linktag("css/vendor/quill.snow.css")
							.linktag("css/vendor/component-custom-switch.min.css");

		return $cssPaginaNew;
	}

	function cerrarSesion()
	{
		session_unset();
		session_destroy();
	}