<!-- partial -->
<script type="text/javascript">
    var data_score = '<?php echo $this->session->idusuario; ?>';
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
                            
                            <h3><strong><i class="fa fa-refresh" aria-hidden="true"></i> Renovación individual</strong></h3>
                            <hr>
                            <div id="app">
                                <div class="row">
                                <div class="col-md-12">
                                    <input placeholder="Buscar" type="search" class="form-control" v-model="search.text" @keyup="searchSolicitud" name="search">
                                </div>
                            </div>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th scope="col">No Poliza</th>
                                                <th scope="col">Contratante</th>
                                                <th scope="col">Clave</th>
                                                <th scope="col">Cliente</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Compañia</th>
                                                <th scope="col">F. Vencimiento</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="option in solicitudes">
                                                <th scope="row">
                                                 <a :href="'/sipa/renovar/detalle/' + option.solicitudId">{{option.noPoliza}}</a>
                                                </th>
                                                <td>{{option.contratante}}</td>
                                                <td>{{option.clave}}</td>
                                                <td>{{option.nombre}}</td>
                                                <td>{{option.producto}}</td>
                                                <td>{{option.compania}}</td>
                                                <td>{{option.fechafin}}</td>
                                            </tr>
                                             <tr v-if="emptyResult">
                                       <td colspan="7"class="text-center h5">No Record Found</td>
                                    </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="7"  >
                                        <pagination
                                            :current_page="currentPage"
                                            :row_count_page="rowCountPage"
                                            @page-update="pageUpdate"
                                            :total_users="totalSolicitudes"
                                            :page_range="pageRange"
                                            >
                                        </pagination>

                                        </td>
                                        </tr>
                                        </tfoot>
                                    </table>
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
<script  data-my_var_1="<?php echo $this->session->idusuario; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/administracion/renovar/renovar.js"></script> 



