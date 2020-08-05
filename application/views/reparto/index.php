<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Confirmacion de reaparto</title>
	<link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital@1&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Notable&display=swap" rel="stylesheet">
	<style type="text/css">

		body{ font-family: 'Roboto Condensed',sans-serif;}
		.p1{
       box-shadow: 2px 2px 5px #999;
       border-radius: 15px;
    }

    .t1{
    	font-weight: bold;
    	font-size: 25px;
    }

    .input-group, #destinatario{
    	width: 90%;
    	margin-right: auto;
    	margin-left: auto;
    }

    .btn{
    	background-color: rgba(255, 153, 51,.9);
    	margin: 10px;
    	width: 30%;
    	height: 30%;
    	display: block;
    	margin-left: auto;
    	margin-right: auto;
    	font-size: 17px;
    }

   #title{ margin-left: 20px;}

   .help-inline-error{color:red;}


	</style>
</head>
<body>
	<div class="main-panel">
		<div class="content-wrapper">
			<div class="row">
				<div class="col-md-12 grid-margin">
					<div class="card">
						<div class="card-body">
							<h3><strong><i class="fa fa-motorcycle"></i>Reparto</strong></h3>
							<hr>
							<div class="row">
								<div class="col-md-6 mx-auto my-3">
									<div class="card p1">
										<div class="card-header text-center t1">Asignación de Reparto</div>
										<div class="card-body">
										<form method="POST" action="<?php echo base_url('Reparto/repartoFile'); ?>" id="form-reparto" role="form" enctype="multipart/form-data">
										<div class="input-group mb-3">
											<div class="input-group-prepend">
												<span class="input-group-text" id="text-span">Cargar</span>
											</div>
											<div class="custom-file">
												<input type="file" name="input-text" id="input-text"  class="custom-file-input"  aria-describedby="text-span" required>
												<label class="custom-file-label" for="input-text" id="message">Seleccionar Documento...</label>	
											</div>
										</div>
										<input type="text" name="destinatario" id="destinatario" placeholder="Nombre del destinatario" class="form-control" required>
                                         <button id="enviar" class="btn">Asignar</button>
										</form>
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
	<script type="text/javascript">
		$(document).ready(()=>{
			$('#input-text').change(()=>{
              
             const filename = document.getElementById('input-text').files[0].name;
             document.getElementById('message').innerHTML = filename;     
			});
		});


	
	</script>
</body>
</html>