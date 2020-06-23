<!-- partial -->
<script type="text/javascript">
    var data_score = '<?php echo $this->session->idusuario; ?>';
</script>
<script type="text/javascript">
    var idsolicitud = '<?php echo $idsolicitud; ?>';

</script>
<div class="main-panel">
    <style type="">

    </style>
    <div class="content-wrapper">
        <div id="app"> 
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            
                            <h4><strong><i class="fa  fa-calendar" aria-hidden="true"></i> Renovar</strong></h4>
                            <hr>
                            <div id="app">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label  class="card-title text-dark"><strong>Cliente:</strong> {{chooseClienteSolicitud.nombrecliente}} </label>
                                    </div>
                                    <div class="col-md-3">
                                        <label  class="card-title text-dark"><strong>RFC: </strong>{{chooseClienteSolicitud.rfc}}</label>
                                    </div>
                                    <div class="col-md-3">
                                         <label  class="card-title text-dark"><strong>Telefono: </strong> ---</label>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class=" col-md-3">
                                         <label  class="card-title text-dark"><strong>No. Póliza: </strong> {{chooseClienteSolicitud.noPoliza}}</label>
                                    </div>
                                     <div class=" col-md-3">
                                         <label  class="card-title text-dark"><strong>Producto: </strong> {{chooseClienteSolicitud.producto}}</label>
                                    </div>
                                     <div class=" col-md-3">
                                         <label  class="card-title text-dark"><strong>Descuento: </strong> $ {{chooseClienteSolicitud.descuento}}</label>
                                    </div>
                                     <div class=" col-md-3">
                                         <label  class="card-title text-dark"><strong>Vencimiento: </strong>{{chooseClienteSolicitud.fechafin}}</label>
                                    </div>
                                </div>
                                 <div class="row">
                                    <div class=" col-md-3">
                                         <label  class="card-title text-dark"><strong>Tipo Tarjeta: </strong> {{chooseClienteSolicitud.tipotarjeta}}</label>
                                    </div>
                                     <div class=" col-md-3">
                                         <label  class="card-title text-dark"><strong>Banco: </strong> {{chooseClienteSolicitud.banco}}</label>
                                    </div>
                                     <div class=" col-md-3">
                                         <label  class="card-title text-dark"><strong>Tarjeta: </strong> {{chooseClienteSolicitud.tarjeta}}</label>
                                    </div>
                                     <div class=" col-md-3">
                                         <label  class="card-title text-dark"><strong>Titular: </strong>{{chooseClienteSolicitud.nombretitular}}</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 


        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
            <div class="container-fluid clearfix">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?php echo date('Y') ?>
                    <a href="http://www.proteges.mx" target="_blank">Proteges</a>. Todos los derechos reservados.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Departamento de Sistemas
                    <i class="fa fa-code text-danger"></i>
                </span>
            </div>
        </footer>
        <!-- partial -->
    </div>  
</div>
<link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script> 

<script src="https://unpkg.com/vue-select@latest"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@latest/dist/vue-select.css">

<!-- or point to a specific vue-select release -->
<script src="https://unpkg.com/vue-select@3.0.0"></script>
<link rel="stylesheet" href="https://unpkg.com/vue-select@3.0.0/dist/vue-select.css">
<script  data-my_var_1="<?php echo $this->session->idusuario; ?>" data-my_var_2="<?php echo $idsolicitud; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/administracion/renovar/detalle.js"></script> 



