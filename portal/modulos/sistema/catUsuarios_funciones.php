<?php

	function catUsuarios_menuInicio()
	{
		$liUsuarios = $divUsuarios = '';
		$valSelected = false;

		switch($_SESSION["mod"])
		{
			case "11706":
				switch($_SESSION["mod"])
				{
					case "11706":
						$ini = 11701;
						$fin = 11702;
					break;
				}

				for($i = $ini; $i <= $fin; $i++)
				{
					liberar_bd();
					$selectPermisosModulos = 'CALL sp_sistema_select_permiso_modulo('.$_SESSION['idPerfil'].', '.$i.');';
					$permisosModulos = consulta($selectPermisosModulos);
					$ctaPerMod = cuenta_registros($permisosModulos);
					if($ctaPerMod != 0)
					{
						$perMod = siguiente_registro($permisosModulos);

						if($valSelected == true)
						{
							$classLink = ' ';
							$divClass = ' ';
						}
						else
						{
							$classLink = ' active ';
							$divClass = ' show active ';
						}

						switch($i)
						{
							case 11702:
								$divCarga = 'divUsers';
								$valSelected = true;
							break;
							case 11701:
								$divCarga = 'divPerf';
								$valSelected = true;
							break;
						}

						$liUsuarios.= ' <li class="nav-item">
											<a onclick="formCatalogo(\''.$divCarga.'\', '.$i.', \'catalogo\', 0)" class="nav-link '.$classLink.'" id="'.$divCarga.'-tab" data-toggle="tab" href="#'.$divCarga.'" role="tab" aria-controls="'.$divCarga.'" aria-selected="true">'.utf8_convert($perMod["nomMod"]).'</a>
										</li>';

						$divUsuarios.= '<div class="tab-pane '.$divCarga.$divClass.' tabUsuario" id="'.$divCarga.'" role="tabpanel" aria-labelledby="'.$divCarga.'-tab"></div>';
					}
				}
			break;
		}

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
						<div class="col-12 mb-4">
							<div class="card">
								<div class="card-body">
									<div class="row mb-2">
										<div class="col-12">
											<h5 class="mb-2 font-weight-bold">Cat&aacute;logos</h5>
										</div>
									</div>
									<div class="row mb-2">
										<div class="col-12">
											<div class="mb-2">
												<ul class="nav nav-tabs divNavCatUser separator-tabs ml-0 mb-5" role="tablist">
													'.$liUsuarios.'
												</ul>
												<div class="tab-content">
													'.$divUsuarios.'
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>';

		return $pagina;
	}