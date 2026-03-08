<?php

	function configuraciones_menuInicio()
	{
		$liVendedor = '';
		if(isset($_SESSION['idVendedorActual']) && $_SESSION['idVendedorActual'] != 0)
			$liVendedor = '<b>Vendedor:</b> '.$_SESSION['nomVendedorActual'];

		$pagina = '<div class="row divHead" id="divHead">
						<div class="col-12">
							<h1 class="text-one">'.$liVendedor.'</h1>
							<nav class="breadcrumb-container d-none d-sm-block d-lg-inline-block" aria-label="breadcrumb">
								<ol class="breadcrumb pt-0">
									<li class="breadcrumb-item">
										<a href="javascript:;" onclick="navegar_modulo(0);">INICIO</a>
									</li>
									<li class="breadcrumb-item active" aria-current="page">'.$_SESSION["moduloPadreActual"].'</li>
								</ol>
							</nav>
							<div class="separator mb-5"></div>
						</div>
					</div>
					<div class="row">
                		<div class="col-12">
                			<div class="row divFormPrint"></div>
							<div class="row divFormCatalogo"></div>
							<div class="row divCatalogo"></div>
						</div>
					</div>';

		return $pagina;
	}