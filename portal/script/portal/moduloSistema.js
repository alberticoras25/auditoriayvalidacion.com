$(document).ready(function()
{
	var myEditor;
	var catTable, catSubTable, catSubRepTable, currentOrder, currentSubOrder, currentSubRepOrder = '';
	var x = [];
	modulo = parseInt(sessionStorage.getItem("modulo"));
	switch(modulo)
	{
		case 11706:
			busqueda_Catalogo("divNavCatUser", ".");
		break;
		case 10001:
			formCatalogo('divFormCatalogo', modulo, 'edit', 0);
		break;
		default:
			cargaCatalogo('divCatalogo', modulo, 0);
		break;
	}
});

function cargaCatalogo(divCarga, catTipo, idElem)
{
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["idElem"] = idElem;

	switch(catTipo)
	{
		case 11702:
			var selectPerf = new Array();
			$("#idPerfilFil :selected").each(function () {
				selectPerf.push({idPerf: $(this).val()});
			});
			formData.selectPerf = selectPerf;
		break;
	}

	$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/ajax/portal/catalogs.php", formData,
	function (valData)
	{
		if (valData.valCatalogo == "false")
			alert(valData.alert);
		else
			$("."+divCarga).html(valData.catalogo);

	}, 'json').done(function(valData)
	{
		btnShowModalCat();
		dateRangePicker("fechaReporte");

		switch(catTipo)
		{
			case 10002:
				resetNewDataTable2("tableOrder", 0, 0, "desc", "btnShowModal", "");
			break;
			case 11702:
				multiSelectGral("idPerfilFil", "#", "Seleccione los perfiles", "Seleccionados todos", "Seleccionar todos", "Perfiles seleccionados");
				catTable = resetNewDataTable2("tableOrder", 0, 0, "desc", "btnShowModal", "", "divCatalogo");
			break;
			case 11701:
				catTable = resetNewDataTable2("tableOrder", 0, 0, "desc", "btnShowModal", "", "divCatalogo");
			break;
		}

		scrollTopSite("");
	});
}

function busqueda_Catalogo(className, tipo)
{
	var divNav = '';
	className = typeof className !== 'undefined' ?  className : '';
	tipo = typeof tipo !== 'undefined' ?  tipo : '.';

	if(className != "")
		divNav = tipo + className;

	var ref_this = $(".nav-tabs"+divNav+" li.nav-item a.active");
	eval($( ref_this ).attr("onclick"));
}

function formCatalogo(divCarga, catTipo, form, idElem)
{
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["idElem"] = idElem;
	formData["form"] = form;

	switch(catTipo)
	{
		case 10002:
			$(".divFormPrint").html("");
		break;
		case 11701:
		case 11702:
			switch(form)
			{
				case 'catalogo':
					$(".tabUsuario").html("");
				break;
			}
		break;
	}

	$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/ajax/portal/formCatalogs.php", formData,
	function (valData)
	{
		if (valData.valCatalogo == "false")
			alert(valData.alert);
		else
		{
			$("."+divCarga).html(valData.formulario);
			switch(catTipo)
			{
				case 10001:
					switch(form)
					{
						case 'edit':
							newDatePickerSimple('fechaNat');
							clearAutoComplete("inpAC", ".");
							clearValue("inpCont", ".");
							$(".classGralNum").numeric(".");
						break;
					}
				break;
				case 10002:
					switch(form)
					{
						case 'dataRed':
						break;
						case 'close':
							$("." + divCarga).html("");
							cargaCatalogo('divCatalogo', modulo, 0);
						break;
						case 'edit':
							switch(idElem)
							{
								case 1:
									resetSelectGral("selectForm");
									$('#idRed').change(function()
									{
										var idRed = parseInt($("#idRed").val());
										if(idRed != 0)
											formCatalogo('divNewCta', catTipo, 'dataRed', idRed);
										else
											$(".divNewCta").html("");
									});

									isInt("diasMov", "#");
								break;
								case 2:
								case 8:
									$(".classGralNum").numeric(".");
								break;
								case 3:
									$(".classGralNum").numeric(".");
									resetSelectGral("selectForm");
									$('input[type=radio][name=pagoComi]').change(function ()
									{
										$("#comisionGral").val("");
										if(this.value == 2)
										{
											$(".divTipoComi").css("display","block");
											$("input[name=tipoComi][value='1']").prop('checked', true);
											$(".divComiGral").css("display","block");
										}
										else if(this.value == 1)
										{
											$(".valCom").val("");
											$(".divTipoComi").css("display","none");
											$(".divComiGral").css("display","none");
											$(".divComiPerfil").css("display","none");
										}
									});

									$('input[type=radio][name=tipoComi]').change(function ()
									{
										$(".valCom").val("");
										$("#comisionGral").val("");
										if(this.value == 1)
										{
											$(".divComiPerfil").css("display","none");
											$(".divComiGral").css("display","block");
										}
										else if(this.value == 2)
										{
											$(".valCom").numeric(".");
											$(".divComiGral").css("display","none");
											$(".divComiPerfil").css("display","block");
										}
									});

									$('input[type=radio][name=notiRet]').change(function ()
									{
										$("#montoRetiro").val("");
										if(this.value == 1)
										{
											var oldMontoRetiro = $("#oldMontoRetiro").val();
											$("#montoRetiro").val(oldMontoRetiro);
											$(".divCantRet").css("display","block");
										}
										else
										{
											$(".divCantRet").css("display","none");
										}
									});

									$('input[type=radio][name=depositoRet]').change(function ()
									{
										resetSelectValueZero('classCtas', '.', '0', 'Seleccione una institución');
										$(".classTxtCuentas").val("");
										if(this.value == 1)
											$(".divCtaRet").css("display","block");
										else
											$(".divCtaRet").css("display","none");
									});

									timePicker('valNewHora', '#', 'time', ".");
								break;
								case 4:
								break;
								case 6:
									resetSelectGral("selectForm");
									$('input[type=radio][name=localizaCli]').change(function ()
									{
										destroySelectMain("idPaisCli", "#", "0");
										resetSelectValueZero('idEdoCli', '#', '1', 'Seleccione un estado');
										resetSelectValueZero('idCityCli', '#', '1', 'Seleccione una ciudad');
										$("input[name=defineCli][value='1']").prop('checked', true);
										$("#divEdoCli").css("display","none");
										$("#divCityCli").css("display","none");
										if(this.value == 2)
										{
											$("#divPaisCli").css("display","none");
											$(".dirCli").css("display","none");
										}
										else if(this.value == 1)
										{
											$("#divPaisCli").css("display","block");
											$(".dirCli").css("display","block");
										}
									});

									$('input[type=radio][name=defineCli]').change(function ()
									{
										switch(parseInt(this.value))
										{
											case 1:
												$("#divEdoCli").css("display","none");
												$("#divCityCli").css("display","none");
												destroySelectMain("idPaisCli", "#", "0");
												resetSelectValueZero('idEdoCli', '#', '1', 'Seleccione un estado');
												resetSelectValueZero('idCityCli', '#', '1', 'Seleccione una ciudad');
											break;
											case 2:
												$("#divEdoCli").css("display","block");
												$("#divCityCli").css("display","none");
												var idPaisCli = $("#idPaisCli").val();
												if(idPaisCli != 0)
													selectListId(idPaisCli, "#", 'estadosPais', 'idEdoCli');
												else
													resetSelectValueZero('idEdoCli', '#', '1', 'Seleccione un estado');
											break;
											case 3:
												$("#divCityCli").css("display","block");
												var idEdoCli = $("#idEdoCli").val();
												if(idEdoCli != 0)
													selectListId(idEdoCli, "#", 'ciudadesEstado', 'idCityCli');
												else
													resetSelectValueZero('idCityCli', '#', '1', 'Seleccione una ciudad');
											break;
										}
									});

									$('#idPaisCli').change(function()
									{
										var defineCli = parseInt($("input[name='defineCli']:checked").val());
										switch(defineCli)
										{
											case 1:
											break;
											case 2:
												var idPaisCli = $("#idPaisCli").val();
												if(idPaisCli != 0)
													selectListId(idPaisCli, "#", 'estadosPais', 'idEdoCli');
												else
													resetSelectValueZero('idEdoCli', '#', '1', 'Seleccione un estado');
											break;
											case 3:
												var idPaisCli = $("#idPaisCli").val();
												if(idPaisCli != 0)
													selectListId(idPaisCli, "#", 'estadosPais', 'idEdoCli');
												else
													resetSelectValueZero('idEdoCli', '#', '1', 'Seleccione un estado');

												resetSelectValueZero('idCityCli', '#', '1', 'Seleccione una ciudad');
											break;
										}
									});

									$('#idEdoCli').change(function()
									{
										var defineCli = parseInt($("input[name='defineCli']:checked").val());
										switch(defineCli)
										{
											case 1:
											break;
											case 2:
											break;
											case 3:
												var idEdoCli = $("#idEdoCli").val();
												if(idEdoCli != 0)
													selectListId(idEdoCli, "#", 'ciudadesEstado', 'idCityCli');
												else
													resetSelectValueZero('idCityCli', '#', '1', 'Seleccione una ciudad');
											break;
										}
									});

									$('input[type=radio][name=localizaProv]').change(function ()
									{
										destroySelectMain("idPaisProv", "#", "0");
										resetSelectValueZero('idEdoProv', '#', '1', 'Seleccione un estado');
										resetSelectValueZero('idCityProv', '#', '1', 'Seleccione una ciudad');
										$("input[name=defineProv][value='1']").prop('checked', true);
										$("#divEdoProv").css("display","none");
										$("#divCityProv").css("display","none");
										if(this.value == 2)
										{
											$("#divPaisProv").css("display","none");
											$(".dirProv").css("display","none");
										}
										else if(this.value == 1)
										{
											$("#divPaisProv").css("display","block");
											$(".dirProv").css("display","block");
										}
									});

									$('input[type=radio][name=defineProv]').change(function ()
									{
										switch(parseInt(this.value))
										{
											case 1:
												$("#divEdoProv").css("display","none");
												$("#divCityProv").css("display","none");
												destroySelectMain("idPaisProv", "#", "0");
												resetSelectValueZero('idEdoProv', '#', '1', 'Seleccione un estado');
												resetSelectValueZero('idCityProv', '#', '1', 'Seleccione una ciudad');
											break;
											case 2:
												$("#divEdoProv").css("display","block");
												$("#divCityProv").css("display","none");
												var idPaisProv = $("#idPaisProv").val();
												if(idPaisProv != 0)
													selectListId(idPaisProv, "#", 'estadosPais', 'idEdoProv');
												else
													resetSelectValueZero('idEdoProv', '#', '1', 'Seleccione un estado');
											break;
											case 3:
												$("#divCityProv").css("display","block");
												var idEdoProv = $("#idEdoProv").val();
												if(idEdoProv != 0)
													selectListId(idEdoProv, "#", 'ciudadesEstado', 'idCityProv');
												else
													resetSelectValueZero('idCityProv', '#', '1', 'Seleccione una ciudad');
											break;
										}
									});

									$('#idPaisProv').change(function()
									{
										var defineProv = parseInt($("input[name='defineProv']:checked").val());
										switch(defineProv)
										{
											case 1:
											break;
											case 2:
												var idPaisProv = $("#idPaisProv").val();
												if(idPaisProv != 0)
													selectListId(idPaisProv, "#", 'estadosPais', 'idEdoProv');
												else
													resetSelectValueZero('idEdoProv', '#', '1', 'Seleccione un estado');
											break;
											case 3:
												var idPaisProv = $("#idPaisProv").val();
												if(idPaisProv != 0)
													selectListId(idPaisProv, "#", 'estadosPais', 'idEdoProv');
												else
													resetSelectValueZero('idEdoProv', '#', '1', 'Seleccione un estado');

												resetSelectValueZero('idCityProv', '#', '1', 'Seleccione una ciudad');
											break;
										}
									});

									$('#idEdoProv').change(function()
									{
										var defineProv = parseInt($("input[name='defineProv']:checked").val());
										switch(defineProv)
										{
											case 1:
											break;
											case 2:
											break;
											case 3:
												var idEdoProv = $("#idEdoProv").val();
												if(idEdoProv != 0)
													selectListId(idEdoProv, "#", 'ciudadesEstado', 'idCityProv');
												else
													resetSelectValueZero('idCityProv', '#', '1', 'Seleccione una ciudad');
											break;
										}
									});
								break;
								case 7:
									multiSelectGral("idTipCli", "#", "Seleccione los tipos de precio", "Seleccionados todos", "Seleccionar todos", "Tipos de precios seleccionados");

									$('input[type=radio][name=tipo]').change(function ()
									{
										if(this.value == 2)
										{
											$("#divCantPaso").css("display","none");
											$("#divCantPlan").css("display","block");
										}
										else if(this.value == 1)
										{
											$("#divCantPlan").css("display","none");
											$("#divCantPaso").css("display","block");
										}
									});
								break;
								case 9:
									isInt("diasAparta", "#");
								break;
							}
						break;
						case 'view':
							switch(idElem)
							{
								case 5:
									formCatalogo('divConfigs', catTipo, 'searchConfigs', idElem);
								break;
							}
						break;
						case 'viewCats':
							switch(idElem)
							{
								case 5:
									formCatalogo('divConfigs', catTipo, 'searchCats', idElem);
								break;
							}
						break;
						case 'searchConfigs':
						case 'searchCats':
							switch(idElem)
							{
								case 5:
									resetNewDataTable2("tableReport", 0, 0, "desc", "", "btnShowModal2");
								break;
							}
						break;
						case 'newConfTicket':
						case 'editConfTicket':
							$(".optTicket").on("click", function()
							{
								var name = $(this).attr("name");
								switch(name)
								{
									case 'logo':
										var tipo = 1;
										var opcion = parseInt($("input[name='logo']:checked").val());
									break;
									case 'sucursal':
										var tipo = 2;
										var opcion = parseInt($("input[name='sucursal']:checked").val());
									break;
									case 'direccion':
										var tipo = 3;
										var opcion = parseInt($("input[name='direccion']:checked").val());
									break;
									case 'rfc':
										var tipo = 4;
										var opcion = parseInt($("input[name='rfc']:checked").val());
									break;
									case 'fecha':
										var tipo = 5;
										var opcion = parseInt($("input[name='fecha']:checked").val());
									break;
									case 'numArt':
										var tipo = 6;
										var opcion = parseInt($("input[name='numArt']:checked").val());
									break;
									case 'encargado':
										var tipo = 7;
										var opcion = parseInt($("input[name='encargado']:checked").val());
									break;
									case 'vendedor':
										var tipo = 8;
										var opcion = parseInt($("input[name='vendedor']:checked").val());
									break;
									case 'telefono':
										var tipo = 9;
										var opcion = parseInt($("input[name='telefono']:checked").val());
									break;
									case 'correo':
										var tipo = 10;
										var opcion = parseInt($("input[name='correo']:checked").val());
									break;
									case 'folio':
										var tipo = 11;
										var opcion = parseInt($("input[name='folio']:checked").val());
									break;
									case 'cliente':
										var tipo = 12;
										var opcion = parseInt($("input[name='cliente']:checked").val());
									break;
									case 'redes':
										var tipo = 13;
										var opcion = parseInt($("input[name='redes']:checked").val());
									break;
								}

								actionCatalogo('', catTipo, 'updateCampoGral', tipo+'_'+opcion);

							});

							$("#dimPapel").focusout(function()
							{
								var dimPapel = $("#dimPapel").val();
								if(dimPapel != "")
									actionCatalogo('', catTipo, 'updateDimPapel', dimPapel);
								else
								{
									$("#dimPapel").focus();
									showAlert(2, "Capture el tamaño del papel", "dimPapel", "#");
									return false;
								}
							});

							$("#nombreTicket").focusout(function()
							{
								var nombreTicket = $("#nombreTicket").val();
								if(nombreTicket != "")
									actionCatalogo('', catTipo, 'updateNombreRefTicket', nombreTicket);
								else
								{
									$("#nombreTicket").focus();
									showAlert(2, "Capture el nombre de referencia del ticket", "nombreTicket", "#");
									return false;
								}
							});

							$(".classGralNum").numeric(".");
						break;
					}
				break;
				case 11702:
					switch(form)
					{
						case 'catalogo':
							cargaCatalogo('divCatalogo', catTipo, idElem);
						break;
					}
				break;
				case 11701:
					switch(form)
					{
						case 'catalogo':
							cargaCatalogo('divCatalogo', catTipo, idElem);
						break;
						case 'close':
							$("." + divCarga).html("");
							cargaCatalogo('divCatalogo', catTipo, 0);
						break;
						case 'new':
						case 'edit':
							setScrollable();
							/*var $myGroup1 = $('#accordioninpanel1');
							$myGroup1.on('show.bs.collapse','.collapse', function() {
								$myGroup1.find('.collapse.in').collapse('hide');
							});

							var $myGroup2 = $('#accordioninpanel2');
							$myGroup2.on('show.bs.collapse','.collapse', function() {
								$myGroup2.find('.collapse.in').collapse('hide');
							});*/
						break;
					}
				break;
			}
		}

		scrollTopSite("");
	}, 'json');
}

function actionCatalogo(divCarga, catTipo, action, idElem)
{
	var scrollTop = false;
	var continuePost = false;
	var reloadPost = true;
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["action"] = action;
	formData["idElem"] = idElem;

	switch(catTipo)
	{
		case 10001:
			switch(action)
			{
				case 'edit':
					var nombre = $("#nombre").val();
					if(nombre == "")
					{
						showAlert(2, "Capture su nombre", "nombre", "#");
						return false;
					}
					formData["nombre"] = nombre;

					var usuario = $("#usuario").val();
					if(usuario == "")
					{
						showAlert(2, "Capture el usuario de acceso", "usuario", "#");
						return false;
					}
					formData["usuario"] = usuario;

					var pass = $("#pass").val();
					if(pass != "")
					{
						var pass2 = $("#pass2").val();
						if(pass!=pass2)
						{
							showAlert(2, "Las contraseñas no son iguales", "pass2", "#");
							return false;
						}
						formData["pass"] = pass;
					}

					var email = $("#email").val();
					formData["email"] = email;
					var telefono = $("#telefono").val();
					formData["telefono"] = telefono;
					var calle = $("#calle").val();
					formData["calle"] = calle;
					var numExt = $("#numExt").val();
					formData["numExt"] = numExt;
					var numInt = $("#numInt").val();
					formData["numInt"] = numInt;
					var colonia = $("#colonia").val();
					formData["colonia"] = colonia;
					var cp = $("#cp").val();
					formData["cp"] = cp;
					var fechaNat = $("#fechaNat").val();
					formData["fechaNat"] = fechaNat;

					continuePost = true;
				break;
			}
		break;
		case 10002:
			switch(action)
			{
				case 'close':
					$("." + divCarga).html("");
					cargaCatalogo('divCatalogo', modulo, 0);
				break;
				case 'edit':
					switch(idElem)
					{
						case 8:
							var confiLim = [];
							$(".confiLim").each(function()
							{
								var idConf = $(this).data("idconf");
								var valLim = $(this).val();
								if(valLim == "")
									valLim = 0;

								confiLim.push({idConf:idConf, valLim:valLim});
							});

							formData.confiLim = confiLim;

							continuePost = true;
						break;
					}
				break;
			}
		break;
		case 11702:
			switch(action)
			{
				case 'delete':
					if(confirm('Desea eliminar el usuario'))
						continuePost = true;
				break;
			}
		break;
		case 11701:
			switch(action)
			{
				case 'close':
					$("." + divCarga).html("");
					cargaCatalogo('divCatalogo', catTipo, 0);
				break;
				case 'delete':
					if(confirm('Desea eliminar el perfil'))
						continuePost = true;
				break;
				case 'new':
				case 'edit':
					var nombrePerfil = $("#nombrePerfil").val();
					if(nombrePerfil == "")
					{
						showAlert(2, "Capture el nombre del perfil", "nombrePerfil", "#");
						return false;
					}
					formData["nombrePerfil"] = nombrePerfil;

					var isAdmin = parseInt($("input[name=isAdmin]:checked").val());
					formData["isAdmin"] = isAdmin;

					if($('.inpMod:checked').length <= 0)
					{
						if(!confirm("No se seleccionaron permisos/acciones, desea continuar?"))
							return false;
					}

					var chkMod = [];
					var chkSubMod = [];
					var chkSubSubMod = [];
					var chkSubSubSubMod = [];
					var chkAccSubSubMod = [];
					var chkAccSubMod = [];
					var chkAccSubSubSubMod = [];
					var chkTab = [];
					var chkSubTab = [];
					var chkAccSubTab = [];
					$(".inpMod").each(function()
					{
						if($(this).is(":checked"))
						{
							var tipo = parseInt($(this).data("tipo"));
							var split = $(this).attr("id").split('_');
							var idArray = $(this).data("tipo");
							switch(tipo)
							{
								case 1:
									chkMod.push({idMod:split[1]});
								break;
								case 2:
									chkSubMod.push({idMod:split[1], idSubMod:split[2]});
								break;
								case 3:
									chkSubSubMod.push({idMod:split[1], idSubMod:split[2], idSubSubMod:split[3]});
								break;
								case 4:
									chkAccSubSubMod.push({idMod:split[1], idSubMod:split[2], idSubSubMod:split[3], idAccSubSubMod:split[4]});
								break;
								case 5:
									chkAccSubMod.push({idMod:split[1], idSubMod:split[2], idAccSubMod:split[3]});
								break;
								case 6:
									chkTab.push({idTab:split[1]});
								break;
								case 7:
									chkSubTab.push({idTab:split[1], idSubTab:split[2]});
								break;
								case 8:
									chkAccSubTab.push({idTab:split[1], idSubTab:split[2], idAccSubTab:split[3]});
								break;
								case 9:
									debugger;
									chkSubSubSubMod.push({idMod:split[1], idSubMod:split[2], idSubSubMod:split[3], idSubSubSubMod:split[4]});
								break;
								case 10:
									debugger;
									chkAccSubSubSubMod.push({idMod:split[1], idSubMod:split[2], idSubSubMod:split[3], idSubSubSubMod:split[4], idAccSubSubSubMod:split[5]});
								break;
							}
						}
					});

					formData.chkMod = chkMod;
					formData.chkSubMod = chkSubMod;
					formData.chkSubSubMod = chkSubSubMod;
					formData.chkSubSubSubMod = chkSubSubSubMod;
					formData.chkAccSubSubMod = chkAccSubSubMod;
					formData.chkAccSubMod = chkAccSubMod;
					formData.chkAccSubSubSubMod = chkAccSubSubSubMod;
					formData.chkTab = chkTab;
					formData.chkSubTab = chkSubTab;
					formData.chkAccSubTab = chkAccSubTab;

					continuePost = true;
				break;
			}
		break;
	}

	if(continuePost)
	{
		disableButtonSys();
		$.post("../seccion/ajax/portal/actions.php", formData,
		function (valData)
		{
			if (valData.valAction == "false")
			{
				enableButtonSys();
				showAlert(2, valData.alert, "divHead", "#");
				switch(catTipo)
				{
				}
			}
			else
			{
				$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
				$("."+divCarga).html("");
				switch(catTipo)
				{
					case 10001:
						formCatalogo('divFormCatalogo', catTipo, 'edit', 0);
					break;
					case 10002:
						switch(action)
						{
							case 'edit':
								if(idElem == 4)
									location.reload();
								else
									cargaCatalogo('divCatalogo', catTipo, 0);
							break;
						}
					break;
					case 11702:
						switch(action)
						{
							case 'delete':
								currentOrder = deleteRowTable(catTable, valData.idReturn);
								catTable = resetNewDataTable2("tableOrder", 0, currentOrder[0][0], currentOrder[0][1], "btnShowModal", "", "divCatalogo");
								checkValSearch(catTable, "");
							break;
						}
					break;
					case 11701:
						switch(action)
						{
							case 'new':
								currentOrder = addRowTable(catTable, valData.newRow);
								catTable = resetNewDataTable2("tableOrder", 0, currentOrder[0][0], currentOrder[0][1], "btnShowModal", "", "divCatalogo");
								checkValSearch(catTable, "");
							break;
							case 'edit':
								currentOrder = editRowTable(valData.idReturn, catTable, valData.newRow);
								catTable = resetNewDataTable2("tableOrder", 0, currentOrder[0][0], currentOrder[0][1], "btnShowModal", "", "divCatalogo");
								checkValSearch(catTable, "");
							break;
							case 'delete':
								currentOrder = deleteRowTable(catTable, valData.idReturn);
								catTable = resetNewDataTable2("tableOrder", 0, currentOrder[0][0], currentOrder[0][1], "", "", "divCatalogo");
								checkValSearch(catTable, "");
							break;
						}
					break;
				}

				if(reloadPost)
				{
					$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
					$("."+divCarga).html("");
				}

				if(scrollTop)
					scrollTopSite("");

				showAlert(1, valData.alert, "divHead", "#");
				enableButtonSys();
			}
		}, 'json');
	}
}

function muestra_page(divCarga, catTipo, action, idElem)
{
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["action"] = action;
	formData["idElem"] = idElem;
	$("#sidebar_right_content").html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/page-right/page_catalogos.php", formData,
	function (valData)
	{
		switch(catTipo)
		{
			case 11702:
				switch(action)
				{
					case 'new':
					case 'edit':
						$("#sidebar_right_content").html(valData.catalogo);
						resetSelectGralModal("selectForm", "exampleModalRight");
						clearAutoComplete("inpAC", ".");
						switch(action)
						{
							case 'new':
								clearValue("inpAC", ".");
							break;
						}
					break;
				}
			break;
		}
	}, 'json').done(function(valData)
	{
		hideLoading();
	});
}

function action_page(divCarga, catTipo, action, idElem)
{
	var continuePost = false;
	var clearToggle = false;

	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["idElem"] = idElem;
	formData["action"] = action;

	switch(catTipo)
	{
		case 11702:
			switch(action)
			{
				case 'new':
				case 'edit':
					var nomUser = $("#nomUser").val();
					if(nomUser == "")
					{
						showAlert(2, "Capture el nombre del usuario", "nomUser", "#");
						return false;
					}
					formData["nomUser"] = nomUser;

					var id_perfil = $("#id_perfil").val();
					if(id_perfil == 0)
					{
						showAlert(2, "Seleccione el perfil del usuario", "id_perfil", "#");
						return false;
					}
					formData["id_perfil"] = id_perfil;

					var idSucGral = $("#idSucGral").val();
					if(idSucGral == 0)
					{
						showAlert(2, "Seleccione la sucursal base", "idSucGral", "#");
						return false;
					}
					formData["idSucGral"] = idSucGral;

					var changeSuc = 0;
					switch(action)
					{
						case 'new':
							var idSucActual = idSucGral;
						break;
						case 'edit':
							var idSucActual = $("#idSucActual").val();
							if(idSucActual == 0)
							{
								showAlert(2, "Seleccione la sucursal del día", "idSucActual", "#");
								return false;
							}

							if(idSucGral != idSucActual)
								changeSuc = 1;
						break;
					}
					formData["idSucActual"] = idSucActual;
					formData["changeSuc"] = changeSuc;

					var logUser = $("#logUser").val();
					if(logUser == "")
					{
						showAlert(2, "Capture el usuario de acceso", "logUser", "#");
						return false;
					}
					formData["logUser"] = logUser;

					var pswd = $("#pswd").val();
					switch(action)
					{
						case 'new':
							if(pswd == "")
							{
								showAlert(2, "Capture la contraseña", "pswd", "#");
								return false;
							}

							var pswd_c = $("#pswd_c").val();
							if(pswd!=pswd_c)
							{
								showAlert(2, "Las contraseñas no son iguales", "pswd_c", "#");
								return false;
							}
							formData["pswd"] = pswd;
						break;
						case 'edit':
							if(pswd != "")
							{
								var pswd_c = $("#pswd_c").val();
								if(pswd!=pswd_c)
								{
									showAlert(2, "Las contraseñas no son iguales", "pswd_c", "#");
									return false;
								}
								formData["pswd"] = pswd;
							}
						break;
					}
				break;
			}
		break;
	}

	disableButtonSys();
	$.post("../seccion/page-right/actionSistema.php", formData,
	function (valData)
	{
		if (valData.valAdmon == "false")
		{
			enableButtonSys();
			showAlert(2, valData.alert, "divModalHead", "#");
		}
		else
		{
			$("#sidebar_right_content").html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
			switch(catTipo)
			{
				case 11702:
					switch(action)
					{
						case 'new':
							currentOrder = addRowTable(catTable, valData.newRow);
							catTable = resetNewDataTable2("tableOrder", 0, currentOrder[0][0], currentOrder[0][1], "btnShowModal", "", "divCatalogo");
							checkValSearch(catTable, "");
						break;
						case 'edit':
							currentOrder = editRowTable(valData.idReturn, catTable, valData.newRow);
							catTable = resetNewDataTable2("tableOrder", 0, currentOrder[0][0], currentOrder[0][1], "btnShowModal", "", "divCatalogo");
							checkValSearch(catTable, "");
						break;
					}
					clearToggle = true;
				break;
			}

			if(clearToggle)
			{
				sidebarRightHide();
				showAlert(1, valData.alert, "divHead", "#");
			}

			scrollTopSite("");
			enableButtonSys();
		}
	}, 'json');
}

function actionIntoPage(action, idElem)
{
	switch(action)
	{
	}
}