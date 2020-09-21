<script type="text/javascript">
    var data_score = '<?php echo $this->session->idusuario; ?>';
</script>

<style>
	.btn1{
		background-color: rgba(255, 153, 51,.9);
		color: white;
    	margin: 10px;
	}
	.btn1:hover{
		color: white;
		background: rgba(255, 153, 51);
	}
	#loading{
		color:#b9936c;
		margin: 0px;
		padding: 0px;
		
	}
	#part2{
		display:none;
	}
	label{margin-top: 10px;}
	.help-inline-error{color:red;}
	#title{
		font-size: 16px;
		font-weight: bold;
		float: right;
		text-decoration: underline black;
	}

	#loading{
	    width: 150px;
	    height: 20px;
	    margin-left: 1%;
	}

	#write{
		width: 180px;
		height: 180px;
		float: right;
	}
	
</style>

   <div class="main-panel">
	<div class="content-wrapper">
		<div id="app">
			<div class="row">
				<div class="col-12 grid-margin">
					<div class="card">
						<div class="card-body">
							<h3><strong>Emitir póliza de autos</strong></h3>
							<!--<textarea class="form-control" style="width: 45%;
							                                      height: 80px;
							                                      display: block;
							                                      float: right;
							                                      margin-top: -72px;" id="xml"></textarea>-->
							    <input type="text" id="data" class="form-control" style="width: 30%;
							                                                             position: absolute;
							                                                             margin-top: -30px;
							                                                             margin-left: 730px;">
							<hr>
							<div class="row">
								<div class="col-md-12">
								<form name="basicform" id="basicform" method="POST" action="<?php echo base_url('latino/emitir')?>" enctype="multipart/form-data">
								<div class="frm" id="part1"> 
									<fieldset>
										<legend><div id="title">Parte 1 de 3</div></legend>
									<div class="row select" >
								        <div class= "col-md-3">
											<div class="form-group">
												<select class="form-control custom-select" id="listpackage" name="package" required>
													<option value=''>* Paquete</option>
													<option value="0">AMPLIA</option>
													<option value="1">LIMITADA</option>
													<option value="2">RESPONSABILIDAD CIVIL</option>
												</select>
												<span style="color:red;"><?php echo form_error('package');?></span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<select name='typepay' id="listPago" class="custom-select form-control" required>
													<option value=" ">* Selecionar forma de pago</option>
													<option value="0">ANUAL</option>
												    <option value="1">SEMESTRAL</option>
												    <option value="2">TRIMESTRAL</option>
												    <option value="3">MENSUAL</option>
												</select>
												<span style="color:red;"><?php echo form_error('typepay');?></span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<select name="state" id="listastate" class="form-control custom-select" required>
													<option value=" ">* Seleccionar estado</option>
												</select>
												<span style="color: red;"><?php echo form_error('state')?></span>
											</div>
										</div> 

										<div class="col-md-3">
											<div class="form-group">
                                             <select name="year" id="listyear" class="form-control custom-select" required>
                                             	<option value=" ">* Seleccionar año</option>
                                             </select>
                                             <span style="color: red;"><?php echo form_error('year'); ?></span>
											</div>

										</div>

										<img src="<?php echo base_url('assets/images/30.gif')  ?>" id="loading"> 
								 </div>

								 

								 <div class='row'>
								 <div class="col-md-12">
												<div class="form-group	">
													<select name="marca" id="listamarca" class="form-control custom-select" required>
														<option selected='' default selected>* Seleccionar Marca</option>
													</select>
													<span style="color: red;"><?php echo form_error('marca');?></span>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<select name="submarca" id="listasubmarca" class="form-control custom-select" required>
                                                        <option value='' >* Seleccionar Modelo</option>
													</select>
													<span style="color: red;"><?php echo form_error('submarca');?></span>
												</div>
											</div>
											</div>

											<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<select name="descripcion" id="listdescripcion" class="form-control custom-select" required>
                                                        <option value='' >* Seleccionar Descripcion</option>
													</select>
													<span style="color: red;"><?php echo form_error('descripcion');?></span>
												</div>
											</div>
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<select name="descuento" id="listDescuento" class="form-control custom-select">
															<option value="">* Seleccionar Descuento</option>
														</select>
														<span style="color: red;"><?php echo form_error('descuento');?></span>
													</div>
												</div>

									</div>
									<div class="row">
                                        <div class="form-group">
                                    	<div class="col-md-3">
                                    		<button type="button" class="btn btn1 next" style="transition: 1s;" id="cotizar">Siguinete <i class="fa fa-arrow-right"></i></button>
										</div>
										</div>

										</div>
                                          
									</fieldset>
								</div>

                           <!--- parte 2 -->

								<div class="frm" id="part2">
									<legend><div id="title">Parte 2 de 3</div></legend>
									<fieldset>
										<br>
									<h5><i class="fa fa-user"></i> Datos del asegurado</h5>
									<div class="row">

										<div class="col-md-4">
											<div class="form-group">
												<input type="text" class="form-control" name="nombre" id="nombre" placeholder=" * Nombres" required>
												<span style="color: red;"><?php echo form_error('nombre');?></span>
											</div>
										</div>

										<div class="col-md-3">
											 <div class="form-group">
												<input type="text" name="apellidop" id="apellidop" class="form-control" placeholder=" * Apellido paterno" required>
												<span style="color: red;"><?php echo form_error('apellidop');?></span>
											</div>
											</div>

										<div class="col-md-3">
											<div class="form-group">
												<input type="text" name="apellidom" id="apellidom" class="form-control" placeholder=" * Appelido materno" required>
												<span style="color: red;"><?php echo form_error('apellidom');?></span>
											</div>
										</div>

										<div class="col-md-2">
											<div class="fomr-group">
											<input type="text" name="rfc" id="rfc" class="form-control" placeholder="* RFC" required>
											<span style="color: red;"><?php echo form_error('rfc');?></span>
											</div>
										</div>

							
								</div>

									<div class="row">

										<div class="col-md-4">
											<div class="from-group">
											<input type="date" name="fechanacimiento" id="fechanacimiento" class="form-control" required>
											<span style="color: red;"><?php echo form_error('fechanacimiento');?></span>
											</div>
									    </div>

										<div class="col-md-3">
											<div class="form-group">
											<select name="genero" id="genero" class="custom-select form-control" required>
												<option value="">GENERO</option>
												<option >Hombre</option>
												<option >Mujer</option>
											</select>
											<span style="color: red;"><?php echo form_error('genero');?></span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
											<input type="email" name="email" id="email" class="form-control" placeholder="Correo" >
											<span style="color: red;"><?php echo form_error('email');?></span>
											</div>
										</div>

										<div class="col-md-2">
											<div class="form-group">
											<input type="text" name="tel" id="tel" class="form-control" placeholder=" Telefono" required>
											<span style="color: red;"><?php echo form_error('tel');?></span>
											</div>
										</div>


									</div>

									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" id="direccion" name="direccion" class="form-control" placeholder="Calle" required>
												<span style="color: red;"><?php echo form_error('direccion');?></span>
											</div>
										</div>

										<div class="col-md-2">
											<div class="form-group">
												<input type="number" name="numero" id='numero' class="form-control"  required>
												<span style="color: red;"><?php echo form_error('numero');?></span>
											</div> 
										</div>

										<div class="col-md-2">
											<div class="form-group">
												<input type="text" id="codigoPostal" name="codigoPostal" class="form-control" placeholder="Codigo postal" required>
												<span style="color: red;"><?php echo form_error('codigoPostal');?></span>
											</div>
										</div>

										<div class="col-md-3">
											<div class="form-group">
												<select class="custom-select form-control" name="colonia" id="colonia" required="">
													<option value="">Selecciona Colonia</option>
												</select>
												<span style="color: red;"><?php echo form_error('colonia');?></span>
											</div>
										</div>	
									   <!--	<div class="col-md-4">
											<div class="form-group">
												<input type="date" >
											</div>
										</div>-->
									</div>

									<br>
									<h5>
										<i class="fa fa-car fa-1x"></i>
										Informacion de vehículo 
									</h5>

									<div class="row">

										<div class="col-md-4">
											<div class="form-group">
											<input type="text" id="serie" name="serie" class="form-control" placeholder="Serie de vihículo" required>	
											<span style="color: red;"><?php echo form_error('serie');?></span>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<input type="text" id="placa" name="placa" class="form-control" placeholder="Placas" required>
												<span style="color: red;"><?php echo form_error('placa');?></span>
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<input type="text" id="numeroMotor" name="numeroMotor" class="form-control" placeholder="Numero del Motor" required>
												<span style="color: red;"><?php echo form_error('numeroMotor');?></span>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<input type="text" id="conductor" name="conductor" class="form-control" placeholder="Nombre del conductor" required>
												<span style="color: red;"><?php echo form_error('conductor');?></span>
											</div>
										</div>
									</div>

									<button type="button" class="btn btn1  back" >
										<i class="fa fa-arrow-left"></i>
										Anterior
									</button>
									<button type="submit" class="btn btn-primary emitir" >
                                         Emitir
										<i class="fa fa-pencil" ></i>
									</button>

									<img src="<?php echo base_url('assets/images/load.gif')  ?>" id="write"> 

									<input type="text" name="camposPoliza" id="camposPoliza" class="form-control" style="
										width: 13%;
							            position: absolute;
							            margin-left: 550px;">

							            <input type="text" name="cliente" id="cliente" class="form-control" style="width: 13%;">

									</fieldset>
								</div>
									</form>
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
				<a href="http://www.proteges.mx" target="_blank">Proteges</a>. Todos los derechos reservados.
			</span>
			<span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Departamento de Sitemas
				<i class="fa fa-code text-danger"></i>
			</span>
		</div>
		</footer>
	</div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/js/latino/peticiones.js'); ?>"></script>

<script>
jQuery().ready(function () {

	var v =  $("#basicform").validate({

		rules:{
			package: "required",
			typepay: "required",
			state: "required",
			year: "required",
			marca: "required",
			submarca : "required",
			descripcion: "required",
			nombre: "required",
			apellidop: "required",
			apellidom: "required",
			fechanacimiento: "required",
			genero: "required",
			direccion: "required",
			colonia: "required",
			serie: "required",
			placa: "required",
			numero: "required",
			numeroMotor:  "required",
			conductor: "required",
			codigoPostal: {
               required: true,
               digits:  true,
               maxlength: 5,
               minlength: 5
			},
			rfc: {
				required: true,
				maxlength: 13,
				minlength: 10
			},
			email: {
				email: true
			},
			tel: {
              required: true,
              digits: true,
              maxlength: 10,
              minlength: 10
			},


		},
		messages: {
			package: "Campo requerido",
			typepay: "Campo requerido",
			state: "Campo requerido",
			year: "Campo requerido",
			marca: "Campo requerido",
			submarca : "Campo requerido",
			descripcion: "Campo requerido",
			nombre: "Campo requerido",
			apellidop: "Campo  requerido",
			apellidom: "Campo  requerido",
			fechanacimiento: "Campo requerido",
			genero: "Campo  requerido",
			direccion: "Campo requerido",
			colonia: "Campo requerido",
			serie: "Campo requerido",
			placa: "Campo  requerido",
			numeroMotor: "Campo requirido",
			conductor: "Campo requerido",
			numero: "Campo requerido",

			codigoPostal:{
              required: "Campo requerido",
              digits: "Solo números",
              maxlength: "5 digitos",
              minlength: "5 digitos"
			},
			rfc:{
				required: "Campo requirido",
				maxlength: "13 caracteres",
				minlength: "13 caracteres"
			},
			email:{
				email: "correo invalido"
			},
			tel:{
				required: "Campo requerido",
				digits: "Solo números",
				maxlength: "10 digitos",
				minlength: "10 digitos"
			}
		},
		errorElement: "span",
		errorClass: "help-inline-error",
	});

// next
	$(".next").click(function () {
            if (v.form()) {
                $(".frm").hide('fast');
                $("#part2").show('slow');
            }
        });

	$(".emitir").click(function(){
		 if(v.form()){
		 	$('#loader').show();
		 }
	})


	// back
	$('.back').click(function(){
		$('.frm').hide('fast');
		$('#part1').show('slow');
	})


});
</script>




	
