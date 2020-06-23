


<div class="main-panel">
	<div class="content-wrapper">
		<div id="app">
		<div class="row">
			<div class="col-12 grid-margin">
				<div class="card">
						<div class="card-body">
							
							<h3><strong><i class="fa fa-medkit"></i>GMM</strong></h3>
							<hr>
              <img src="<?php echo base_url('assets/images/load/35.gif'); ?>" id="cargando">

							<br>
						       <h4>Buscar por:</h4>			
								<div class="row">
									<div class="col-sm-4">
										<input type="text" name="asegurado" class="form-control" id="buscar" placeholder="Nombre de Asegurado" ref="asegurado" @keyup.enter="buscar">
                    <input type="hidden" id="name" class="form-control" value="<?php echo $nombre; ?>">
                    
									</div>
									<div class="col-sm-2">
										<input type="text" name="noPoliza" class="form-control" id="buscar2" placeholder="Numero de poliza" ref="noPoliza" @keyup.enter="buscar" >
                    <input type="hidden" id="poliza" class="form-control" value="<?php echo $poliza; ?>">
                     
									</div>
									<div class="col-sm-2">
										<input type="text" name="certificado" class="form-control" id="buscar3" placeholder="certificado" ref="certificado" @keyup.enter="buscar" >
									</div>

									<div class="col-sm-2">
										<button class="btn  btn-fw" style="border-radius: 20px;background-color: rgba(255, 153, 51,0.9);" class="fa fa-search" aria-hidden="true" @click="buscar" >Buscar</button>
										<div v-if="loading" class="circle-loader"></div>
									</div> 

                                       <div v-if="mostrar">
                                          <hr>
                                        	<div class=" container">
                                        		<div class="row">
                                        		<table class="table-responsive table-striper table-hover" v-if="polizas.length">
                                        			<thead>
                                        				<tr>
                                        		<th width="15%"><h5><strong>Poliza</strong></h5></th>
                                                <th width="30%" class="text-center"><h5><strong>Certificado</strong></h5></th>
                                                <th width="25%"><h5><strong>Asegurado</strong></h5></th> 
                                                <th width="10%"><h5><strong>Estatus</strong></h5></th> 
                                                <th width="20%" class="text-center"><h5><strong>Compañia</strong></h5></th>
                                            


                                     
                                                  </tr>
                                        			</thead>
                                        			<tbody>
                                        				<tr v-for="poliza in polizas">
                                        				<td id="col1">{{poliza.noPoliza}}<br>
                                        				<!--	<span><strong>Sisnova:</strong></span>{{polizas.polizaSisnova}}<br>
                                        					<span><strong>Bienestar: </strong></span>{{polizas.polizaBienestar}} -->
                                        				</td>
                                        				<td id="col2"><strong>Certificado: </strong> 
                                                                   {{poliza.certificado}} <br>
                                        				     <strong>Nombre: </strong>
                                                                  {{poliza.asegurado}}</td>
                                        				<td>
                                        					<div v-if="poliza.beneficiario != null">
                                                    <span v-for="nuevo in poliza.beneficiario.split('-')">
                                        						{{nuevo}}
                                                    </span>
                                        					</div>
                                        					<div v-else>
                                        						
                                        					</div>
                                        				</td>
                                        				<td> 
                                                   <span v-if="poliza.clasificacion=='Transferido'" class="badge badge-primary" style="font-size: 14px;"> Transferido
                                            </span>
                                            <span v-if="poliza.clasificacion=='Activo'" class="badge badge-success" style="font-size: 14px;"> Activo
                                            </span>
                                            <span  v-if="poliza.clasificacion == 'No Transferido'" class="badge badge-danger" style="font-size: 14px;"> No Tranferido
                                            </span>     
                                        				</td>
                                        				<td class="text-center">
                                        				  <div v-if="poliza.clasificacion == 'Transferido'" style="justify-content: center;">
                                                              <img src="<?php echo base_url('assets/images/latino.png'); ?>" class="img-fluid" alt="Responsive image"><br>
                                                              {{poliza.nivel}}
                                                          
                                                           </div>
                                                         <div v-else>
                                                           <img src="<?php echo base_url('assets/images/sisnova.png'); ?>"class="img-fluid" alt="Responsive image">
                                                         </div>
                                        				</td>   
                                        				</tr> 
                                        			</tbody>
                                        		</table>
                                        	</div> 
                                                <tfoot>
                                                <tr>
                                                    <td colspan="3"  >
                                            <pagination
                                                :current_page="currentPage"
                                                :row_count_page="rowCountPage"
                                                @page-update="pageUpdate"
                                                :total_users="totalPolizas"
                                                :page_range="pageRange"
                                                >
                                            </pagination>

                                            </td>
                                            </tr>
                                            </tfoot>
                                            </div>

                                        	
                                    </div>
						      </div>
                            </div>

						</div>
					</div>
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
		</div>
	</div>

	  <link href="https://unpkg.com/nprogress@0.2.0/nprogress.css" rel="stylesheet" />
    <script src="https://unpkg.com/nprogress@0.2.0/nprogress.js"></script>
	  <script type="text/javascript" src="<?php echo base_url();?>/assets/vue/appvue/appgmm.js"></script>	
  <script type="text/javascript">
      
      $(document).ready( ()=> {

        $('#cargando').hide();

        let name  = $('#name').val();
        let poliza = $('#poliza').val();

        if(name == '' && poliza == '')
        {
          return;
        }else
        {

          $.ajax({
          type: 'POST',
          url: 'http://190.9.53.22:8484/apiSIPA/gmm/buscarPolizas',
          data: `asegurado=${name}&noPoliza${poliza}`,
          dataType: 'json',

          beforeSend: ()=> $('#cargando').show(),
          complete: ()=> $('#cargando').hide(),

          success: (response)=>
          {
              console.log(response);
          }


        })
  
        }

         });
    </script>
