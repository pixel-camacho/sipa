<!DOCTYPE html>
<html>
<head>
	<title>Zurch</title>
</head>
<style type="text/css">
	#part{
		font-size: 16px;
		font-weight: bold;
		float: right;
		text-decoration: underline black;
	}
</style>
<body>
	<div class="main-panel">
		<div class="content-wrapper">
			<div class="row">
				<div class="col-12 margin-grid">
					<div class="card">
						<div class="card-body">
							<h3><strong>Emitir póliza de autos Zurich</strong></h3>
							<hr>
							
							<div class="row">
								<div class="col-md-12">
									<form name="form-zurich" id="form-zurich" method="POST" action="<?PHP echo base_url('Zurich/emitir');?>" enctype="multipart/form-data">
										<div class="form" id="paso1">
											<fieldset>
												<legend><div id="part">Paso 1  de 3</div></legend>
                                                 
                                                 <div class="row">
                                                 	<div class="col-md-4">
                                                 		<div class="form">
                                                 			
                                                 		</div>
                                                       <select class="custom-select form-control" name="car" id="car">
													           <option value="">* Tipo de vehículo</option>
													           <option value="0">Automóvil</option>
													           <option value="1">Camión ligero</option>
												       </select>
                                                 	</div>

                                                 	<div class="col-md-4">
                                                 		<select class="custom-select form-control" name="paquete" id="paquete">
                                                 			<option value="">* Selecciona paquete</option>
                                                 		</select>
                                                 	</div>

                                                 	<div class="col-md-4">
                                                 		<select class="custom-select form-control" name="uso" id="uso">
                                                 			<option value="">* Seleciona tipo de Uso</option>
                                                 			<option value="1">Uso Particular Servicio Privado</option>
                                                 			<option value="2">Uso Comercial Servicio Transporte Merc.</option>
                                                 		</select>
                                                 	</div>
                                                </div>
                                                <div class="row">
                                                	<div class="col-md-4">
                                                 		<select class="custom-select form-control" id="tipovalor" name="tipovalor">
                                                 			<option value="">* Tipo de valor</option>
                                                 			<option value="2">Valor Comercial+10%</option>
                                                 			<option value="6">Valor Convenido Autos Residentes</option>
                                                 			<option value="7">Valor Comercial Autos Residentes</option>
                                                 		</select>
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

</body>
</html>