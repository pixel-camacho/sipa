    <!-- partial -->
    <script type="text/javascript">
      var data_score = '<?php echo $this->session->idusuario;?>';
    </script>
    
      <div class="main-panel">
        <div class="content-wrapper">
        <div id="app"> 
          <div class="row">
            <div class="col-12 grid-margin">
                    <div class="card">
                <div class="card-body">
                
                   <h3><strong>Clabe</strong></h3>
                  <p class="card-description">
                     Administrar clabes para formas de cobro.
                  </p>

                           <form class="form-sample">
                
 
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
                               <button type="button"  @click.prevent="searchSolicitud()" style="margin-top:30px;" class="btn btn-primary btn-fw">Buscar</button>
                          </div>
                         
                        </div>
                      </div>
                      <div class="col-md-2"> 
                         <div v-if="loading" class="circle-loader"></div> 
                    </div>
					</div>
                  <div class="row">
                      
                  </div>
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

                            <a href="#" align="left"  @click="abrirPoliza(solicitud.solicitudId); selectSolicitud(solicitud)" > 
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

                     <div class="row">
                    <div class="col-md-12"> 
                      <hr>
                       <h4 class="card-title"><strong>Modificar Clabe</strong> </h4>
                      <form>
                          <p v-if="errors.length"> 
                             <ul>
                               <li v-for="error in errors" class="text-danger">{{ error }}</li>
                             </ul>
                           </p>
                        <div class="form-row">
                          <div class="form-group col-md-6"> 
                            <label for="inputEmail4">Banco</label> 
                             <select class="form-control" ref="banco" >
                                  <option v-for="template in bancos"
                                      :selected="template.bancoId == chooseSolicitud.bancocobro ? 'selected' : ''"
                                      :value="template.bancoId"  v-model="newCable.bancoid">
                                     {{ template.bancoDescr }}
                                  </option>
                              </select>
 

 
                          </div>
                          <div class="form-group col-md-6">
                            <label for="inputPassword4">Tipo de Tarjeta</label>
                           <select class="form-control" ref="tipotarjeta">
                                    <option   v-for="option in tipostarjetas" v-bind:value="option.tipoTarjetaId" 
                                     v-model="newCable.tipotarjetaid" 
                                    :selected="option.tipoTarjetaId == chooseSolicitud.tipotarjetacobro ? 'selected' : ''">
                                    {{ option.tipoTarjetaDescr }}
                                  </option>
                                </select>
                          </div>
                        </div>
                         <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="inputEmail4">Número de Tarjeta</label>
                            <input type="text" class="form-control"  v-model="chooseSolicitud.tarjetacobro"  placeholder="################" ref="numerotajeta">
                          </div>
                          <div class="form-group col-md-6">
                            <label for="inputPassword4">Titular de la Tarjeta</label>
                            <input type="text" class="form-control" v-model="chooseSolicitud.titulartarjetacobro" placeholder="Nombre" ref="titular">
                          </div>
                        </div>
                      
                        <button type="button" @click="addDomiciliacion" class="btn btn-success btn-fw">Modificar</button>
                 </form>
                    </div>
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
      <script src="<?php echo base_url();?>/assets/vue/appvue/appclabe.js"></script> 

<link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
 