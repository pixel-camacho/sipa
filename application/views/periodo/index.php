<!-- partial -->
<script type="text/javascript">
   var data_score = '<?php echo $this->session->idusuario;?>';
</script>
<div class="main-panel">
<div class="content-wrapper">
   <div id="app">
      <div class="row">
         <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
               <div class="card-body">
                  <h3><strong>Periodos</strong></h3>
                  <p class="card-description">
                     Administracion de periodos.
                  </p>
                  <div class="row">
                      <div class="col-md-10">
                        <div class="form-group row"> 
                          <div class="col-sm-4">
                            <label>Poliza</label>
                            <input placeholder="Poliza" type="search" id="search" class="form-control"  name="search"  ref="search">
                          </div>
                          <div class="col-sm-4">
                            <label>Certificado</label>
                            <input placeholder="Certificado" type="search" id="certificado" class="form-control"  name="certificado"  ref="certificado">
                          </div>
                          <div class="col-sm-4" align="left">
                               <button type="button"  @click.prevent="searchSolicitud()" class="btn btn-primary btn-fw">Buscar</button>
                          </div>
                         
                        </div>
                      </div>
                      <div class="col-md-2"> 
                         <div v-if="loading" class="circle-loader"></div> 
                    </div>
               </div>
                  <div class="col-md-12">
                     <div v-if="mostrar">
                        <p class="card-description">
                           Polizas:    <i class="fa  fa-thumbs-down text-danger"></i>  Inactiva || <i class="fa  fa-thumbs-up text-success"></i>  Activa 
                        </p>
                        <table class="table table-hover">
                           <thead>
                              <tr>
                                 <th>Poliza</th>
                                 <th>Producto</th>
                                 <th>Asegurado</th>
                                 <th>Contratante</th>
                                 <th>Estatus</th>
                                 <th>Registro</th>
                              </tr>
                           </thead>
                           <tbody>
                              <tr v-for="solicitud in solicitudes" class="table-default">
                                 <td >
                                    <a href="#" align="left"  @click="abrirPoliza(solicitud.solicitudId,solicitud.claveId);" >
                                       <div  v-if="solicitud.activa=='1'"  class="text-success"> <i class="fa fa-thumbs-up"></i>   {{solicitud.nopoliza}} </div>
                                       <div  v-if="solicitud.activa=='0'"  class="text-danger"> <i class="fa  fa-thumbs-down"></i>   {{solicitud.nopoliza}} </div>
                                    </a>
                                 </td>
                                 <td>{{solicitud.producto}}</td>
                                 <td>{{solicitud.nombrecliente}} {{solicitud.apaternocliente}} {{solicitud.apmaternocliente}}</td>
                                 <td>{{solicitud.contratante}}</td>
                                 <td>{{solicitud.estatus}}</td>
                                 <td>{{solicitud.fecharegistro}}</td>
                              </tr>
                           </tbody>
                           <tfoot>
                              <tr>
                                 <td colspan="7" align="right">
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
                  <div v-if="detallepoliza">
                     <div class="row">
                        <div class="col-md-4">
                           <div class="card-body">
                              <h4 class="card-title text-primary">Datos de la Poliza</h4>
                              <p class="card-description"></p>
                              <div class="template-demo">
                                 <p>Estatus: <span class="font-weight-bold">{{chooseSolicitud.estatus}}</span> </p>
                                 <p>Compañia: <span class="font-weight-bold">{{chooseSolicitud.compania}}</span> </p>
                                 <p>Poliza: <span class="font-weight-bold">{{chooseSolicitud.nopoliza}}</span> </p>
                                 <p>Producto: <span class="font-weight-bold">{{chooseSolicitud.producto}}</span> </p>
                                 <p>Vigencia: <span class="font-weight-bold">{{chooseSolicitud.fechainicio}} a {{chooseSolicitud.fechafin}}</span> </p>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="card-body">
                              <h4 class="card-title text-primary">Datos del Contratante</h4>
                              <p class="card-description"></p>
                              <div class="template-demo">
                                 <p>Contratante: <span class="font-weight-bold">{{chooseSolicitud.contratante}}</span> </p>
                                 <p>Total: <span class="font-weight-bold">{{chooseSolicitud.total}}</span> </p>
                                 <p>Tipo Pago: <span class="font-weight-bold">{{chooseSolicitud.tipoperiodo}} - {{chooseSolicitud.clave}}</span> </p>
                                 <p>Descuento: <span class="font-weight-bold"> {{chooseSolicitud.descuento}}</span> </p>
                                 <p>Periodo inico: <span class="font-weight-bold">{{chooseSolicitud.periodoinicio}}</span> </p>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-4">
                           <div class="card-body">
                              <h4 class="card-title text-primary"> Personas Relacionadas</h4>
                              <p class="card-description"> </p>
                              <div class="template-demo">
                                 <p>Asegurado: <span class="font-weight-bold">{{chooseSolicitud.rfccliente}} - {{chooseSolicitud.nombrecliente}} {{chooseSolicitud.apaternocliente}} {{chooseSolicitud.apmaternocliente}}</span> </p>
                                 <p>Edad de asegurado: <span class="font-weight-bold">{{chooseSolicitud.edadcliente}} años </span> </p>
                                 <p>Responsable: <span class="font-weight-bold">{{chooseSolicitud.rfcresponsable}} - {{chooseSolicitud.nombreresponsable}} {{chooseSolicitud.apaternoresponsable}} {{chooseSolicitud.apmaternoresponsable}}</span> </p>
                                 <p>Edad de responsable: <span class="font-weight-bold">{{chooseSolicitud.edadresponsable}} años </span> </p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div v-if="detallepoliza">
            <div class="row">
               <div class="col-md-5 d-flex align-items-stretch grid-margin">
                  <div class="row flex-grow">
                     <div class="col-12">
                        <div class="card">
                           <div class="card-body">
                              <h4 class="card-title"><strong>Periodo de inicio</strong></h4>
                              <p class="card-description">
                                 <label><strong>Nota: </strong><code>NO se debe de cambiar el PERIODO de INICIO a dos periodos ATRAS.</code></label>
                              </p>
                              <form class="forms-sample">
                                 <div class="form-group">
                                    <label for="exampleInputEmail1">Periodo</label>
                                    <select class="form-control" ref="periodo"  >
                                       <option v-for="option in periodos"
                                          :selected="option.periodoId == chooseSolicitud.periodoPrimerDescuento ? 'selected' : ''"
                                          :value="option.periodoId" >
                                          {{ option.periodo }} - {{ option.fechainicio }}
                                       </option>
                                    </select>
                                 </div>
                                 <button type="submit"  @click="modPrimerPeriodo" class="btn btn-success mr-2">Modificar</button> 
                              </form>
                           </div>
                        </div>
 <div class="card">
                           <div class="card-body">
                              <h4 class="card-title"><strong>Agregar periodo</strong></h4>
                              <p class="card-description">
                                 <label><strong>Nota: </strong><code>Limitase agregar Periodos que no correspondan a la Vigencia de la Poliza.</code></label>
                              </p>
                              <form class="forms-sample">
                                 <div class="form-group row">
                                    <label for="exampleInputPassword2" class="col-sm-3 col-form-label">Periodo</label>
                                    <div class="col-sm-9">
                                       <select class="form-control" ref="periodoadd"  >
                                       <option v-for="option in periodos"
                                          :value="option.periodoId" >
                                          {{ option.periodo }} - {{ option.fechainicio }}
                                       </option> 
                                    </select>
                                    </div>
                                 </div>
                                 <button @click="addPeriodo" class="btn btn-success mr-2">Agregar</button>
                              </form>
                           </div>
                        </div>


                     </div> 
                  </div>
               </div>
               <div class="col-md-7 grid-margin stretch-card">
                  <div class="card">
                     <div class="card-body">
                        <h4 class="card-title"><strong>Quitar periodo</strong></h4>
                        <p class="card-description">
                           <label><strong>Nota: </strong><code>No puedes eliminar un periodo si la columna PAGADO es igual a SI o ya  esta Abonado.</code></label>
                        </p>
                       
                           <table class="table table-hover">
                              <thead>
                                 <tr>
                                   <th></th>
                                    <th>Fecha</th>
                                    <th>Periodo</th>
                                    <th>Descuento</th>
                                    <th>Pagado</th>
                                   
                                 </tr>
                              </thead>
                              <tbody>
                                 <tr  v-for="option in amortizacion" >
                                    <td>
                                        <i class="mdi mdi-delete icon-md text-danger"  @click="deletePeriodo(option.tablaAmortizacionClienteId)"></i>
                                    </td>
                                    <td>{{option.fecha}}</td>
                                    <td>{{option.periodo}}</td>
                                    <td>{{option.descuento}}</td>
                                    <td>
                                       <label v-if="option.pagado==1" class="badge badge-success">Pagado</label>
                                       <label v-else class="badge badge-warning">No pagado</label>
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
   </div>
</div> 
<script src="<?php echo base_url();?>/assets/vue/appvue/appperiodo.js"></script>  
<link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
