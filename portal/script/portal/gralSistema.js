$(document).ready(function()
{
	modulo = parseInt(sessionStorage.getItem("modulo"));
	$('.see_sidemenu_r_system').on('click', function()
	{
		sidebarRightToggle();
	});
});

function muestra_page_system(divCarga, catTipo, action, idElem)
{
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["action"] = action;
	formData["idElem"] = idElem;
	$("#sidebar_right_content").html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/page-right/page_system.php", formData,
	function (valData)
	{
		switch(catTipo)
		{
			case 0:
				switch(action)
				{
					case 'changeConfig':
						$("#sidebar_right_content").html(valData.catalogo);
						$('.close_sidemenu_r').on('click', function ()
						{
							sidebarRightToggle();
						});
						dateRangePicker("fechaPeriGral");
					break;
				}
			break;
		}
	}, 'json').done(function(valData)
	{
	});
}

function action_page_system(divCarga, catTipo, action, idElem)
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
		case 0:
			switch(action)
			{
				case 'changeConfig':
					var fechaPeriGral = $("#fechaPeriGral").val();
					formData["fechaPeriGral"] = fechaPeriGral;

					var chequeVal = $('input:radio[name=chequeVal]:checked').val();
					formData["chequeVal"] = chequeVal;

					showLoading();
					continuePost = true;
				break;
			}
		break;
	}

	if(continuePost)
	{
		$.post("../seccion/page-right/actionSystem.php", formData,
		function (valData)
		{
			if(valData.valAdmon == "false")
			{
				//showAlert(2, valData.alert, "alertModal", "#");
				switch(catTipo)
				{
					case 0:
						switch(action)
						{
							case 'changeConfig':break;
						}
					break;
				}
			}
			else
			{
				switch(catTipo)
				{
					case 0:
						switch(action)
						{
							case 'changeConfig':
								location.reload();
								//hideLoading();
							break;
						}
					break;
				}

				if(clearToggle)
					sidebarRightHide();

				scrollTopSite("");
			}
		}, 'json');
	}
}

