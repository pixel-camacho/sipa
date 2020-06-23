<!-- partial -->
<script type="text/javascript">
    var data_score = '<?php echo $this->session->idusuario; ?>';
</script>
<style type="">
    .modal-body{
        max-height: calc(100vh - 200px);
        overflow-y: auto;

    } 
    /*.select2-container .select2-selection {
          height: 34px; 
             padding-top: -30px;
      }*/

    @media screen and (min-width: 768px) {
        .modal-dialog {
            width: 700px; /* New width for default modal */
        }
        .modal-sm {
            width: 350px; /* New width for small modal */
        }
    }
    @media screen and (min-width: 992px) {
        .modal-lg {
            width: 950px; /* New width for large modal */
        }
    }
    .select2 {
        width:100%!important;
    }
    .text-pequeno{
        font-size: 14px;
    }

</style>
<div class="main-panel">
    <style type="">

    </style>
    <div class="content-wrapper">
        <div id="app"> 
            <div class="row">
                <div class="col-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h3><strong><i class="fa  fa-edit" aria-hidden="true"></i> Pre-registro</strong></h3>
                            <hr>

                            <div class="modal fade bd-example-modal-lg" role="dialog" id="myModal" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Buscar Cliente</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="background-color: #fff">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <label>RFC</label>
                                                    <input placeholder="RFC" type="text" id="search" class="form-control"  name="search"  ref="rfc">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Apellido Paterno</label>
                                                    <input placeholder="Apellido Paterno" type="text" id="search" class="form-control"  name="search"  ref="nombre">
                                                </div>
                                                <div class="col-sm-3">
                                                    <label>Apellido Materno</label>
                                                    <input placeholder="Apellido Materno" type="text" id="search" class="form-control"  name="search"  ref="apellidop">
                                                </div>
                                                <div class="col-sm-2">
                                                    <label>Nombre</label>
                                                    <input placeholder="Nombre" type="text" id="certificado" class="form-control"  name="certificado"  ref="apellidom">
                                                </div>
                                                <div class="col-sm-2" align="left" style="padding-top: 35px;" >
                                                    <button type="button"  @click.prevent="searchSolicitud()" class="btn btn-primary btn-fw"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>


                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table  v-if="solicitudes.length" class="table-responsive table-striped  table-hover">
                                                        <thead  >
                                                            <tr>
                                                                <th class="th-sm"></th> 
                                                                <th class="th-sm">RFC</th> 
                                                                <th class="th-sm">Nombre</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="solicitud in solicitudes" class="table-default"  > 
                                                                <td align="right">
                                                                    <button type="button" class="btn btn-icons btn-rounded btn-success"  @click="hideModal(); selectCliente(solicitud)"  title="Seleccionar">
                                                                        <i class="fa   fa-check-circle"></i>
                                                                    </button>
                                                                </td>
                                                                <td style="padding-left: 20px;" > 
                                                                    {{solicitud.rfc}}
                                                                </td> 
                                                                <td   style="padding-left: 20px;" >

                                                                    {{solicitud.nombreresponsable}}<br>
                                                                    <strong>Beneficiarios:</strong> {{solicitud.nombreresponsable}}<br>
                                                                    <strong>Asegurados:</strong> {{solicitud.asegurados}}<br>

                                                                    <strong>Pólizas:</strong> {{solicitud.polizas}}


                                                                </td>

                                                            </tr> 
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td colspan="3"  >
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
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                                        </div>
                                    </div>
                                </div>
                            </div> 


                            <div class="modal fade bd-example-modal-lgvendedor" role="dialog" id="myModalVendedor" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Vendedores</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="background-color: #fff">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-hover table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col"></th>
                                                                <th scope="col"><strong>Nombre</strong></th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="row in vendedores">
                                                                <th scope="row">
                                                                    <button type="button" class="btn btn-icons btn-rounded btn-success"  @click="hideModalVendedor(); selectVendedor(row)"  title="Seleccionar">
                                                                        <i class="fa   fa-check-circle"></i>
                                                                    </button>
                                                                </th>
                                                                <td>{{row.nombre}} {{row.apPaterno}} {{row.apMaterno}}</td> 
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                                        </div>
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="modal fade bd-example-modal-lgasesor" role="dialog" id="myModalAsesor" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel"><strong>Asesores</strong></h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body" style="background-color: #fff">

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <span align="center" v-if="!asesores.length"><font color="red">* Primero seleccione el producto.</font></span>
                                                    <table v-else class="table table-hover">
                                                        <thead>
                                                            <tr>
                                                                <th scope="col"></th>
                                                                <th scope="col"><strong>Nombre</strong></th> 
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="row in asesores">
                                                                <th scope="row">
                                                                    <button type="button" class="btn btn-icons btn-rounded btn-success"  @click="hideModalAsesor(); selectAsesor(row)"  title="Seleccionar">
                                                                        <i class="fa   fa-check-circle"></i>
                                                                    </button>
                                                                </th>
                                                                <td>{{row.nombre}} {{row.apPaterno}} {{row.apMaterno}}</td> 
                                                            </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                                        </div>
                                    </div>
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-md-4"></div>
                                <div class="col-md-4">
                                    <div  class="form-inline">
                                        <div class="form-group">
                                            <label><font color="red">*</font> Tramite:&nbsp;&nbsp;</label> 
                                            <select v-model="nuevoRegistro.idtipotramite" class="form-control" :class="{'is-invalid': formValidate.idtipotramite}" >
                                                    <option value="">Seleccionar...</option>
                                                <option   v-for="option in tipotramites" v-bind:value="option.tipoTramiteId">
                                                    {{ option.tipoTramiteDescr }}
                                                </option>

                                            </select>
                                                 <div class="text-danger" v-html="formValidate.idtipotramite"> </div>
                                                    
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4"></div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-4" >
                                    <div class="form-inline">
                                        <label class="text-pequeno"><font color="red">*&nbsp;</font> RFC:&nbsp;&nbsp;</label> 
                                        <input type="text" size="2" class="form-control col-md-8" v-bind:value="rfccliente" />&nbsp;&nbsp;  <button type="button"  data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-icons btn-rounded btn-primary">
                                            <i class="fa  fa-search"></i>
                                        </button>
                                    </div>
                                    <div class="text-danger" v-html="formValidate.idcliente"></div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <label class="text-pequeno"><font color="red">*&nbsp;</font> Asegurado:&nbsp;&nbsp;</label> 
                                        <input type="checkbox" size="2" v-model="nuevoRegistro.asegurado" class="col-md-2" value="si" />  
                                    </div>
                                </div>
                                <div class="col-md-4"> 
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-pequeno" >Asegurado: <strong>{{v.chooseCliente.nombrecliente}}</strong></label> 
                                </div>
                                <div class="col-md-4">
                                    <label class="text-pequeno" >Apellido Paterno: <strong>{{v.chooseCliente.apellidopaterno}}</strong></label> 
                                </div>
                                <div class="col-md-4">
                                    <label class="text-pequeno" >Apellido Materno: <strong>{{v.chooseCliente.apellidomaterno}}</strong></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-pequeno" >Dirección: <strong>{{v.chooseCliente.direccion}}</strong></label> 
                                </div>
                                <div class="col-md-4">
                                    <label class="text-pequeno">Colonia: <strong>{{v.chooseCliente.coloniaDescr}}</strong></label> 
                                </div>
                                <div class="col-md-4">
                                    <label class="text-pequeno">Correo electrónico: <strong>{{v.chooseCliente.email}}</strong></label> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="text-pequeno">Teléfono: <strong>---</strong></label> 
                                </div>
                                <div class="col-md-4">
                                    <label class="text-pequeno">Sexo: 

                                        <strong v-if="v.chooseCliente.sexo==1">Hombre</strong>
                                        <strong  v-else-if="v.chooseCliente.sexo==2">Hombre</strong>
                                        <strong v-else></strong> </label> 
                                </div>
                                <div class="col-md-4">
                                    <label class="text-pequeno">Centro de Trabajo: <strong>{{v.chooseCliente.nombrecentrotrabajo}}</strong></label> 
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-md-3" style="border:solid 1px #ccc">
                                    <label><strong>Selección Producto</strong></label>

                                    <div v-for="row in productos" v-on:change="changeTipoProducto($event)">
                                        <input type="radio" v-model="nuevoRegistro.tipoproducto"   :value="row.productoId"> {{row.productoDescr}}
                                    </div> 
                                    <div class="text-danger" v-html="formValidate.tipoproducto"></div>
                                </div>
                                <div class="col-md-6" style="border:solid 1px #ccc">
                                    <label><strong>Compromisos</strong></label>
                                </div>
                                <div class="col-md-3" style="border:solid 1px #ccc">
                                    <label><strong>Saldo Vencido</strong></label>
                                </div>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col-md-12">
                                    <label><strong> Selección de Asesor y Medio de Afluencia</strong></label>
                                </div>
                            </div>
                            <div class="row"> 


                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><font color="red">*</font> Asesor Asignado: <a href="#" data-toggle="modal" data-target=".bd-example-modal-lgasesor"  >

                                                <span v-if="typeof chooseAsesor.nombre !== 'undefined'">{{chooseAsesor.nombre}} {{chooseAsesor.apPaterno}} {{chooseAsesor.apMaterno}}</span>
                                                <span v-else>Seleccionar</span> 
                                              

                                            </a></label>
                                        <div class="text-danger" v-html="formValidate.idasesor"></div>
                                    </div>
                                    <div class="form-group">
                                        <label><font color="red">*</font> Vendedor: <a href="#" data-toggle="modal" data-target=".bd-example-modal-lgvendedor"  >

                                                <span v-if="typeof chooseVendedor.nombre !== 'undefined'">{{chooseVendedor.nombre}} {{chooseVendedor.apPaterno}} {{chooseVendedor.apMaterno}}</span>
                                                <span v-else>Seleccionar</span> 
                                              

                                            </a></label>
                                        <div class="text-danger" v-html="formValidate.idvendedor"></div>

                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><font color="red">*</font> ¿Cómo se enteró?:</label>
                                        <select v-model="nuevoRegistro.idmedioconocimiento"   :class="{'is-invalid': formValidate.idmedioconocimiento}"class="form-control">
                                                <option value="">Seleccionar...</option>
                                                 <option   v-for="option in mediosconocimientos" v-bind:value="option.medioConocimientoId">
                                                {{ option.medioConocimientoDescr }}
                                            </option> 
                                            
                                        </select>
                                        <div class="text-danger" v-html="formValidate.idmedioconocimiento"></div>
                                    </div>
                                     <div class="form-group">
                                         <label><font color="red">*</font> Fecha solicitud:</label>
                                           <input type="date" class="form-control"  :class="{'is-invalid': formValidate.fechasolicitud}" v-model="nuevoRegistro.fechasolicitud" autcomplete="off" >
                                           <div class="text-danger" v-html="formValidate.fechasolicitud"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Observaciones</label>
                                        <textarea v-model="nuevoRegistro.observacion" placeholder="add multiple lines" class="form-control"></textarea>
                                    </div>
                                    <div class="form-group" align="right">
                                        <button type="button" class="btn btn-success btn-fw" @click="addSolicitud" > <i class="fa   fa-check"></i> Aceptar</button>
                                        <button type="button" class="btn btn-danger btn-fw"> <i class="fa    fa-warning"></i> Cancelar</button>
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

    <script  data-my_var_1="<?php echo $this->session->idusuario; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/preregistro/preregistro.js"></script> 
