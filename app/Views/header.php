<?php 
    $sesión = session();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Gestión APR</title>
        <link href="<?php echo base_url(); ?>/css/styles.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>/css/estilo_extra.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>/css/buttons.dataTables.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>/css/select.dataTables.min.css" rel="stylesheet" />
        <link href="<?php echo base_url(); ?>/css/jquerysctipttop.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/Multiple-Select/dist/css/bootstrap-multiselect.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/sweetalert2/sweetalert2.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/context-menu/context-menu.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url(); ?>/fileinput-bootstrap/css/fileinput.css" media="all" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" crossorigin="anonymous">
        <link href="<?php echo base_url(); ?>/fileinput-bootstrap/themes/explorer-fas/theme.css" media="all" rel="stylesheet" type="text/css"/>
        <script src="<?php echo base_url(); ?>/js/all.min.js"></script>
    </head>

    <body class="sb-nav-fixed">
        <input type="hidden" id="txt_base_url" name="txt_base_url" value="<?php echo base_url(); ?>">
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <a class="navbar-brand" href="index.html"><?php echo $sesión->apr_ses; ?></a>
            <button class="btn btn-link btn-sm order-1 order-lg-0" id="sidebarToggle" href="#"><i class="fas fa-bars"></i></button>
            
            <!-- Navbar-->
            <ul class="navbar-nav ml-auto mr-0 mr-md-3 my-2 my-md-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userDropdown" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo $sesión->nombres_ses . " " . $sesión->ape_pat_ses . " "; ?><i class="fas fa-user fa-fw"></i></a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#"><?php echo $sesión->apr_ses; ?></a>
                        <a class="dropdown-item" href="#">Actualizar Clave</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url(); ?>/ctrl_login/logout">Cerrar Sesión</a>
                    </div>
                </li>
            </ul>
        </nav>
        <div id="layoutSidenav">
            <div id="layoutSidenav_nav">
                <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                    <div class="sb-sidenav-menu">
                        <div class="nav">
                            <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseFormularios" aria-expanded="false" aria-controls="collapseFormularios">
                                <div class="sb-nav-link-icon"><i class="fas fa-cogs"></i></div>
                                Formularios
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseFormularios" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" id="menu_socios">
                                        <div class="sb-nav-link-icon"><i class="fas fa-male"></i></div> Socios
                                    </a>
                                    <a class="nav-link" id="menu_arranques">
                                        <div class="sb-nav-link-icon"><i class="fas fa-swimming-pool"></i></div> Arranques
                                    </a>
                                    <a class="nav-link" id="menu_sectores">
                                        <div class="sb-nav-link-icon"><i class="fas fa-location-arrow"></i></div> Sectores
                                    </a>
                                    <a class="nav-link" id="menu_subsidios">
                                        <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div> Subsidios
                                    </a>
                                    <a class="nav-link" id="menu_convenios">
                                        <div class="sb-nav-link-icon"><i class="fas fa-handshake"></i></div> Convenios
                                    </a>
                                    <a class="nav-link" id="menu_medidores">
                                        <div class="sb-nav-link-icon"><i class="fas fa-faucet"></i></div> Medidores
                                    </a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseConsumo" aria-expanded="false" aria-controls="collapseConsumo">
                                <div class="sb-nav-link-icon"><i class="fas fa-tint"></i></div>
                                Consumo
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseConsumo" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" id="menu_metros">
                                        <div class="sb-nav-link-icon"><i class="fas fa-tint"></i></div> Metros
                                    </a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapsePagos" aria-expanded="false" aria-controls="collapsePagos">
                                <div class="sb-nav-link-icon"><i class="fas fa-money-bill-alt"></i></div>
                                Pagos
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapsePagos" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" id="menu_caja">
                                        <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div> Caja
                                    </a>
                                    <a class="nav-link" id="menu_hist_pago">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-invoice"></i></div> Historial de Pagos
                                    </a>
                                    <a class="nav-link" id="menu_boleta_electronica">
                                        <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div> Boleta Electrónica
                                    </a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseInformes" aria-expanded="false" aria-controls="collapseInformes">
                                <div class="sb-nav-link-icon"><i class="fas fa-file-pdf"></i></div>
                                Informes
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseInformes" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" id="menu_socios_inf">
                                        <div class="sb-nav-link-icon"><i class="fas fa-male"></i></div> Socios
                                    </a>
                                    <a class="nav-link" id="menu_arranques_inf">
                                        <div class="sb-nav-link-icon"><i class="fas fa-swimming-pool"></i></div> Arranques
                                    </a>
                                    <a class="nav-link" id="menu_pagos_diarios">
                                        <div class="sb-nav-link-icon"><i class="fas fa-money-bill-alt"></i></div> Pagos Diarios
                                    </a>
                                    <a class="nav-link" id="menu_subsidios_inf">
                                        <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd"></i></div> Subsidios
                                    </a>
                                    <a class="nav-link" id="menu_arqueo">
                                        <div class="sb-nav-link-icon"><i class="fas fa-receipt"></i></div> Arqueo
                                    </a>
                                    <a class="nav-link" id="menu_balance">
                                        <div class="sb-nav-link-icon"><i class="fas fa-balance-scale-left"></i></div> Balance
                                    </a>
                                    <a class="nav-link" id="menu_afecto_corte">
                                        <div class="sb-nav-link-icon"><i class="fas fa-cut"></i></div> Afecto a Corte
                                    </a>
                                    <a class="nav-link" id="menu_mensualidad">
                                        <div class="sb-nav-link-icon"><i class="fas fa-clock"></i></div> Mensualidad
                                    </a>
                                </nav>
                            </div>
                            <a class="nav-link collapsed" data-toggle="collapse" data-target="#collapseConfiguracion" aria-expanded="false" aria-controls="collapseConfiguracion">
                                <div class="sb-nav-link-icon"><i class="fas fa-tools"></i></div>
                                Configuración
                                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                            </a>
                            <div class="collapse" id="collapseConfiguracion" aria-labelledby="headingOne" data-parent="#sidenavAccordion">
                                <nav class="sb-sidenav-menu-nested nav">
                                    <a class="nav-link" id="menu_usuarios">
                                        <div class="sb-nav-link-icon"><i class="fas fa-user"></i></div> Usuarios
                                    </a>
                                    <a class="nav-link" id="menu_apr">
                                        <div class="sb-nav-link-icon"><i class="fas fa-house-user"></i></div> APR
                                    </a>
                                    <a class="nav-link" id="menu_costo_metros">
                                        <div class="sb-nav-link-icon"><i class="fas fa-dollar-sign"></i></div> Costo Metros
                                    </a>
                                </nav>
                            </div>
                        </div>
                    </div>
                    <div class="sb-sidenav-footer">
                        <?php echo $sesión->establecimiento_ses; ?>
                    </div>
                </nav>
            </div>