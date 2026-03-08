$(document).ready(function()
{
	modulo = parseInt(sessionStorage.getItem("modulo"));
	cargaCatalogo('divCatalogo', modulo, 0);
	$('.see_sidemenu_r').on('click', function()
	{
		sidebarRightToggle();
	});
});

function cargaCatalogo(divCarga, catTipo, idElem)
{
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["idElem"] = idElem;

	$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/ajax/inicio/catalogs.php", formData,
	function (valData)
	{
		if (valData.valCatalogo == "false")
			alert(valData.alert);
		else
			$("."+divCarga).html(valData.catalogo);

	}, 'json').done(function(valData)
	{
		catTable = resetNewDataTable2("tableOrder", 0, 0, "desc", "btnShowModal", "", "divCatalogo");
	});
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
	}

	$("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/ajax/inicio/formCatalogs.php", formData,
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
	}

	if(continuePost)
	{
		disableButtonSys();
		$.post("../seccion/ajax/inicio/actions.php", formData,
		function (valData)
		{
			if(valData.valAction == "false")
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

	switch(catTipo)
	{
	}

	$("#sidebar_right_content").html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/page-right/page_saldos.php", formData,
	function (valData)
	{
		$("#sidebar_right_content").html(valData.catalogo);
		switch(catTipo)
		{
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

	if(continuePost)
	{
		disableButtonSys();
		$.post("../seccion/page-right/actionReportes.php", formData,
		function (valData)
		{
			if (valData.valAdmon == "false")
			{
				enableButtonSys();
				alert(valData.alert);
			}
			else
			{
				if(clearToggle)
				{
					$("#sidebar_right_content").html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
					sidebarRightToggle();
				}

				scrollTopSite("");
				enableButtonSys();
			}
		}, 'json');
	}
}

function actionIntoPage(action, idElem)
{
	switch(action)
	{
		case 'showFormPay':

		break;
	}
}

function actionPrintPage(divCarga, catTipo, form, idElem)
{
	var continuePrint = false;
	var formData = {};
	formData["form"] = form;
	formData["idElem"] = idElem;
	formData["catTipo"] = catTipo;
	switch(form)
	{
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

				$("div."+divCarga).html('<div class="col-12">'+
										'<div class="card mb-4">'+
										'<div class="card-body">'+
										'<div class="row mb-2 divMsjHead" id="divMsjHead">'+
										'<div class="col-10">'+
										'<h5 class="mb-2 font-weight-bold">'+txtTitle+'</h5>'+
										'</div>'+
										'<div class="col-2">'+
										'<div class="top-right-button-container">'+
										'<button type="button" class="close" aria-label="Close" onclick="actionCatalogo(\'divFormPrint\', '+catTipo+', \'close\', 0)">'+
										'<span aria-hidden="true">×</span>'+
										'</button>'+
										'</div>'+
										'</div>'+
										'</div>'+
										'<div class="row">'+
										'<div class="col-12">'+
										'<div class="mb-2 ticketPdf" id="ticketPdf">'+
										'</div>'+
										'</div>'+
										'</div>'+
										'</div>'+
										'</div>');

				$('#ticketPdf').append(iFrameJQueryObject);
				/*iFrameJQueryObject.on('load', function()
				{
					$(this).get(0).contentWindow.print();
				});*/
			}

			scrollTopSite("");
		}, 'json');
	}
}
