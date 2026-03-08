$(document).ready(function()
{
    var catTable, catSubTable, catSubRepTable, currentOrder, currentSubOrder, currentSubRepOrder = '';
    var x = [];
    var editor = "";
    modulo = parseInt(sessionStorage.getItem("modulo"));
    switch(modulo)
    {
        case 11610:
            busqueda_Catalogo("divNavCatPor", ".");
        break;
        default:
            cargaCatalogo('divCatalogo', modulo, 0);
        break;
    }
});

function cargaCatalogo(divCarga, catTipo, idElem)
{
    var continueForm = true;
    var formData = {};
    formData["divCarga"] = divCarga;
    formData["catTipo"] = catTipo;
    formData["idElem"] = idElem;
    
    var fechaReporte = $('#fechaReporte').val();
    formData["fechaReporte"] = fechaReporte;

    switch(catTipo)
    {
        case 11601:
        break;
    }

    if(continueForm)
    {
        $("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
        $.post("../seccion/ajax/catalogos/catalogs.php", formData,
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
            resetSelectGral("selectSerch");

            switch(catTipo)
            {
                case 11601:
                    catTable = resetNewDataTable2("tableOrder", 0, 0, "desc", "btnShowModal", "", "divCatalogo");
                break;
            }

            scrollTopSite("");
        });
    }
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
        case 11601:
            switch(form)
            {
                case 'catalogo':
                    $('.divFormCatalogo').html("");
                    $(".tabPortal").html("");
                break;
            }
        break;
    }

    $("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
    $.post("../seccion/ajax/catalogos/formCatalogs.php", formData,
    function (valData)
    {
        if (valData.valCatalogo == "false")
            alert(valData.alert);
        else
        {
            $("."+divCarga).html(valData.formulario);
            switch(catTipo)
            {
                case 11601:
                    switch(form)
                    {
                        case 'catalogo':
                            scrollTop = true;
                            cargaCatalogo('divCatalogo', catTipo, idElem);
                        break;
                        case 'new':
                        case 'edit':
                            showFileTxt("archivo", "#");
                            quillEditor("descripcion", "#");
                        break;
                    }
                break;
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
        case 11601:
            switch(action)
            {
                case 'close':
                    scrollTop = true;
                    $("." + divCarga).html("");
                break;
                case 'new':
                case 'edit':
                    var validaFile = true;
                    switch(action)
                    {
                        case 'edit':
                            validaFile = false;
                        break;
                    }

                    var archivo = $('#archivo').val();
                    if(archivo != "")
                    {
                        var validImage = ['pdf'];
                        var extension = $("#archivo").prop('files')[0].type.split('/')[1];
                        if(validImage.indexOf(extension) == -1)
                        {
                            showAlert(2, "Adjunte una archivo válido [pdf]", "divHead", "#");
                            return false;
                        }
                        else
                            var archivo = $('#archivo').prop('files')[0];
                    }
                    /*else if(validaFile == true)
                    {
                        showAlert(2, "Seleccione el archivo", "divHead", "#");
                        return false;
                    }*/

                    var form_data = new FormData();
                    form_data.append('idElem', idElem);
                    form_data.append('divCarga', divCarga);
                    form_data.append('catTipo', catTipo);
                    form_data.append('action', action);
                    form_data.append('archivo', archivo);

                    var titulo = $("#titulo").val();
                    if(titulo == "")
                    {
                        showAlert(2, "Capture el título", "titulo", "#");
                        return false;
                    }
                    form_data.append('titulo', titulo);

                    var folio = $("#folio").val();
                    if(folio == "")
                    {
                        showAlert(2, "Capture el folio", "folio", "#");
                        return false;
                    }
                    form_data.append('folio', folio);

                    if($("#descripcion div.ql-editor").hasClass("ql-blank"))
                    {
                        showAlert(2, "Capture la descripción", "descripcion", "#");
                        return false;
                    }
                    else
                    {
                        var descripcion = $("#descripcion div.ql-editor").html();
                        if(descripcion == "" || descripcion == "<p><br></p>")
                        {
                            showAlert(2, "Capture la descripción", "descripcion", "#");
                            return false;
                        }
                    }
                    form_data.append('descripcion', descripcion);

                    showLoading();
                    $.ajax
                    ({
                        url: '../seccion/ajax/catalogos/actions.php',
                        type: 'POST',
                        cache: false,
                        contentType: false,
                        processData: false,
                        data: form_data,
                        dataType: "json",
                        success: function (valData)
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
                                $("."+divCarga).html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
                                $("."+divCarga).html(valData.txtReturn);
                                showAlert(1, valData.alert, "divHead", "#");

                                switch(catTipo)
                                {
                                    case 11601:
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
                            }
                        }
                    });
                break;
                case 'delete':
                    if(confirm('Desea eliminar el documento'))
                        continuePost = true;
                break;
            }
        break;
    }

    if(continuePost)
    {
        disableButtonSys();
        $.post("../seccion/ajax/catalogos/actions.php", formData,
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
                    case 11601:
                        switch(action)
                        {
                            case 'delete':
                                currentOrder = deleteRowTable(catTable, valData.idReturn);
                                catTable = resetNewDataTable2("tableOrder", 0, currentOrder[0][0], currentOrder[0][1], "btnShowModal", "", "divCatalogo");
                                checkValSearch(catTable, "");
                            break;
                            case 'validation':
                                cargaCatalogo('divCatalogo', catTipo, idElem);
                                /*if(valData.newRow != "")
                                {
                                    currentOrder = editRowTable(valData.idReturn, catTable, valData.newRow);
                                    catTable = resetNewDataTable2("tableOrder", 0, currentOrder[0][0], currentOrder[0][1], "btnShowModal", "", "divCatalogo");
                                    checkValSearch(catTable, "");
                                }*/
                            break;
                        }

                        reloadPost = false;
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

	switch(catTipo)
	{
	}

	$("#sidebar_right_content").html('<div style="height:100px !important; width:100px !important;" id="cargando"></div>');
	$.post("../seccion/page-right/page_catalogos.php", formData,
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
    var scrollTop = false;
    var continuePost = false;
    var clearToggle = false;
    var formData = {};
    formData["divCarga"] = divCarga;
    formData["catTipo"] = catTipo;
    formData["idElem"] = idElem;
    formData["action"] = action;

	switch(catTipo)
	{
	}

	if(continuePost)
	{
        disableButtonSys();
        $.post("../seccion/page-right/actionCatalogos.php", formData,
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
                }

                if(clearToggle)
                {
                    sidebarRightHide();
                    showAlert(1, valData.alert, "divHead", "#");
                }

                if(scrollTop)
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
		$.post("../seccion/ajax/catalogos/actions.php", formData,
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