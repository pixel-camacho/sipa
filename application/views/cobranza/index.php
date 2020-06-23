    <!-- partial -->
    <script type="text/javascript">
      var data_score = '<?php echo $this->session->idusuario;?>';
    </script>
   
    </style>
           

      <div class="main-panel">
        <div class="content-wrapper">
        <div id="app"> 
          <div class="row">
            <div class="col-12 grid-margin">
                    <div class="card">
                <div class="card-body">
                     
                  <h3><strong>Cobranza</strong></h3>
                  <p class="card-description">
                     Administrar cobros de las polizas.
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

                            <a href="#" align="left"  @click="abrirPoliza(solicitud.solicitudId, solicitud.descuento, solicitud.contratanteid); selectSolicitud(solicitud)" > 
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
                                  <p>Vigencia: <span class="font-weight-bold">{{chooseSolicitud.fechainicio}} - {{chooseSolicitud.fechafin}}</span> </p> 
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

                       <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                          <div class="card-body">
                            <h4 class="card-title text-success">Periodos del estado de cuenta.</h4>
                            
                              <p class="card-description">
                              <button type="button" class="btn btn-primary btn-fw"  @click="addModal = true;">
                             <i class="fa fa-plus"></i> Agregar</button> 
                               </p>
                              
                             
                            <div class="table-responsive">
                              <table class="table table-hover">
                                <thead>
                                  <tr>
                                    <th> </th>
                                    <th>Fecha pago</th>
                                    <th>Periodo</th>
                                    <th>Movimiento</th>
                                    <th>Cargo</th>
                                    <th>Abono</th>
                                  </tr>
                                </thead>
                                <tbody>

                                  <tr v-for="periodo in periodos" class="table-default">
                                    <td align="center"> 
 
                                      <button v-if="periodo.imagen=='nopagado'"  @click="editModal = true; selectPeriodoModificar(periodo)" type="button" class="btn btn-outline-success btn-fw">
                                      <i class="fa fa-plus-square"></i> Pagar</button>

                                      <button  v-else-if="periodo.imagen=='pagado' && periodo.abono != '0.00'"  @click="editAbonoModal = true; selectModificarCobro(periodo)"   type="button" class="btn btn-outline-primary btn-fw">
                                      <i class="fa fa-money"></i> Modificar</button>

                                      <button  v-else   type="button" class="btn btn-outline-light btn-fw">
                                      <i class="fa fa-lock"></i> Bloqueado</button>

                                    </td>
                                    <td> {{periodo.fecha}}</td>
                                    <td>
                                      <div  v-if="periodo.imagen=='pagado'"  class="text-success"> <i class="fa fa-tag"></i> <strong> {{periodo.periodo}}</strong> </div>
                                       <div  v-else  class="text-danger"> <i class="fa fa-tag"></i> <strong> {{periodo.periodo}} </strong></div>
                                     
                                    </td>
                                   <td> {{periodo.movimiento}}</td>
                                    <td >  
                                   
                                    <div v-if="periodo.imagen=='pagado'" class="text-success">
                                      <strong> $ {{periodo.cargo}} </strong>
                                    </div>
                                    <div v-else class="text-danger">
                                      <strong> $ {{periodo.cargo}} </strong>
                                    </div>
                                     </td>
                                    <td  > 
                                      <div v-if="periodo.imagen=='pagado'" class="text-success">
                                      <strong> $ {{periodo.abono}} </strong>
                                    </div>
                                    <div v-else class="text-danger">
                                     <strong>  $ {{periodo.abono}} </strong>
                                    </div>
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
          </div>

 
  <?php include 'modal.php';?>
  
        </div>
        </div> 
        <div id="app2" ></div>

 

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
      <script src="<?php echo base_url();?>/assets/vue/appvue/appsolicitud.js"></script>  
   
      <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
      <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
       