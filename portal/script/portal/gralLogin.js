$(document).ready(function()
{
	var nModulo = $("#modulo").length;
	if(nModulo == 0)
	{
		$("input[type=\'password\']").val("");
		$("input[type=\'text\']").val("");

		$("#txtPassword").keypress(function(event)
		{
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == "13")
				action_page_login('', 0, 'login');

		});

		$("#txtRePassword").keypress(function(event)
		{
			var keycode = (event.keyCode ? event.keyCode : event.which);
			if(keycode == "13")
			{
				action_page_login('', 0, 'reconnect');
			}

		});

		$("#btnEnvio").click(function()
		{
			action_page_login('', 0, 'login');
		});

		$("#btnReEnvio").click(function()
		{
			action_page_login('', 0, 'reconnect');
		});

		resetSelectGral("selectLogin");

		/*$("#idSucursalLogin").multiselect({
			buttonWidth: '100%',
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			maxHeight: 450,
			buttonClass: "multiselect dropdown-toggle btn btn-default btn-system",
			nonSelectedText: 'Seleccione una opción!',
			//disableIfEmpty: true,
			//disabledText: 'Inactivo ...',
			allSelectedText: 'Sin opciones',
			onDropdownHide: function() {
				$('button.multiselect-clear-filter').click();
			},
		});*/

		$('#idSucursalLogin').change(function()
		{
			var idSucursalLogin = $("#idSucursalLogin").val();
			if(idSucursalLogin != 0)
				selectListId(idSucursalLogin, "#", 'vendedoresSucursal', 'idVendedorLogin');
			else
				resetSelectValueZero('idVendedorLogin', '#', '1', 'Seleccione un vendedor');
		});

		/*$("#idVendedorLogin").multiselect({
			buttonWidth: '100%',
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			maxHeight: 450,
			buttonClass: "multiselect dropdown-toggle btn btn-default btn-system",
			nonSelectedText: 'Seleccione una opción!',
			//disableIfEmpty: true,
			//disabledText: 'Inactivo ...',
			allSelectedText: 'Sin opciones',
			onDropdownHide: function() {
				$('button.multiselect-clear-filter').click();
			},
		});*/

		$("[data-hide]").on("click", function(){
			$("#" + $(this).attr("data-hide")).hide();
		});
	}
	else
		action_page_login('', 1, 'valToken');
});

function action_page_login(divCarga, catTipo, action)
{
	var continuePost = false;
	var clearToggle = false;
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["action"] = action;

	switch(catTipo)
	{
		case 0:
			switch(action)
			{
				case 'changeSuc':
				case 'login':
					var idSucursalLogin = $("#idSucursalLogin").val();
					if(idSucursalLogin == 0)
					{
						$("#alertSucursal").fadeTo(2000, 500).slideUp(500, function(){
							$("#alertSucursal").slideUp(500);
						});
						return false;
					}
					formData["idSucursalLogin"] = idSucursalLogin;

					var idVendedorLogin = $("#idVendedorLogin").val();
					formData["idVendedorLogin"] = idVendedorLogin;

					var login = $.trim($("#txtUsuario").val()), pass = $.trim($("#txtPassword").val());
					if (login.length === 0)
					{
						$("#alertUsuario").fadeTo(2000, 500).slideUp(500, function(){
							$("#alertUsuario").slideUp(500);
						});
						return false;
					}
					formData["txtUsuario"] = login;

					if(pass.length === 0)
					{
						$("#alertPassword").fadeTo(2000, 500).slideUp(500, function(){
							$("#alertPassword").slideUp(500);
						});
						return false;
					}
					formData["txtPassword"] = pass;

					switch(action)
					{
						case 'changeSuc':
							formData["changeSuc"] = 1;
						break;
						case 'login':
							formData["changeSuc"] = 0;
						break;
					}
					continuePost = true;
				break;
				case 'reconnect':
					var pass = $.trim($("#txtRePassword").val());
					if(pass.length === 0)
					{
						$("#alertRePassword").fadeTo(2000, 500).slideUp(500, function(){
							$("#alertPassword").slideUp(500);
						});
						return false;
					}
					formData["txtRePassword"] = pass;

					continuePost = true;
				break;
			}
		break;
		case 1:
			switch(action)
			{
				case 'valToken':
					continuePost = true;
				break;
			}
		break;
	}

	if(continuePost)
	{
		$.post("../seccion/ajax/login/actions.php", formData,
		function (valData)
		{
			switch(valData.valAction)
			{
				case "change":
					$("#txtAlertDanger").html("<strong>Error!</strong> "+valData.alert);
					$("#alertDanger").fadeTo(2000, 500).slideUp(500, function(){
						$("#alertDanger").slideUp(500);
					});
				break;
				case "false":
					switch(catTipo)
					{
						case 0:
							switch(action)
							{
								case 'login':
									$("input[type=\'password\']").val("");
									$("input[type=\'text\']").val("");
									resetSelectValueZero('idSucursalLogin', '#', 0, 'Seleccione sucursal');
									$("#txtAlertDanger").html("<strong>Error!</strong> "+valData.alert);
									$("#alertDanger").fadeTo(2000, 500).slideUp(500, function(){
										$("#alertDanger").slideUp(500);
									});
								break;
								case 'reconnect':
									$("input[type=\'password\']").val("");
									$("#txtAlertDanger").html("<strong>Error!</strong> "+valData.alert);
									$("#alertDanger").fadeTo(2000, 500).slideUp(500, function(){
										$("#alertDanger").slideUp(500);
									});

									if(parseInt(valData.idReturn) == 1)
										sessLogOut(1);
								break;
							}
						break;
						case 1:
							switch(action)
							{
								case 'closeCorte':
								break;
								case 'valToken':
									(new PNotify({
										title: 'Cuidado!',
										text: valData.alert,
										icon: 'fa fa-warning',
										shadow: "false",
										opacity: 1,
										type: "warning",
										hide: false,
										confirm: {
											confirm: true,
											buttons: [{
												text: 'Ok',
												addClass: 'btn-primary',
												click: function () {
													sessLogOut(1);
												}
											}, null]
										},
										buttons: {
											closer: false,
											sticker: false
										},
										history: {
											history: false
										},
										addclass: 'stack-modal',
										stack: {
											'dir1': 'down',
											'dir2': 'right',
											'modal': true
										}
									}));
								break;
							}
						break;
					}
				break;
				case "true":
					switch(catTipo)
					{
						case 0:
							switch(action)
							{
								case "changeSuc":
								case 'login':
									$("#txtAlertSuccess").html("<strong>Bienvenido "+valData.alert+"!</strong> Comencemos");
									$("#alertSuccess").fadeTo(2000, 500).slideUp(500, function(){
										$("#frmAcceso").submit();
										$("#alertSuccess").slideUp(500);
									});
								break;
								case 'reconnect':
									$("#txtAlertSuccess").html("<strong>Bienvenido "+valData.alert+"!</strong> Volvimos");
									$("#alertSuccess").fadeTo(2000, 500).slideUp(500, function(){
										$("#frmAcceso").submit();
										$("#alertSuccess").slideUp(500);
									});
								break;
							}
						break;
						case 1:

						break;
					}
				break;
				case "close":
					sessLogOut(1);
				break;
			}
		}, 'json');
	}
}

