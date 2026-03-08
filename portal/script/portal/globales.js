var ext = "";
var base = $("link[rel='base']").attr("href");
if(base == "https://iopik.com/altaiopik/" || base == "/proyectos/iopik/altaiopik/")
	ext = "../";

function closeSession()
{
	sessionStorage.setItem("idUserSite", "");
	location.reload();
}

function validar_contenido(campo,tipo)
{
	switch(tipo){
		case "numero":
			setTimeout(
			function(){
				var regexp = /^\d*\.?\d*$/;
				var nstr='';
				for(var i=0;i<campo.value.length;i++)
				{
					if(regexp.test(campo.value.charAt(i)))
					{
						nstr+=campo.value.charAt(i);
					}
				}
				campo.value=nstr;},50
			);
			return true;
		break;

		default:

		setTimeout(
			function(){
				var regexp = /^\d*\.?\d*$/;
				var nstr='';
				for(var i=0;i<campo.value.length;i++){
					if(regexp.test(campo.value.charAt(i))){
						nstr+=campo.value.charAt(i);
					}
				}
				campo.value=nstr;},50
			);
			return true;
		break;
	}
}

function validaEntero(numero)
{
	if (!/^([0-9])*$/.test(numero))
		return false;
	else
		return true;
}

function addCommas(nStr)
{
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
		x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}

function removeCommas(nStr)
{
	nStr = parseFloat(nStr.replace(/,/g, ''));
	return nStr;
}

function resetSelectValueZero(className, type, limpiar, valReset)
{
	type = typeof type !== 'undefined' ?  type : '.';
	limpiar = typeof limpiar !== 'undefined' ?  limpiar : '0';
	valReset = typeof valReset !== 'undefined' ?  valReset : '';

	if(parseInt(limpiar) == 1)
	{
		$(type + className).html('<option selected value="0">'+valReset+'</option>');
		$(type + className).val(0).trigger("change");
		$(type + className).select2(
		{
			theme: "bootstrap",
			dir: "ltr",
			placeholder: "",
			maximumSelectionSize: 6,
			containerCssClass: ":all:",
			"language":
			{
				"noResults" : function () { return 'No se encontraron datos'; }
			}
		});
	}
	else
	{
		$(type + className).val(0).trigger("change");
		$(type + className).select2(
		{
			theme: "bootstrap",
			dir: "ltr",
			placeholder: "",
			maximumSelectionSize: 6,
			containerCssClass: ":all:",
			"language":
			{
				"noResults" : function () { return 'No se encontraron datos'; }
			}
		});
	}
	hideLoading();

	/*$(type + className).val("").multiselect();
	$('select'+ type + className).multiselect("rebuild");

	if(parseInt(limpiar) == 1)
	{
		$('select'+ type + className).html('<option selected value="0">'+valReset+'</option>');
		//$('select'+ type + className).multiselect("val", valReset);
	}

	$('select'+ type + className).multiselect("select", "0");
	$('select'+ type + className).multiselect({
		buttonWidth: '100%',
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		maxHeight: 250,
		buttonClass: "multiselect dropdown-toggle btn btn-default btn-system",
		nonSelectedText: 'Seleccione una opción!',
		//disableIfEmpty: true,
		//disabledText: 'Inactivo ...',
		allSelectedText: 'Sin opciones',
		onDropdownHide: function() {
			$('button.multiselect-clear-filter').click();
		},
	});

	$('select'+ type + className).multiselect("rebuild");

	hideLoading();*/
}

function resetSelectMain(className, type)
{
	type = typeof type !== 'undefined' ?  type : '.';
	$(document).ready(function() {
		$(type + className).val(0).trigger("change");
	});
}

function resetSelectGral(className, type)
{
	type = typeof type !== 'undefined' ?  type : '.';
	$(type + className).select2(
	{
		theme: "bootstrap",
		dir: "ltr",
		placeholder: "",
		maximumSelectionSize: 6,
		containerCssClass: ":all:",
		"language":
		{
			"noResults" : function () { return 'No se encontraron datos'; }
		}
	});

	/*$("." + className).multiselect({
	 buttonWidth: '100%',
	 enableFiltering: true,
	 enableCaseInsensitiveFiltering: true,
	 maxHeight: 250,
	 buttonClass: "multiselect dropdown-toggle btn btn-default btn-system",
	 nonSelectedText: 'Seleccione una opción!',
	 //disableIfEmpty: true,
	 //disabledText: 'Inactivo ...',
	 allSelectedText: 'Sin opciones',
	 onDropdownHide: function() {
	 $('button.multiselect-clear-filter').click();
	 },
	 });*/
}

function resetSelectGralModal(className, nameModal)
{
	$("." + className).select2(
	{
		dropdownParent: $('#'+nameModal),
		theme: "bootstrap",
		dir: "ltr",
		placeholder: "",
		maximumSelectionSize: 6,
		containerCssClass: ":all:",
		"language":
		{
			"noResults" : function () { return 'No se encontraron datos'; }
		}
	});
}

function searchSelectGral2(className, tipo, URL, numChr, txtSeach)
{
	tipo = typeof tipo !== 'undefined' ?  tipo : '.';
	$(tipo + className).select2({
		/*allowClear: true,*/
		placeholderOption: 'first',
		buttonClass: 'multiselect dropdown-toggle btn btn-default btn-primary',
		minimumInputLength: numChr,
		placeholder: txtSeach,
		tags: [],
		ajax:
		{
			url: URL,
			dataType: 'json',
			quietMillis: 250,
			data: function(term)
			{
				return { q: term };
			},
			processResults: function(data)
			{
				var results;
				results = [];
				$.each(data, function(idx, item) {
					results.push({
						'id': item.id,
						'text': item.text
					});
				});
				return { results: results };
			}
		}
		/*ajax:
		 {
		 url: URL,
		 dataType: 'json',
		 delay: 250,
		 processResults: function (data)
		 {
		 return {
		 results: data
		 };
		 },
		 cache: true
		 }*/
	});
}

function searchSelectGral(className, tipo, URL, numChr, txtSeach)
{
	tipo = typeof tipo !== 'undefined' ?  tipo : '.';
	$(tipo + className).select2(
	{
		width: '100%',
		placeholderOption: 'first',
		buttonClass: 'multiselect dropdown-toggle btn btn-default btn-primary',
		theme: "bootstrap",
		dir: "ltr",
		placeholder: txtSeach,
		maximumSelectionSize: 6,
		minimumInputLength: numChr,
		containerCssClass: ":all:",
		"language":
		{
			"noResults" : function () { return 'No se encontraron datos'; },
			"inputTooShort": function () { return 'Capture '+numChr+ ' caracteres mínimo para su búsqueda'; }
		},
		tags: [],
		ajax:
		{
			url: URL,
			dataType: 'json',
			quietMillis: 250,
			data: function(term)
			{
				return { q: term };
			},
			processResults: function(data)
			{
				var results;
				results = [];
				$.each(data, function(idx, item) {
					results.push({
						'id': item.id,
						'text': item.text
					});
				});
				return { results: results };
			}
		}
	});
}

function multiSelectGral(className, type, txtSelect, txtAllSelect, txtClicAll, txtSelected)
{
	type = typeof type !== 'undefined' ?  type : '.';
	txtClicAll = typeof txtClicAll !== 'undefined' ?  txtClicAll : 'Seleccionar todas';
	txtSelected = typeof txtSelected !== 'undefined' ?  txtSelected : 'Opciones seleccionadas';

	if(txtAllSelect == null || txtAllSelect == "")
		txtAllSelect="SELECCIONAR TODAS";

	if(txtClicAll == null || txtClicAll == "")
		txtClicAll="SELECCIONAR TODAS";

	/*$('select'+ type + className).select2(
	{
		/!*theme: "bootstrap",
		dir: "ltr",
		placeholder: "",
		maximumSelectionSize: 6,
		containerCssClass: ":all:"*!/
	});*/

	$('select' + type + className).selectpicker({
		selectAllText: 'SELECCIONAR TODOS',
		deselectAllText: 'DESELECCIONAR TODOS',
		liveSearch: true,
		actionsBox: true,
		size: 4,
		noneSelectedText: 'NADA SELECCIONADO',
		noneResultsText: 'NO HAY RESULTADOS COINCIDENTES {0}',
		countSelectedText: function (numSelected, numTotal)
		{
			return (numSelected == 1) ? '{0} '+txtSelected : '{0} '+txtSelected;
		}
	});

	/*$('select' + type + className).multiselect({
		includeSelectAllOption: true,
		enableFiltering: true,
		enableCaseInsensitiveFiltering: true,
		maxHeight: 250,
		buttonClass: "multiselect dropdown-toggle btn btn-default btn-system",
		nonSelectedText: txtSelect,
		allSelectedText: txtAllSelect,
		selectAllText: txtClicAll,
		buttonWidth: '100%',
		nSelectedText: ' - ' + txtSelected,
		onDropdownHide: function () {
			$('button.multiselect-clear-filter').click();
		},
	});*/
}

function clearAutoComplete(className, type)
{
	type = typeof type !== 'undefined' ?  type : '.';
	$(type + className).attr('autocomplete','off');
}

function clearValue(className, type)
{
	type = typeof type !== 'undefined' ?  type : '.';
	$(type + className).val('');
}

function destroySelectMain(className, typeClass, valSel)
{
	typeClass = typeof typeClass !== 'undefined' ?  typeClass : '.';
	valSel = typeof valSel !== 'undefined' ?  valSel : '0';

	$(typeClass + className).val(valSel).trigger("change");
	$(typeClass + className).select2(
	{
		theme: "bootstrap",
		dir: "ltr",
		placeholder: "",
		maximumSelectionSize: 6,
		containerCssClass: ":all:",
		"language":
		{
			"noResults" : function () { return 'No se encontraron datos'; }
		}
	});

	/*$(document).ready(function() {
		$(typeClass + className).val("").multiselect();
		$(typeClass + className).multiselect("rebuild");
		//$(typeClass + className).multiselect({enableFiltering: true, maxHeight: 450});
		$(typeClass + className).multiselect({
			buttonWidth: '100%',
			enableFiltering: true,
			enableCaseInsensitiveFiltering: true,
			maxHeight: 250,
			buttonClass: "multiselect dropdown-toggle btn btn-default btn-system",
			nonSelectedText: 'Seleccione una opción!',
			//disableIfEmpty: true,
			//disabledText: 'Inactivo ...',
			allSelectedText: 'Sin opciones',
			onDropdownHide: function() {
				$('button.multiselect-clear-filter').click();
			},
		});
		$(typeClass + className).multiselect('select', valSel);
	});*/
}

function destroySelectMainSearch(className, tipo, URL, numChr, txtSeach)
{
	tipo = typeof tipo !== 'undefined' ?  tipo : '.';

	$(document).ready(function() {
		$(tipo + className).val("").select2();
		$(tipo + className).select2({
			allowClear: true,
			/*placeholderOption: 'first',*/
			buttonClass: 'multiselect dropdown-toggle btn btn-default btn-primary',
			minimumInputLength: numChr,
			/*placeholder: txtSeach,*/
			tags: [],
			ajax:
			{
				url: URL,
				dataType: 'json',
				quietMillis: 250,
				data: function(term)
				{
					return { q: term };
				},
				processResults: function(data)
				{
					var results;
					results = [];
					$.each(data, function(idx, item) {
						results.push({
							'id': item.id,
							'text': item.text
						});
					});
					return { results: results };
				}
			}
			/*ajax:
			 {
			 url: URL,
			 dataType: 'json',
			 delay: 250,
			 processResults: function (data)
			 {
			 return {
			 results: data
			 };
			 },
			 cache: true
			 }*/
		});
	});
}

function destroyMultiSelect(className, type)
{
	$(type + className).multiselect('destroy');
}

function resetDataTable(nameTable, totales)
{
	var table = $('.' + nameTable).dataTable
	({
		"aLengthMenu": [[15, 50, 75, -1], [15, 50, 75, "Todos"]],
		"iDisplayLength": -1,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
		},
		"sDom": 'T<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
		"oTableTools": {
			"sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
		},
		responsive: true
	});

	$('.' + nameTable).on('draw.dt', function () {
		$('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Búsqueda...');
		$('.dataTables_length select').addClass('form-control');
		if (totales == 1) {
			$('input[type=search]').keyup(function () {
				doCalc();
			});
		}
	});


	$('.' + nameTable + ' tbody').on('click', 'tr', function () {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
		}
		else {
			table.$('tr.active').removeClass('active');
			$(this).addClass('active');
		}
	});
}

function resetNewDataTable(nameTable, totales, orden, tipoOrden, funcion)
{
	totales = typeof totales !== 'undefined' ?  totales : 0;
	orden = typeof orden !== 'undefined' ?  orden : 0;
	tipoOrden = typeof tipoOrden !== 'undefined' ?  tipoOrden : 'asc';

	var table = $('.' + nameTable).dataTable
	({
		/*dom: 'Bfrtip',
		buttons: [
			'copy', 'csv', 'excel', 'pdf', 'print'
		],*/
		"aLengthMenu": [[5, 50, 75, -1], [5, 50, 75, "Todos"]],
		"iDisplayLength": -1,
		"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json"
		},
		/*"sDom": 'T<"dt-panelmenu clearfix"lfr>t<"dt-panelfooter clearfix"ip>',
		 "oTableTools": {
		 "sSwfPath": "vendor/plugins/datatables/extensions/TableTools/swf/copy_csv_xls_pdf.swf"
		 },*/
		"order": [[ orden, tipoOrden ]],
		"pagingType": "full_numbers",
		responsive: true,
		"initComplete": function( settings, json ) {
			if(funcion != undefined)
			{
				window[funcion](nameTable);
			}
		},
		//"deferRender": true,
		//fixedHeader: true,
		stateSave: true,
		footer: true
		/*scrollY: '50vh',
		 scrollCollapse: true*/
	});

	$('.' + nameTable).on('draw.dt', function () {
		$('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Búsqueda...');
		$('.dataTables_length select').addClass('form-control');
		if (totales == 1) {
			$("input[type=search]").keyup(function () {
				doCalc();
			});

			$("#example_length").change(function() {
				doCalc();
			});

			$(".paginate_button").click(function() {
				doCalc();
			});
		}
	});


	$('.' + nameTable + ' tbody').on('click', 'tr', function () {
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
		}
		else {
			table.$('tr.active').removeClass('active');
			$(this).addClass('active');
		}
	});

	$('button.toggle-vis').on( 'click', function (e)
	{
		e.preventDefault();

		// Get the column API object
		var column = table.api().column( $(this).attr('data-column') );

		// Toggle the visibility
		column.visible( ! column.visible() );
		if(!$(this).hasClass("active"))
		{
			$(this).addClass("active");
		}
		else
			$(this).removeClass("active");

	} );

	return table;

	//$('.' + nameTable).wrap('<dbtnShowModal2iv class="dataTables_scroll" />');
}

function resetNewDataTable2(nameTable, totales, orden, tipoOrden, funcion, funcionCalc, divCont)
{
	totales = typeof totales !== 'undefined' ?  totales : 0;
	orden = typeof orden !== 'undefined' ?  orden : 0;
	tipoOrden = typeof tipoOrden !== 'undefined' ?  tipoOrden : "asc";
	funcion = typeof funcion !== 'undefined' ?  funcion : "";
	funcionCalc = typeof funcionCalc !== 'undefined' ?  funcionCalc : "";
	divCont = typeof divCont !== 'undefined' ?  divCont : "divCatalogo";

	var table = $('.' + nameTable).DataTable
	({
		"scrollX": true,
		dom: 'Bftip',
		buttons: [
            {
				text:'<i class="simple-icon-info"></i>',
                action: function ( e, dt, node, config ) {
                    this.disable(); // disable button
                },
				titleAttr: 'Info'
            },
			{
				extend:    'copy',
				text:      '<i class="iconsminds-file-copy"></i>',
				titleAttr: 'Copiar'
			},
			{
				extend:    'excel',
				text:      '<i class="iconsminds-receipt-4"></i>',
				titleAttr: 'Excel'
			},
			/*{
				extend:    'pdf',
				text:      '<i class="iconsminds-file"></i>',
				titleAttr: 'Pdf'
			},*/
			{
				extend:    'print',
				text:      '<i class="simple-icon-printer"></i>',
				titleAttr: 'Imprimir'
			},
			{
				extend:    'pageLength',
				text:      '<i class="simple-icon-list"></i>',
				titleAttr: 'Longitud de página'
			}

        ],
		aLengthMenu: [[25, 50, 100, -1],
			[ '25 renglones', '50 renglones', '100 renglones', 'Todos' ]],
		"iDisplayLength": 50,
		language:
		{
			paginate:
			{
				previous: "<i class='fas fa-angle-left'></i>",
				next: "<i class='fas fa-angle-right'></i>"
			},
			"lengthMenu": "Muestra _MENU_ registors por página",
			"zeroRecords": "No se encontraron registros",
			"info": "Mostrando página _PAGE_ de _PAGES_",
			"infoEmpty": "No se encontraron registros",
			"infoFiltered": "(Filtrado para _MAX_ registros totales)",
			search: "_INPUT_",
			searchPlaceholder: "BUSCAR...",
			/*"url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Spanish.json",
			search: "_INPUT_",
			searchPlaceholder: "Buscar...",
			lengthMenu: "Muestra _MENU_ renglones"*/
		},
		drawCallback: function ()
		{
			//alert("Hello world");
			$($("." + divCont + " .dataTables_wrapper .pagination li:first-of-type"))
				.find("a")
				.addClass("prev");
			$($("." + divCont + " .dataTables_wrapper .pagination li:last-of-type"))
				.find("a")
				.addClass("next");

			$("." + divCont + " .dataTables_wrapper .pagination").addClass("pagination-sm");
		},
		order: [[ orden, tipoOrden ]],
		responsive: true,
		initComplete: function( settings, json )
		{
			//alert("Hello world");
			if(funcionCalc !== '')
			{
				window[funcionCalc]();
				if (totales == 1)
				{
					$("." + divCont + " input[type=search]").keyup(function ()
					{
						window[funcionCalc]();
					});

					$("." + divCont + " #example_length").change(function()
					{
						window[funcionCalc]();
					});

					$("." + divCont + " .paginate_button").click(function()
					{
						window[funcionCalc]();
					});
				}
			}

			if(funcion !== '')
			{
				window[funcion]();
			}
		},
		footer: true
	});

	$('.' + nameTable + ' tbody').on('click', 'tr', function ()
	{
		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
		}
		else {
			table.$('tr.active').removeClass('active');
			$(this).addClass('active');
		}
	});

	$("." + divCont + " button.toggle-vis").on( 'click', function (e)
	{
		e.preventDefault();

		// Get the column API object
		var column = table.api().column( $(this).attr('data-column') );

		// Toggle the visibility
		column.visible( ! column.visible() );
		if(!$(this).hasClass("active"))
		{
			$(this).addClass("active");
		}
		else
			$(this).removeClass("active");

	} );
	//$('.' + nameTable).wrap('<div class="dataTables_scroll" />');

	return table;
}

/*var date = new Date(), y = date.getFullYear(), m = date.getMonth(), d = date.getDay();
var firstDay = new Date(y, m, d);
var lastDay = new Date(y, m + 1, 0);
firstDay = moment(firstDay).utcOffset("-06:00").format("DD-MM-YYYY");
lastDay = moment(lastDay).utcOffset("-06:00").format("DD-MM-YYYY");*/

function datePickerSimple(elementTime)
{
	$(function(){
		$("." + elementTime).daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			defaultDate: moment()
		});

		$("." + elementTime).css('cursor', 'pointer');
		$("."+elementTime).click(function(){
			$(this).blur();
		});
		$("."+elementTime).keyup(function(){
			//To further secure field, uncomment next line
			//$(this).val( $(this).val().slice(0,-1) );
			$(this).blur();
		});
	});
}

function newDatePickerSimple(elementTime)
{
	$(function(){
		$("." + elementTime).datepicker(
		{
			format: 'dd/mm/yyyy',
			rtl: false,
			templates: {
				leftArrow: "<i class='fas fa-angle-left'></i>",
				rightArrow: "<i class='fas fa-angle-right'></i>"
			},
			onChange: function(selectedDates, dateStr, instance)
			{
				if(funcion != undefined)
				{
					setTimeout(function()
					{
						window[funcion]();
					}, 500);
				}
			}
		});

		/*$("." + elementTime).daterangepicker({
			singleDatePicker: true,
			showDropdowns: true,
			defaultDate: moment(),
			minYear: 1938
		});

		$("." + elementTime).css('cursor', 'pointer');
		$("."+elementTime).click(function(){
			$(this).blur();
		});
		$("."+elementTime).keyup(function(){
			//To further secure field, uncomment next line
			//$(this).val( $(this).val().slice(0,-1) );
			$(this).blur();
		});*/
	});
}

/*function dateRangePicker(elementTime)
{
	$("." + elementTime).daterangepicker({
		startDate: firstDay,
		endDate: lastDay
	});

	$("." + elementTime).css('cursor', 'pointer');
}*/

function newDatePickerSimpleFlt(className, typeData, funcion)
{
	typeData = typeof typeData !== 'undefined' ?  typeData : ".";

	$(typeData+className).datepicker(
	{
		rtl: false,
		templates:
			{
				leftArrow: "<i class='fas fa-angle-left'></i>",
				rightArrow: "<i class='fas fa-angle-right'></i>"
			}
	}).on("change", function()
	{
		if(funcion != undefined)
		{
			setTimeout(function()
			{
				window[funcion]();
			}, 500);
		}
	});
}

function newDatePickerSetDate(className, typeData, funcion, newDate)
{
	newDate = new Date(newDate);
	var day = newDate.getDate();
	var monthIndex = newDate.getMonth()+1;
	var year = newDate.getFullYear();
	var newDateCal = day + '/' + monthIndex + '/' + year;

	typeData = typeof typeData !== 'undefined' ?  typeData : ".";

	$(typeData+className).datepicker(
	{
		rtl: false,
		templates:
			{
				leftArrow: '<i class="simple-icon-arrow-left"></i>',
				rightArrow: '<i class="simple-icon-arrow-right"></i>'
			}
		}).on("change", function()
		{
			if(funcion != undefined)
			{
				setTimeout(function()
				{
					window[funcion]();
				}, 500);
			}
		}).datepicker('setDate', newDateCal);
}

function dateRangePicker(elementTime)
{
	$(function(){
		$("." + elementTime).daterangepicker({
			"showDropdowns": true,
			"autoApply": true,
			"locale": {
				"format": "DD/MM/YYYY",
				"separator": " - ",
				"applyLabel": "Aplicar",
				"cancelLabel": "Cancelar",
				"fromLabel": "Hasta",
				"toLabel": "Desde",
				"customRangeLabel": "Custom",
				"weekLabel": "W",
				"daysOfWeek": [
					"Do",
					"Lu",
					"Ma",
					"Mi",
					"Ju",
					"Vi",
					"Sa"
				],
				"monthNames": [
					"Enero",
					"Febrero",
					"Marzo",
					"Abril",
					"Mayo",
					"Junio",
					"Julio",
					"Augosto",
					"Septiembre",
					"Octubre",
					"Noviembre",
					"Diciembre"
				],
				"firstDay": 1
			},
			"opens": "center"
		});
	});
}

function datePickerFull(elementTime)
{
	$('.' + elementTime).daterangepicker();
	$("." + elementTime).css('cursor', 'pointer');
	$("."+elementTime).click(function(){
		$(this).blur();
	});
	$("."+elementTime).keyup(function(){
		//To further secure field, uncomment next line
		//$(this).val( $(this).val().slice(0,-1) );
		$(this).blur();
	});
}

function timePicker(inpTime, inpTypeClass, elementTime, typeClass)
{
	typeClass = typeof typeClass !== 'undefined' ?  typeClass : ".";
	$(typeClass + elementTime).timeDropper();

	/*$(typeClass + elementTime).datetimepicker({
		pickDate: false
	});*/
}

function scrollTopSite(divCharge)
{
	if(divCharge != "")
		$("#" + divCharge).html('');

	$('body,html').animate({
		scrollTop: 0
	}, 500);
}

function getFormattedDate(date)
{
	var day = date.getDate();
	var month = date.getMonth() + 1;
	var year = date.getFullYear().toString().slice(2);
	return day + '-' + month + '-' + year;
}

function str_pad(input, pad_length, pad_string, pad_type)
{
	var half = '',
			pad_to_go;

	var str_pad_repeater = function(s, len) {
		var collect = '',
				i;

		while (collect.length < len) {
			collect += s;
		}
		collect = collect.substr(0, len);

		return collect;
	};

	input += '';
	pad_string = pad_string !== undefined ? pad_string : ' ';

	if (pad_type !== 'STR_PAD_LEFT' && pad_type !== 'STR_PAD_RIGHT' && pad_type !== 'STR_PAD_BOTH') {
		pad_type = 'STR_PAD_RIGHT';
	}
	if ((pad_to_go = pad_length - input.length) > 0) {
		if (pad_type === 'STR_PAD_LEFT') {
			input = str_pad_repeater(pad_string, pad_to_go) + input;
		} else if (pad_type === 'STR_PAD_RIGHT') {
			input = input + str_pad_repeater(pad_string, pad_to_go);
		} else if (pad_type === 'STR_PAD_BOTH') {
			half = str_pad_repeater(pad_string, Math.ceil(pad_to_go / 2));
			input = half + input + half;
			input = input.substr(0, pad_length);
		}
	}

	return input;
}

function selectListId(idElement, tipo, list, selectRet, funcion)
{
	idElement = typeof idElement !== 'undefined' ?  idElement : 0;
	tipo = typeof tipo !== 'undefined' ?  tipo : "#";

	$(tipo + selectRet).html("");
	var formData = {};
	formData["idElement"] = idElement;
	formData["list"] = list;
	formData["selectRet"] = selectRet;

	$.post("../seccion/ajax/listas/selectAjax.php", formData,
	function (valData)
	{
		$(tipo + selectRet).html(valData.retLista);
		if(valData.valCount == "false")
			alert(valData.errorOption);

		if(valData.reseteRet == "true")
			destroySelectMain(selectRet, tipo, valData.valSel);
		else
			resetSelectGral(selectRet);

		if(funcion != undefined)
		{
			window[funcion](valData);
		}
	}, 'json').done(function(valData)
	{
		hideLoading();
	});
}

function selectCatId(type, idElement, tipo, list, selectRet, valMulti, funcion)
{
	idElement = typeof idElement !== 'undefined' ?  idElement : 0;
	tipo = typeof tipo !== 'undefined' ?  tipo : "#";
	valMulti = typeof valMulti !== 'undefined' ?  valMulti : "";

	$(tipo + selectRet).val("");
	var formData = {};
	formData["type"] = type;
	formData["idElement"] = idElement;
	formData["list"] = list;
	formData["selectRet"] = selectRet;
	formData["valMulti"] = valMulti;

	$.ajax(
	{
		method: "POST",
		dataType: "json",
		url: ext+"seccion/ajax/listas/selectTags.php",
		data: formData,
		success: function(response)
		{
			var len = response.length;

			if(len != 0)
			{
				for(var i=0; i<len; i++)
				{
					$(tipo + selectRet).tagsinput('add', response[i].nombre);
				}

				if(funcion != undefined)
				{
					window[funcion](valData);
				}
			}

			hideLoading();
		},
		error : function (e)
		{
			console.log(e);
		}
	});
}

function sidebarRightToggle(divCarga, catTipo, form, idElem)
{
	$('.myModalContent').html('');
	$('.myModal').modal('show');
}

function sidebarRightHide(divCarga, catTipo, form, idElem)
{
	$('.myModalContent').html('');
	$('.myModal').modal('hide');
}

function showContectModal(divCarga, catTipo, form, idElem)
{
	var continueScroll = false;
	var formData = {};
	formData["divCarga"] = divCarga;
	formData["catTipo"] = catTipo;
	formData["idElem"] = idElem;
	formData["form"] = form;

	switch(catTipo)
	{
	}

	$("."+divCarga).html('<div style="height:190px !important; width:190px !important;" id="cargando"></div>');
	$.post("seccion/ajax/modal/formCatalogs.php", formData,
	function (valData)
	{
		if (valData.valCatalogo == "false")
			alert(valData.alert);
		else
		{
			$("."+divCarga).html(valData.formulario);
			switch(catTipo)
			{
				case 'modal':
					continueScroll = false;
					switch(form)
					{
						case 'login':
							$("#btnRegistration").click(function()
							{
								form_page_app('modal-content', 'modal', 'registry', 0);
							});
						break;
						case 'registry':
							$("#usuario").keyup(function()
							{
								convertSlug("usuario", "#", "slug", "#");
							});
							actionIntoPage("showPass", 0);
							$("#btnBackLogin").click(function()
							{
								form_page_app('modal-content', 'modal', 'login', 0);
							});
						break;
						case 'contact':
						break;
					}
				break;
			}
		}

		if(continueScroll)
			scrollTopSite("");

	}, 'json');
}

function sidebarRightToggle2()
{
	$("#sidebar_right_content").html("");
	var defaults = {
		sbl: "sb-l-o", // sidebar left open onload
		sbr: "sb-r-c", // sidebar right closed onload
		collapse: "sb-l-m", // sidebar left collapse style
		siblingRope: true
		// Setting this true will reopen the left sidebar
		// when the right sidebar is closed
	};

	var options = $.extend({}, defaults, options);

	// toggle sidebar state(open/close)
	if (!$('body').hasClass('mobile-view') && $('body').hasClass('sb-r-o'))
		$('body').toggleClass('sb-r-o sb-r-c').toggleClass(options.collapse);
	else
		$('body').toggleClass('sb-r-o sb-r-c').addClass(options.collapse);

	// Create Modal for hover effect
	if($('.metro-modal').length == 0)
	{
		metroBG = $('<div class="metro-modal"></div>').appendTo('body');
		setTimeout(function() {
			$('.metro-modal').fadeIn();
		}, 380);
	}
	else
		$('.metro-modal').fadeOut('fast', function() { $(this).remove(); });

	setTimeout(function() {
		$(window).trigger('resize');
	}, 300);
}

function sidebarRightTogglePos()
{
	$("#codigoProd").blur();
	$("#codigoProd").val("");
	$("#sidebar_right_content").html("");
	var defaults = {
		sbl: "sb-l-o", // sidebar left open onload
		sbr: "sb-r-c", // sidebar right closed onload
		collapse: "sb-l-m", // sidebar left collapse style
		siblingRope: true
		// Setting this true will reopen the left sidebar
		// when the right sidebar is closed
	};

	var options = $.extend({}, defaults, options);

	// toggle sidebar state(open/close)
	if (!$('body').hasClass('mobile-view') && $('body').hasClass('sb-r-o'))
	{
		$('body').toggleClass('sb-r-o sb-r-c').toggleClass(options.collapse);
		setTimeout(function(){
			$("#codigoProd").focus();
		}, 1000);
	}
	else
	{
		$('body').toggleClass('sb-r-o sb-r-c').addClass(options.collapse);
	}

	// Create Modal for hover effect
	if($('.metro-modal').length == 0)
	{
		metroBG = $('<div class="metro-modal"></div>').appendTo('body');
		setTimeout(function() {
			$('.metro-modal').fadeIn();
		}, 380);
	}
	else
		$('.metro-modal').fadeOut('fast', function() { $(this).remove(); });

	setTimeout(function() {
		$(window).trigger('resize');
	}, 300);
}

function ocultarRightBar(className)
{
	$("#oscurecedor-pantalla").css("display", "none");
	$("body").removeClass("show-rightbar");
	$("#page-rightbar").html("");
	$("#page-rightbar").html("");

	//clear_form_elements(className);
	//$(".modal-backdrop").remove();
}

function togglePanel()
{
	$(".btnPanelToogle").on("click",function()
	{
		$(this).toggleClass("fa-angle-down");
		$(this).toggleClass("fa-angle-up");
	});
}

function sumColsDataTable(varIni, varFin, varTd, varSpn, params)
{
	var j = 0;
	var formato = '';
	params = typeof params !== 'undefined' ?  params : '';

	for(var i = varIni; i <= varFin; i++)
	{
		var totalData = "totalData"+i;
		window[totalData] = 0;
		$('tr').each(function ()
		{
			var txtTd = "td."+varTd+i;
			var val = $(this).children(txtTd).text();
			var importeData = $(this).children(txtTd).text().replace("$", "").replace(/\,/g, '');

			if (importeData !== "")
				window[totalData] = parseFloat(window[totalData]) + parseFloat(importeData);
		});

		var countParams = params.length;
		if(countParams == 0)
		{
			$("."+varSpn+i).html('$ ' + addCommas(parseFloat(window[totalData]).toFixed(2)));
		}
		else
		{
			formato = params[j]["tipo"];
			//formato = arrayLookup(i, params, "col", "tipo");
			switch(formato)
			{
				case '0':
					$("."+varSpn+i).html(parseFloat(window[totalData]));
				break;
				case '1':
					$("."+varSpn+i).html(addCommas(parseFloat(window[totalData]).toFixed(2)));
				break;
				case '2':
					$("."+varSpn+i).html('$ ' + addCommas(parseFloat(window[totalData]).toFixed(2)));
				break;
			}
		}

		j++;
	}
}

function isInt(className, tipo)
{
	tipo = typeof tipo !== 'undefined' ?  tipo : "#";

	$(tipo+className).keypress(function(e)
	{
		console.log(e.which);
		// between 0 and 9
		if((e.which < 48 || e.which > 57) && e.which != 8)
		{
			return(false);  // stop processing
		}
	});
}

function sign(number)
{
	return ( number > 0 ) ? 1 : ( ( number < 0 ) ? -1 : 0 );
}

function showLoading()
{
	$(".overlay").show();
}

function hideLoading()
{
	$(".overlay").hide();
}

function validateEmail(email)
{
	var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
	return re.test(String(email).toLowerCase());
}

function validate()
{
	var $result = $("#result");
	var email = $("#email").val();
	$result.text("");

	if (validateEmail(email))
	{
		$result.text(email + " is valid :)");
		$result.css("color", "green");
	}
	else
	{
		$result.text(email + " is not valid :(");
		$result.css("color", "red");
	}
	return false;
}

function checkValue(value,arr)
{
	var status = false;
	for(var i=0; i<arr.length; i++)
	{
		var name = arr[i];
		if(name == value)
		{
			status = true;
			break;
		}
	}

	return status;
}

function arrayLookup(searchValue, array, searchIndex, returnIndex)
{
	var returnVal = null;
	var i;
	for(i=0; i<array.length; i++)
	{
		if(array[i][searchIndex]==searchValue)
		{
			returnVal = array[i][returnIndex];
			break;
		}
	}

	return returnVal;
}

function sortByKeyDescAsc(array, key, tipo, stylo)
{
	return array.sort(function (a, b)
	{
		var x = a[key];
		var y = b[key];

		if(stylo == 1)
		{
			if(tipo == 1)
				return ((parseFloat(x) > parseFloat(y)) ? -1 : ((parseFloat(x) < parseFloat(y)) ? 1 : 0));
			else
				return ((parseFloat(x) < parseFloat(y)) ? -1 : ((parseFloat(x) > parseFloat(y)) ? 1 : 0));
		}
		else
		{
			if(tipo == 1)
				return ((x > y) ? -1 : ((x < y) ? 1 : 0));
			else
				return ((x < y) ? -1 : ((x > y) ? 1 : 0));
		}
	});
}

function parseDMY(value)
{
	var date = value.split("/");
	var d = parseInt(date[0], 10),
		m = parseInt(date[1], 10),
		y = parseInt(date[2], 10);

	return new Date(y, m - 1, d);
}

function strToDate(dtStr)
{
	var dateParts = dtStr.split("/");
	var timeParts = dateParts[2].split(" ")[1].split(":");
	dateParts[2] = dateParts[2].split(" ")[0];
	// month is 0-based, that's why we need dataParts[1] - 1
	var date = new Date(dateParts[2], dateParts[1]-1, +dateParts[0], timeParts[0], timeParts[1], timeParts[2]);
	return date.getTime();
}

function uniqid()
{
	var ts=String(new Date().getTime()), i = 0, out = '';
	for(i=0;i<ts.length;i+=2) {
		out+=Number(ts.substr(i, 2)).toString(36);
	}
	return ('d'+out);
}

function btnShowModalCat()
{
	$('.see_sidemenu_r').on('click', function()
	{
		sidebarRightToggle();
	});
}

function btnShowModal()
{
	$('.tableOrder tbody').on( 'click', '[class*=see_sidemenu_r_cat]', function () {
		sidebarRightToggle();
	});
}

function btnShowCat()
{
	$('.see_sidemenu_r_form').on('click', function()
	{
		sidebarRightToggle();
	});
}

function btnShowModal2()
{
	$('.tableReport tbody').on( 'click', '[class*=see_sidemenu_r_cat2]', function () {
		sidebarRightToggle();
	});
}

function setScrollable()
{
	var chatAppScroll;
	$(".scroll").each(function () {
		if ($(this).parents(".chat-app").length > 0) {
			var scrollElement = $(this)[0];
			var $scrollContent = $(this).find(".scroll-content");
			var initialized = false;

			function createChatAppScroll() {
				chatAppScroll = new PerfectScrollbar(scrollElement, { suppressScrollX: true });
				chatAppScroll.isRtl = false;
				initialized = false;
			}

			function calculateHeight() {
				var elementsHeight = 0;
				if ($("main").length > 0) {
					elementsHeight += parseInt($("main").css("margin-top"));
				}
				if ($(".chat-input-container").length > 0) {
					elementsHeight += $(".chat-input-container").outerHeight(true);
				}
				if ($(".chat-heading-container").length > 0) {
					elementsHeight += $(".chat-heading-container").outerHeight(true);
				}
				if ($(".separator").length > 0) {
					elementsHeight += $(".separator").outerHeight(true);
				}
				$(".chat-app .scroll").css("height", (window.innerHeight - elementsHeight) + "px");

				if (chatAppScroll) {
					$(".chat-app .scroll").scrollTop(
						$(".chat-app .scroll").prop("scrollHeight")
					);
					chatAppScroll.update();
				}
				if (window.innerWidth < 576) {
					if (chatAppScroll) {
						chatAppScroll.destroy();
						chatAppScroll = null;
					}
					$(".chat-app .scroll-content > div:last-of-type").css("padding-bottom", ($(".chat-input-container").outerHeight(true)) + "px");

					if (!initialized) {
						setTimeout(function () {
							$("html, body").animate({ scrollTop: $(document).height() + 30 }, 100);
						}, 300);
						initialized = true;
					}
				} else {
					if (!chatAppScroll) {
						createChatAppScroll();
					}
					$(".chat-app .scroll-content > div:last-of-type").css("padding-bottom", 0);
				}
			}
			$(window).on("resize", function (event) {
				calculateHeight();
			});
			calculateHeight();

			return;
		}
		var ps = new PerfectScrollbar($(this)[0], { suppressScrollX: true });
		ps.isRtl = false;
	});
}

function convertSlug(className, type, newClassName, newType)
{
	type = typeof type !== 'undefined' ?  type : '.';
	newType = typeof newType !== 'undefined' ?  newType : '.';

	var string = $(type + className).val().toLowerCase();
	var strReplaceAll = string;
	var intIndexOfMatch = strReplaceAll.indexOf(' ');
	while(intIndexOfMatch != -1)
	{
		strReplaceAll = strReplaceAll.replace(' ', '-');
		intIndexOfMatch = strReplaceAll.indexOf(' ');
	}

	var from = "ãàáäâẽèéëêìíïîõòóöôùúüûñç·/_,:;";
	var to   = "aaaaaeeeeeiiiiooooouuuunc------";

	for(var i=0, l=from.length ; i<l ; i++)
	{
		strReplaceAll = strReplaceAll.replace(new RegExp(from.charAt(i), 'g'), to.charAt(i));
	}

	strReplaceAll = strReplaceAll.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
			.replace(/\s+/g, '-') // collapse whitespace and replace by -
			.replace(/-+/g, '-'); // collapse dashes

	string = strReplaceAll;
	for(var i = 0, output = '', valid='-0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; i < string.length; i++)
	{
		if(valid.indexOf(string.charAt(i)) != -1)
		{
			output += string.charAt(i);
		}
	}

	$(newType + newClassName).val(output.toLowerCase());
}

function showAlert(tipo, msj, className, typeClass, findParent, elemParentClass)
{
	typeClass = typeof typeClass !== 'undefined' ?  typeClass : ".";
	findParent = typeof findParent !== true ?  findParent : false;
	elemParentClass = typeof elemParentClass !== 'undefined' ?  elemParentClass : '';

	var txtAlert = "";
	var divAlert = "";
	var typeAlert = "";
	var icono = "";

	if(findParent)
	{
		var parents = $(typeClass+className).parents('.'+elemParentClass);
	}

	switch(tipo)
	{
		case 1:
			txtAlert = "txtAlertSuccess";
			divAlert = "alertSuccess";
			typeAlert = "alert-primary";
			icono = "fa-check";
		break;
		case 2:
			txtAlert = "txtAlertDanger";
			divAlert = "alertDanger";
			typeAlert = "alert-danger";
			icono = "fa-exclamation-triangle";
		break;
		case 3:
			txtAlert = "txtAlertWarning";
			divAlert = "alertWarning";
			typeAlert = "alert-warning";
			icono = "fa-check";
		break;
	}

	$(document).ready(function()
	{
		$('html,body').animate(
		{
			scrollTop: $(typeClass+className).offset().top-140
		},
		'slow');

		if(findParent)
		{
			$('<div class="text-left text-one alert '+typeAlert+' alert-dismissable mt-3 mx-1" id="'+divAlert+'" style="display: none;"><button type="button" class="close" data-hide="'+divAlert+'">×</button><i class="fa '+icono+' pr10"></i><span id="'+txtAlert+'">'+msj+'</span></div>').insertAfter(parents);
			$("#"+divAlert).fadeTo(3000, 500).slideUp(500, function()
			{
				$("#"+divAlert).slideUp(500).remove();
			});
		}
		else
		{
			$('<div class="text-left text-one alert '+typeAlert+' alert-dismissable mt-3 mx-1" id="'+divAlert+'" style="display: none;"><button type="button" class="close" data-hide="'+divAlert+'">×</button><i class="fa '+icono+' pr10"></i><span id="'+txtAlert+'">'+msj+'</span></div>').insertAfter(typeClass+className);
			$("#"+divAlert).fadeTo(3000, 500).slideUp(500, function()
			{
				$("#"+divAlert).slideUp(500).remove();
			});
		}
	});
}

function showHideDiv(action, typeClass, className)
{
	$(typeClass+className).collapse(action);
}

function initMap()
{
	var simpleMapId = "map_canvas";
	if( $('#'+simpleMapId).length > 0 )
	{
		var mapElement = $(document.getElementById(simpleMapId));
		var mapDefaultZoom = parseInt(mapElement.attr("data-ts-map-zoom"), 10);
		var centerLatitude = parseFloat(mapElement.attr("data-ts-map-center-latitude"));
		var centerLongitude = parseFloat(mapElement.attr("data-ts-map-center-longitude"));
		var zoomPosition = mapElement.attr("data-ts-map-zoom-position");
		var controls = parseInt(mapElement.attr("data-ts-map-controls"), 10);
		( controls === 0 ) ? controls = true : controls = false;
		var locale = mapElement.attr("data-ts-locale");
		var currency = mapElement.attr("data-ts-currency");
		var unit = mapElement.attr("data-ts-unit");
		var scrollWheel = mapElement.attr("data-ts-map-scroll-wheel");
		var mapStyle = mapElement.attr("data-ts-google-map-style");
		var markerDrag = parseInt( mapElement.attr("data-ts-map-marker-drag"), 10 );
		( markerDrag === 1 ) ? markerDrag = true : markerDrag = false;

		if( !mapDefaultZoom ){
			mapDefaultZoom = 14;
		}

		var mapCenter = new google.maps.LatLng(centerLatitude,centerLongitude);
		var mapOptions = {
			zoom: mapDefaultZoom,
			center: mapCenter,
			disableDefaultUI: controls,
			scrollwheel: scrollWheel,
			styles: mapStyle
		};
		var element = document.getElementById(simpleMapId);
		map = new google.maps.Map(element, mapOptions);
		var geocoder = new google.maps.Geocoder();
		var marker = new google.maps.Marker(
			{
			position: mapCenter,
			map: map,
			icon: "assets/img/marker-small.png",
			draggable: markerDrag
		});

		google.maps.event.addListener(marker, 'dragend', function (event)
		{
			geocoder.geocode(
			{
				latLng: marker.getPosition()
			},
			function(responses)
			{
				var place = "";
				if (responses && responses.length > 0)
				{
					marker.formatted_address = responses[0].formatted_address;
					var place = responses[0].address_components;
				}
				else
				{
					marker.formatted_address = 'No se puede determinar la dirección en esta ubicación.';
				}

				$("#searchMapInput").val(marker.formatted_address);
				infowindow.setContent('<div><strong>'+marker.formatted_address+'</strong></div>');
				infowindow.open(map, marker);

				for(var i = 0; i < place.length; i++)
				{
					if(place[i].types[0] == 'route')
					{
						$("#calleCliente").val(place[i].long_name);
					}
					if(place[i].types[0] == 'street_number')
					{
						$("#numExtCliente").val(place[i].long_name);
					}
					if(place[i].types[0] == 'political')
					{
						$("#coloniaCliente").val(place[i].long_name);
					}
					if(place[i].types[0] == 'postal_code')
					{
						$("#cpCliente").val(place[i].long_name);
					}
					/*if(place[i].types[0] == 'administrative_area_level_1')
					 {
					 //ESTADO
					 var txtEstado = place[i].long_name;
					 }
					 if(place[i].types[0] == 'locality')
					 {
					 //CIUDAD
					 var txtCiudad = place[i].long_name;
					 }
					 if(place[i].types[0] == 'sublocality_level_1')
					 {
					 //COLONIA
					 var txtColonia = place[i].long_name;
					 }
					 if(place[i].types[0] == 'country')
					 {
					 //document.getElementById('country').innerHTML =      long_name;
					 }*/
				}

				$("#latMap").val(marker.getPosition().lat());
				$("#longMap").val(marker.getPosition().lng());
			});
		});

		var input = document.getElementById('searchMapInput');
		map.controls[google.maps.ControlPosition.TOP_LEFT].push(input);
		var autocomplete = new google.maps.places.Autocomplete(input);
		autocomplete.bindTo('bounds', map);

		var infowindow = new google.maps.InfoWindow();
		autocomplete.addListener('place_changed', function()
		{
			infowindow.close();
			marker.setVisible(false);
			var place = autocomplete.getPlace();
			if(!place.geometry) {
				window.alert("Autocomplete's returned place contains no geometry");
				return;
			}

			/* If the place has a geometry, then present it on a map. */
			if (place.geometry.viewport)
			{
				map.fitBounds(place.geometry.viewport);
			}
			else
			{
				map.setCenter(place.geometry.location);
				map.setZoom(17);
			}

			marker.setPosition(place.geometry.location);
			marker.setVisible(true);
			var address = '';
			if (place.address_components)
			{
				address = [

					(place.address_components[0] && place.address_components[0].short_name || ''),

					(place.address_components[1] && place.address_components[1].short_name || ''),

					(place.address_components[2] && place.address_components[2].short_name || '')

				].join(' ');
			}

			infowindow.setContent('<div><strong>' + place.name + '</strong><br>' + address);
			infowindow.open(map, marker);

			//Location details
			for(var i = 0; i < place.address_components.length; i++)
			{
				if(place.address_components[i].types[0] == 'route')
				{
					$("#calleCliente").val(place.address_components[i].long_name);
				}
				if(place.address_components[i].types[0] == 'street_number')
				{
					$("#numExtCliente").val(place.address_components[i].long_name);
				}
				if(place.address_components[i].types[0] == 'sublocality_level_1')
				{
					$("#coloniaCliente").val(place.address_components[i].long_name);
				}
				if(place.address_components[i].types[0] == 'postal_code')
				{
					$("#cpCliente").val(place.address_components[i].long_name);
				}
				/*if(place.address_components[i].types[0] == 'administrative_area_level_1')
				{
					//ESTADO
					var txtEstado = place.address_components[i].long_name;
				}
				if(place.address_components[i].types[0] == 'locality')
				{
					//CIUDAD
					var txtCiudad = place.address_components[i].long_name;
				}
				if(place.address_components[i].types[0] == 'sublocality_level_1')
				{
					//COLONIA
					var txtColonia = place.address_components[i].long_name;
				}
				if(place.address_components[i].types[0] == 'country')
				{
					//document.getElementById('country').innerHTML = place.address_components[i].long_name;
				}*/
			}

			/* Location details */
			$("#latMap").val(place.geometry.location.lat());
			$("#longMap").val(place.geometry.location.lng());
		});
	}
}

function actionUlLi(className, typeData, funcion)
{
	typeData = typeof typeData !== 'undefined' ?  typeData : ".";

	$('div'+typeData+className+' a').click(function(e)
	{
		var value = $(this).data('value');
		var txt = $(this).text();
		$(this).closest(".input-group-append").find('.inputRango').val(value);
		$(this).closest(".input-group-append").find('.spnRango').html(txt);

		if(funcion != "")
			window[funcion]();
	});
}

function addRowTable(catTable, newRow)
{
	var current = catTable.order();
	var valSearch = $('.divCatalogo .dataTables_filter input').val();
	if(valSearch !== "")
		sessionStorage.setItem("valSearch", valSearch);

	catTable.row.add($(newRow)[0]);
	catTable.destroy();

	return current;
}

function editRowTable(idRow, catTable, newRow)
{
	var valSearch = $('.divCatalogo .dataTables_filter input').val();
	if(valSearch !== "")
		sessionStorage.setItem("valSearch", valSearch);
	else
		sessionStorage.setItem("valSearch", "");

	catTable.row('#'+idRow).remove();
	var current = addRowTable(catTable, newRow);

	return current;
}

function deleteRowTable(catTable, idRow)
{
	var valSearch = $('.divCatalogo .dataTables_filter input').val();
	if(valSearch !== "")
		sessionStorage.setItem("valSearch", valSearch);
	else
		sessionStorage.setItem("valSearch", "");

	var current = catTable.order();
	catTable.row('#'+idRow).remove();
	catTable.destroy();

	return current;
}

function checkValSearch(catTable, funcionCalc)
{
	funcionCalc = typeof funcionCalc !== 'undefined' ?  funcionCalc : "";
	var valSearch = sessionStorage.getItem("valSearch");
	if(valSearch !== "")
	{
		$('.divCatalogo .dataTables_filter input').val(valSearch);
		catTable.search(valSearch).draw();
	}

	if(funcionCalc !== '')
	{
		window[funcionCalc]();
	}
}

function addSubRowTable(catSubTable, newRow)
{
	var current = catSubTable.order();
	var valSubSearch = $('.divFormCatalogo .dataTables_filter input').val();
	if(valSubSearch !== "")
		sessionStorage.setItem("valSubSearch", valSubSearch);
	else
		sessionStorage.setItem("valSubSearch", "");

	catSubTable.row.add($(newRow)[0]);
	catSubTable.destroy();

	return current;
}

function editSubRowTable(idRow, catSubTable, newRow)
{
	var valSubSearch = $('.divFormCatalogo .dataTables_filter input').val();
	if(valSubSearch !== "")
		sessionStorage.setItem("valSubSearch", valSubSearch);
	else
		sessionStorage.setItem("valSubSearch", "");

	catSubTable.row('#'+idRow).remove();
	var current = addSubRowTable(catSubTable, newRow);

	return current;
}

function deleteSubRowTable(catSubTable, idRow)
{
	var valSubSearch = $('.divFormCatalogo .dataTables_filter input').val();
	if(valSubSearch !== "")
		sessionStorage.setItem("valSubSearch", valSubSearch);
	else
		sessionStorage.setItem("valSubSearch", "");

	var current = catSubTable.order();
	catSubTable.row('#'+idRow).remove();
	catSubTable.destroy();

	return current;
}

function checkValSubSearch(catSubTable, funcionCalc)
{
	funcionCalc = typeof funcionCalc !== 'undefined' ?  funcionCalc : "";
	var valSubSearch = sessionStorage.getItem("valSubSearch");
	if(valSubSearch !== "")
	{
		$('.divFormCatalogo .dataTables_filter input').val(valSubSearch);
		catSubTable.search(valSubSearch).draw();
	}

	if(funcionCalc !== '')
	{
		window[funcionCalc]();
	}
}

function addSubRowRepTable(catSubRepTable, newRow)
{
	var current = catSubRepTable.order();
	var valSubRepSearch = $('.divSubFormCatalogo .dataTables_filter input').val();
	if(valSubRepSearch !== "")
		sessionStorage.setItem("valSubRepSearch", valSubRepSearch);
	else
		sessionStorage.setItem("valSubRepSearch", "");

	catSubRepTable.row.add($(newRow)[0]);
	catSubRepTable.destroy();

	return current;
}

function colorPicker(className, tipo)
{
	tipo = typeof tipo !== 'undefined' ?  tipo : "#";

	$(tipo+className).colorpicker(
	{
		popover: false,
		inline: true,
		container: tipo+className
	});
}

function resetCalendarNew(classNameDate, typeDate, classNameCal, typeCal, nameFile, option, funcion)
{
	typeDate = typeof typeDate !== 'undefined' ?  typeDate : '.';
	typeCal = typeof typeCal !== 'undefined' ?  typeCal : '.';

	var dateOld = $(typeDate+classNameDate).val();
	if(dateOld != "")
	{
		var dt = parseInt("01");
		var mon = parseInt(dateOld.substring(0,2));
		var yr = parseInt(dateOld.substring(3,7));
		var newDate = new Date(yr, mon-1, dt);
	}
	else
		var newDate = "";

	$(typeCal+classNameCal).fullCalendar("destroy");
	$(typeCal+classNameCal).fullCalendar
	({
		//weekMode: 'variable',
		themeSystem: "bootstrap4",
		height: "auto",
		isRTL: false,
		header:
		{
			left: "",
			center: "title",
			right: ""
		},
		locale: 'es',
		monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
		monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun','Jul','Ago','Sep','Oct','Nov','Dic'],
		dayNames: ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'],
		dayNamesShort: ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'],
		allDayDefault: false,
		editable: false,
		disableResizing: false,
		eventLimit: true,
		views: {
			timeGrid: {
				eventLimit: 3
			}
		},
		fixedWeekCount: true,
		showNonCurrentDates: false,
		eventSources:
			[
				{
					events: function(start, end, timezone, callback)
					{
						$.ajax
						({
							url: "../seccion/ajax/calendario/"+nameFile+".php",
							dataType: 'json',
							data:
							{
								option: option,
								start: start.unix(),
								end: end.unix()
							},
							success: function(msg)
							{
								var events = msg.events;
								callback(events);
							}
						});
					}
				}
			],
		eventRender: function(event, element, view )
		{
			element.find('.fc-title').prepend('');
		},
		error: function()
		{
			alert('there was an error while fetching events!');
		},
		eventClick: function(event, element)
		{
			if(event.idElem != "")
				window[funcion](event.idElem);
		}
	});

	$(typeCal+classNameCal).fullCalendar('gotoDate', newDate);
}

function showFileTxt(className, type, txtDefLab)
{
	type = typeof type !== 'undefined' ?  type : '.';
	txtDefLab = typeof txtDefLab !== 'undefined' ?  txtDefLab : 'Seleccionar archivo';

	$(type+className).on('change', function()
	{
		var fileName = $(this).val().split('\\').pop();
		if (fileName)
		{
			$(type+"lbl"+className).html(fileName);
		}
		else
		{
			clearFile(className, type, txtDefLab);
		}
	});
}

function clearFile(className, type, txtDefLab)
{
	type = typeof type !== 'undefined' ?  type : '.';
	txtDefLab = typeof txtDefLab !== 'undefined' ?  txtDefLab : 'Seleccionar archivo';

	$(type+className).val('');
	$(type+"lbl"+className).html(txtDefLab);
}

function disableButtonSys()
{
	$(".modal-footer").find("button").prop("disabled", true);
	$(".btn-toolbar.justify-content-end").find("button").prop("disabled", true);
	$("body").addClass("show-spinner");
	$("body").addClass("active");
}

function enableButtonSys()
{
	$(".modal-footer").find("button").prop("disabled", false);
	$(".btn-toolbar.justify-content-end").find("button").prop("disabled", false);
	$("body").removeClass("show-spinner");
	$("body").removeClass("active");
}

function limitText(className, type, maxLength, classNameTxt, typeTxt)
{
	type = typeof type !== 'undefined' ?  type : '.';
	typeTxt = typeof typeTxt !== 'undefined' ?  typeTxt : '.';

	var textlen = parseInt(maxLength) - parseInt($(type+className).val().length);
	$(typeTxt+classNameTxt).text(textlen+"/"+maxLength);
}

function changeUrl(page, url)
{
	if (typeof (history.pushState) != "undefined")
	{
		var obj = {Page: page, Url: url};
		history.pushState(obj, obj.Page, obj.Url);
	}
	else
	{
		window.location.href = "homePage";
		// alert("Browser does not support HTML5.");
	}
}

function chargeImage(className, type)
{
	var $this = $(type + className);

	if( $this.hasClass("ts-separate-bg-element") )
	{
		$this.append('<div class="ts-background">');

		// Background Color

		if( $("[data-bg-color]") )
		{
			$this.find(".ts-background").css("background-color", $this.attr("data-bg-color") );
		}

		// Background Image

		if( $this.attr("data-bg-image") !== undefined )
		{
			$this.find(".ts-background").append('<div class="ts-background-image">');
			$this.find(".ts-background-image").css("background-image", "url("+ $this.attr("data-bg-image") +")" );
			$this.find(".ts-background-image").css("background-size", $this.attr("data-bg-size") );
			$this.find(".ts-background-image").css("background-position", $this.attr("data-bg-position") );
			$this.find(".ts-background-image").css("opacity", $this.attr("data-bg-image-opacity") );

			$this.find(".ts-background-image").css("background-size", $this.attr("data-bg-size") );
			$this.find(".ts-background-image").css("background-repeat", $this.attr("data-bg-repeat") );
			$this.find(".ts-background-image").css("background-position", $this.attr("data-bg-position") );
			$this.find(".ts-background-image").css("background-blend-mode", $this.attr("data-bg-blend-mode") );
		}

		// Parallax effect

		if( $this.attr("data-bg-parallax") !== undefined )
		{
			$this.find(".ts-background-image").addClass("ts-parallax-element");
		}
	}
	else
	{
		if(  $this.attr("data-bg-color") !== undefined ){
			$this.css("background-color", $this.attr("data-bg-color") );
			if( $this.hasClass("btn") ) {
				$this.css("border-color", $this.attr("data-bg-color"));
			}
		}

		if( $this.attr("data-bg-image") !== undefined ){
			$this.css("background-image", "url("+ $this.attr("data-bg-image") +")" );

			$this.css("background-size", $this.attr("data-bg-size") );
			$this.css("background-repeat", $this.attr("data-bg-repeat") );
			$this.css("background-position", $this.attr("data-bg-position") );
			$this.css("background-blend-mode", $this.attr("data-bg-blend-mode") );
		}

		if( $this.attr("data-bg-pattern") !== undefined ){
			$this.css("background-image", "url("+ $this.attr("data-bg-pattern") +")" );
		}

	}
}

function ckeditor(className, type)
{
	type = typeof type !== 'undefined' ?  type : '.';

	ClassicEditor.create(document.querySelector(type+className)).catch(function (error) { });
}

function quillEditor(className, type)
{
	type = typeof type !== 'undefined' ?  type : '.';

	if (typeof Quill !== "undefined")
	{
		var quillToolbarOptions = [
			["bold", "italic", "underline", "strike"],
			["blockquote", "code-block"],

			[{ header: 1 }, { header: 2 }],
			[{ list: "ordered" }, { list: "bullet" }],
			[{ script: "sub" }, { script: "super" }],
			[{ indent: "-1" }, { indent: "+1" }],
			[{ direction: "rtl" }],

			[{ size: ["small", false, "large", "huge"] }],
			[{ header: [1, 2, 3, 4, 5, 6, false] }],

			[{ color: [] }, { background: [] }],
			[{ font: [] }],
			[{ align: [] }],

			["clean"]
		];

		editor = new Quill(type+className, {
			modules: { toolbar: quillToolbarOptions },
			theme: "snow"
		});
	}
}
