<!DOCTYPE html>
<html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>SIPA - Sistema Integral Proteges Abono</title>
        <link rel="icon" type="image/png" href="<?php echo base_url('assets/images/logo.png'); ?>" />
        <!-- plugins:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/sweetalert2/dist/sweetalert2.css'); ?>">

        <!-- Boostrap -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->

        <!-- plugins:css -->
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/css/vendor.bundle.base.css'); ?>">
        <link rel="stylesheet" href="<?php echo base_url('assets/vendors/css/vendor.bundle.addons.css'); ?>"> 

        <link rel="stylesheet" href="<?php echo base_url() ?>assets/fullcalendar/dist/fullcalendar.min.css" /> 

        <!-- endinject -->
        <!-- plugin css for this page -->
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <!-- Latest compiled and minified CSS -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->


        <link rel="stylesheet" href="<?php echo base_url('assets/css/screen.css'); ?>"> 
        <link rel="stylesheet" href="<?php echo base_url('assets/css/share/style.css'); ?>"> 
        <link rel="stylesheet" href="<?php echo base_url('assets/css/share/styledemo.css'); ?>"> 
        <link rel="stylesheet" href="<?php echo base_url() ?>assets/font-awesome/css/font-awesome.min.css">

        <!--Plugins DataTable-->
        <!--<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">-->
        <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <!-- Estilo personalizado de Tabla -->
        <link rel="stylesheet" href="<?php echo base_url('assets/css/table-style.css'); ?>">
        <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.bootstrap.min.css">-->



        <style type="text/css">
            .modal-mask {
                position: fixed;
                z-index: 9998;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, .5);
                display: table;
                transition: opacity .3s ease;
            }

            .modal-wrapper {
                display: table-cell;
                vertical-align: middle;
            }

            .preloader {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                z-index: 9999;
                background-color: #fff;
            }
            .preloader .loading {
                position: absolute;
                left: 50%;
                top: 50%;
                transform: translate(-50%,-50%);
                font: 14px arial;
            }
        </style>

        <script src="<?php echo base_url() ?>assets/vue/vue/vue.min.js"></script>
        <script src="<?php echo base_url() ?>assets/vue/axios/axios.min.js"></script>  
        <script src="<?php echo base_url() ?>assets/jquery/jquery-3.3.1.min.js"></script>   

        <link href="<?php echo base_url(); ?>/assets/css/select/select2.min.css" rel="stylesheet" />


        <script language="JavaScript" src="https://cdn.datatables.net/1.10.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
        <script language="JavaScript" src="https://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.js" type="text/javascript"></script>


        <link rel="stylesheet" type="text/css" href="http://cdn.datatables.net/plug-ins/3cfcc339e89/integration/bootstrap/3/dataTables.bootstrap.css">
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function () {
                $('#example').DataTable();
            });
        </script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

        <script>
            $(document).ready(function () {
                $(".preloader").fadeOut();
            })
        </script>

    </head>

    <body>
        <div class="preloader">
            <div class="loading">
                <img src="<?php echo base_url('assets/images/preload.gif'); ?>" width="80">
                <p><strong>Cargando SIPA</strong></p>
            </div>
        </div>
        <div class="container-scroller">
            <!-- partial:partials/_navbar.html -->
            <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
                <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
                    <a class="navbar-brand brand-logo" href="javascript:void(0)">
                        <img src="<?php echo base_url('assets/images/logo.png'); ?>" alt="logo" style=" width: auto; height: auto;" />
                    </a>
                    <br/>
                </div>
                <div class="navbar-menu-wrapper d-flex align-items-center">

                    <ul class="navbar-nav navbar-nav-right">

                        <li class="nav-item dropdown d-none d-xl-inline-block">
                            <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                                <span class="profile-text">Hola, <?php echo $this->session->name ?> !</span>
                                <img class="img-xs rounded-circle" src="<?php echo base_url('assets/images/faces/'); ?><?php echo $this->session->imagen ?>" alt="Profile image">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">

                                <a class="dropdown-item"> 
                                </a> 
                                <?php if($this->session->usuario == 'lfong') { ?>
                                <!-- <a href="<?= base_url('/editar/') ?>" class="dropdown-item">Editar polizas</a> -->
                                <?php  }?>
                                <a  href="javascript:void(0);" class="dropdown-item">Administrar</a>
                                <a href="<?= base_url('/login/logout') ?>" class="dropdown-item">
                                    Salir
                                </a>
                            </div>
                        </li>
                    </ul>
                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>
                </div>
            </nav>
            <!-- partial -->
            <div class="container-fluid page-body-wrapper">
                <!-- partial:partials/_sidebar.html -->
                <nav class="sidebar sidebar-offcanvas" id="sidebar">
                    <ul class="nav">
                        <li class="nav-item nav-profile">
                            <div class="nav-link">
                                <div class="user-wrapper">
                                    <div class="profile-image">
                                       <a href="#" data-toggle="modal" data-target="#modalImagen"> <img src="<?php echo base_url('assets/images/faces/'); ?><?php echo $this->session->imagen ?>" alt=".."> <!-- </a> -->
                                    </div>
                                    <div class="text-wrapper">
                                        <p class="profile-name"><?php echo $this->session->usuario ?></p>
                                        <div>
                                            <small class="designation text-muted"><?php echo $this->session->rol ?></small>
                                            <span class="status-indicator online"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/login/') ?>">
                                <i class="menu-icon fa fa-home"></i>
                                <span class="menu-title">Principal</span>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/preregistro/') ?>">
                                <i class="menu-icon fa fa-edit "></i>
                                <span class="menu-title">Pre-Registro</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/cliente/') ?>">
                                <i class="menu-icon fa fa-user-o "></i>
                                <span class="menu-title">Cliente</span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/solicitud/') ?>">
                                <i class="menu-icon fa fa-wpforms"></i>
                                <span class="menu-title">Solicitud</span>
                            </a> 
                        </li>

                          <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('/gmm/') ?>">
                                <i class="menu-icon fa fa-plus-square"></i>
                                <span class="menu-title">Gmm</span>
                            </a>
                        </li>

                     <!--    <li class="nav-item">
                            <a class="nav-link" data-toggle='collapse' href="#latino" aria-expanded="false" aria-controls="ui-basic">
                                <i class="menu-icon fa fa-building-o" ></i>
                                <span class="menu-title">La Latino</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="latino">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                         <a class="nav-link" href="<?= base_url('/latino/') ?>">
                                          <i class="menu-icon fa fa-newspaper-o"></i>
                                        <span>Emitir póliza</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>  -->


                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="ui-basic">
                                <i class="menu-icon fa fa-bars"></i>
                                <span class="menu-title">Opciones</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="auth">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                    <a class="nav-link" href="<?= base_url('/cobranza/') ?>">
                                            <i class="menu-icon fa fa-search"></i>
                                            <span class="menu-title">Cobranza</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= base_url('/recibo/') ?>">
                                            <i class="menu-icon fa fa-check"></i>
                                            <span class="menu-title">Primer cobro</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= base_url('/clabe/') ?>">
                                            <i class="menu-icon fa fa-credit-card"></i>
                                            <span class="menu-title">Clabe</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link"  href="<?= base_url('/periodo/') ?>">
                                            <i class="menu-icon fa fa-plus"></i>
                                            <span class="menu-title">Agregar Periodos</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= base_url('/serie/') ?>">
                                            <i class="menu-icon fa  fa-car"></i>
                                            <span class="menu-title">Num Serie</span>
                                        </a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?= base_url('/document/') ?>">
                                            <i class="menu-icon fa fa-file-text-o"></i>
                                            <span class="menu-title">Documentos</span>
                                        </a>
                                    </li>
                    
				<!-- <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <i class="menu-icon fa fa-bars"></i>
                                            <span class="menu-title">reporte</span>
                                        </a>
                                    </li>-->
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                                <i class="menu-icon fa fa-cogs"></i>
                                <span class="menu-title">Administración</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <i class="menu-icon fa fa-refresh"></i>
                                            <span>Renovación</span>
                                        </a>
                                        <a class="nav-link" href="<?= base_url('/emitirana/') ?>">
                                            <i class="menu-icon fa fa-newspaper-o"></i>
                                            <span>Emitir ANA</span>
                                        </a>
                                        <a class="nav-link" href="<?= base_url('/user/') ?>">
                                            <i class="menu-icon fa fa-users"></i>
                                            <span>Usuarios</span>
                                        </a>
                                    </li> 
                                </ul>
                            </div>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" data-toggle="collapse" href="#ui-basic2" aria-expanded="false" aria-controls="ui-basic">
                                <i class="menu-icon fa fa-bar-chart"></i>
                                <span class="menu-title">Reporte</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse" id="ui-basic2">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#">
                                            <i class="menu-icon fa fa-usd"></i>
                                            <span>Cobranza</span>
                                        </a> 
                                        <!---<a class="nav-link" href="<?= base_url('/reciboprovicional/') ?>">
                                            <i class="menu-icon fa fa-file-text-o"></i>
                                            <span>Recibo</span>
                                        </a> -->
                                    </li> 
                                </ul>
                            </div>
                        </li>
                    </ul>
                </nav>

<!-- <div class="modal fade" id="modalImagen" tabindex="-1" role="dialog"  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" >
       <form method="post" action="#" enctype="multipart/form-data">
    <div class="card">
        <img class="card-img-top" src="<?php echo base_url('assets/images/faces/'); ?><?php echo $this->session->imagen ?>">
        <div class="card-body">
        </div>
    </div>
</form>
    </div>
    <<div class="modal-footer">

        <div class="form-group">
           <input type="file" class="form-control-file" name="image" id="image"> 
           <input type="button" class="btn btn-primary upload" value="Subir">
        </div>
    </div>
  </div>
</div>
      </div> -->