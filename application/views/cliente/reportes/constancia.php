<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Constancia de recepción de póliza</title>
	<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39+Text&display=swap" rel="stylesheet">
	<style type="text/css">
		body{
			margin: 0;
			padding: 0;
            font-family: 'Gadugi','Calibri'; 
            font-size: 12px;
          	background: url('assets/images/background.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
       		}

			.contenedor{
       		 width: 100vh;
       		 height: 90px;

       		}

		.contenedor img:first-child{
			position: absolute;
			float: left;
			width: 150px;
			height: 66px;
		}

		.contenedor h3{
			margin-right: auto;
			margin-left: auto;
			text-align: center;
			width: 350px;
			margin-bottom: 30px;
			font-size: 15px;
		}
		.contenedor span{
			position: absolute;
			margin-left: 450px;
			top: 60px;
			font-size: 12px;
		}
		h4{
			margin-top: 2px;
			background: #d4d4d4;
			text-align: center;
			height: 20px;
			border:solid #a6a6a6;
		}

		#poliza{
			margin-left:610px;
			font-family: Arial;
			font-weight: bold;
			font-size: 13px;
		}

		#title1{
			margin-top: 50px;

			border: solid #a6a6a6;
		}


		#left{			
			float: left;
			width: 50%;
			position: absolute;
			top: 125px;
		}


		#left span, #right span{
			text-align: justify;
			position: absolute;
			left: 70px;
		}

		#municipio1 {
			margin-left: 125px;
		}

		#right{
			float: right;
			margin-right: 65px;
			width: 40%;
			position: absolute;
			top: 125px;
			}

		.contenedor1{
			margin-top: -10px;
		}

		#municipio{
			margin-left: 450px;
		}

		#municipioSpan{
			margin-left: 400px;
		}

		.contenedor1 span{
			text-align: justify;
			position: absolute;
			left: 180px;
		}

		#title2{
			margin-top: 10px;
		}	
		.contenedor2{
			margin-top: -17px;
		}

		#lblLeft{
			float: left;
			width: 55%;
		}

	
		.contenedor2 span{
			text-align: justify;
			margin-left: 50px;
		}


		.contenedor3{
			margin-top: -13;
		}
		#title3{
			margin-top: 30px;
		}

		}
        .contenedor3 span{
        	position: absolute;
        	margin-left:400px;
        }
	     
	     #title4{
	     	margin-top: 10px;
	     }

		.contenedor4{
			margin-top: -7;
		}
		.fecha {
			float: left;
			width: 20%;
			text-align: center;
		}
		.motivo{
			float: left;
			width: 19%;
			text-align: center;
		}
		.observaciones{
			float: right;
			width: 60%;
			text-align: center;
		}


	</style>
</head>
<body>

	<div class="contenedor">
		<img src="assets/images/logoproteges.png">
		<h3>CONSTANCIA DE RECEPCIÓN DE PÓLIZA</h3>
		<span><?php echo $data[0]['fechaActual']; ?></span>
		<span id="poliza"><?php echo $data[0]['noPoliza'];?></span>
	</div>


	<h4>CLIENTE DEL DECUENTO</h4>
	<div id="left">
	<label>NOMBRE: </label><span><?php echo $data[0]['responsable'];?></span><br>
	<label>DOMICILIO: </label><span><?php echo $data[0]['domicilio'];?></span><span></span><br>
	<label>COLONIA: </label><span><?php echo $data[0]['colonia'];?></span>
	</div>

	<div id="right">
	<label>EMAIL: </label><span><?php echo $data[0]['email'];?></span><br>
	<label>C.P:</label><span><?php echo $data[0]['cp'];?></span><span id="municipio1">MUNICIPIO:<?php echo $data[0]['municipio'];?></span><br>
	<label>TELEFONO: </label><span><?php foreach($data as $key => $value){
		                                             if($key < 2){
                                                        echo $value['telefono'].'<br>';		                                             	
		                                             }
                                             
	                                }?></span>
	</div>


	<h4 id="title1"><label>CENTRO DE TRABAJO</label></h4>
	<div class="contenedor1">
	<label>CVE CENTRO DE TRABAJO: </label><span><?php echo $data[0]['clave'];?></span><br>
	<label>NOMBRE: </label><span><?php echo $data[0]['lugar'];?></span><br>
	<label>DOMICILIO: </label><span><?php echo $data[0]['domicilioCentro'];?></span><br>
	<label>COLONIA: </label><span><?php echo $data[0]['colonia'];?></span><label id="municipio">MUNICIPIO </label><span id="municipioSpan"><?php  echo $data[0]['municipio'];?></span><br>
	<label>DEPARTAMENTO: </label><span><?php echo $data[0]['departamento'];?></span><br>
	<label>TELEFONO DEPARTAMENTO:</label><span><?php echo $data[0]['telefonodepart'];?></span>
    </div>

	<h4 id="title2">DATOS DE LA PÓLIZA</h4>
	<div class="contenedor2">
     <p>RECIBI DE PROTECCION GENERAL EN SEGUROS LA PÓLIZA DEL SEGURO DE GMM</p>

    <div id="lblLeft">
	<label>COMPAÑIA: </label><span><?php echo $data[0]['compania'];?></span><br>
	<label>DESCUENTO: </label><span style="margin-left: 40px;"><?php echo $data[0]['tarifa'];?></span><br>
	<label>TITULAR: </label><span style="margin-left: 60px;"><?php echo $data[0]['irresponsable'];?></span><br>
	<label>VENDEDOR: </label><span style="margin-left: 45px;"><?php echo $data[0]['colonia'];?></span>
	</div>

	<div id="lblRight">
	<label>VIGENCIA:</label><span style="margin-left: 90px;"><?php echo $data[0]['vigencia'];?></span><br>
	<label>CVE. DE DESC:</label><span style="margin-left: 69px;"><?php echo $data[0]['clave'];?></span><br>
	<label>CONTRATANTE-CLAVE:</label><span style="margin-left: 15px;"><?php echo $data[0]['contratante'];?></span>
	</div>

	

	</div>

	<h4 id="title3">PARA SER LLENADO POR QUIEN RECICE LA PÓLIZA</h4>
	<div class="contenedor3">
	 <span> </span>	
	<label>NOMBRE & FRIMA: </label><hr><span> </span>
	<label>DOMICILIO: </label><hr><span>C.P: </span>
	<label>COLONIA: </label><hr><span>EMAIL:</span>	
	<label>TELEFONO: </label><hr><span>TELEFONO DEL C.T:</span>	
	<label>CVE DE CENTRO DE TRABAJO: </label><hr><span><input type="radio">IFE
	                                                   <input type="radio">LICENCIA</span>
	<label>FECHA Y MUNICIPIO DE ENTREGA: </label><hr><span> </span>
	<label>NOMBRE Y FIRMA DEL REPARTIDOR: </label><hr>
	</div>


	<h4 id="title4">PARA EL CONTROL DEL DEPARTAMENTO DE REPARTO DE POLIZAS</h4>
	<div class="contenedor4">	
	<div class="fecha">
		<label>FECHA</label>
		<hr><span> </span><br>	
		<hr><span> </span><br>	
		<hr><span> </span><br>	
		<hr>			
	</div>
	<div class="motivo">
	<label>*MOTIVO</label>
	<hr><span> </span><br>	
	<hr><span> </span><br>	
	<hr><span> </span><br>	
	<hr>					
	</div>

	<div class="observaciones">
	<label>OBSERVACIONES</label>
	<hr><span> </span><br>	
	<hr><span> </span><br>	
	<hr><span> </span><br>	
	<hr>				
	</div>

	</div>



</body>
</html>