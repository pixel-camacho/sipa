<div class="main-panel">
	<div class="content-wrapper">
		<div id="app">
			<div class="row">
				<div class="col-12 grid-margin">
					<div class="card">
						<div class="card-body">
							<h3><strong>Emision de pólizas HDI</strong></h3>
							<input type="text" name="campo" id="campo" class="form-control" style="width: 20%; float: right; margin-top: -30px;">
							<hr>
							<div class="row">
								<div class="col-md-12">
									<strong><i class="fa fa-car"> </i><label>Datos de vehículo</label></strong>
									<form name="form-hdi" id="form-hdi" method="POST" 
									      action="<?php echo base_url('Hdi/emitir')?>" 
									      enctype="multipart/form-data">
									      <fieldset>
									      	<div class="row">
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="typeCar" name="typeCar">
									      					<option value="">* Selecciona</option>
									      				</select>
									      			</div>
									      		</div>
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listYear" name="year">
									      					<option value="">* Seleciona Año</option>
									      					<?php for($i = 1990; $i < 2020; $i++ ) { 
                                                                echo "<option value='".$i."'>".$i."</option>";
                                                            }
									      					?>
									      				</select>
									      			</div>
									      		</div>
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listBrand" name="brand">
									      					<option value="">* Selecciona Marca</option>
									      				</select>
									      			</div>
									      		</div>
								
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listSubBrand" name="subBrand">
									      					<option value="">* Selecciona Submarca</option>
									      				</select>
									      			</div>
									      		</div>
									          </div>
									      	<img src="<?php echo base_url('assets/images/load/30.gif')  ?>" id="loading">
                                       
									      	<div class="row">
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listVersion" name="version">
									      					<option value="">* Selecciona Version</option>
									      				</select>
									      			</div>
									      		</div>
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listTransmision" name="transmision">
									      					<option value="">* Selecciona Trasmision</option>
									      				</select>
									      			</div>
									      		</div>
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listModel" name="model">
									      					<option value="">* Selecciona Model</option>
									      				</select>
									      			</div>
									      		</div>
									      		<div class="col-md-3">
									      			<div class="form-group">
									      				<input type="text" id="serie" class="form-control"  placeholder="Ingres numero de Serie">
									      				<!--<select class="custom-select form-control" id="listDescripcion" name="descripcion">
									      					<option value="">* Selecciona Descripcion</option>
-->									      				</select>
									      			</div>
									      		</div>
									      	</div>

                                             <br>
									      	<div class="row">
									      		<div class="col-md-12"><strong><i class="fa fa-file"> </i><label>Informacion General</label></strong></div>
									      		<div class="col-md-4">
									      			<div class="form-group">	
									      			<select class="custom-select form-control" id="listEstado" name="estado">
									      				<option value="">* Selecciona Estado</option>
									      			</select>
									      			</div>
									      		</div>
									      		<div class="col-md-4">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listCiudad"
									      				name="ciudad">
									      				<option value="">* Selecciona Ciudad</option>
									      					
									      				</select>
									      			</div>
									      		</div>
									      		<div class="col-md-4">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="listPago"
									      				name="pago">
									      				<option value="">* Selecciona Tipo pago</option>
									      				</select>
									      			</div>
									      		</div>
									      	</div>
									      	<div class="row">
									      		<div class="col-md-4">
									      			<div class="form-group">
									      			 <select class="custom-select form-control" id="listTipoPago">
									      			 	<option value="">* Seleccionar</option>
									      			 </select>
									      			</div>
									      		</div>
									      		<div class="col-md-4">
									      			<div class="form-group">									      		<select class="custom-select form-control" id="listServicios">
									      				<option value="">* Selecciona Servicio</option>
									      			    </select>
									      			</div>
									      		</div>
									      		<div class="col-md-4">
									      			<div class="form-group">
									      				<select class="custom-select form-control" id="cp">
                                                            <option value="">*  Selecciona codigo postal</option>	

                                                            <?php
                                                                foreach($datacolonia as $value)
											                    {
                                                                   echo "<option value='$value->cp'>$value->cp $value->nombrecolonia</option>";
											                    }
                                                            ?>			
									      				</select>
									      			</div>
									      		</div>
									      	</div>

									      	<br>
									      	<div class="row">
									      		<div class="col-md-12">
									      			<strong><i class="fa fa-user"></i> <label>Informacion de asegurado</label></strong>
									      		</div>
									      			<div class="col-md-3">
									      				<div class="form-group">
									      				 <input type="text" id="nombre" class="form-control" placeholder="Nombre">
									      				</div>
									      			</div>
									      			<div class="col-md-3">
									      				<div class="form-group">
									      				 <input type="text" id="apPaterno" class="form-control" placeholder="Apellido paterno">
									      				</div>
									      			</div>
									      			<div class="col-md-3">
									      				<div class="form-group">
									      				 <input type="text" id="apMaterno" class="form-control" placeholder="Apellido materno">
									      				</div>
									      			</div>
									      			<div class="col-md-3">
									      				<div class="form-group">
									      				 <input type="text" id="rfc" class="form-control" placeholder="RFC">
									      				</div>
									      			</div>
									      	</div>
									      	<br>
									      	<div class="row">
									      		<div class="col-md-12">
									      		 <button class="btn btn-primary" type="submit" id="cotizar" style="display: block; margin-left: auto; margin-right: auto; width: 20%;">
									      		 	Cotizar
									      		 </button>								      			
									      		</div>
									      	</div>
									      </fieldset>
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



<script type="text/javascript" src="<?php echo base_url('assets/js/hdi/request.js')?>"></script>

<script type="text/javascript">
	$(document).ready(()=>{
         


		$('#listModel').change(()=>{

 let url      = 'http://190.9.53.22:8484/sipa/Hdi/getDescripcion';
 let tipo     = $('#typeCar').find('option:selected').val();
 let marca    = $('#listBrand').find('option:selected').val();
 let submarca = $('#listSubBrand').find('option:selected').val();
 let version  = $('#listVersion').find('option:selected').val();
 let transmision = $('#listTransmision').find('option:selected').val();
 let modelo   = $('#listModel').find('option:selected').val();

 let data = `tipo=${tipo}&marca=${marca}&submarca=${submarca}&version=${version}&transmision=${transmision}&modelo=${modelo}`;

 $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'json',

        beforeSend: ()=> $('#loading').show(),
        complete: ()=> $('#loading').hide(),
        success: (response)=>{

        	$('#campo').append(response);
        	$('#campo').val(response);
        }
      });
});

    $('#cotizar').click((e)=>{
         e.preventDefault();

 let url      = 'http://190.9.53.22:8484/sipa/Hdi/setPaquete';
 let tipo     = $('#typeCar').find('option:selected').val();
 let marca    = $('#listBrand').find('option:selected').val();
 let submarca = $('#listSubBrand').find('option:selected').val();
 let version  = $('#listVersion').find('option:selected').val();
 let transmision = $('#listTransmision').find('option:selected').val();
 let modelo   = $('#listModel').find('option:selected').val();
 let serie    = $('#serie').val();
 let ciudad   = $('#listCiudad').find('option:selected').val();
 let estado   = $('#listEstado').find('option:selected').val();
 let servicio = $('#listServicios').find('option:selected').val();
 let tiposuma = $('#listTipoPago').find('option:selected').val();
 let cp       = $('#cp').find('option:selected').val();
 let data     = `tipo=${tipo}&marca=${marca}&submarca=${submarca}&version=${version}&transmision=${transmision}&modelo=${modelo}&serie=${serie}&ciudad=${ciudad}&estado=${estado}&servicio=${servicio}&tiposuma=${tiposuma}&cp=${cp}`;

  $.ajax({
        type: 'POST',
        url: url,
        data: data,
        dataType: 'json',

        beforeSend: ()=> $('#loading').show(),
        complete: ()=> $('#loading').hide(),
        success: (response)=>{

                 
        }
      });


	
    })


	})
</script>