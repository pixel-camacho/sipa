<script type="text/javascript">
    var data_score = '<?php echo $this->session->idusuario; ?>';
</script>

<style type="text/css">
	
  .table td.demo {
        max-width: 177px;
    }
    .table td.demo span {
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        white-space: nowrap;
        max-width: 100%;
    }


</style>
<div class="main-panel">
<div class="content-wrapper">
	<div id="app">
		<div class="row">
			<div class="col-12 grid-margin">
				<div class="card">
					<div class="card-body ">
						<h3><strong><i class="fa fa-file"></i>Solicitudes</strong></h3>
            <hr>
						<br><br>
						 <div class="row">
                                <div class="col-sm-2">
                                    <label>Poliza</label>
                                    <input placeholder="Poliza" type="text" id="search" class="form-control"  name="search"  ref="noPoliza" 
                                     @keyup.enter="BuscarcarSolicitudes()">
                                </div>

                                <div class="col-sm-2">
                                    <label>Certificado</label>
                                    <input placeholder="Certificado" type="text" id="search" class="form-control"  name="search"  ref="certificado"
                                     @keyup.enter="BuscarcarSolicitudes()" >
                                </div>

                                <div class="col-sm-4">
                                    <label>Asegurado</label>
                                    <input placeholder="Asegurado" type="text" id="search" class="form-control"  name="search"  ref="asegurado" 
                                    @keyup.enter="BuscarcarSolicitudes()">
                                </div>

                                <div class="col-sm-2">
                                	<label>Producto</label>
                                	<select class="form-control" v-model="select" ref="producto">
                                        <option value="">Seleccionar...</option>
                                		<option v-for="producto in productos" v-bind:value="producto.productoId" >{{producto.productoDescr}}</option>
                                	</select>
                                </div>

                                 <div class="col-sm-2">
                                	<label>Tramite</label>
                                	<select class="form-control" v-model="select1" ref="tramite">
                                		<option value="">Seleccionar...</option>
                                        <option v-for="tramite in tramites" v-bind:value="tramite.tipoTramiteId">{{tramite.tipoTramiteDescr}}</option>
                                	</select>
                                </div>

                            </div>
                             
                            <div class=" row justify-content-end">
                                       <div class="col-sm-2 my-3">
                                		<label>Estatus</label>
                                		<select class="form-control" v-model="select2" ref="estatus"  name="estatus">
                                			<option value="">Seleccionar...</option>
                                            <option v-for="estatus in estatus" v-bind:value="estatus.estatusSolicitudId">{{estatus.estatusSolicitudDescr}}</option>
                                		</select>
                                		</div>
                                <!--
                                    <div class="row justify-content-end">
                                      <div class="col-sm-2 my-3">
                                        <label>Estatus</label>
                                        <input list="estatus" v-model="select2" ref="estatus" name="estatus">
                                         <datalist id="estatus" v-for="estatus in estatus">
                                           <option >
                                         </datalist>
                                      </div>
                                      
                                    </div>
-->
                                    <div class="col-sm-2 my-3"  style="padding-top: 35px;" >
                                        <button type="button" style="background-color: rgba(255, 153, 51,.9);" @click.prevent="BuscarcarSolicitudes()" class="btn btn-fw"><i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                                    <div v-if="loading" class="circle-loader"></div> 

                                </div>
                            </div>
              
 
                            <div v-if="mostrar">
                              <div class="container">
                                <div class="row">
                                <div class="card-columns" v-if="solicitudes.length">
                              <div class="card" v-for="solicitud of solicitudes" v-bind:key="solicitudes.solicitudId">
                                 <h6 class="card-header text-center">{{solicitud.cliente}}</h6>
                             <!--  <div v-if="solicitud.sexo === 'hombre'">
                                 <img src="<?php echo base_url('assets/images/chico.png');?>" class="card-img-top" >
                               </div>
                               <div v-else-if="solicitud.sexo === 'mujer'">
                                 <img src="<?php echo base_url('assets/images/chica.png');?>" class="card-img-top" >
                               </div> -->
                              <div class="card-body">
                                <div >
                                  <h5 class="card-title text-center"><a :href="'/sipa/cliente/poliza/' + solicitud.solicitudId" style="text-decoration: none;"> {{solicitud.NoSolicitud}} <br>
                               {{solicitud.compania}} </a></h5>
                                </div>
                             <!--
                              <div v-else-if="solicitud.compania === null ">
                                  <h5 class="card-title text-center">
                                    {{solicitud.NoSolicitud}} <br>
                               {{solicitud.compania}} </h5>
                                </div> 
                               <h5 class="card-title text-center"><a :href="'/sipa/cliente/poliza/' + solicitud.solicitudId" style="text-decoration: none;"> {{solicitud.NoSolicitud}} <br>
                               {{solicitud.compania}} </a></h5>-->
                                 <p>
                                <strong>RFC: </strong> {{solicitud.rfc}}<br>
                                <strong>Poliza:</strong> {{solicitud.noPoliza}}<br>
                                <strong>Certificado:</strong> {{solicitud.certificado}}<br>
                                <strong>Producto:</strong> {{solicitud.producto}}<br>
                                <strong>Fecha:</strong> {{solicitud.fechaRegistro}}<br>
                                <strong>Estatus:</strong> {{solicitud.estatus}}<br>
                                <strong>Contratante:</strong> {{solicitud.contratante}}<br> 
                                <strong>Pago:</strong> {{solicitud.clave}}-{{solicitud.periodo}}<br>
                                <strong>Solicitud: </strong>{{solicitud.solicitudId}}
                                </p>
                      <div class="card-footer text-muted">
                      <div class="d-flex justify-content-between">
                       <a href="#"><i class="fa fa-plus-circle" title="Agregar">Siniestro</i></a>
                       <a href="#"><i class="fa fa-plus-circle" title="Agregar">Endoso</i></a>
                       </div>
                   </div>
                  </div>
                     </div>     
                               </div> 
                                </div>
                                <tfoot>
                                  <pagination
                                                :current_page="currentPage"
                                                :row_count_page="rowCountPage"
                                                @page-update="pageUpdate"
                                                :total_users="totalSolicitudes"
                                                :page_range="pageRange">
                                    </pagination>
                                          
                                   </tfoot> 
                              </div>
                              </div>
                            </div>
<!--
                           <div v-if="mostrar">
                              <div class="container">
                                <div class="row">
                                  <table class="table-resposive table-striper table-hover" v-if="solicitudes.length">
                                    <thead >
                                      <tr>
                                        <th>Nosolicitud</th>
                                        <th>Poliza</th>
                                        <th>Certificado</th>
                                        <th>Producto</th>
                                        <th>Asegurado</th>
                                        <th>RFC</th>
                                        <th>Contrante</th>
                                        <th>Fecha de Registro</th>
                                        <th>Trámite</th>
                                        <th>Estatus</th>
                                        <th>Sin.</th>
                                        <th>Endoso</th> 
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr v-for="solicitud in solicitudes" class="table-default">
                                        <td><a :href="'/sipa/cliente/poliza/' + solicitud.solicitudId">{{solicitud.NoSolicitud}}
                                        <center>{{solicitud.compania}}</center></a></td>
                                        <td>{{solicitud.nopoliza}}</td>
                                        <td>
                                          <div v-if="solicitud.certificado == 'NULL'">
                                            
                                          </div>
                                          <div v-else>
                                        {{solicitud.certificado}}
                                        </div>
                                      </td>
                                        <td>{{solicitud.producto}}</td>
                                        <td>{{solicitud.cliente}}</td>
                                        <td>{{solicitud.rfc}}</td>
                                        <td>{{solicitud.contratante}}</td>
                                        <td>{{solicitud.fechaRegistro}}</td>
                                        <td>{{solicitud.tramite}}</td>
                                        <td>{{solicitud.estatus}}</td>
                                       <td><a href="#"><i class="fa fa-plus-circle fa-2x "></i></a></td>
                                        <td><a href="#"><i class="fa fa-plus-circle fa-2x "></i></a></td>
                                      </tr>
                                    </tbody>
                                  </table>   
                                </div>
                                <tfoot>
                                        <tr>
                                          <td colspan="3">
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
                              </div>
                            </div>
                                	 
                            </div>
-->
                         
                                         <!-- partial -->

                                          
					</div>

					 
				</div>
        <footer class="footer">
            <div class="container-fluid clearfix">
                <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © <?php echo date('Y') ?>
                    <a href="http://www.proteges.mx" target="_blank">Proteges</a>. Todos los derechos reservados.</span>
                <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Departamento de Sistemas
                    <i class="fa fa-code text-danger"></i>
                </span>
            </div>
        </footer>
  </footer>
			</div>
			
		</div>
	</div>

</div>
</div>

<link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
<script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script> 

<script type="text/javascript" src="<?php echo base_url();?>/assets/vue/appvue/solicitud/solicitudapp.js"></script>

<!--

<script type="text/javascript">
    
var v  = new Vue ({
    el:'#app',
    data:
    {
        productos:[],
        tramites:[],
        estatus:[],
        solicitudes:[],
        apmaterno: '',
        search: {
            text: ''
        },
        loading: false,
        mostrar: true,
        currentPage: 0,
        rowCountPage: 10,
        totalSolicitudes: 0,
        emptyResult: false,
        pageRange: 3,
        select: '',
        select1:'',
        select2:''
      
    },
    created()
    {
      this.allProductos();
      this.allTramites();
      this.allEstatus();

    },methods:
    {

      BuscarcarSolicitudes()
      {
        this.loading = true;
        NProgress.start()
        this.mostrar = true;
        axios.get('http://190.9.53.22:8484/apiSIPA/solicitud/buscarSolicitud',
        {
          params:
          { 
            noPoliza: this.$refs.noPoliza.value,
            certificado: this.$refs.certificado.value,
            asegurado: this.$refs.asegurado.value,
            producto: this.select

          }
        }).then( function(response)
        {

          if(response.data.solicitud === null)
          {
              NProgress.done()
              v.noResult()

          }else
          {
            NProgress.done()
            v.getData(response.data.solicitudes);
          }
           
        });

          },
    
         allProductos()
         {
           axios.get('http://190.9.53.22:8484/apiSIPA/Producto/allProducto').
                 then(response =>(this.productos = response.data));
         },
         allTramites()
         {
           axios.get('http://190.9.53.22:8484/apiSIPA/TipoTramite/allTipoTramite').
                 then(response =>(this.tramites = response.data));
         },
         allEstatus()
         {
           axios.get('http://190.9.53.22:8484/apiSIPA/Estatus/allEstatus').
                 then(response => (this.estatus = response.data));
         },
          getData(solicitudes) {
            this.loading = false;
            v.emptyResult = false; // become false if has a record
            v.totalSolicitudes = solicitudes.length; //get total of user
            v.solicitudes = solicitudes.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.solicitudes.length == 0 && v.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                //v.clearAll();  
            }
        },
        noResult() {
            this.loading = false;
            v.emptyResult = true; // become true if the record is empty, print 'No Record Found'
            v.solicitudes = null
            v.totalSolicitudes = 0 //remove current page if is empty

        },
        pageUpdate(pageNumber) {
            v.currentPage = pageNumber; //receive currentPage number came from pagination template
            v.refresh()
        },
          refresh(){
             v.search.text ? v.BuscarcarSolicitudes() : v.BuscarcarSolicitudes();

       }

     }

})


</script>


