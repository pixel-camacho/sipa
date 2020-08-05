<script type="text/javascript">
    var data_score = '<?php echo $this->session->idusuario; ?>';
</script>

<style>
	.btn{
		background-color: rgba(255, 153, 51,.9);
		color: white;
    	margin: 10px;
	}
	.btn:hover{
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
	
</style>

   <div class="main-panel">
	<div class="content-wrapper">
		<div id="app">
			<div class="row">
				<div class="col-12 grid-margin">
					<div class="card">
						<div class="card-body">
							<h3><strong>Emitir póliza de autos</strong></h3>
							<hr>
							<div class="row">
								<div class="col-md-12">
								<form name="basicform" id="basicform" method="POST" action="<?php echo base_url('latino/emitir')?>" enctype="multipart/form-data">
								<div class="frm" id="part1"> 
									<fieldset>
										<legend><div id="title">Parte 1 de 4</div></legend>
									<div class="row select" >
								        <div class= "col-md-4">
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
										<div class="col-md-4">
											<div class="form-group">
												<select name="state" id="listastate" class="form-control custom-select" required>
													<option value=" ">* Seleccionar estado</option>
												</select>
												<span style="color: red;"><?php echo form_error('state')?></span>
											</div>
										</div>

									<!--	<div class="col-md-4">
											<div class="form-group">
												<select name="year" id="listyear" class="form-control custom-select" required>
													<option value=''>* Año</option>
													<?php
														 for($i = 2021; $i >= 1990; $i--)
														 {
															 echo "<option value='$i'>".$i."</option>";
														 }

													?>
												</select>
												<span style="color:red;"><?php echo form_error('year');?></span>
											</div>
										</div>-->
										<div class="col-md-4">
											<div class="form-group">
                                             <select name="year" id="listyear" class="form-control custom-select" required>
                                             	<option value=" ">* Seleccionar el año</option>
                                             </select>
                                             <span style="color: red;"><?php echo form_error('year'); ?></span>
											</div>

										</div>
								 </div>
								 <img src="<?php echo base_url('assets/images/load/30.gif')  ?>" id="loading">
								 <div class='row'>
								 <div class="col-md-12">
												<div class="form-group	">
													<select name="marca" id="listamarca" class="form-control custom-select" required>
														<option selected='' default selected>* Seleccionar Marca</option>
													</select>
													<span style="color:red;"><?php echo form_error('marca');?></span>
												</div>
											</div>
										</div>

										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<select name="submarca" id="listasubmarca" class="form-control custom-select" required>
                                                        <option value='' >* Seleccionar Modelo</option>
													</select>
													<span style="color:red;"><?php echo form_error('submarca');?></span>
												</div>
											</div>
											</div>

											<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<select name="descripcion" id="listdescripcion" class="form-control custom-select" required>
                                                        <option value='' >* Seleccionar Descripcion</option>
													</select>
													<span style="color:red;"><?php echo form_error('descripcion');?></span>
												</div>
											</div>
											</div>
											<div class="row">
										<div class="col-md-12">
										<div class="form-group">
										<select class="custom-select my-1" id="cp">
											<option value="">* Selecciona codigo postal</option>
											<?php
											  foreach($datacolonia as $value)
											  {
                                                 echo "<option value='$value->idcolonia'>$value->cp $value->nombrecolonia</option>";
											  }
											?>
										</select>
										</div>
										</div>
                                        <div class="form-group">
                                    	<div class="col-md-3">
                                    		<button type="button" class="btn next">Siguinete<i class="fa fa-arrow-right"></i></button>
										</div>
										</div>
									</fieldset>
								</div>

                           <!--- parte 2 -->

								<div class="frm" id="part2">
									<legend><div id="title">Parte 2 de 4</div></legend>
									<fieldset>
										<br>
									<h5><i class="fa fa-user"></i> Datos del Asegurado</h5>
									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" class="form-control" name="nombre" id="nombre" placeholder=" * Nombres" required>
											</div>
										</div>
										<div class="col-md-4">
											 <div class="form-group">
												<input type="text" name="apllidop" id="apellidop" class="form-control" placeholder=" * Apellido paterno" required>
											</div>
											</div>
										<div class="col-md-4">
											<div class="form-group">
												<input type="text" name="apellidom" id="apellidom" class="form-control" placeholder=" * Appelido materno" required>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-4">
											<div class="from-group">
											<input type="date" name="fechanacimiento" id="fechanacimiento" class="form-control" required>
											</div>
										</div>
										<div class="col-md-4">
											<div class="fomr-group">
											<input type="text" name="RFC" id="rfc" class="form-control" placeholder="* RFC" required>
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
											<select name="listgenero" id="listgenero" class="custom-select">
												<option value="">* GENERO</option>
												<option >Hombre</option>
												<option >Mujer</option>
											</select>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-md-4">
											<div class="form-group">
											<input type="text" name="correo" id="correo" class="form-control" placeholder="Correo">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
											<input type="text" name="cel" id="cel" class="form-control" placeholder="* Telefono">
											</div>
										</div>
										<div class="col-md-4">
											<div class="form-group">
												<select name="listocupacion" id="listocupacion" class="custom-select">
													<option value="">* OCUPACION</option>
													
												</select>
											</div>
										</div>
									</div>
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
			state: "required",
			year: "required",
			marca: "required",
			submarca : "required",
			descripcion: "required"
		},
		messages: {
			package: "Campo requerido",
			state: "Campo requerido",
			year: "Campo requerido",
			marca: "Campo requerido",
			submarca : "Campo requerido",
			descripcion: "Campo requerido",
			
			
		},
		errorElement: "span",
		errorClass: "help-inline-error",
	});

	$(".next").click(function () {
            if (v.form()) {
                $(".frm").fadeOut();
                $("#part2").fadeIn();
            }
        });

});
</script>




	
