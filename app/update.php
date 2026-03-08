<?php
    session_start();
    error_reporting(E_ERROR);
    include_once("../portal/motor/conexionSitio.php");
    include_once("../portal/motor/globales.php");

    $formulario = '	<!DOCTYPE html>
						<html lang="en">
							<head>
								<meta charset="UTF-8">
								<title>.::Sistema Integral Sicresa::.</title>
								<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
								<meta http-equiv="expires" content="Mon, 26 Jul 1997 05:00:00 GMT"/>
								<meta http-equiv="pragma" content="no-cache" />
								<link rel="stylesheet" href="../portal/font/iconsmind-s/css/iconsminds.css" />
								<link rel="stylesheet" href="../portal/font/simple-line-icons/css/simple-line-icons.css" />
								<link rel="stylesheet" href="../portal/css/vendor/bootstrap.min.css" />
								<link rel="stylesheet" href="../portal/css/vendor/bootstrap.rtl.only.min.css" />
								<link rel="stylesheet" href="../portal/css/vendor/bootstrap-float-label.min.css" />
								<link rel="stylesheet" href="../portal/css/vendor/select2.min.css" />
								<link rel="stylesheet" href="../portal/css/vendor/select2-bootstrap.min.css" />
								<link rel="stylesheet" href="../portal/css/main.css" />
								<link rel="shortcut icon" href="../portal/imagenes/empresa/icono.png">
							</head>
							<body class="background no-footer">
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
								<script src="../portal/js/vendor/jquery-3.3.1.min.js"></script>
								<script src="../portal/js/vendor/bootstrap.bundle.min.js"></script>
								<script src="../portal/js/vendor/select2.full.js"></script>
								<script src="../portal/js/vendor/bootstrap-notify.min.js"></script>
								<script src="../portal/js/vendor/mousetrap.min.js"></script>
								'.scripttag("../portal/js/dore.script.js?v=".uniqid()).
                                scripttag("../portal/script/portal/globales.js?v=".uniqid()).
                                scripttag("../portal/script/portal/sistema.js?v=".uniqid()).
                                scripttag("../portal/js/scripts.js?v=".uniqid()).
                                scripttag("../portal/script/portal/gralLogin.js").'
							</body>
						</html>';

    echo $formulario;
