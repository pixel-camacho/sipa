
<style type="">

	.help-inline-error{color:red;}

</style>

<div class="main-panel">
	<div class="content-wrapper">
		<div id="app">
			<div class="row">
				<div class="col-12 grid-margin">
					<div class="card">
						<div class="card-body">
							<h3><strong>Emision de pólizas HDI</strong></h3>
											
							

								<input type="hidden" id="cotizacion" name="cotizacion" class="form-control" style="width: 
								                                                                                 10%;">
									
							   <!-- <input type="text" id="poliza" class="form-control"
							         style="width: 15%;">-->

							    <input type="hidden"  id="detalles" name="detalles" class="form-control" 
							       style="width: 13%; 
							       float: right; 
							       margin-top: -30px;">
									
							
							<hr>
							<div class="row">
								<div class="col-md-12">
									<strong><i class="fa fa-car"> </i><label>Datos de vehículo</label></strong>
									<form name="form-hdi" id="form-hdi" method="POST" 
									      action="<?php echo base_url('Hdi/emitir')?>" 
									      enctype="multipart/form-data">
									      <div class="frm" id="next">	
									      <fieldset>
									      	<div class="row">
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="typeCar" name="typeCar" required>
									      					<option value="">* Tipo de vehiculo</option>
									      				</select>
									      				<span style="color: red;"><?php echo form_error('typeCar');?></span>
									      			</div>
									      		</div>
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listYear" name="year" required>
									      					<option value="">* Seleciona modelo</option>
									      					<?php for($i = 1990; $i < 2020; $i++ ) { 
                                                                echo "<option value='".$i."'>".$i."</option>";
                                                            }
									      					?>
									      				</select>
									      			</div>
									      		</div>
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listBrand" name="brand" required>
									      					<option value="">* Selecciona Marca</option>
									      				</select>
									      				
									      			</div>
									      		</div>
								
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listSubBrand" name="subBrand" required>
									      					<option value="">* Selecciona Submarca</option>
									      				</select>
									      			</div>
									      		</div>
									          </div>
									      	<img src="<?php echo base_url('assets/images/load/30.gif')  ?>" id="loading">
                                       
									      	<div class="row">
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listVersion" name="version" required>
									      					<option value="">* Selecciona Version</option>
									      				</select>
									      			</div>
									      		</div>
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listTransmision" name="transmision" required>
									      					<option value="">* Selecciona Trasmision</option>
									      				</select>
									      			</div>
									      		</div>
									      
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listUsos" name="usos" required>
									      					<option value="">* Selecciona tipo de uso</option>
								      				</select>
									      			</div>
									      		</div>

                                                <div class="col-md-3">
									      			<div class="form-group">
									      				<input type="text" id="serie" class="form-control"  placeholder="Ingres numero de Serie" required>
									      			</div>
									      			<span style="color: red;
									      			             padding: 0;
									      			             margin: 0;
									      			             text-align: center;
									      			             display: block;" id="error"></span>
									      		   </div>

									      	</div>

									      		<div class="row">
									      			<div class="col-md-3">
									      				<div class="form-group">
									      					<input type="text" id="color" name="color" class="form-control" placeholder="Color de vehiculo">
									      				</div>
									      			</div>

									      			<div class="col-md-3">
									      				<div class="form-group">
									      					<input type="text" id="placa"  class="form-control" placeholder=" Placa del vehiculo">
									      				</div>
									      			</div>

									      			

									      		</div>

									      		
									      	<div class="row">
									      		<div class="col-md-12"><strong><i class="fa fa-file"> </i><label>Informacion General</label></strong></div>
									      		<div class="col-md-4">
									      			<div class="form-group">	
									      			<select class="custom-select form-control" id="listEstado" name="estado" required>
									      				<option value="">* Selecciona Estado</option>
									      			</select>
									      			</div>
									      		</div>
									      		<div class="col-md-4">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listCiudad"
									      				name="ciudad" required>
									      				<option value="">* Selecciona Ciudad</option>
									      					
									      				</select>
									      			</div>
									      		</div>
									      		<div class="col-md-4">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listPago"
									      				name="pago" required>
									      				<option value="">* Periodos de pago</option>
									      				</select>
									      			</div>
									      		</div>

									      		<div class="col-md-4">
									      			<div class="form-group">
									      			 <select class="custom-select form-control" id="listTipoPago" required>
									      			 	<option value="">* Seleccionar</option>
									      			 </select>
									      			</div>
									      		</div>
									      		<div class="col-md-4">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listServicios" required>
									      				<option value="">* Tipo de servicio</option>
									      			    </select>
									      			</div>
									      		</div>
									      		<div class="col-md-4">
									      			<div class="form-group">
									      		   		<select class="custom-select form-control" 
									      		   		id="listConducto" required>
									      		   			<option value="">* Tipo de Pago</option>
									      		   		</select>
									      		   	</div>
									      		</div>

									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="paquete" required>
									      					<option value="">* Selecciona paquete</option>
									      					<option value="19">AMPLIA</option>
									      					<option value="21">LIMITADA</option>
									      					<option value="22">BASICA</option>
									      					<option value="144">RC</option>
									      				</select>
									      			</div>
									      		</div>

									      		<div class="col-md-3">
									      			<div class="form-group">
									      			<select class="custom-select form-control" id="listOcupacion" required>
									      				<option value="">* Ocupacion del conductor</option>
									      			</select>	
									      			</div>
									      		</div>

									      		<div class="col-md-4">
									      			<input type="date" id='fecha' name="fecha" class="form-control" required>
									      		</div>
									      	</div>

                                             <br>
									      	<div class="row">
									      		<div class="col-md-12">
									      			<strong><i class="fa fa-user"></i> <label>Informacion del cliente</label></strong>
									      		</div>
									      			<div class="col-md-4">
									      				<div class="form-group">
									      				 <input type="text" id="nombre" class="form-control" placeholder="Nombre" required>
									      				 <span style="color: red;"><?php echo  form_error('nombre');?></span>
									      				</div>
									      			</div>
									      			<div class="col-md-3">
									      				<div class="form-group">
									      				 <input type="text" id="apPaterno" class="form-control" placeholder="Apellido paterno" required>
									      				</div>
									      			</div>
									      			<div class="col-md-3">
									      				<div class="form-group">
									      				 <input type="text" id="apMaterno" class="form-control" placeholder="Apellido materno" required>
									      				</div>
									      			</div>
									      			<div class="col-md-2">
									      				<div class="form-group">
									      				 <input type="date" id="nacimiento" class="form-control" placeholder="Fecha nacimiento" required>
									      				</div>
									      			</div>
									      	</div>

									      	<div class="row">
									      		<div class="col-md-2">
									      			<div class="form-group">
									      			   <select class="custom-select form-control" id="listSexo" required>
									      			   	<option value="">* Sexo</option>
									      			   	<option value="1">MASCULINO</option>
									      			   	<option value="2">FEMENINO</option>
									      			   </select>
									      			</div>
									      		</div>
									      			<div class="col-md-2">
									      			<div class="form-group">
									      			   <select class="custom-select form-control" id="listCivil" required>
									      			   	<option value="">* Estado civil</option>
									      			   </select>
									      			</div>
									      		</div>

									      			<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listNacionalidad" required>
                                                            <option value="">*  Nacionalidad</option>	
									      				</select>
									      			</div>
									      		</div>

									      		<div class="col-md-2">
									      			<div class="form-group">
                                                      <input type="text" id="rfc" placeholder="RFC" class="form-control" required>									      	
									      			</div>
									      		</div>

									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<input type="number" name="telefono" id="telefono" class=" form-control" placeholder="Ingresar Telefono" required>
									      			</div>
									      		</div>
									    
									      		

									      		<div class="col-md-4">
									      			<div class="form-group">
									      				<input type="text" id="direccion" class="form-control" placeholder="Direccion Calle" required>
									      			</div>
									      		</div> 

									      		<div class="col-md-2">
									      			<div class="form-group">
									      				<input type="text" id="numero" class="form-control" placeholder="numero" required>
									      			</div>
									      		</div>

									      		<div class="col-md-4">
									      			<div class="form-group">
									      				<input type="text" id="colonia" class="form-control" placeholder="Colonia" required>
									      			</div>
									      		</div>

									      		<div class="col-md-2">
									      			<div class="form-group">
									      				<input type="number" id="codigop" class="form-control" placeholder="codigo" required>
									      			</div>
									      		</div>					

									      			<div class="col-md-3">
									      			<div class="form-group">
									      			   <select class="custom-select form-control" id="listOcupaciones" required>
									      			   	<option value="">* Ocupacion</option>
									      			   </select>
									      			</div>
									      		</div>
									      		<div class="col-md-5">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listGiros" required>
                                                            <option value="">* Giro de ocupacion</option>	
									      				</select>
									      			</div>
									      		</div>

                                                

									      	</div>

									      	<div class="row">
									      		
									      		<div class="col-md-12">
									      			<div class="form-group">
									      	          	 <button class="btn btn-primary" id="save" 
									      		  style="display: block;
									      		         margin-left: auto;
									      		         margin-right: auto; 
									      		         border-radius: 20px;
                                                         text-align: center;
									      		         transition: 1s;" type="submit">
									      		      <i class="fa fa-save fa-2x" aria-hidden="true" ></i>
									      		 	  Guardar
									      		 </button>
									      			</div>
									      			 <button class="btn btn-warning"  id="emitir"
									      		 	        style="display: block;
									      		 	               margin-left: auto;
									      		 	               margin-right: auto;
									      		 	               border-radius: 15px;
									      		 	               text-align: center;
									      		 	               transition: 1s;" type="submit">
									      		 	    <i class="fa fa-pencil fa-2x"></i>
									      		       Emitir		
									      		 	</button>										      			
									      		</div>
									      	</div>
									      	<img src="<?php echo  base_url('assets/images/load.gif')?>" id='cargar'  style="margin-top: -5%;
									      	       float: right;
									      	       width: 150px;
									      	       height: 150px;">
									      	<img src="<?php echo base_url('assets/images/saving.gif')?>" id='salvar'
									      	 style="width: 150px;
									      	        height: 150px;
									      	        float: right;
									      	        margin-top: -5%;">
									      </fieldset>
									      </div>
									</form>
									<div class="frm" id="poliza">
										
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



<script type="text/javascript" src="<?php echo base_url('assets/js/hdi/request.js')?>"></script>

<script type="text/javascript">

	$(document).ready(()=>{

	
		$('#cargar').hide();
		$('#salvar').hide();
		$('#emitir').hide();

          //select
        $('#listConducto').attr('disabled','disabled');
        $('#listSexo').attr('disabled','disabled');
        $('#listCivil').attr('disabled','disabled');
        $('#listNacionalidad').attr('disabled','disabled');
        $('#listOcupaciones').attr('disabled','disabled');
        $('#listYear').attr('disabled','disabled');
        $('#listGiros').attr('disabled','disabled');
        $('#listOcupacion').attr('disabled','disabled');
        $('#paquete').attr('disabled','disabled');


        })



		 $('#save').click((e)=>{
         e.preventDefault();

       //  if(validarCampos() == true)
         //{
 
         if(validateForm()) {
       
 let url       = 'http://190.9.53.22:8484/sipa/Hdi/saveCotizacion';
 let tipo      = $('#typeCar').find('option:selected').val();
 let pago      = $('#listPago').find('option:selected').val();
 let marca     = $('#listBrand').find('option:selected').val();
 let submarca  = $('#listSubBrand').find('option:selected').val();
 let version   = $('#listVersion').find('option:selected').val();
 let transmision = $('#listTransmision').find('option:selected').val();
 let modelo    = $('#listYear').find('option:selected').val();
 let serie     = $('#serie').val();
 let ciudad    = $('#listCiudad').find('option:selected').val();
 let estado    = $('#listEstado').find('option:selected').val();
 let tiposuma  = $('#listTipoPago').find('option:selected').val();
 let uso       = $('#listUsos').find('option:selected').val();
 let detalles  = $('#detalles').val();
 let servicio  = $('#listServicios').find('option:selected').val();
 let ocupacion = $('#listOcupaciones').find('option:selected').val();
 let sexo      = $('#listSexo').find('option:selected').val();
 let civil     = $('#listCivil').find('option:selected').val();
 let nombre    = $('#nombre').val();
 let apMaterno = $('#apMaterno').val();
 let apPaterno = $('#apPaterno').val();
 let fechaNa   = $('#nacimiento').val();
 let rfc       = $('#rfc').val();
 let inicio    = $('#fecha').val();
 let color     = $('#color').val();
 let placa     = $('#placa').val();
 let direccion = $('#direccion').val();
 let numero    = $('#numero').val();
 let colonia   = $('#colonia').val();
 let cp        = $('#codigop').val();
 let telefono  = $('#telefono').val();
 let nacionalidad = $('#listNacionalidad').find('option:selected').val();
 let giro      = $('#listGiros').find('option:selected').val();
 let conducto  = $('#listConducto').find('option:selected').val();
 let ocupacionC= $('#listOcupacion').find('option:selected').val();
 let paquete  = $('#paquete').find('option:selected').val();

 let data      = `tipo=${tipo}&marca=${marca}&submarca=${submarca}&version=${version}&transmision=${transmision}&modelo=${modelo}&serie=${serie}&ciudad=${ciudad}&estado=${estado}&tiposuma=${tiposuma}&cp=${cp}&uso=${uso}&detalles=${detalles}&pago=${pago}&servicio=${servicio}&ocupacion=${ocupacion}&sexo=${sexo}&civil=${civil}&nombre=${nombre}&apPaterno=${apPaterno}&apMaterno=${apMaterno}&nacimiento=${fechaNa}&rfc=${rfc}&inicio=${inicio}&color=${color}&placa=${placa}&telefono=${telefono}&nacionalidad=${nacionalidad}&numero=${numero}&colonia=${colonia}&direccion=${direccion}&giro=${giro}&conducto=${conducto}&ocupacionC=${ocupacionC}&paquete=${paquete}`;

  $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'html',

        beforeSend: ()=> $('#salvar').show(),
        complete: ()=> $('#salvar').hide(),
        success: (response)=>{
             
        	 let valor   = response.trim();
        	 let mensaje = valor.substring(5);

        	if(valor.indexOf('error') == -1)
        	{
        		$('#cotizacion').val(valor);
        		$('#save').hide(500);
		        $('#emitir').toggle(100);

        	}else{

        		 swal({
        title:'Error',
        text:mensaje,
        type:'error',
        showCancelButton: false,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'ACEPTAR'
      }).then((result) => {
        if (result.value) {
            }
          })

        	}
        }
      });
   }

      //}
         	
    })

	

  $('#emitir').click(function(e){
    	e.preventDefault();

          

         if(validateForm())
         {

 let url       = 'http://190.9.53.22:8484/sipa/Hdi/emitir';
 let conducto  = $('#listConducto').find('option:selected').val();
 let tipo      = $('#typeCar').find('option:selected').val();
 let pago      = $('#listPago').find('option:selected').val();
 let marca     = $('#listBrand').find('option:selected').val();
 let submarca  = $('#listSubBrand').find('option:selected').val();
 let version   = $('#listVersion').find('option:selected').val();
 let transmision = $('#listTransmision').find('option:selected').val();
 let modelo    = $('#listYear').find('option:selected').val();
 let serie     = $('#serie').val();
 let ciudad    = $('#listCiudad').find('option:selected').val();
 let estado    = $('#listEstado').find('option:selected').val();
 let tiposuma  = $('#listTipoPago').find('option:selected').val();
 let uso       = $('#listUsos').find('option:selected').val();
 let detalles  = $('#detalles').val();
 let servicio  = $('#listServicios').find('option:selected').val();
 let ocupacion = $('#listOcupaciones').find('option:selected').val();
 let sexo      = $('#listSexo').find('option:selected').val();
 let civil     = $('#listCivil').find('option:selected').val();
 let nombre    = $('#nombre').val();
 let apMaterno = $('#apMaterno').val();
 let apPaterno = $('#apPaterno').val();
 let fechaNa   = $('#nacimiento').val();
 let rfc       = $('#rfc').val();
 let inicio    = $('#fecha').val();
 let color     = $('#color').val();
 let placa     = $('#placa').val();
 let direccion = $('#direccion').val();
 let numero    = $('#numero').val();
 let colonia   = $('#colonia').val();
 let cp        = $('#codigop').val();
 let telefono  = $('#telefono').val();
 let nacionalidad = $('#listNacionalidad').find('option:selected').val();
 let cotizacion= $('#cotizacion').val();
 let giro      = $('#listGiros').find('option:selected').val();
 let ocupacionC= $('#listOcupacion').find('option:selected').val();
 let paquete   = $('#paquete').find('option:selected').val();

 let data      = `tipo=${tipo}&marca=${marca}&submarca=${submarca}&version=${version}&transmision=${transmision}&modelo=${modelo}&serie=${serie}&ciudad=${ciudad}&estado=${estado}&tiposuma=${tiposuma}&cp=${cp}&uso=${uso}&detalles=${detalles}&pago=${pago}&servicio=${servicio}&ocupacion=${ocupacion}&sexo=${sexo}&civil=${civil}&nombre=${nombre}&apPaterno=${apPaterno}&apMaterno=${apMaterno}&nacimiento=${fechaNa}&rfc=${rfc}&inicio=${inicio}&color=${color}&placa=${placa}&telefono=${telefono}&nacionalidad=${nacionalidad}&numero=${numero}&colonia=${colonia}&cotizacion=${cotizacion}&giro=${giro}&conducto=${conducto}&ocupacionC=${ocupacionC}&calle=${direccion}&paquete=${paquete}`;

 $.ajax({
 	type: 'POST',
 	url: url,
 	data: data,
 	dataType: 'html',

 	beforeSend: ()=>$('#cargar').show(),
 	complete: ()=>$('#cargar').hide(),
    success: (response)=>{

     if(response.indexOf('error') == -1)
      {
      	console.log(response);

         let btn = document.createElement('a');
         btn.download = 'poliza.pdf';
         btn.href = 'data:application/octet-stream;base64,' + response;
         btn.click();

      	swal({
    			title:'Exitosa',
    			text:'poliza generada',
    			type:'success',
    			showCancelButton: false,
    			confirmButtonColor: '#3085d6',
    			confirmButtonText: 'ACEPTAR'
    		}).then((result) =>{
    			if(result.value)
    			{
    				location.reload();
    			}
    		})
      }

      if(response.indexOf('error') == 0){

      	swal({
      		title:'Error',
      		text: response,
      		type: 'error',
      		showCancelButton: false,
      	    confirmButtonColor: '#3085d6',
    		confirmButtonText: 'ACEPTAR'
    		}).then((result) =>{
    			if(result.value)
    			{
    				
    			}
    		})
      }

    }

 })

 }
  //}
    	
    })

 function validateForm()
 {
 	let  validacion = $('#form-hdi').valid({

 		rules: {
 			typeCar: "required",
 	
 		},
 		message: {
 			typeCar: "Campo requerido",
 		},

 		errorElement: "span",
        errorClass: "help-inline-error"
 	});

 	if(validacion)
 	{
 		return true;
 	}else{

 		return false;
 	}
 }

	
</script>