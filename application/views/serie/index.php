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
                  <h3><strong>Número de Serie</strong></h3>
                  <p class="card-description">
                     Administrar números de serie asociadas a una poliza.
                  </p>
                  <div class="col-md-6">
                     <div class="form-group row">
                        <div class="col-sm-6">
                           <input placeholder="Número de serie" type="search" id="search" class="form-control"  name="search"  ref="search">
                        </div>
                        <div class="col-sm-6">
                           <button type="button"   @click.prevent="searchSolicitud()" class="btn btn-primary btn-fw">Buscar</button>

                           <div v-if="loading">
                              <i class="fa fa-spin fa-spinner"></i>
                              <!-- <img src="../src/assets/loader.gif"/>-->
                              Cargando...
                           </div>

                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     
                  </div>
                  <div class="col-md-12">

                <div v-if="mostrarregistros">

                       <div class="fluid-container">
                    <div class="row ticket-card mt-3 pb-2 border-bottom pb-3 mb-3"  v-for="row in series" >
                      <div class="col-md-1">
                        <img class="img-sm rounded-circle mb-4 mb-md-0" src="<?php echo base_url('assets/images/iconocar.png');?>" alt="profile image">
                      </div>
                      <div class="ticket-details col-md-11">
                        <div class="d-flex">
                          <p class="text-dark font-weight-semibold mr-2 mb-0 no-wrap">Asegurado: {{row.asegurado}} :</p>
                          <p class="text-primary mr-1 mb-0">[Poliza: #{{row.poliza}}]</p>
                          <p class="mb-0 ellipsis">Responsable: {{row.responsable}}.</p>
                        </div>
                        <p class="text-gray ellipsis mb-2">
                           
                          <label><strong>Marca:</strong></label> {{row.marca}}
                          <label><strong>Modelo:</strong></label>{{row.modelo}}
                          <label><strong>Version:</strong></label>{{row.version}}
                          <label><strong>Año:</strong></label>{{row.anno}}
                        </p>
                        <div class="row text-gray d-md-flex d-none">
                          <div class="col-4 d-flex">
                            <small class="mb-0 mr-2 text-muted text-muted">Vigencia :</small>
                            <small class="Last-responded mr-2 mb-0 text-muted text-muted">{{row.fechainicio}} - {{row.fechafin}}</small>
                          </div>
                          <div class="col-4 d-flex">
                            <small class="mb-0 mr-2 text-muted text-muted">Estatus :</small>
                            <small class="Last-responded mr-2 mb-0 text-muted text-muted">{{row.estatus}}</small>
                          </div>
                        </div>
                      </div> 
                    </div> 
                  </div>

               </div>
                  </div>
                
               </div>
            </div>
         </div>
       </div>
             
   </div>
</div>
<script src="<?php echo base_url();?>/assets/vue/appvue/appserie.js"></script> 
<link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
