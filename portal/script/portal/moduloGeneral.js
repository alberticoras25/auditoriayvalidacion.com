$(document).ready(function()
{
	modulo = parseInt(sessionStorage.getItem("modulo"));
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
	$.post("../seccion/ajax/general/catalogs.php", formData,
	function (valData)
	{
		if (valData.valCatalogo == "false")
			alert(valData.alert);
		else
			$("."+divCarga).html(valData.catalogo);

	}, 'json').done(function(valData)
	{
		switch(catTipo)
		{
		}

		scrollTopSite("");
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
	$.post("../seccion/ajax/general/formCatalogs.php", formData,
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
		$.post("../seccion/ajax/general/actions.php", formData,
		function (valData)
		{
			if (valData.valAction == "false")
			{
				enableButtonSys();
				alert(valData.alert);
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
				}

				scrollTopSite("");
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
		}
	}, 'json');
}

function action_page(divCarga, catTipo, action, idElem)
{
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["idElem"] = idElem;
	formData["action"] = action;

	switch(catTipo)
	{
	}

	disableButtonSys();
	$.post("../seccion/page-right/actionSistema.php", formData,
	function (valData)
	{
		if (valData.valAdmon == "false")
		{
			enableButtonSys();
			alert(valData.alert);
		}
		else
		{
			$("#sidebar_right_content").html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
			switch(catTipo)
			{
			}

			sidebarRightToggle();
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