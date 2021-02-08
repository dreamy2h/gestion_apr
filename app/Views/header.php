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
        <link href="<?php echo base_url(); ?>/css/jquerysctipttop.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/Multiple-Select/dist/css/bootstrap-multiselect.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/sweetalert2/sweetalert2.min.css" rel="stylesheet">
        <link href="<?php echo base_url(); ?>/context-menu/context-menu.min.css" rel="stylesheet" type="text/css">
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
                                        <div class="sb-nav-link-icon"><i class="fas fa-male mr-1"></i></div> Socios
                                    </a>
                                    <a class="nav-link" id="menu_arranques">
                                        <div class="sb-nav-link-icon"><i class="fas fa-faucet mr-1"></i></div> Arranques
                                    </a>
                                    <a class="nav-link" id="menu_sectores">
                                        <div class="sb-nav-link-icon"><i class="fas fa-location-arrow mr-1"></i></div> Sectores
                                    </a>
                                    <a class="nav-link" id="menu_subsidios">
                                        <div class="sb-nav-link-icon"><i class="fas fa-hand-holding-usd mr-1"></i></div> Subsidios
                                    </a>
                                    <a class="nav-link" id="menu_convenios">
                                        <div class="sb-nav-link-icon"><i class="fas fa-handshake mr-1"></i></div> Convenios
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
                                        <div class="sb-nav-link-icon"><i class="fas fa-tint mr-1"></i></div> Metros
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
                                    <a class="nav-link" id="menu_socios">
                                        <div class="sb-nav-link-icon"><i class="fas fa-cash-register mr-1"></i></div> Caja
                                    </a>
                                    <a class="nav-link" id="menu_socios">
                                        <div class="sb-nav-link-icon"><i class="fas fa-file-invoice mr-1"></i></div> Historial de Pagos
                                    </a>
                                    <a class="nav-link" id="menu_socios">
                                        <div class="sb-nav-link-icon"><i class="fas fa-receipt mr-1"></i></div> Boleta Electrónica
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
                                        <div class="sb-nav-link-icon"><i class="fas fa-user mr-1"></i></div> Usuarios
                                    </a>
                                    <a class="nav-link" id="menu_apr">
                                        <div class="sb-nav-link-icon"><i class="fas fa-house-user mr-1"></i></div> APR
                                    </a>
                                    <a class="nav-link" id="menu_costo_metros">
                                        <div class="sb-nav-link-icon"><i class="fas fa-dollar-sign mr-1"></i></div> Costo Metros
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