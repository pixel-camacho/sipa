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
                            <h3><strong><i class="fa  fa-edit" aria-hidden="true"></i> Generar recibo de cobro</strong></h3>
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

                            <select style="display:none"  v-model="nuevoRegistro.idtipotramite" class="form-control" > 
                                <option   v-for="option in tipotramites" v-bind:value="option.tipoTramiteId"> 
                                </option>

                            </select> 

                            <hr>
                            <div class="row">
                                <div class="col-md-4" >
                                    <div class="form-inline">
                                        <label class="text-pequeno"><font color="red">*&nbsp;</font> RFC:&nbsp;&nbsp;</label> 
                                        <input type="text" size="2" class="form-control col-md-8" style="height: 8px;"  v-bind:value="rfccliente" />&nbsp;&nbsp;  <button type="button"  data-toggle="modal" data-target=".bd-example-modal-lg" class="btn btn-icons btn-rounded btn-primary">
                                            <i class="fa  fa-search"></i>
                                        </button>
                                    </div>
                                    <div class="text-danger" v-html="formValidate.idcliente"></div>
                                </div> 
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="row"> 
                                        <div class="col-sm-12"> 
                                            <div class="form-group" style="padding-top: 10px">
                                                
                                                <label class="text-pequeno" >Responsable: <strong>{{v.chooseCliente.nombrecliente}} {{v.chooseCliente.apellidopaterno}} {{v.chooseCliente.apellidomaterno}}</strong></label> <br/>
                                                <label class="text-pequeno" >Dirección: <strong>{{v.chooseCliente.direccion}} {{v.chooseCliente.coloniaDescr}}</strong></label> <br/>
                                                <label class="text-pequeno">Centro de Trabajo: <strong>{{v.chooseCliente.nombrecentrotrabajo}}</strong></label> <br/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row"> 
                                        <div class="col-sm-6"> 
                                            <div class="form-group">
                                                 <select class="form-control" v-model="nuevoRegistro.formapago" :class="{'is-invalid': formValidate.formapago}">
                                                    <option value="" selected="">Forma pago</option>
                                                    <option   v-for="option in formaspago" v-bind:value="option.tipoPagoEdoCuentaId"> 
                                                        {{option.tipoPagoDesc}}
                                                    </option>
                                                </select> 
                                                <div class="text-danger" v-html="formValidate.formapago"> </div>
                                             </div> 
                                        </div>
                                        <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <input  type="text" placeholder="No. Autorización" v-model="nuevoRegistro.autorizacion"  style="height: 10px;" class="form-control"  >
                                        <div class="text-danger" v-html="formValidate.autorizacion"> </div>
                                        </div> 
                                        </div>
                                    </div>
                                        <div class="row"> 
                                        <div class="col-sm-6"> 
                                            <div class="form-group">
                                                 <select class="form-control" v-model="nuevoRegistro.banco" :class="{'is-invalid': formValidate.banco}">
                                                    <option value="" selected="">Banco</option>
                                                    <option   v-for="option in bancos" v-bind:value="option.bancoId"> 
                                                        {{option.bancoDescr}}
                                                    </option>
                                                </select> 
                                                <div class="text-danger" v-html="formValidate.banco"> </div>
                                             </div> 
                                        </div>
                                        <div class="col-sm-6"> 
                                        <div class="form-group">
                                            <input  type="file"  id="file" ref="file" v-model="nuevoRegistro.file" v-on:change="handleFileUpload()" class="form-control-file"  >
                                         <div class="text-danger" v-html="formValidate.file"> </div>
                                          <div class="text-danger" v-html="formValidate.mensaje"> </div>
                                        </div> 
                                        </div>
                                    </div>
                                </div> 
                                <div class="col-md-6"> 
                                    <div class="row">
                                        <div class="col-sm-6"> 
                                            <div class="form-group">
                                                <input placeholder="Poliza" type="text" v-model="nuevoRegistro.poliza" :class="{'is-invalid': formValidate.poliza}" style="height: 10px;" class="form-control"  >
                                             <div class="text-danger" v-html="formValidate.poliza"> </div>
                                            </div> 
                                        </div>
                                        <div class="col-sm-6"> 
                                             <div class="form-group">
                                            <input  type="text" placeholder="Cantidad" v-model="nuevoRegistro.cantidad" :class="{'is-invalid': formValidate.cantidad}"  style="height: 10px;" class="form-control"  >
                                        <div class="text-danger" v-html="formValidate.cantidad"> </div>
                                             </div> 
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6"> 
                                             <div class="form-group">
                                            <input   type="date"  style="height: 10px;" v-model="nuevoRegistro.fechainicio"  :class="{'is-invalid': formValidate.fechainicio}" class="form-control"   > 
                                        <div class="text-danger" v-html="formValidate.fechainicio"> </div>
                                             </div> 
                                        </div>
                                        <div class="col-sm-6"> 
                                             <div class="form-group">
                                            <input   type="text"  style="height: 10px;" v-model="nuevoRegistro.periodo"  :class="{'is-invalid': formValidate.periodo}" class="form-control"  placeholder="Periodo de cobro" > 
                                        <div class="text-danger" v-html="formValidate.periodo"> </div>
                                             </div> 
                                        </div>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-sm-6"> 
                                            <div class="form-group">
                                                <select class="form-control" v-model="nuevoRegistro.producto"  :class="{'is-invalid': formValidate.producto}" >
                                                    <option value="" selected="">Producto</option>
                                                    <option   v-for="option in productos" v-bind:value="option.productoId"> 
                                                        {{option.productoDescr}}
                                                    </option>
                                                </select> 
                                                <div class="text-danger" v-html="formValidate.producto"> </div>
                                            </div> 
                                        </div>
                                        <div class="col-sm-6"> 
                                            <div class="form-group">
                                                <select class="form-control" v-model="nuevoRegistro.compania" :class="{'is-invalid': formValidate.compania}" >
                                                    <option value="" selected="">Compania</option>
                                                    <option   v-for="option in companias" v-bind:value="option.companiaId"> 
                                                        {{option.companiaDescr}}
                                                    </option>
                                                </select> 
                                                <div class="text-danger" v-html="formValidate.compania"> </div>
                                            </div> 
                                        </div>
                                    </div>
                                    
                                </div>
                            </div> 
                            <hr/> 
                           
                            <div class="row"> 
                                <div class="col-md-12">
                                    <div class="form-group" align="right">
                                        <button type="button" class="btn btn-success btn-fw" @click="addSolicitud" > <i class="fa   fa-check"></i> Aceptar</button>
                                        <button type="button" class="btn btn-danger btn-fw"  @click="clearAll" > <i class="fa    fa-warning"></i> Cancelar</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">Póliza</th>
                                                <th scope="col">Cobrado</th>
                                                <th scope="col">Periodo</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Compañia</th>
                                                <th scope="col">Fecha</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="recibo in recibos">
                                                <td >
                                                    <label  v-if="recibo.subido === 1"  class="text-success"><strong> {{recibo.poliza}}</strong></label>
                                                    <label  v-else class="text-danger"><strong> {{recibo.poliza}}</strong></label>
                                                   </td>
                                                <td>$ {{recibo.cantidad}}</td>
                                                <td>{{recibo.periodocobro}}</td>
                                                <td>
                                                    <label v-if="recibo.idproducto === '3'">HOGAR</label>
                                                    <label  v-else-if="recibo.idproducto === '5'">VIDA</label>
                                                    <label  v-else-if="recibo.idproducto === '6'">GMM</label>
                                                    <label  v-else-if="recibo.idproducto === '7'">AUTO</label>
                                                    <label  v-else>NO DEFINIDO</label> 
                                                </td> 
                                                <td>
                                                    <label v-if="recibo.idcompania === '10'">LATINO SEGUROS S.A.</label>
                                                    <label  v-else-if="recibo.idcompania === '11'">HDI SEGUROS</label>
                                                    <label  v-else-if="recibo.idcompania === '30'">QUALITAS AUTOS MX</label>
                                                    <label  v-else-if="recibo.idcompania === '31'">GENERAL DE SEGUROS</label>
                                                    <label  v-else-if="recibo.idcompania === '35'">ABA SEGUROS</label>
                                                    <label  v-else-if="recibo.idcompania === '39'">GRUPO N PROVINCIAL, S.A.B.</label>
                                                    <label  v-else-if="recibo.idcompania === '43'">NATIONAL UNITY INSURANCE COMPANY</label>
                                                    <label  v-else-if="recibo.idcompania === '44'">CRUCE SEGURO</label>
                                                    <label  v-else-if="recibo.idcompania === '62'">ANA SEGUROS SA DE CV</label>
                                                    <label  v-else-if="recibo.idcompania === '63'">METROPOLITANA</label>
                                                    <label  v-else-if="recibo.idcompania === '64'">THONA SEGUROS</label>
                                                    <label  v-else-if="recibo.idcompania === '66'">ATLAS SEGUROS</label>
                                                    <label  v-else-if="recibo.idcompania === '67'">SISNOVA</label>
                                                    <label  v-else>NO DEFINIDO</label> 
                                                </td>
                                                <td>{{recibo.fechare}}</td>
                                                <td align="right">
                                                    <a class="btn btn-primary btn-sm" :href="'/sipa/reciboprovicional/upload/' + recibo.idrecibo"><i class="fa fa-upload" aria-hidden="true"></i></a>
                                                    <a class="btn btn-info btn-sm" target="_blank" :href="'/sipa/reciboprovicional/imprimir/' + recibo.idrecibo"><i class="fa fa-print" aria-hidden="true"></i></a>
                                                 </td>
                                            </tr>
                                           
                                        </tbody>
                                    </table>
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


    <script  data-my_var_1="<?php echo $this->session->idusuario; ?>" src="<?php echo base_url(); ?>/assets/vue/appvue/reporte/recibo/apprecibo.js"></script> 
