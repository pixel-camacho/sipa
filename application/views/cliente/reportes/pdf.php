<html>
<head>
       <title>Documento</title>
</head>

<style type="text/css">

	#texto{
		padding-bottom: 15px;
		text-align: right;
		font-family: Arial;
		font-size: 14px;
	}
	body{

		 margin: 0;	
		 background-size: 20%;
		 background-image: url('assets/images/background.png');
		 background-repeat: no-repeat;
		 background-position: center;
		 background-size: cover;
	}

	.cliente{
		font-family: verdana;
		font-size: 14px;
		line-height: .5px;
	}

	.informacion p{
		text-align: justify;
		font-family: Arial;
		font-size: 15px;
		line-height: 12px;
		margin-top: 7px;
		text-indent: 55px;
	}

	table, th, td{
		border: 1px solid black;
	}
	table{

		margin-top: 15px;
		border-collapse: collapse;	
	    margin-left: 40px;
	    font-family: Times new Roman;
	    font-size: 12px;
	}

    th{
    	background-color: #b4b4b4;
    	text-align: center;
    	width: 250px;
    }
    p{
    	text-align: justify;
    	font-family: Arial;
    	font-size: 15px;
    	margin-top: 20px;
    }
    .panel{
    	width: 100%;
    	height: 200px;
    }
    .left{

    	position: relative;
    	float: left;
    	width: 50%;
    	height: 50%;
    }

 .left img
 {
 	margin-top: 35px;
 	margin-left: 75px
 }

 .left span
 {
 	float: left;
 	margin-top: 85px;
 	margin-left: 90px;
 }
    .right{

    	text-align: center;
    	float: right;
    	width: 50%;
    	height: 50%;
    }
    .right hr{
    	margin-top: 60px;
    }

    .container{
    	width: 100%;
    	height: 75px;
    }
    #left{
    	float: left;
    	width: 25%;
    	height: 75px;
    }

    #right{
    	float: right;
    	width: 75%;
    	height: 75px;
    }

    #right hr{
    	border: none;
    	margin-top: 37.5px;
    	height: 4px;
    	background-color:#B22222; 
    }
    * {
  box-sizing: border-box;
}

/*
    .clearfix{
    	content: "";
    	clear: both;
    	display: table;
    }
    .box{
    	float: left;
    	width: 33.34%;
    	background-color: #B22222;
    	height: 60px;
    	color: white;
    }*/
 
</style>
<body>

	<div class="container">
       
       <div id="left">
		<img class="img" src="assets/images/logoproteges.png"/>
		</div>

		<div id="right">
			<hr>
		</div>
		
	</div>
<div id="content">
	<div id="texto"><strong><?php echo $municipio;?>,</strong> Baja California a <?php echo $hoy;?></div>
<div class="body">
<div class="cliente">
	<p>Cliente del descuento: <strong><?php echo $responsable;?></strong></p>
	<p>Asegurado(s): ------ <strong><?php echo $asegurado;?></strong></p>
	<p>Póliza: <strong><?php echo $noPoliza; ?></strong> Certificado:<strong> <?php echo $certificado; ?></strong></p>
	<p>Vigencia: <strong><?php echo $inicio; ?><?php echo $fin; ?></strong></p>
	<p>Antigüedad: <strong><?php echo $antiguedad; ?></strong></p>
</div>

<div class="informacion">
	<p>Estimado Asegurado, con el placer de saludar e informarle que en beneficio suyo y de sus dependientes,
	   hemos decidido respaldar el seguro  de Gastos Médicos Mayores, nuevamente con la Cía. La latino Seguros.
	   con efecto a partir  del día 1ro de febrero del presente año, sustituyendo el Seguro que tenía contratado
	   anteriormente con Aseguradora Sisnova.
	</p>
	   <p>
	   	La Latino Seguros, S.A. es una aseguradora Mexicana con más de 114 años en el medio, de las más antiguas
	   	del país quien con el compromiso de fortalecer el proceso de atención Médica y Hospitalaria, dando respuesta
	   	oportuna a sus trámites de programación de Cirugías y tramite de reembolsos, con una clara red de Médicos y 
	   	Hospitales de la regíon y a nivel nacional. 
	   </p>
	   <p>
	   	En esta transferencia quedan protegidos aspectos importantes como antigüedad de su póliza, las
	   	preexistencias que pudiera tener y los pagos de complementos para los asegurados que ya se estaban tratando de
	   	algún padecimiento hasta agotar la suma contratada.
	   </p>
 </div>
 	    <table>
 		<thead>
 			<tr>
 				<th>Conceptos Generales</th>
 				<th>La Latino Seguros, S.A.</th>
 			</tr>
 		</thead>
 		<tbody>
 			<tr>
 			<td>Tipo de póliza</td>
 			<td>Individual</td>
 			</tr>
 			<tr>
 			<td>Suma Asegurada</td>
 			<td><?php echo $suma; ?></td>
 			</tr>
 			<tr>
 			<td>Pago director a Hospitales de Red</td>
 			<td>Nivel hospitalario <?php echo $nivel; ?></td>
 			</tr>
 			<tr>
 				<td>Reembolsos</td>
 				<td>15 díás</td>
 			</tr>
 			<tr>
 				<td>Programacíon de Cirugías</td>
 				<td>5 a 8 días</td>
 			</tr>
 			<tr>
 				<td>Deducible</td>
 				<td>$8,000</td>
 			</tr>
 			<tr>
 				<td>Coaseguro</td>
 				<td>5%</td>
 			</tr>
 			<tr>
 				<td>Reduccíon de deducibles con atencíon
 				    médicos y hospitales de red
 				</td>
 				<td>$4,000.00</td>
 			</tr>
 			<tr>
 				<td>Maternidad</td>
 				<td>$40,000.00</td>
 			</tr>
 			<tr>
 				<td>Consultas</td>
 				<td>Asistenciadora</td>
 			</tr>
 			<tr>
 				<td>Emergencia en el extranjero</td>
 				<td>$50,000.00 dlls (reembolso 7 días)</td>
 			</tr>
 			<tr>
 				<td>Honorarios Quirúrgicos</td>
 				<td><?php echo $honorario; ?></td>
 			</tr>
 		</tbody>	
 	</table>
 	<p>
 	  En Asesores Proteges nos preocupamos en buscar siempre las mejores opciones de seguros que garanticen
 	  otorgar los beneficios contratados, si tiene alguna duda comunícarse a los teléfonos <b><?php echo $telefono; ?></b>
 	  donde con gusto le atenderemos.
 	</p>

     <div class="panel">
    <div class="left" >
 	<img src="assets/images/firma.png"> 
 <!--	<hr width="250px;"> -->
 	<span>Asesores Proteges</span>
 	</div>

 	<div class="right">
 	<label >Conocimiento y Aceptacíon</label>
 	<hr width="300px">
 	<span><?php echo $responsable; ?></span>
 	</div>
 	</div>
<!--
 	<footer>
 		<div class="clearfix">
 			<div class="box">
 				<p style="text-align: center;">Tijuana</p>
 			</div>
 			<div class="box">
 				<p>Mexicali</p>
 			</div>
 			<div class="box">
 				<p>Ensenada</p>
 			</div>
 			
 		</div>
 	</footer> -->

</div>
</div>
</form>
</body>
</html>