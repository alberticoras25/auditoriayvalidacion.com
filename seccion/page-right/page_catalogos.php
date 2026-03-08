<?php
	ini_set( 'date.timezone', 'America/Mexico_City' );
	session_start();
	error_reporting(E_ERROR);
	include_once("../../portal/motor/conexionSitio.php");
	include_once("../../portal/motor/globales.php");
	conectarSistema();
	$valAction = "true";
	$alert = $txtReturn = '';
	$idReturn = 0;

	switch($_POST["catTipo"])
	{
		case '11610':
			switch($_POST["action"])
			{
				case 'qr':
					//DATOS DEL DOCUMENTO
					liberar_bd();
					$selectDocumento = 'CALL sp_sistema_select_datos_catalogo_documento_id('.$_POST["idElem"].');';
					$documento = consulta($selectDocumento);
					$doc = siguiente_registro($documento);

					$catalogo = '	<div class="modal-header">
										<h5 class="modal-title">Datos del QR</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<img src="imagenes/qr/'.$doc["qr"].'" style="width:100%;">
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
									</div>';
				break;
			}
		break;
		case '11702':
			switch($_POST["action"])
			{
				case 'new':
				case 'edit':
					$actualDate = date("d-m-Y");
					if($_POST["idElem"] != 0)
					{
						liberar_bd();
						$selectUsuarioId = "CALL sp_sistema_select_usuario_id(".$_POST["idElem"].");";
						$usuarioId = consulta($selectUsuarioId);
						$user = siguiente_registro($usuarioId);
						$nomUser = utf8_convert($user["nombre"]);
						$logUser = utf8_convert($user["login"]);
						$idPerfil = $user["idPerfil"];
						$alertPass = '  <div class="alert alert-warning alert-dismissable">
											<i class="fa fa-warning pr10"></i>
											<strong>Dejar ambos campos en blanco para no modificar la contrase&ntilde;a</strong>
										</div>';

						$txtUsuario = ": ".utf8_convert($user["nombre"]);
					}
					else
					{
						$alertPass = $txtUsuario = '';
						$idPerfil = $idSucGral = $idSucActual = 0;
					}

					if($idPerfil == 1)
						$divPerfil = '<input type="hidden" id="id_perfil" name="id_perfil" value="1">';
					else
					{
						$divPerfil = '	<label class="form-group has-float-label col-md-12">
											<select id="id_perfil" name="id_perfil" class="form-control selectForm">
												<option value="0">Seleccione un perfil</option>';
												//LISTA DE PERFILES
												liberar_bd();
												$selectPerfil = "CALL sp_sistema_lista_perfiles();";
												$perfiles = consulta($selectPerfil);
												while($per = siguiente_registro($perfiles))
												{
													$selPerfil = '';
													if($idPerfil == $per["id"])
														$selPerfil = 'selected';

													$divPerfil .= '<option '.$selPerfil.' value="'.$per["id"].'">'.utf8_convert($per["nombre"]).'</option>';
												}
						$divPerfil.= '		</select>
											<span>Perfil de usuario</span>
										</label>';
					}

					$catalogo = '	<div class="modal-header">
										<h5 class="modal-title">Datos del usuario</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<label class="form-group has-float-label col-md-12">
											<input type="text" class="form-control inpAC" id="nomUser" name="nomUser" value="'.$nomUser.'">
											<span>Nombre completo del usuario</span>
										</label>
										'.$divPerfil.'
										<label class="form-group has-float-label col-md-12">
											<input type="text" class="form-control inpAC" id="logUser" name="logUser" value="'.$logUser.'">
											<span>Usuario</span>
										</label>
										'.$alertPass.'
										<label class="form-group has-float-label col-md-12">
											<input type="password" class="form-control inpAC" id="pswd" name="pswd">
											<span>Contrase&ntilde;a</span>
										</label>
										<label class="form-group has-float-label col-md-12">
											<input type="password" class="form-control inpAC" id="pswd_c" name="pswd_c">
											<span>Confirmar contrase&ntilde;a</span>
										</label>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-dark"  onclick="action_page(\''.$_POST["divCarga"].'\', '.$_POST["catTipo"].', \''.$_POST["action"].'\', '.$_POST["idElem"].')">Guardar</button>
										<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
									</div>';
				break;
			}
		break;
	}

	echo json_encode(array("catalogo"=>$catalogo, "valAction"=>$valAction, "alert"=>$alert, "idReturn"=>$idReturn, "txtReturn"=>$txtReturn));