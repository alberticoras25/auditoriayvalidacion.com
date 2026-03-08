// JavaScript Document
//VARIABLES GLOBALES
//Variable para insertar codigo html en span campos
sessionStorage.setItem("valSearch", "");
sessionStorage.setItem("valSubSearch", "");
sessionStorage.setItem("valSubRepSearch", "");

var modulo = $("#modulo").val();
sessionStorage.setItem("modulo", modulo);
var formulario = document.getElementById('campos');

function navegar_modulo(destino)
{
	document.frmSistema.modulo.value = destino;
	sessionStorage.setItem("modulo", destino);
	document.frmSistema.submit(); 
}

function navegar(destino)
{
	document.frmSistema.accion.value = destino;
	sessionStorage.setItem("accion", destino);
	document.frmSistema.submit(); 
}

function navegar_accion(destino, accion)
{
	document.frmSistema.modulo.value = destino;
	sessionStorage.setItem("modulo", destino);
	document.frmSistema.accion.value = accion;
	sessionStorage.setItem("accion", accion);
	document.frmSistema.submit(); 
}

function navegarPunto(destino)
{
	document.frmSistemaPunto.accion.value = destino; 
	document.frmSistemaPunto.submit(); 
}

function checar_submodulos(modulo, tipo)
{
	if(tipo != 2)
		var idInput = $(modulo).attr("id");
	else
		var idInput = modulo;

	if($("#"+idInput).prop("checked"))
	{
		$("input[id*='"+idInput+"_']").prop("checked", true);
	}
	else
		$("input[id*='"+idInput+"_']").prop("checked", false);

}

function checa_padre(submodulo)
{
	var idInput = $(submodulo).attr("id");

	if($("#"+idInput).prop("checked"))
	{
		var hijo = idInput.split("_");

		if(hijo[5] != undefined)
		{
			if(!$("#"+hijo[0]+"_"+hijo[1]+"_"+hijo[2]+"_"+hijo[3]+"_"+hijo[4]+"_"+hijo[5]).prop("checked"))
				$("#"+hijo[0]+"_"+hijo[1]+"_"+hijo[2]+"_"+hijo[3]+"_"+hijo[4]+"_"+hijo[4]).prop("checked", "checked");
		}
		if(hijo[4] != undefined)
		{
			if(!$("#"+hijo[0]+"_"+hijo[1]+"_"+hijo[2]+"_"+hijo[3]+"_"+hijo[4]).prop("checked"))
				$("#"+hijo[0]+"_"+hijo[1]+"_"+hijo[2]+"_"+hijo[3]+"_"+hijo[4]).prop("checked", "checked");
		}
		if(hijo[3] != undefined)
		{
			if(!$("#"+hijo[0]+"_"+hijo[1]+"_"+hijo[2]+"_"+hijo[3]).prop("checked"))
				$("#"+hijo[0]+"_"+hijo[1]+"_"+hijo[2]+"_"+hijo[3]).prop("checked", "checked");
		}
		if(hijo[2] != undefined)
		{
			if(!$("#"+hijo[0]+"_"+hijo[1]+"_"+hijo[2]).prop("checked"))
				$("#"+hijo[0]+"_"+hijo[1]+"_"+hijo[2]).prop("checked", "checked");
		}
		if(hijo[1] != undefined)
		{
			if(!$("#"+hijo[0]+"_"+hijo[1]).prop("checked"))
				$("#"+hijo[0]+"_"+hijo[1]).prop("checked", "checked");
		}
	}

	checar_submodulos(idInput, 2);
}

function checar_acciones(modulo)
{
	var estatus;
	if(modulo.checked)
		estatus = "checked";
	else
		estatus = "";

	var papa = modulo.id.split("_");
	for (var i=0; i<document.frmSistema.elements.length; i++)
	{
		var elemento = document.frmSistema.elements[i];
		if(elemento.type == "checkbox")
		{
			var hijo = elemento.id.split("_");
			if(hijo[2]==papa[2] && hijo.length==3 && elemento.checked)
			{
				elemento.checked = estatus;
			}
		}
	}
}

function checar_nietos(modulo)
{
	var estatus;
	if(modulo.checked)
		estatus = "checked";
	else
		estatus = "";

	var papa = modulo.id.split("_");
	for (var i=0; i<document.frmSistema.elements.length; i++)
	{
		var elemento = document.frmSistema.elements[i];
		if(elemento.type == "checkbox")
		{
			var hijo = elemento.id.split("_");
			if(hijo[2]==papa[2])
			{
				elemento.checked = estatus;
			}
		}

	}
}

function checa_padre_accion(submodulo)
{
	//modulo_100_101
	var hijo = submodulo.id.split("_");
	var encontrado=0;

	for (var i=0; i<document.frmSistema.elements.length; i++)
	{
		var elemento = document.frmSistema.elements[i];
		if(elemento.type == "checkbox")
		{
			//modulo_100 info[0]=modulo info[1]= 100
			//modulo_100_101 info[0]=modulo info[1]= 100  info[2]= 101
			var info = elemento.id.split("_");
			if(info[1]==hijo[1] && elemento.checked)
			{
				encontrado++;
			}
		}

	}

	//document.getElementById(modulo_100).checked="checked";
	if(encontrado>0)
		document.getElementById(hijo[0]+"_"+hijo[1]).checked="checked";
	else
		document.getElementById(hijo[0]+"_"+hijo[1]).checked="";

}

function validarLogIn()
{
	if(validar(document.frmAcceso.txtUsuario) == true && validar(document.frmAcceso.txtPassword) == true)
	{
		//document.frmAcceso.txtPassword.value = calcMD5(document.frmAcceso.txtPassword.value);
		document.frmAcceso.submit();
	}
	else
	{
		alert("POR FAVOR INGRESA CORRECTAMENTE TUS DATOS DE ACCESOS");
	}
}

function sessLogOut(tipo)
{
	tipo = typeof tipo !== 'undefined' ?  tipo : 1;
	var formData = {};
	formData["divCarga"] = '';
	formData["catTipo"] = 0;
	formData["action"] = 'setSessionInit';
	formData["idElem"] = tipo;
	$.post("../seccion/ajax/portal/actions.php", formData,
	function (valData)
	{
		if (valData.valAction == "false")
			alert(valData.alert);
		else
		{
			var idForm = $('form').attr('id');

			if(tipo == 1)
			{
				localStorage.setItem('sessionSlide', 'loggedOut');
				$("#session-expired-modal").modal('hide');
				$("#modulo").val('-1');
				$('form#'+idForm).submit();
			}
			else
			{
				$("#modulo").val('-1');
				$('form#'+idForm).submit();
			}
		}
	}, 'json');
}

function sessLogin()
{
	var txtRePassword = $("#txtRePassword").val();
	var formData = {};
	formData["txtRePassword"] = txtRePassword;
	formData["divCarga"] = '';
	formData["catTipo"] = 0;
	formData["action"] = 'setSessionReConnect';
	formData["idElem"] = 0;
	$.post("../seccion/ajax/portal/actions.php", formData,
	function (valData)
	{
		if (valData.valAction == "false")
			alert(valData.alert);
		else
		{
			$('form#frmAcceso').submit();
		}
	}, 'json');
}

function validarSucursal()
{
	var o = document.createElement('input');
	o.type = "hidden";
	o.name = "nvaSucursal";
	o.value = '25';
	document.frmAcceso.appendChild(o);
	document.frmAcceso.submit();	
}

function detectaEnter(e)
{
	if(e.keyCode == 13){
		validarLogIn();
	}
}

function abre_menu(menu){
	var partes = new Array();
	partes = menu.split("-");
	
	var subobjs = new Array();
	subobjs = document.getElementById("menu_0_"+partes[1]).getElementsByTagName("a");
	var child;
	
	for(var j=0;j<subobjs.length;j++){
		child = subobjs[j];
		if(child.offsetHeight != 30){
			if(child.offsetHeight > 0){
				//new Effect.Morph(child,{duration:0.5,style:"height:0px"});
				child.style.height = "0px";
			}else{
				//new Effect.Morph(child,{duration:0.5,style:"height:25px"});
				child.style.height = "25px";
			}
		}
	}
	document.getElementById("menu_"+partes[1]+"_"+partes[0]).style.textDecoration = "underline";
}

function openAjax(archivo,tituloCabezal)
{
	$.modal({
		title: tituloCabezal,		
		url: "../ajax/" + archivo,
		width: 800
	});
};

function openWizard()
{
		// Elements
		var form = $(".wizard"),
		
			// If layout is centered
			centered;
		
		// Handle resizing (mostly for debugging)
		function handleWizardResize()
		{
			centerWizard(false);
		};
		
		// Register and first call
		$(window).bind("normalized-resize", handleWizardResize);
		
		/*
		 * Center function
		 * @param boolean animate whether or not to animate the position change
		 * @return void
		 */
		function centerWizard(animate)
		{
			form[animate ? "animate" : "css"]({ marginTop: Math.max(0, Math.round(($.template.viewportHeight-30-form.outerHeight())/2))+"px" });
		};
		
		// Initial vertical adjust
		centerWizard(false);
		
		// Refresh position on change step
		form.on("wizardchange", function() { centerWizard(true); });
		
		// Validation
		if ($.validationEngine)
		{
			form.validationEngine();
		}
}


function validaFormularioUsuario(opcion)
{
	if(validar(document.frmSistema.nombre_usuario) == true && validar(document.frmSistema.login_usuario) == true && validar(document.frmSistema.pswd_usuario) == true)
	{
		if(document.frmSistema.pswd_usuario.value == document.frmSistema.pswd_usuario_c.value)
		{
			navegar(opcion);
		}
		else
		{
			alert("Las claves de acceso no coinciden");
		}
	}
	else
	{
		if(document.frmSistema.tipo.value == "editar")
		{
			if(document.frmSistema.pswd_usuario.value == document.frmSistema.pswd_usuario_c.value)
			{
				navegar(opcion);
			}
			else
			{
				alert("Las claves de acceso no coinciden");
			}
		}
		else
		{
			alert("Por favor llene todos los campos");
		}
	}
}

function nuevaSucursal(opcion)
{
	if(validar(document.frmSistema.nombreSucursal) == true)	
	{
		navegar(opcion); 
	}
	else
	{
		alert("Capture nombre de la sucursal");
	}
	
}

function nuevaMarca(opcion)
{
	if(validar(document.frmSistema.nombreMarca) == true)	
	{
		navegar(opcion); 
	}
	else
	{
		alert("Capture nombre de la marca");
	}
}

function nuevaLinea(opcion)
{
	if(validar(document.frmSistema.nombreLinea) == true)	
	{
		navegar(opcion); 
	}
	else
	{
		alert("Capture nombre de la línea");
	}
}

function nuevaUnidad(opcion)
{
	if(validar(document.frmSistema.nombreUnidad) == true)	
	{
		if(validar(document.frmSistema.nombreAbrev) == true)
		{
			navegar(opcion); 
		}
		else
		{
			alert("Capture abreviatura de la unidad");
		}
	}
	else
	{
		alert("Capture nombre de la unidad");
	}
}

function nuevoProducto(opcion)
{
	isFloatPrecio = true;
	isFloatCosto = true;
	precio = document.frmSistema.precioGeneral.value;
	costo = document.frmSistema.costoProducto.value;
	
	if(!/^(\d)+((\.)(\d){1,2})?$/.test(precio))
		isFloatPrecio = false;
	if(!/^(\d)+((\.)(\d){1,2})?$/.test(costo))
		isFloatCosto = false;		
	
	
	if(validar(document.frmSistema.nombreProducto) == true)
	{	
		if(isFloatPrecio == true)	
		{
			if(isFloatCosto == true)	
			{
				if(validar(document.frmSistema.stockMinProducto) == true)
				{
					navegar(opcion); 
				}
				else
				{
					alert("Capture stock mínimo del producto.");
				}
			}
			else
			{
				alert("El formato de costo no es correcto.");
			}
		}
		else
		{
			alert("El formato de precio no es correcto.");
		}
	}
	else
	{
		alert("Capture nombre del producto.");
	}
}

/*-------------alta de proveedor--------------*/

function nuevoProveedor(opcion)
{
	if(validar(document.frmSistema.nombreProveedor) == true)	
	{
		navegar(opcion); 
	}
	else
	{
		alert("Capture nombre del proveedor");
	}
}

/*-------------alta de cliente--------------*/

function nuevoCliente(opcion)
{
	if(validar(document.frmSistema.nombreCliente) == true)	
	{
		if(validar(document.frmSistema.correoCliente) == true)	
		{
			navegar(opcion); 
		}
		else
		{
			alert("Capture correo del cliente");
		}
	}
	else
	{
		alert("Capture nombre del cliente");
	}
}

/*-------------alta de medio de contacto--------------*/

function nuevoTipoContacto(opcion)
{
	if(validar(document.frmSistema.nombreTipo) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture nombre del medio de contacto");
	}	
}

/*-------------alta de forma de contacto--------------*/

function nuevaFormaContacto(opcion)
{
	if(validar(document.frmSistema.formaContacto) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Forma de contacto");
	}
}

/*-------------alta de tipo de egreso--------------*/

function nuevaCta(opcion)
{
	if(validar(document.frmSistema.nombreCta) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture tipo de egreso");
	}	
}


/*-------------alta de categoria--------------*/

function nuevaCategoria(opcion)
{
	if(validar(document.frmSistema.nombreCta) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture nombre de categoría");
	}	
}

/*-------------alta forma de pago--------------*/

function nuevoTipoPago(opcion)
{
	if(validar(document.frmSistema.nombreTipo) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture todos los campos");
	}	
}

/*-------------alta cuenta bancaria--------------*/

function nuevaCuenta(opcion)
{
	if(validar(document.frmSistema.empresa) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture nombre de la cuenta");
	}
}

/*-------------alta ingreso--------------*/

function nuevoIngreso(opcion)
{
	isFloatMonto = true;
	monto = document.frmSistema.montoEgr.value;
	if(!/^(\d)+((\.)(\d){1,2})?$/.test(monto))
		isFloatMonto = false;
		
	if(validar(document.frmSistema.datepicker) == true)	
	{
		if(validar(document.frmSistema.conceptoEgr) == true)
		{	
			if(isFloatMonto == true)	
			{
				navegar(opcion);
			}
			else
			{
				alert("El formato del monto no es correcto");
			}
		}
		else
		{
			alert("Capture concepto de egreso");
		}
	}
	else
	{
		alert("Capture fecha de egreso");
	}	
}

/*-------------alta egreso--------------*/

function nuevoEgreso(opcion)
{
	isFloatMonto = true;
	monto = document.frmSistema.montoEgr.value;
	if(!/^(\d)+((\.)(\d){1,2})?$/.test(monto))
		isFloatMonto = false;
		
	if(validar(document.frmSistema.datepicker) == true)	
	{
		if(isFloatMonto == true)	
		{
			navegar(opcion);
		}
		else
		{
			alert("El formato del monto no es correcto");
		}
	}
	else
	{
		alert("Capture fecha de egreso");
	}	
}

function cargarCiudadesSistema(val)
{
	if (window.XMLHttpRequest)
	{
	  xmlhttp = new XMLHttpRequest();
	}
	else
	{
	  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.open("POST","../seccion/ajax/estados_ajax.php",true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("idEdo="+val);
	
	xmlhttp.onreadystatechange = function(){
		if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			$(".selectSerchCity").select2({width: '100%'});
			document.getElementById("city_spn").innerHTML = xmlhttp.responseText.toString();
		}
	}
}

function buscarProductos(obj)
{
	if(obj != 0)
	{
		parametros="idProducto="+obj;
		var enlace = crea_objetoAjax('../seccion/ajax/productos_ajax.php',parametros);
		enlace.onreadystatechange = function()
		{
		   if(enlace.readyState == 4 && enlace.status == 200)
		   {
			  if(enlace.responseText != '')
			  {
				  document.getElementById("costo").value = enlace.responseText;
				  obtener_importe("importe",document.frmSistema.cantidad,document.frmSistema.costo);
			  }
			  
		   }
		}
	}
	else
	{
		 document.getElementById("costo").value = '';
		 document.getElementById("importe").value = '';
	}
}

function buscarProductosVenta(obj)
{
	if(obj != 0)
	{
		parametros="idProducto="+obj;
		var enlace = crea_objetoAjax('../seccion/ajax/productosVenta_ajax.php',parametros);
		enlace.onreadystatechange = function()
		{
		   if(enlace.readyState == 4 && enlace.status == 200)
		   {
			  if(enlace.responseText != '')
			  {
				  document.getElementById("precio").value = enlace.responseText;
				  obtener_importe("importe",document.frmSistema.cantidad,document.frmSistema.precio);
			  }
			  
		   }
		}
	}
	else
	{
		 document.getElementById("precio").value = '';
		 document.getElementById("importe").value = '';
	}
}

function buscarProductosVentaSucursal(obj)
{
	if(obj != 0)
	{
		parametros="idProducto="+obj;
		var enlace = crea_objetoAjax('../seccion/ajax/productosVentaSucursal_ajax.php',parametros);
		enlace.onreadystatechange = function()
		{
		   if(enlace.readyState == 4 && enlace.status == 200)
		   {
			  if(enlace.responseText != '')
			  {
				  document.getElementById("precio").value = enlace.responseText;
				  obtener_importe("importe",document.frmSistema.cantidad,document.frmSistema.precio);
			  }
			  
		   }
		}
	}
	else
	{
		 document.getElementById("precio").value = '';
		 document.getElementById("importe").value = '';
	}
}

function buscarProductosAsignacion(obj)
{
	if(obj != 0)
	{
		parametros="idProducto="+obj;
		var enlace = crea_objetoAjax('../seccion/ajax/productosAsignacion_ajax.php',parametros);
		enlace.onreadystatechange = function()
		{
		   if(enlace.readyState == 4 && enlace.status == 200)
		   {
			  if(enlace.responseText != '')
			  {
				  document.getElementById("returnAjax").innerHTML = enlace.responseText;
				  obtener_importe("importe",document.frmSistema.cantidad,document.frmSistema.precio);
			  }
			  
		   }
		}
	}
	else
	{
		 document.getElementById("precio").value = '';
		 document.getElementById("importe").value = '';
	}
}


function obtener_importe(control,campo_cantidad,campo_costo)
{
	setTimeout(
				function()
				{
					/*validar_contenido(campo_cantidad,"numero");
					validar_contenido(campo_costo,"numero");*/
					
					var cantidad = campo_cantidad.value;
					cantidad = Math.round(cantidad * 100)/100;
					var precio = campo_costo.value;
					precio = Math.round(precio * 100)/100;
					if(precio > 0 && cantidad > 0)
					{
						var total = precio * cantidad;
						document.getElementById(control).value = total;				
					}				
				},100);		
}

function agregarDetalleCompra(opcion)
{
	if(validar(document.frmSistema.cantidad) == true)	
	{
		if(validar(document.frmSistema.importe) == true && document.frmSistema.importe != 0)	
		{
			var idProd = document.frmSistema.idProducto.value;
			if (window.XMLHttpRequest)
			{
			  xmlhttp = new XMLHttpRequest();
			}
			else
			{
			  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
			}
			
			xmlhttp.open("POST","../seccion/ajax/insertDetalleEntrada_ajax.php",true);
			xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
			xmlhttp.send("idEdo="+ idProd);
			
			xmlhttp.onreadystatechange = function(){
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
				{
					document.getElementById("city_spn").innerHTML = xmlhttp.responseText.toString();
				}
			}
			var t = document.getElementById("detallesEntrada").getElementsByTagName("tbody")[0];
			if(t)
			{
				var a = document.createElement('tr');		
				var b = document.createElement('td');
				var c = document.createElement('td');
				var d = document.createElement('td');
				var e = document.createElement('td');
				var f = document.createElement('td');
				b.innerHTML = 'cantidad';
				c.innerHTML = 'producto';
				d.innerHTML = 'costo';
				e.innerHTML = 'importe';
				f.innerHTML = '';
				a.appendChild(b);
				a.appendChild(c);
				a.appendChild(d);
				a.appendChild(e);
				a.appendChild(f);
				t.appendChild(a);		
			}
		}
		else
		{
			alert("Seleccione un producto válido");
		}
	}
	else
	{
		alert("Capture la cantidad");
	}	
}

/*function guardarDetalleCompra(opcion)
{
	if(validar(document.frmSistema.cantidad) == true)	
	{
		if(validar(document.frmSistema.importe) == true && document.frmSistema.importe != 0)	
		{
			navegar(opcion);
		}
		else
		{
			alert("Seleccione un producto válido");
		}
	}
	else
	{
		alert("Capture la cantidad");
	}
}*/

function guardarDetalleChipCompra(opcion)
{
	if(validar(document.frmSistema.cantidad) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture la cantidad");
	}
}

function guardarDetalleAsignacion(opcion)
{
	if(document.frmSistema.stock.value != 0)
	{
		if(validar(document.frmSistema.cantidad) == true)	
		{
			navegar(opcion);			
		}
		else
		{
			alert("Capture la cantidad");
		}
	}
	else
	{
		alert("El producto no es correcto o esta agotado");
	}
}

function guardarDetalleVenta(opcion)
{
	if(validar(document.frmSistema.cantidad) == true)	
	{
		if(validar(document.frmSistema.importe) == true && document.frmSistema.importe != 0)	
		{
			navegar(opcion);
		}
		else
		{
			alert("Seleccione un producto válido");
		}
	}
	else
	{
		alert("Capture la cantidad");
	}
}

function guardarCancelacion(opcion)
{
	if(validar(document.frmSistema.motivoCancelacion) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture motivo de cancelación");
	}
}

function guardarDevolucion(opcion)
{
	if(validar(document.frmSistema.motivoDevolucion) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture motivo de devolución");
	}
}

function guardarAsignaciones(opcion)
{
	navegar(opcion);	
}

/*function guardarEstilo(archivo, opcion)
{
	extensiones_permitidas = new Array(".jpg", ".png");
	if(validar(document.frmSistema.txtEstiloName) == true)	
	{
		if (archivo)
		{ 
			extension = (archivo.substring(archivo.lastIndexOf("."))).toLowerCase();
			permitida = false;
			for (var i = 0; i < extensiones_permitidas.length; i++) 
			{
				if (extensiones_permitidas[i] == extension) 
				{
					 permitida = true;
					 break;
				}
			}
			if (!permitida) 
			{
				 alert("Comprueba la extensión del archivo a subir. \nSólo se pueden subir archivos con extensiones: " + extensiones_permitidas.join()); 
			}
			else
			{
				navegar(opcion);
		   	} 
		}
		else
		{
			navegar(opcion);
		}
	}
	else
	{
		alert("Capture nombre del estilo");
	}
	
}

function guardarModelo(opcion)
{
	if(validar(document.frmSistema.txtModeloName) == true)	
	{
		navegar(opcion); 
	}
	else
	{
		alert("Capture nombre del modelo");
	}
	
}*/

function navegarComision(opcion)
{
	document.frmSistema.seccionComision.value = opcion;
	navegar(); 
}


function validarUtilidad(opcion)
{
	var monto=document.frmSistema.txtSalarios.value;
	var monto1=document.frmSistema.txtRenta.value;
	var monto2=document.frmSistema.txtOtros.value;
	var fecha=document.frmSistema.fechaReporte.value;
	var patron=/^\d+(\.\d{1,2})?$/;
	/*if(fecha == '')
		document.frmSistema.fechaReporte.value = '01-01-1000 - 25-11-2013';*/
	if(monto == '')
	{
		monto = 0.00;
		document.frmSistema.txtSalarios.value = '0.00';
	}
	if(monto1 == '')
	{
		monto1 = 0.00;
		document.frmSistema.txtRenta.value = '0.00';
	}
	if(monto2 == '')
	{
		monto2 = 0.00;	
		document.frmSistema.txtOtros.value = '0.00';
	}
		
	/*if(patron.test(monto))
	{
		if(patron.test(monto1))
		{
			if(patron.test(monto2))
			{*/
				navegar(opcion);
			/*}
			else
			{
				alert("Capture valor de otros gastos correcto");
			}
		}
		else
		{
			alert("Capture valor de renta correcta");
		}
	}
	else
	{
		alert("Capture valor de salario correcto");
	}*/
}

function nuevoTipoCliente(opcion)
{
	if(validar(document.frmSistema.nombreTipo) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture nombre del tipo de cliente");
	}	
}

function validaFormularioFel()
{
	if(validar(document.frmSistema.usuario) == true && validar(document.frmSistema.cuenta) == true && validar(document.frmSistema.pass) == true)
	{
		navegar('Guarda Configuracion');
	}
	else
	{
		alert("Por favor llene todos los campos");
	}
}

function nuevoPasillo(opcion)
{
	if(validar(document.frmSistema.nombrePasillo) == true)
	{
		navegar(opcion);
	}
	else
	{
		alert("Por favor capture nombre de pasillo");
	}
}

function nuevaPlanta(opcion)
{
	if(validar(document.frmSistema.nombrePlanta) == true)
	{
		navegar(opcion);
	}
	else
	{
		alert("Por favor capture nombre de la planta");
	}
}

function nuevoAnaquel(opcion)
{
	if(validar(document.frmSistema.nombreAnaquel) == true)
	{
		navegar(opcion);
	}
	else
	{
		alert("Por favor capture nombre del anaquel");
	}
}

function compraInventario(opcion)
{
	if(validar(document.frmSistema.cantProd) == true && validar(document.frmSistema.motivoAgregar) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture ambos campos");
	}	
}

function calcula_cambio()
{
	var total = $("#total").val();
	var recibido = $("#recibido").val();
	if(recibido!="")
	{
		var cambio = parseFloat(recibido-total);
		if(cambio>0){$("#cambio").val(cambio);}
		else{$("#cambio").val("");}
		
	}
}

function load_descripcion()
{
	var var_codigo = $("#codigo").val();
	if (var_codigo!="")
	{
		$("#carga_descripcion").load("../seccion/ajax/carga_descripcion.php",{codigo:var_codigo});
		$("#carga_precio").load("../seccion/ajax/carga_precio.php",{codigo:var_codigo});
	}
}

function agrega_ticket()
{
	var var_codigo = $("#codigo").val();
	var var_cantidad = $("#cantidad").val();
	var var_precio = $("#precio").val();
	var var_descripcion = $("#descripcion").val();
	var var_transaccion = $("#carga_transaccion").text();

	if (var_codigo!="" && var_cantidad!="" && var_precio !="")
	{
		
		if($("#interno").attr("checked"))
		{
			if(confirm("¿Es Consumo Interno?"))
			{
				var var_total = parseFloat ($("#total").val());
				var_total = var_total + (var_precio * var_cantidad);
				var_total = parseFloat(var_total).toFixed(2);
				$("#total").val(var_total);
				$("#ticket").load("../seccion/ajax/interno.php",{codigo:var_codigo,cantidad:var_cantidad,precio:var_precio,descripcion:var_descripcion,transaccion:var_transaccion});
			}
		}
		else 
		{
			var var_total = parseFloat ($("#total").val());
			var_total = var_total + (var_precio * var_cantidad);
			var_total = parseFloat(var_total).toFixed(2);
			$("#total").val(var_total);
			$("#ticket").load("../seccion/ajax/guarda_salida.php",{codigo:var_codigo,cantidad:var_cantidad,precio:var_precio,descripcion:var_descripcion,transaccion:var_transaccion});
		}
							
	}
	
	$("#codigo").val("");
	$("#cantidad").val("1");
	$("#precio").val("");
	$("#descripcion").val("");			
	$("#codigo").focus();		
		
}

function genera_transaccion()
{
	$("#carga_transaccion").load("../seccion/ajax/genera_transaccion.php");
}

function borra_salida(var_folio,var_codigo,var_cantidad,var_transaccion,var_precio)
{
	var var_total = parseFloat ($("#total").val());
	var_total = var_total - (var_precio * var_cantidad);
	var_total = parseFloat(var_total).toFixed(2);
	$("#total").val(var_total);
	
	$("#ticket").load("../seccion/ajax/elimina_salida.php",{folio:var_folio,codigo:var_codigo,cantidad:var_cantidad,transaccion:var_transaccion});
}

function borra_salida_interna(var_folio,var_codigo,var_cantidad,var_transaccion,var_precio)
{
	var var_total = parseFloat ($("#total").val());
	var_total = var_total - (var_precio * var_cantidad);
	var_total = parseFloat(var_total).toFixed(2);
	$("#total").val(var_total);
	
	$("#ticket").load("../seccion/ajax/elimina_salida_interna.php",{folio:var_folio,codigo:var_codigo,cantidad:var_cantidad,transaccion:var_transaccion});
}

function crea_link_ticket()
{
	var var_transaccion = $("#carga_transaccion").text();
	$("#link_ticket").attr("href","../seccion/ajax/crea_ticket.php?transaccion="+var_transaccion);
}

function carga_productos()
{
	$("#div_articulos").load("../seccion/ajax/articulos.php");
	$("#div_articulos").show();
}

function nuevaImagen(opcion)
{
	if(validar(document.frmSistema.nombreImagen) == true)
	{
		var archivo = document.getElementById("adjunto").value;
		if(archivo == '')
		{
			alert('Debe seleccionar un archivo previamente');
			return false;
		}
		else
		{
			if(navigator.userAgent.indexOf('Linux') != -1)
			{
				var SO = "Linux"; 
			}
			else if((navigator.userAgent.indexOf('Win') != -1) &&(navigator.userAgent.indexOf('95') != -1))
			{
				var SO = "Win"; 
			}
			else if((navigator.userAgent.indexOf('Win') != -1) &&(navigator.userAgent.indexOf('NT') != -1))
			{
				var SO = "Win"; 
			}
			else if(navigator.userAgent.indexOf('Win') != -1)
			{
				var SO = "Win"; 
			}
			else if(navigator.userAgent.indexOf('Mac') != -1)
			{
				var SO = "Mac"; 
			}
			else 
			{ 
				var SO = "no definido";
			}
			if(SO = "Win")
			{
				var arr_ruta = archivo.split("\\");
			}
			else
			{
				var arr_ruta = archivo.split("/");
			}
			var nombre_archivo = (arr_ruta[arr_ruta.length-1]);
			var ext_validas = /\.(gif|jpg|png)$/i.test(nombre_archivo);
			if (!ext_validas)
			{
				borrar();
				alert("Archivo con extensión no válida.");
				return false;
			}
			else
			{
				navegar(opcion);
			}
		}
	}
	else
	{
		alert('Capture nombre de la imágen');
	}
}

function nuevaImagenSider(opcion)
{
	var archivo = document.getElementById("adjunto").value;
	if(archivo == '')
	{
		alert('Debe seleccionar un archivo previamente');
		return false;
	}
	else
	{
		if(navigator.userAgent.indexOf('Linux') != -1)
		{
			var SO = "Linux"; 
		}
		else if((navigator.userAgent.indexOf('Win') != -1) &&(navigator.userAgent.indexOf('95') != -1))
		{
			var SO = "Win"; 
		}
		else if((navigator.userAgent.indexOf('Win') != -1) &&(navigator.userAgent.indexOf('NT') != -1))
		{
			var SO = "Win"; 
		}
		else if(navigator.userAgent.indexOf('Win') != -1)
		{
			var SO = "Win"; 
		}
		else if(navigator.userAgent.indexOf('Mac') != -1)
		{
			var SO = "Mac"; 
		}
		else 
		{ 
			var SO = "no definido";
		}
		if(SO = "Win")
		{
			var arr_ruta = archivo.split("\\");
		}
		else
		{
			var arr_ruta = archivo.split("/");
		}
		var nombre_archivo = (arr_ruta[arr_ruta.length-1]);
		var ext_validas = /\.(gif|jpg|png)$/i.test(nombre_archivo);
		if (!ext_validas)
		{
			borrar();
			alert("Archivo con extensión no válida.");
			return false;
		}
		else
		{
			navegar(opcion);
		}
	}	
}

function borrar()
{
	var vacio = document.getElementById('adjunto').value = "";
}

function guardaDatosEmpresa(opcion)
{
	var archivo = document.getElementById("adjunto").value;
	if(archivo != '')
	{
		if(navigator.userAgent.indexOf('Linux') != -1)
		{
			var SO = "Linux"; 
		}
		else if((navigator.userAgent.indexOf('Win') != -1) &&(navigator.userAgent.indexOf('95') != -1))
		{
			var SO = "Win"; 
		}
		else if((navigator.userAgent.indexOf('Win') != -1) &&(navigator.userAgent.indexOf('NT') != -1))
		{
			var SO = "Win"; 
		}
		else if(navigator.userAgent.indexOf('Win') != -1)
		{
			var SO = "Win"; 
		}
		else if(navigator.userAgent.indexOf('Mac') != -1)
		{
			var SO = "Mac"; 
		}
		else 
		{ 
			var SO = "no definido";
		}
		if(SO = "Win")
		{
			var arr_ruta = archivo.split("\\");
		}
		else
		{
			var arr_ruta = archivo.split("/");
		}
		var nombre_archivo = (arr_ruta[arr_ruta.length-1]);
		var ext_validas = /\.(gif|jpg|png)$/i.test(nombre_archivo);
		if (!ext_validas)
		{
			borrar();
			alert("Archivo con extensión no válida.");
			return false;
		}
	}
	if(validar(document.frmSistema.razonConf) == true)
	{
		if(validar(document.frmSistema.rfcConf) == true)
		{
			if(validar(document.frmSistema.domicilioConf) == true)
			{
				navegar(opcion);
			}
			else
			{
				alert("Por favor capture domicilio de la empresa");
			}
		}
		else
		{
			alert("Por favor capture rfc de la empresa");
		}		
	}
	else
	{
		alert("Por favor capture razón de la empresa");
	}
}

function guarda_existencia(opcion)
{
	var proVal = $("#prodTrue").val();
	if(proVal != 0)
	{
		if(validar(document.frmSistema.existenciaUpdate) == true)
		{
			if(validar(document.frmSistema.observacionUpdate) == true)
			{
				if($("#chkCodigo").is(":checked")) 
				{
					if(validar(document.frmSistema.codigoUpdate) == true)
						navegar(opcion);
					else
						alert("Por favor capture el código del producto");
				}
				else
				{
					$("#idProducto option:selected").each(function () 
					{
						var idProducto=$(this).val();
						if(idProducto != 0)
							navegar(opcion);
						else
							alert("Por favor seleccione un producto");
					});
					
				}
			}
			else
			{
				alert("Por favor capture la observación");			
			}
		}
		else
		{
			alert("Por favor capture existencia del producto");
		}
	}
	else
	{
		alert("Por favor seleccione un producto válido");
	}
}

function nuevoPago(opcion)
{
	if(validar(document.frmSistema.cantidad) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture cantidad de pago");
	}
}

function eliminarIngreso(opcion)
{
	if(validar(document.frmSistema.motivoIngr) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture motivo de eliminación");
	}
}

function eliminarEgreso(opcion)
{
	if(validar(document.frmSistema.motivoEgr) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture motivo de eliminación");
	}
}

function guardarEgreso(opcion)
{
	if(validar(document.frmSistema.conceptoEgr) == true)	
	{
		navegar(opcion);
	}
	else
	{
		alert("Capture concepto del egreso");
	}
}

function nuevaPromocion(opcion)
{
	if(validar(document.frmSistema.nombrePromo) == true)	
	{
		if(validar(document.frmSistema.rangoFechas) == true)	
		{
			navegar(opcion);
		}
		else
		{
			alert("Capture vigéncia de la promoción");
		}
	}
	else
	{
		alert("Capture nombre de la promoción");
	}
}


function navegarFacturas(opcion)
{
	document.frmSistema.facturasCargar.value = opcion;
	navegar(); 
}

function nuevoNivel(opcion)
{
	if(validar(document.frmSistema.nombreNivel) == true)	
	{
		navegar(opcion);		
	}
	else
	{
		alert("Capture nombre del nivel de interés");
	}
}

function nuevoTipoSeg(opcion)
{
	if(validar(document.frmSistema.nombreTipo) == true)	
	{
		navegar(opcion);		
	}
	else
	{
		alert("Capture nombre del tipo de seguimiento");
	}
}

function nuevoTipoRec(opcion)
{
	if(validar(document.frmSistema.nombreTipo) == true)	
	{
		navegar(opcion);		
	}
	else
	{
		alert("Capture nombre del tipo de rechazo");
	}
}

function devolucionCompra(opcion)
{
	if(validar(document.frmSistema.motivoDevolver) == true)	
	{
		navegar(opcion);		
	}
	else
	{
		alert("Capture motivo de devolución");
	}
}

function nuevaMateria(opcion)
{
	isFloatCosto = true;
	costo = document.frmSistema.costoProducto.value;
	
	if(!/^(\d)+((\.)(\d){1,2})?$/.test(costo))
		isFloatCosto = false;	
	
	
	if(validar(document.frmSistema.nombreProducto) == true && validar(document.frmSistema.codigo) == true && validar(document.frmSistema.codigoInt) == true)
	{	
		if(isFloatCosto == true)	
		{
			navegar(opcion); 			
		}
		else
		{
			alert("El formato del costo no es correcto.");
		}
	}
	else
	{
		alert("Capture todos los campos.");
	}
}

function view_message(divCarga, catTipo, action)
{
	var continuePost = false;
	var clearToggle = false;
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["action"] = action;

	switch(catTipo)
	{
		case 1:
			switch(action)
			{
				case 'closeCorte':
				case 'printRetiro':
				case 'printHoraRetiro':
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

				break;
				case "false":
					switch(catTipo)
					{
						case 1:
							switch(action)
							{
								case 'closeCorte':
									(new PNotify({
										title: 'Correcto!',
										text: valData.alert,
										icon: 'fa fa-check-circle',
										shadow: "false",
										opacity: 1,
										type: "success",
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
						case 1:
							switch(action)
							{
								case 'printRetiro':
								case 'printHoraRetiro':
									(new PNotify({
										title: 'Aviso!',
										text: valData.alert,
										icon: 'fa fa-check-circle',
										shadow: "false",
										opacity: 1,
										type: "warning",
										hide: false,
										confirm: {
											confirm: true,
											buttons: [{
												text: 'Ok',
												addClass: 'btn-primary',
												/*click: function () {
													sessLogOut(1);
												}*/
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
			}
		}, 'json');
	}
}

