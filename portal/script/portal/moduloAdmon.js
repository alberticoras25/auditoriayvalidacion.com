$(document).ready(function()
{
	var catTable, catSubTable, catSubRepTable, currentOrder, currentSubOrder, currentSubRepOrder = '';
	var x = [];
	modulo = parseInt(sessionStorage.getItem("modulo"));
	switch(modulo)
	{
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

	}

	$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/ajax/admon/catalogs.php", formData,
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
			case 11704:
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
	var scrollTop = false;
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["idElem"] = idElem;
	formData["form"] = form;

	switch(catTipo)
	{
	}

	$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/ajax/admon/formCatalogs.php", formData,
	function (valData)
	{
		if (valData.valCatalogo == "false")
			alert(valData.alert);
		else
		{
			$("."+divCarga).html(valData.formulario);
			switch(catTipo)
			{

			}
		}

		if(scrollTop)
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
		case 11704:
			switch(action)
			{
				case 'delete':
					if(confirm('Desea eliminar el correo para notificaciones'))
						continuePost = true;
				break;
				case 'close':
					$("." + divCarga).html("");
					cargaCatalogo('divCatalogo', catTipo, 0);
					scrollTopSite("");
				break;
				case 'assign':
					var chkNoti = [];
					$(".chkNoti:checked").each(function ()
					{
						var valConf = parseInt($(this).val());
						if(valConf == 1)
						{
							var idConf = $(this).data("idconf");
							var valConf = $(this).val();
							chkNoti.push({idConf:idConf, valConf:valConf});
						}
					});

					formData.chkNoti = chkNoti;
					continuePost = true;
				break;
			}
		break;
	}

	if(continuePost)
	{
		disableButtonSys();
		showLoading();
		$.post("../seccion/ajax/admon/actions.php", formData,
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
				switch(catTipo)
				{
					case 11704:
						switch(action)
						{
							case 'assign':
								currentOrder = editRowTable(valData.idReturn, catTable, valData.newRow);
								catTable = resetNewDataTable2("tableOrder", 0, currentOrder[0][0], currentOrder[0][1], "btnShowModal", "", "divCatalogo");
								checkValSearch(catTable, "");
							break;
							case 'delete':
								currentOrder = deleteRowTable(catTable, valData.idReturn);
								catTable = resetNewDataTable2("tableOrder", 0, currentOrder[0][0], currentOrder[0][1], "btnShowModal", "", "divCatalogo");
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
		}, 'json').done(function(valData)
		{
			hideLoading();
		});
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
		$("#sidebar_right_content").html(valData.catalogo);
		$('.close_sidemenu_r').on('click', function ()
		{
			sidebarRightToggle();
		});

		switch(catTipo)
		{
			case 11704:
				switch(action)
				{
					case 'new':
					case 'edit':
						$("#sidebar_right_content").html(valData.catalogo);
						$('.close_sidemenu_r').on('click', function ()
						{
							sidebarRightToggle();
						});
						scrollTopSite("");

						$("#correo").bind("click", validate);
					break;
				}
			break;
		}
	}, 'json');
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
		case 11704:
			switch(action)
			{
				case 'new':
				case 'edit':
					var correo = $("#correo").val();
					if(correo == "")
					{
						showAlert(2, "Capture el correo", "correo", "#");
						return false;
					}
					formData["correo"] = correo;

					var txtCorreo = $("#txtCorreo").val();
					formData["txtCorreo"] = txtCorreo;
					continuePost = true;
				break;
			}
		break;
	}

	if(continuePost)
	{
		disableButtonSys();
		$.post("../seccion/page-right/actionAdmon.php", formData,
		function (valData)
		{
			if (valData.valAdmon == "false")
			{
				enableButtonSys();
				showAlert(2, valData.alert, "divModalHead", "#");
			}	
			else
			{
				switch(catTipo)
				{
					case 11704:
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
}

function actionIntoPage(divCarga, repTipo, action, idElem)
{
	var continuePost = false;
	var chargePost = false;
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["action"] = action;
	formData["idElem"] = idElem;
	formData["catTipo"] = repTipo;

	switch(repTipo)
	{
	}

	if(continuePost)
	{
		disableButtonSys();
		$.post("../seccion/ajax/admon/actions.php", formData,
		function (valData)
		{
			if (valData.valAction == "false")
			{
				enableButtonSys();
				showAlert(2, valData.alert, "divModalHead", "#");
				switch(action)
				{
				}
			}
			else
			{
				switch(repTipo)
				{
				}

				if(chargePost)
					cargaCatalogo('divCatalogo', repTipo, 0);
				
				enableButtonSys();
			}
		}, 'json');
	}
}

function actionPrintPage(divCarga, repTipo, form, idElem)
{
	var continuePrint = false;
	var formData = {};
	formData["form"] = form;
	formData["idElem"] = idElem;
	formData["repTipo"] = repTipo;
	switch(form)
	{
		case 'printTicketCargEgr':
			continuePrint = true;
		break;
	}

	if(continuePrint)
	{
		$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
		$.post("../seccion/ajax/reportes/printPdf.php", formData,
		function (valData)
		{
			if (valData.valReporte == "false")
				alert(valData.alert);
			else
			{
				switch(form)
				{
				}

				var iFrameJQueryObject = $('<iframe id="pdfPrint" src="'+valData.txtFile+'" style="width:100%; height:500px;"></iframe>');


				$("div."+divCarga).html('<div class="modal-header">'+
										'<h5 class="modal-title">Comprobante</h5>'+
										'<button type="button" class="close" data-dismiss="modal" aria-label="Close">'+
										'	<span aria-hidden="true">&times;</span>'+
										'</button>'+
										'</div>'+
										'<div class="modal-body ticketPdf" id="ticketPdf">'+
										'</div>'+
										'<div class="modal-footer">'+
										'	<button type="button" class="btn btn-danger default" data-dismiss="modal">Cerrar</button>'+
										'</div>');

				$('#ticketPdf').append(iFrameJQueryObject);
				iFrameJQueryObject.on('load', function()
				{
					$(this).get(0).contentWindow.print();
				});
			}
		}, 'json');
	}
}

function formOtherCatalogo(divCarga, catTipo, form, idElem)
{
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["idElem"] = idElem;
	formData["form"] = form;

	$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/ajax/catalogos/formOtherCatalogs.php", formData,
	function (valData)
	{
		if (valData.valCatalogo == "false")
			alert(valData.alert);
		else
		{
			$("."+divCarga).html(valData.formulario);
			switch(catTipo)
			{
			}
		}

		scrollTopSite("");
	}, 'json');
}

function actionOtherCatalogo(divCarga, catTipo, action, idElem)
{
	var continuePost = false;
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["action"] = action;
	formData["idElem"] = idElem;

	switch(catTipo)
	{
	}

	if(continuePost)
	{
		disableButtonSys();
		$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
		$.post("../seccion/ajax/catalogos/actions.php", formData,
			function (valData)
			{
				if (valData.valAction == "false")
				{
					enableButtonSys();
					alert(valData.alert);
				}	
				else
				{
					$("."+divCarga).html("");
					switch(catTipo)
					{
					}

					scrollTopSite("");
					enableButtonSys();
				}
			}, 'json');
	}
}