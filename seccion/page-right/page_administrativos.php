<?php
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
		case '11101':
			switch($_POST["action"])
			{
				case 'new':
				case 'edit':
					$idTitulo = 0;
					if($_POST["idElem"] != 0)
					{
						//DATOS DEL AGENTE
						liberar_bd();
						$selectDatosCatAdmon = "CALL sp_sistema_select_datos_cat_admon_tipo(".$_POST["idElem"].");";
						$datosCatAdmon = consulta($selectDatosCatAdmon);
						$catAdmon = siguiente_registro($datosCatAdmon);
						$nombreTipo = utf8_convert($catAdmon["nombreCat"]);
						$descTipo = utf8_convert($catAdmon["txtCat"]);
						$slug = utf8_convert($catAdmon["slugCat"]);
						$idTitulo = $catAdmon["idRefCat"];
					}

					//TITULO PROFESIONAL
					liberar_bd();
					$optionTitulos = '<option value="0">SELECCIONE EL T&Iacute;TULO</option>';
					$selectCatalogoAdmon = 'CALL sp_sistema_select_lista_catalogo_admon_tipo(6);';
					$catalogoAdmon = consulta($selectCatalogoAdmon);
					while($catAdmon = siguiente_registro($catalogoAdmon))
					{
						$selTitulo = '';
						if($idTitulo == $catAdmon["id"])
							$selTitulo = ' selected="selected" ';

						$optionTitulos .= '<option '.$selTitulo.' value="'.$catAdmon["id"].'">'.utf8_convert($catAdmon["nombre"]).'</option>';
					}

					$catalogo = '	<div class="tab-block sidebar-block br-n">
										<input readonly class="slug" type="hidden" id="slug" name="slug" value="'.$slug.'">
										<div class="tab-content br-n">
											<div class="col-md-12 admin-grid">
												<div class="panel sort-disable" id="p0">
													<div class="panel-body">
														<h4 class="title-divider mt25 mb10"><i class="fa fa-file-text-o"></i> Datos del agente</h4>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Nombre:</label>
																<div class="col-md-7">
																	<input class="form-control input-sm inpAC" type="text" id="nombreTipo" name="nombreTipo" maxlength="100" value="'.$nombreTipo.'">
																</div>
															</div>
														</div>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">T&iacute;tulo prefesional:</label>
																<div class="col-md-7">
																	<select id="idTitulo" name="idTitulo" class="selectForm">
																		'.$optionTitulos.'
																	</select>
																</div>
															</div>
														</div>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Descripci&oacute;n:</label>
																<div class="col-md-7">
																	<textarea class="form-control" name="descTipo" id="descTipo" rows="15">'.$descTipo.'</textarea>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-xs-12 va-b prn">
																<menu id="nestable-menu" class="text-right mb10">
																	<div class="btn-group" data-toggle="buttons">
																		<button type="button" class="btn bg-danger light dark mr5 close_sidemenu_r"><i class="fa fa-times-circle-o"></i> Cerrar</button>
																		<button type="button" class="btn bg-dark light dark mr5" onclick="action_page(\''.$_POST["divCarga"].'\', '.$_POST["catTipo"].',  \''.$_POST["action"].'\', '.$_POST["idElem"].')"><i class="fa fa-floppy-o"></i> Guardar</button>
																	</div>
																</menu>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>';
				break;
				case 'newContact':
				case 'editContact':
					$idForma = 0;
					$idElem = explode("_", $_POST["idElem"]);
					$idNewElem = $idElem[0];
					$tipo = $idElem[1];
					$chkPrincipal = "";

					if($tipo != 0)
					{
						liberar_bd();
						$selectDatosContacto = "CALL sp_sistema_select_datos_contacto(".$tipo.");";
						$datosContacto = consulta($selectDatosContacto);
						$datCont = siguiente_registro($datosContacto);
						$nombreTipo = utf8_convert($datCont["valor"]);
						$idForma = $datCont["idCatAdmon"];

						//REVISAMOS SI EXISTE TIPO DE CONTACTO PRINCIPAL
						liberar_bd();
						$selectContactoPrincipal = 'CALL sp_sistema_select_contacto_id_tipo_prioridad('.$idNewElem.', '.$tipo.');';
						$contactoPrincipal = consulta($selectContactoPrincipal);
						$ctaContactoPrincipal = cuenta_registros($contactoPrincipal);
						if($ctaContactoPrincipal != 0)
							$chkPrincipal = "checked";
					}

					//FORMA DE CONTACTO
					liberar_bd();
					$optionForma = '<option value="0">Seleccione una forma de contacto</option>';
					$selectCatalogoAdmon = 'CALL sp_sistema_select_lista_catalogo_admon_tipo(5);';
					$catalogoAdmon = consulta($selectCatalogoAdmon);
					while($catAdmon = siguiente_registro($catalogoAdmon))
					{
						$selForma = '';
						if($idForma == $catAdmon["id"])
							$selForma = ' selected="selected" ';

						$optionForma.= '<option '.$selForma.' value="'.$catAdmon["id"].'">'.utf8_convert($catAdmon["nombre"]).'</option>';
					}

					$catalogo = '	<div class="tab-block sidebar-block br-n">
										<input readonly class="slug" type="hidden" id="slug" name="slug" value="'.$slug.'">
										<div class="tab-content br-n">
											<div class="col-md-12 admin-grid">
												<div class="panel sort-disable" id="p0">
													<div class="panel-body">
														<h4 class="title-divider mt25 mb10"><i class="fa fa-file-text-o"></i> Datos de la forma de contacto</h4>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Principal:</label>
																<div class="col-md-7">
																	<input '.$chkPrincipal.' type="checkbox" id="principal" name="principal">
																</div>
															</div>
														</div>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Forma de contacto:</label>
																<div class="col-md-7">
																	<select id="idForma" name="idForma" class="selectForm">
																		'.$optionForma.'
																	</select>
																</div>
															</div>
														</div>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Contacto:</label>
																<div class="col-md-7">
																	<input class="form-control input-sm" type="text" id="nombreTipo" name="nombreTipo" maxlength="100" value="'.$nombreTipo.'">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-xs-12 va-b prn">
																<menu id="nestable-menu" class="text-right mb10">
																	<div class="btn-group" data-toggle="buttons">
																		<button type="button" class="btn bg-danger light dark mr5 close_sidemenu_r"><i class="fa fa-times-circle-o"></i> Cerrar</button>
																		<button type="button" class="btn bg-dark light dark mr5" onclick="action_page(\''.$_POST["divCarga"].'\', '.$_POST["catTipo"].',  \''.$_POST["action"].'\', \''.$_POST["idElem"].'\')"><i class="fa fa-floppy-o"></i> Guardar</button>
																	</div>
																</menu>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>';
				break;
				case 'newProfile':
				case 'editProfile':
					$idTipo = 0;
					$idElem = explode("_", $_POST["idElem"]);
					$idNewElem = $idElem[0];
					$tipo = $idElem[1];
					$chkPrincipal = "";

					if($tipo != 0)
					{
						liberar_bd();
						$selectDatosContacto = "CALL sp_sistema_select_datos_red_cat_admon(".$tipo.");";
						$datosContacto = consulta($selectDatosContacto);
						$datCont = siguiente_registro($datosContacto);
						$url = utf8_convert($datCont["url"]);
						$idTipo = $datCont["idRed"];

						//REVISAMOS SI EXISTE LA RED SOCIAL PRINCIPAL
						liberar_bd();
						$selectRedPrincipal = 'CALL sp_sistema_select_red_id_tipo_prioridad('.$idNewElem.', '.$tipo.');';
						$redPrincipal = consulta($selectRedPrincipal);
						$ctaRedPrincipal = cuenta_registros($redPrincipal);
						if($ctaRedPrincipal != 0)
							$chkPrincipal = "checked";
					}

					//TIPO DE REDES SOCIALES
					liberar_bd();
					$optionTipo = '<option value="0">Seleccione tipo de red</option>';
					$selectTiposRedes = 'CALL sp_sistema_select_lista_tipos_redes_sociales();';
					$tiposRedes = consulta($selectTiposRedes);
					while($tipRed = siguiente_registro($tiposRedes))
					{
						$selTipo = '';
						if($idTipo == $tipRed["id"])
							$selTipo = ' selected="selected" ';

						$optionTipo.= '<option '.$selTipo.' value="'.$tipRed["id"].'">'.utf8_convert($tipRed["tipo"]).'</option>';
					}

					$catalogo = '	<div class="tab-block sidebar-block br-n">
										<input readonly class="slug" type="hidden" id="slug" name="slug" value="'.$slug.'">
										<div class="tab-content br-n">
											<div class="col-md-12 admin-grid">
												<div class="panel sort-disable" id="p0">
													<div class="panel-body">
														<h4 class="title-divider mt25 mb10"><i class="fa fa-file-text-o"></i> Datos del perfil social</h4>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Principal:</label>
																<div class="col-md-7">
																	<input '.$chkPrincipal.' type="checkbox" id="principal" name="principal">
																</div>
															</div>
														</div>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Tipo de red social:</label>
																<div class="col-md-7">
																	<select id="idTipo" name="idTipo" class="selectForm">
																		'.$optionTipo.'
																	</select>
																</div>
															</div>
														</div>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Url del perfil:</label>
																<div class="col-md-7">
																	<input class="form-control input-sm" type="text" id="url" name="url" maxlength="100" value="'.$url.'">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-xs-12 va-b prn">
																<menu id="nestable-menu" class="text-right mb10">
																	<div class="btn-group" data-toggle="buttons">
																		<button type="button" class="btn bg-danger light dark mr5 close_sidemenu_r"><i class="fa fa-times-circle-o"></i> Cerrar</button>
																		<button type="button" class="btn bg-dark light dark mr5" onclick="action_page(\''.$_POST["divCarga"].'\', '.$_POST["catTipo"].',  \''.$_POST["action"].'\', \''.$_POST["idElem"].'\')"><i class="fa fa-floppy-o"></i> Guardar</button>
																	</div>
																</menu>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>';
				break;
				case 'newImage':
					$idElem = explode("_", $_POST["idElem"]);
					$idNewElem = $idElem[0];

					/*$chkPrincipal = "";
					//REVISAMOS SI EXISTE IMAGEN PRINCIPAL
					liberar_bd();
					$selectImagenPrincipal = 'CALL sp_sistema_select_imagen_id_tipo_prioridad('.$idNewElem.', 1);';
					$imagenPrincipal = consulta($selectImagenPrincipal);
					$ctaImagenPrincipal = cuenta_registros($imagenPrincipal);
					if($ctaImagenPrincipal != 0)
						$chkPrincipal = "checked";*/

					$catalogo = '	<div class="tab-block sidebar-block br-n">
										<div class="tab-content br-n">
											<div class="col-md-12 admin-grid">
												<div class="panel sort-disable" id="p0">
													<div class="panel-body">
														<h4 class="title-divider mt25 mb10"><i class="fa fa-file-text-o"></i> Im&aacute;gen galer&iacute;a</h4>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Principal:</label>
																<div class="col-md-7">
																	<input type="checkbox" id="principal" name="principal">
																</div>
															</div>
														</div>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-12 text-left">Nueva im&aacute;gen:</label>
																<div class="col-md-12 admin-form">
																	<div class="section">
																		<label class="field prepend-icon file">
																			<span class="button">Adjuntar</span>
																			<input type="file" class="gui-file" id="imagen" onChange="document.getElementById(\'uploader2\').value = this.value;">
																			<input type="text" class="gui-input" id="uploader2" placeholder="Seleccione una im&aacute;gen">
																			<label class="field-icon"><i class="fa fa-upload"></i></label>
																		</label>
																	</div>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-xs-12 va-b prn">
																<menu id="nestable-menu" class="text-right mb10">
																	<div class="btn-group" data-toggle="buttons">
																		<button type="button" class="btn bg-danger light dark mr5 close_sidemenu_r"><i class="fa fa-times-circle-o"></i> Cerrar</button>
																		<button type="button" class="btn bg-dark light dark mr5" onclick="action_page(\''.$_POST["divCarga"].'\', '.$_POST["catTipo"].',  \''.$_POST["action"].'\', \''.$_POST["idElem"].'\')"><i class="fa fa-floppy-o"></i> Guardar</button>
																	</div>
																</menu>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>';
				break;
				case 'catChange':
					//DATOS DEL USUARIO
					liberar_bd();
					$selectDatosCatAcces = 'CALL sp_sistema_select_datos_catalogo_acceso('.$_POST["idElem"].');';
					$datosCatAcces = consulta($selectDatosCatAcces);
					$datAcc = siguiente_registro($datosCatAcces);
					$idRefCat = $datAcc["idRefCat"];

					//LISTA DE CATEGORÍAS
                    liberar_bd();
                    $optionCategorias = '<option value="0">SELECCIONE UNA CATEGOR&Iacute;A</option>';
                    $selectCatalogoCat = 'CALL sp_sistema_select_lista_catalogo_admon_tipo(13);';
                    $catalogoCat = consulta($selectCatalogoCat);
                    while($cat = siguiente_registro($catalogoCat))
                    {
                        $selectCat = "";
                        if($cat["id"] == $idRefCat)
                            $selectCat = "selected";

                        $optionCategorias.= '<option '.$selectCat.' value="'.$cat["id"].'">'.utf8_convert($cat["nombre"]).'</option>';
                    }

					$catalogo = '	<div class="tab-block sidebar-block br-n">
										<input readonly class="slug" type="hidden" id="slug" name="slug" value="'.$slug.'">
										<div class="tab-content br-n">
											<div class="col-md-12 admin-grid">
												<div class="panel sort-disable" id="p0">
													<div class="panel-body">
														<h4 class="title-divider mt25 mb10"><i class="fa fa-file-text-o"></i> Cambio de categor&iacute;a</h4>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Nombre:</label>
																<label class="col-sm-7">'.utf8_convert($datAcc["nombreCatAdmon"]).'</label>
															</div>
														</div>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Correo:</label>
																<label class="col-sm-7">'.utf8_convert($datAcc["correo"]).'</label>
															</div>
														</div>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Categor&iacute;a actual:</label>
																<label class="col-sm-7">'.utf8_convert($datAcc["nomCatUser"]).'</label>
															</div>
														</div>
														<div class="form-horizontal" role="form">
															<div class="form-group">
																<label class="col-sm-5 text-left">Categor&iacute;a:</label>
																<div class="col-md-7">
																	<select id="idCatUser" name="idCatUser" class="selectForm">
																		'.$optionCategorias.'
																	</select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-xs-12 va-b prn">
																<menu id="nestable-menu" class="text-right mb10">
																	<div class="btn-group" data-toggle="buttons">
																		<button type="button" class="btn bg-danger light dark mr5 close_sidemenu_r"><i class="fa fa-times-circle-o"></i> Cerrar</button>
																		<button type="button" class="btn bg-dark light dark mr5" onclick="action_page(\''.$_POST["divCarga"].'\', '.$_POST["catTipo"].',  \''.$_POST["action"].'\', '.$_POST["idElem"].')"><i class="fa fa-floppy-o"></i> Guardar</button>
																	</div>
																</menu>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>';
				break;
			}
		break;
	}

	echo json_encode(array("catalogo"=>$catalogo, "valAction"=>$valAction, "alert"=>$alert, "idReturn"=>$idReturn, "txtReturn"=>$txtReturn));
