<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Adjunto</title>
</head>

<!-- CONSTANCIA DE RECEPCIÓN DE PÓLIZA -->
<style type="text/css">
	.formato2{
       		width: 100vh;
       		height: 950px;
       	}

       	.conetedor00{
       		width: 100%;
       		height: 80px;
       	}


       	.formato2 img{
       		float: left;
       		width: 150px;
       		height: 66px;
       	}

       	.formato2 h3{
       		display: block;
       		margin-left: auto;
       		margin-right: auto;
       		text-align: center;
       		width: 300px;
       	}

       	#poliza{
       		margin-top: 10px;
       		float: right;
       		font-size: 13px;
       		font-weight: bold;
       		font-family: 'Arial';
       	}

        #fecha00{
        	margin-top: 0px;
        	margin-left: 300px;
        }

        .titulo, #titulo1, #titulo2, #titulo3, #titulo4{
        width: 100vh;
        background-color: #d4d4d4;
        text-align: center;
        height: 20px;
        border:solid #a6a6a6;
        }

       .titulo{
        	margin-top: 0px;
        }

        #titulo1{
        	margin-top: 50px;
        }

        #titulo2{
        	margin-top: 10px;
        }

        #titulo3{
			margin-top: 30px;
		}

		#titulo4{
			margin-top: 10px;
		}

        #left{			
			float: left;			
			width: 50%;
			position: absolute;
			top: 115px;
		}

		#right{
			float: right;
			width: 50%;
			position: absolute;
			top: 115px;
		}

		.contenedor1{
			margin-top: -10px;
		}

	    #municipio{
			margin-left: 100px;
		}

		#municipioSpan{
			margin-left: 5px;
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

		.contenedor3 span{
        	position: absolute;
        	margin-left:390px;
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
		    display: block;
		    margin-left: auto;
		    margin-right: auto;
			width: 18%;
			text-align: center;
			margin-left: 150px;
		}
		.observaciones{
			position: absolute;
			float: right;
			width: 60%;
			text-align: center;
			top: 0;
		}

		.formato2 #left span{
			margin-left: 75px;
		}

		.formato2 #right span{
			margin-left: 70px;
		}

		#deduccionTotal{
			position: absolute;
			width: 120px;
			height: 17px;
			margin-left: 240px;
			bottom: 425px;
			text-align: center;
		}

		.barcode{
			position: absolute;
			max-width: 170px;
			height: 50px;
			float: right;
			margin-left: 10px;
			margin-top: -15px;
			font-family: 'Libre Barcode 128', cursive;
			font-size: 34pt;
			text-align: center;
		}

</style>


<!--AUTORIZACION -->

<style type="text/css">
	.formato3{
		width: 100vh;
		height: 950px;
	}
	.container01{
		width: 100vh;
		height: 70px;
		margin-top: 20px;
	}

	.container01 img{
		float: left;
		width: 20%;
	}

	.container01 hr{
		border: none;
		position: absolute;
		float: right;
		width: 75%;
		margin-left: 170px;
		margin-top: 30px;
		height: 4px;
    	background-color:#B22222;
	}

	#texto01{
		float: right;
		font-family: Arial;
		font-size: 14px;
		padding-bottom: 15px;
	}

	.cliente{
		margin-top: 45px;
		font-family: verdana;
		font-size: 14px;
	}

	.cliente p{
		line-height: 5px;
	}

	.informacion p{
		text-align: justify;
		font-family: Arial;
		font-size: 15px;
		line-height: 12px;
		margin-top: 7px;
		text-indent: 55px;
	}

	.tabla01 table{
		margin-top: 15px;
		border-collapse: collapse;	
	    margin-left: 40px;
	    font-family: Times new Roman;
	    font-size: 12px;
	}

	.tabla01 th{
	background-color: #b4b4b4;
    text-align: center;
    width: 250px;
	}

	#messagehidde{
		text-align: justify;
    	font-family: Arial;
    	font-size: 15px;
    	margin-top: 15px;
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

    .right label, .right span, .left span{
    	font-family: 'Arial';
    	font-size: 15px;
    }

     * {
      box-sizing: border-box;
       }
		
		}
</style>

<body>


	<!--AUTORIZACION-->

	<div class="formato3">
	<div class="container01">
		<img class="img" src="assets/images/logoproteges.png"/>
		<hr>
	</div>

	<div id="texto01"><strong><?php echo $data[0]['municipio'];?>,</strong> Baja California a <?php echo $data[0]['fechaActual'];?>
    </div>

<div class="cliente">
	<p>Cliente del descuento: <strong><?php echo $data[0]['responsable'];?></strong></p>
	<p>Asegurado(s): ------ <strong><?php echo $data[0]['irresponsable'];?></strong></p>
	<p>Póliza: <strong><?php echo $data[0]['noPoliza']; ?></strong> Certificado:<strong> <?php echo $data[0]['certificado']; ?></strong></p>
	<p>Vigencia: <strong><?php echo $data[0]['vigencia']; ?></strong></p>
	<p>Antigüedad: <strong><?php echo $data[0]['antiguedad']; ?></strong></p>
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

<div class="tabla01"> 
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
 			<td><?php echo $data[0]['suma']; ?></td>
 			</tr>
 			<tr>
 			<td>Pago director a Hospitales de Red</td>
 			<td>Nivel hospitalario <?php echo $data[0]['nivel']; ?></td>
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
 				<td><?php echo $data[0]['honorario']; ?></td>
 			</tr>
 		</tbody>	
 	</table>
</div>

  <div id="messagehidde">
 	<p>
 	  En Asesores Proteges nos preocupamos en buscar siempre las mejores opciones de seguros que garanticen
 	  otorgar los beneficios contratados, si tiene alguna duda comunícarse a los teléfonos <b><?php echo $data[0]['numero']; ?></b>
 	  donde con gusto le atenderemos.
 	</p>
 </div>
     <div class="panel">
    <div class="left" >
 	<img src="assets/images/firma.png"> 
 	<span>Asesores Proteges</span>
 	</div>

 	<div class="right">
 	<label >Conocimiento y Aceptacíon</label>
 	<hr width="300px">
 	<span><?php echo $data[0]['responsable']; ?></span>
 	</div>
 	</div>
</div>
</div> 
</div>


	<!--CONSTANCIA DE RECEPCIÓN DE PÓLIZA-->

	<div class="formato2">

         	<div class="conetedor00">
         		<img src="assets/images/logoproteges.png">
         		<h3>CONSTANCIA DE RECEPCIÓN DE PÓLIZA</h3>
         		<span id="fecha00"><?php echo $data[0]['fechaActual']; ?></span>
         		<div class="barcode"><label><?php echo $data[0]['noPoliza'];?></label></div>
		        <span id="poliza"><?php echo $data[0]['noPoliza'];?></span>
         	</div>

         	<h4 class="titulo">CLIENTE DEL DECUENTO</h4>
         	<div id="left">
	<label>NOMBRE: </label><span style="margin-left: 14px;"><?php echo $data[0]['responsable'];?></span><br>
	<label>DOMICILIO: </label><span style="margin-left: 2px;" ><?php echo $data[0]['domicilio'];?></span>
	<span></span><br>
	<label>COLONIA: </label><span style="margin-left: 14px;" ><?php echo $data[0]['colonia'];?></span>
	</div>

	<div id="right">
	<label>EMAIL: </label><span style="margin-left: 23px;" ><?php echo $data[0]['email'];?></span><br>
	<label>C.P:</label><span style="margin-left: 47px;"><?php echo $data[0]['cp'];?></span>
	<span id="municipio24" style="margin-right: 0px;"> MUNICIPIO:<?php echo $data[0]['municipio'];?></span><br>
	<label>TELEFONO: </label><span style="margin-left: 0px;"><?php 
    	                             foreach ($data as $indice => $value) {

    	                             	    if($value['telefono'] == $value['telefono1']) {
                                             	 echo $value['telefono'];
                                             	}else{
                                             		echo $value['telefono'].' '.$value['telefono1'];
                                             	}
                                            
    	                              } ?></span>
	</div>

	<h4 id="titulo1"><label>CENTRO DE TRABAJO</label></h4>

	<div class="contenedor1">
	<label>CVE CENTRO DE TRABAJO: </label><span style="margin-left: 17px;"><?php echo $data[0]['clave'];?></span><br>
	<label>NOMBRE: </label><span style="margin-left: 118px;"><?php echo $data[0]['lugar'];?></span><br>
	<label>DOMICILIO: </label><span style="margin-left: 104px;"><?php echo $data[0]['domicilioCentro'];?></span><br>
	<label>COLONIA: </label><span style="margin-left: 114px;"><?php echo $data[0]['colonia'];?></span><label id="municipio">MUNICIPIO </label><span id="municipioSpan"><?php  echo $data[0]['municipio'];?></span><br>
	<label>DEPARTAMENTO: </label><span><?php echo $data[0]['departamento'];?></span><br>
	<label>TELEFONO DEPARTAMENTO:</label><span><?php echo $data[0]['telefonodepart'];?></span>
    </div>

    <h4 id="titulo2">DATOS DE LA PÓLIZA</h4>

	<div class="contenedor2">
     <p>RECIBI DE PROTECCION GENERAL EN SEGUROS LA PÓLIZA DEL SEGURO DE GMM</p>

    <div id="lblLeft">
	<label>COMPAÑIA: </label><span><?php echo $data[0]['compania'];?></span><br>
	<label>DESCUENTO: </label><span style="margin-left: 40px;"><?php echo $data[0]['deduccion'];?></span><br>
	<label>TITULAR: </label><span style="margin-left: 60px;"><?php echo $data[0]['irresponsable'];?></span><br>
	<label>VENDEDOR: </label><span id="vendedor" style="margin-left: 45px;"><?php echo $name;?></span>
	</div>

	<div id="lblRight">
	<label>VIGENCIA:</label><span style="margin-left: 90px;"><?php echo $data[0]['vigencia'];?></span><br>
	<label>CVE. DE DESC:</label><span style="margin-left: 69px;"><?php echo $data[0]['clave'];?></span><br>
	<label>CONTRATANTE-CLAVE:</label><span style="margin-left: 15px;"><?php echo $data[0]['contratante'];?></span>
	</div>
	</div>

	<h4 id="titulo3">PARA SER LLENADO POR QUIEN RECICE LA PÓLIZA</h4>
	<div class="contenedor3">
	 <span> </span>	
	<label>NOMBRE & FRIMA: </label><hr><span> </span>
	<label>DOMICILIO: </label><hr><span>C.P: </span>
	<label>COLONIA: </label><hr><span>EMAIL:</span>	
	<label>TELEFONO: </label><hr><span>TELEFONO DEL C.T:</span>	
	<label>CVE DE CENTRO DE TRABAJO: </label><hr><span>
	                                                   </span>
	<label>FECHA Y MUNICIPIO DE ENTREGA: </label><hr><span> </span>
	<label>NOMBRE Y FIRMA DEL REPARTIDOR: </label><hr>
	</div>

	<h4 id="titulo4">PARA EL CONTROL DEL DEPARTAMENTO DE REPARTO DE POLIZAS</h4>
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
</div>

<!--Autorizacion DE DESCUENTO-->
<style type="text/css">

			body{ 
			font-family: 'Gadugi','Calibri'; 
			font-size: 12px;
			margin: 0;
			padding: 0;
			background: url('assets/images/background.png');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
		}


		 .big-box{
		 	width: 100vh;
		 	height: 980px;
		 }

		.header{
			width: 100%;
			height: 80px;
		    position: absolute;	
		}

		  #logoLeft{
		  	position: absolute;
			float: left;
			width:150px;
			height: 66px;
		}

		   #titleCenter{
			margin-right: auto;
			margin-left: auto;
			text-align: center;
			display: block;
			width: 260px;
			font-size: 15px;
			font-weight: bold;
		}

		 #codiRight1{
		 	display: block;
		 	margin-top: -18px;
			width: 170px;
			height: 50px;
		   margin-left: 78%;
			font-family: 'Libre Barcode 128', cursive;
			font-size: 32pt;
		}

		  #fecha0{
		    display: block;
		    margin-left: 65%;
		    margin-top: 48px;
		}

		#solicitud0{
			display: block;
	     	float: right;
			font-size: 13px;
			font-weight: bold;
		}

		#sub1, #sub2, #sub3, #sub4{
			position: absolute;
			text-align: center;
			top: 80px;
			width: 100vh;
			background: #d8d8d8;
		}

		#sub2{
			top: 175px;
		}
		#sub3{
			top: 240px;
		}
		#sub4{
			top: 670px;
		}

		#sectionLeft , 
		#sectionRight, 
		#sub2Left, 
		#sub2Right,
		#sub3block{
			position: absolute;
			top: 120px;
		}

		#sectionLeft label, 
		#sub2Left label,  
		#sub3block label {
			position: absolute;
			text-align: justify;
			left: 125px;
		}

		#sectionRight label{
			position: absolute;
			text-align: justify;
			left: 55px;
		}

		#sub2Right label {
			position: absolute;
			text-align: justify;
			left: 89px;
		}

		#sectionRight{
			top: 120px;
			left:410px;	
		}

		#sub2Left{
			top: 210px;
		}

		#sub2Right{
			top: 210px;
			left: 380px;
		}

		#contratante{
			position: absolute;
			right: 275px;
		}
		#label{
			position: absolute;
			left: 48px;
		}

		#sub3block{
			top: 280px;
		}

		#texto{
			position: absolute;
			top: 315px;
			text-align: justify;
			font-font-family: Arial;
		}
		#tabla ,th, td {
			position: absolute;
			top: 365px;
			width: 100vh;
			border: 2px solid #d4d4d4;
			text-align: left;
			font-size: 13px;
		}

		th:first-child {
			width: 170px;
		}

		.contenedor0{
			position: absolute;
			top: 580px;
			width: 100vh;
			height: 70px;
		}


		#left0{
			float: left;
			width: 58%;
		}

		#left0 p{
			margin-left: 40px;
			margin-bottom: 25px;
		}


		#left0 p:last-child{
			margin-left: 100px;
		}

		#left0 hr{
			margin: 0;
			padding: 0;
			width: 200px;
			margin-left: 200px;
			margin-top: -25px;
			border: 2px solid #d4d4d4;
		}

		#right0{
			float: right;
			width: 40%;
		}
		#right0 p{
			margin-bottom: 25px;
		}

		#right0 hr{
			margin: 0;
			padding: 0;
			width: 225px;
			margin-left: 47px;
			margin-top: -25px;
			border:  2px solid #d4d4d4;
		}

		#mensage{
			position: absolute;
			top: 635px;
			text-align: justify;
			font-family: Arial;
		}

		.box{
			position: absolute;
			top: 700px;
			font-size: 12px;
			width: 100vh;
			height: 150px;

		}
		 #descripcion {
		 	float: left;
		 	width: 30%;
		 }

		 #descripcion p:last-child{
		 	position: absolute;
		 	top: 227px;
		 	margin-left: 400px;
		 	height: 20px;
		 	padding: 0;
		 }

		 #lineas hr{
		 	width: 70%;
		 	height: 19px;
		    margin-left: 200px;
		    border: 1px solid #d4d4d4;
		 }

		  #lineas hr:last-child{
		 	width: 210px;
		 	margin-left: 483px;
		 }

		 #lineas #cp{
		 	width: 50%;
		 }	


</style>


<!--AUTORIZACIÓN DE DESCUENTO-->
   
   <div class="big-box">
   	   
   	   <div class="header">
       <img id="logoLeft" src="assets/images/logoproteges.png" alt="Logo Proteges">
       <label id="titleCenter">AUTORIZACIÓN DE DESCUENTO</label>
       <span id="codiRight1"><?php echo $data[0]['noSolicitud'];?></span>
       </div>

       <span id="fecha0"><?php echo $data[0]['fechaActual']; ?></span>
       <span id="solicitud0"><?php echo $data[0]['noSolicitud']?></span> 

    <h4 id="sub1">CLIENTE DEL DESCUENTO</h4>
     <div id="sectionLeft">
    	<b>Nombre: </b><span style="margin-left: 35px;"><?php echo $data[0]['responsable'];?></span><br>
    	<b>Domicilio: </b><span style="margin-left: 26px;"><?php echo $data[0]['domicilio']; ?></span><br>
    	<b>Municipio: </b><span style="margin-left: 24px;"><?php echo $data[0]['municipio'];?></span><br>
    	<b>Telefono:</b><span style="margin-left: 35px;" ><?php  foreach ($data as $value) {   

    		                          if($value['telefono'] == $value['telefono1']) {
                                             	 echo $value['telefono'];
                                             	}else{
                                             		echo $value['telefono'].' '.$value['telefono1'];
                                             	}
    	                             }
    	?>
    		
    	</span>
      </div>
      <div id="sectionRight">
      	<b>RFC: </b><span style="margin-left: 16px;"><?php echo $data[0]['rfc'];?></span><br>
      	<b>Ext: </b><span style="margin-left:21px;"><?php  foreach ($data as $key => $value) 
      	{
      		if($key == 0 || $key == 1 || $key == 2 || $key == 3 || $key == 4){
      			echo $value['noExterior'];
      		}
      	}

      	?></span><br>
      	<b>Email: </b><span style="margin-left: 10px;"><?php echo $data[0]['email'];?></span><br>
      	<b>Colonia: </b><span><?php echo $data[0]['colonia']; ?></span>
      </div>

    <h4 id="sub2">CENTRO DE TRABAJO</h4>
    <div id="sub2Left">
    <b>Clave: </b><span style="margin-left: 46px;"><?php echo $data[0]['clave']; ?></span><br>
    <b>Domicilio: </b><span style="margin-left: 25px;"><?php echo $data[0]['domicilioCentro'];?></span><br>
    <b>Departamento:</b><span style="margin-left: 3px;"><?php echo $data[0]['departamento']+' '+$data[0]['telefonodepart'];?></span>
    </div>
    <div id="sub2Right">
    	<b>Nombre: </b><span style="margin-left: 35px;"><?php echo $data[0]['lugar'];?></span><br><br>
    	<b id="contratante">Contratante: </b><span style="margin-left: 35px; margin-top: -10px;" id="label"><?php echo $data[0]['contratante'];?></span>
    </div>

    <h4 id="sub3">DATOS DE LA POLIZA</h4>
    <div id="sub3block">
    	<b>Poliza: </b><span style="margin-left: 44px;"><?php echo $data[0]['noPoliza']; ?></span><br>
    	<b>Plan: </b><span style="margin-left: 50px;"><?php echo $data[0]['paquete'];
    	                          echo $data[0]['suma']; ?></span><br>
    	<b>Vigencia: </b><span style="margin-left: 28px;"><?php echo $data[0]['vigencia']; ?></span>
    </div>

    <p id="texto">
    	Autorizo a Protección General en Seguros S.A de C.V aplicar la actualización de trafifas de
    	Seguris de Gastos Médicos Mayores para que sea descontado de mi sueldo, con la finalidad de
    	cubrir los compromisos adquiridos con dicha empresa:
    </p>
    <table id="tabla">
    	<thead>
    	<tr>
    		<th>ASEGURADOS</th>
    		<th>F DE PAGO</th>
    		<th>PLAN</th>
    		<th>TARIFA</th>
    		
    	</tr>
    </thead>
    <?php foreach($data as $clave => $value) {?>
    	<tr>
    			<td><?php echo $value['beneficiarios'];?></td>
    			<td><?php echo $value['pago']; ?></td>
    			<td><?php echo $value['nombrePaquete'];?></td>
    			<td><?php echo $value['tarifa'];?></td>
    			<td><?php echo $value['edad'];?></td>
    	</tr> 
    <?php }?>
    </table>

      	<div class="contenedor0">
    	<div id="left0">
    	<p>DEDUCCION AUTORIZADA: </p><hr>
    	<div id="deduccionTotal" > 
    	<span><?php  echo $data[0]['descuentoTotal'];?></span>
    	</div>
    	<p>PROMOTOR: </p> <hr>
    	</div>

         <div id="right0">
    	<p>FIRMA: </p><hr> 
    	<p>FECHA: </p> <hr>
        </div>
        </div>

        <p id="mensage">
        	* Antes de firmar revise las tarifas vigentes y verifique sus datos,  de esto dependerá la entrega oportuna de
        	su póliza. Si existen cambios, actualize sus datos. Gracias.
        </p>

        <h4 id="sub4">ACTUALIZACION DE DATOS</h4>

         <div class="box">

        <div id="descripcion">
        <p>NOMBRE & FRIMA: </p>
        <p>DOMICILIO: </p>
        <p>COLONIA: </p>
        <p>EMAIL: </p>
        <p>TELEFONO: </p>
        <p>CLAVE DE CENTRO DE TRABAJO: </p>
        <p>TELEFONO DEL C.T: </p>
        <p>FECHA Y MUNICIPIO DE ENTREGA: </p>
        <p>REPARTIDOR: </p>
        </div>
        

        <div id="lineas">
        	<hr>
        	<hr>
        	<hr>
        	<hr>
        	<hr>
        	<hr>
        	<hr>
        	<hr>
        	<hr>

        </div>
        </div>
       </div>

    <!-- DESCUENTO ISE -->

 <style type="text/css">

 	.formato4{
 		width: 100vh;
 		height: 950px;
 	}

	 .formato4 h3{
	 	text-align: center;
	 	font-size: 18px;
	 }

	 .formato4 label{
	 	margin-left: 340px;
	 	font-size: 17px;
	 }

	 #institulo{
	 	font-size: 19px;
	 	width: 390px;
	 	font-weight: bold;
	 }

	 #institulo label{
      margin-left: 0px;
      letter-spacing: .3em;
	 }

	 .message{
	 	font-family: sans-serif;
	 	font-size: 19px;
	 	text-align: justify;
	 }

	 .att label{
	 	font-size: 20px;
	 	font-weight: bold;
	 	margin-left: 0px;
	 	letter-spacing: .2em;
	 }

	 .att hr:first-child,
	 .#last{
        margin-left: 0px;
        width: 550px;
	 }

	 .message span{
	 	font-weight: bold;
	 }

	 #middle{
	 	margin-left: 0px;
	 	width:210px;
	 }
 </style>

 <?php if( $seguros[0]['claveId'] == 62 || $seguros[0]['claveId'] == 66) { ?>

 <div class="formato4">

 	<h3>FORMATO ÚNICO DE AUTORIZACION PARA PAGO VÍA NOMINA</h3><br>
	<label>Mexicali, B.C. , a </label> <span><?php echo $data[0]['fechaActual'];?></span>
	<br>
	<br>
	<div id="institulo">
	INSTITUTO DE SERVICIOS EDUCATIVOS Y
    PEDAGOGICOS DE B.C. <br>
     <label>PRESENTE.-</label> 
    </div>
    <br>

<div class="message">
Por este conducto y con motivo del Abono que adquirí de la empresa
Protección General en Seguros, S.A. de C.V. autorizo de manera expresa e
irrevocable para que se cubra a esta última, la cantidad de <span><?php echo $data[0]['cantidadTotal'];?></span> vía
nómina, en <span><?php echo $data[0]['periodo'];?></span> pagos en la clave <span><?php echo $data[0]['clavePago'];?></span> por la cantidad de <span><?php echo $data[0]['descuentoTotal'];?></span>  quincenales desde 
 <span><?php $fecha = explode('-',$data[0]['vigencia']);
              echo $fecha[0];?></span> hasta el día <span><?php echo $fecha[1];?></span>.
<br>
<br>
La presente autorización atiende al crédito personal derivado de la adquisición de <span><?php echo $data[0]['tipoSeguro'];?></span>
Seguro de  con Protección General en Seguros, S.A. de C.V. con
quien la ISEP suscribió Convenio de Colaboración para la Promoción de Abonos.
Por tal motivo proporciono mis datos como trabajador y doy autorización para que
sea descontado de mi sueldo, con la finalidad de cubrir con los compromisos
contraídos.
</div>

<br>
<br>
<br>
<br>
<br>

<div class="att">

	<label>ATENTAMENTE</label>
	<br>
	<br>
	<br>
	<br>
	<span style="font-size: 15px;"><?php echo $data[0]['responsable'];?></span>
	<hr>
	<b>Nombre  y firma</b>
    <br>
    <br>
    <br>
    <span style="font-size: 15px;"><?php echo $data[0]['rfc'];?></span>
	<hr id="middle">
	<b id="lblMiddle">RFC</b>
	<br>
	<br>
	<br>
	<span style="font-size: 15px;"><?php echo $data[0]['lugar'];?></span>
	<hr id="last">
	<b id="spanLast">Dependencia</b>
	<br>
 </div>
</div>

<?php } ?>

<!-- domiciliación -->

<style type="text/css">
	.formato03{
		width: 100vh;
		height: 990px;
	}

    #head{
    	width: 100vh;
    	height: 70px;
    	padding: 0px;
    	margin: 0px;
    }

    #head img{
    	width: 150px;
    	height: 66px;
    	float: left;
    }

    #head h4{
    	float: right;
    	font-weight: bold;
    	font-family: 'Arial';
    	font-size: 17px;
    	margin-top: 10px;

    }

    #head span{
    	position: absolute;
    	font-weight: bold;
    	font-family: 'Arial'; 
    	font-size: 15px;
        left: 230px;
        top: 0px;
    }

    #title, #title1, #title2{
    	position: absolute;
    	background: #d9d9d9;
    	border: 1px solid rgba(0,0,0,.8);
    	text-align: center;
    	width: 200px;
    	height: 20px;
    	font-size: 12px;
    	font-family: 'Gadugi','Calibri';
    	font-weight: bold;
    	float: left;
    	top: 80px;
    }

   #title1{
   	margin-left: auto;
   	margin-right: auto;
   	width: 300px;
    margin-left: 32px;
   }

   #title2{
   	float: right;
   	width: 100px;
   	margin-left: 230px;
   }

   #campo, #campo1, #campo2{
   	position: absolute;
   	width: 200px;
   	height: 35px;
   	border: 1px solid rgba(0,0,0,.8);
   	text-align: center;
   	font-size: 13px;
   	margin-top: 105px;
   }

   #campo1{
   	margin-left: 234px;
   	width: 300px;
   	background: #d9d9d9;
   }

   #campo2{
   	left: 602px;
   	width: 100px;
   	top: 0px;
  
   }

   #title3, #title4, 
   #title10,#title11,
   #title12,#title13{
   	position: absolute;
   	width: 100vh;
   	height: 20px;
   	background-color: #d9d9d9;
   	border: 1px solid rgba(0,0,0,.8);
   	text-align: center;
   	font-size: 12px;
   	top: 155px;
   	font-weight: bold;
   }

   #title3{
   	margin-top: -7px;
   }

   #title10, #title11,
   #campo9, #title12,
   #title13{
   	position: absolute;
   	width: 60%;
   	text-align: center;
   	font-size: 13px;
   	top: 380px;
   }

   #title11, #campo10{
   	position: absolute;
   	width: 40%;
   	top: 395px;
   	left: 60%;
   }
   
   #title11{
   	top: 380px;
   }


   #campo9, #campo10,
   #campo11, #campo12,
   #campo13, #campo14{
   position: absolute;
   width: 60%;
   height: 15px;
   border: 1px solid rgba(0,0,0,.8);
   text-align: center;
   font-size: 13px;
   margin-top: 25px;
   }

   #campo10{
   	width: 40%;
   	top: 380px;
   }

   #title12{
   	top: 425px;
   }

   #title13{
   	top: 425px;
   	width: 40%;
   	left: 60%;
   }

   #campo11{
   	top: 426px;
   	width: 60%;
   }

   #campo112{
   	position: absolute;
   	top: 451px;
   	border: 1px solid rgba(0,0,0,.7);
   	text-align: center;
   	font-size: 13px;
   	width: 40%;
   	height: 15px;
   	left: 60%;
   }

   #option,#title15{
     	position: absolute;
     	width: 60%;
     	height: 90px;
     	top: 472px;
     	border: solid;
     	background: #d4d4d4;
     	border:1px solid rgba(0,0,0,.8);
     	font-size: 14px;
     }

     #title15{
     	height: 20px;
     	top: 562px;
     	text-align: center;
     	font-weight: bold;
     	font-size: 13px;
     }

     #option b{
     	float: left;
        margin-top: 30px;
     }

     #option input{
     	display: block;
     	margin-top: 3px;
     	margin-left: 200px;
     	width: 20px;
     }

     #title14{
     	position: absolute;
     	width: 40%;
     	height: 110px;
     	background: #d4d4d4;
     	border: 1px solid rgba(0,0,0,.8);
     	margin-left: 60%;
     	margin-top: 472px;
     	text-align: center;
     	font-size: 13px;
     }

     #title14 b{
     	position: absolute;
     	top: 90px;
     	left: 35%;
     	letter-spacing: .1em;
     }

     #campo13 {
     	margin-top: 584px;
     	width: 60%;
     	height: 15px;
     }

     #campo14{
     	margin-top: 584px;
     	margin-left: 60%;
     	width: 40%;
     	height: 15px;
     }
 
     #title16, #title17,
     #title18, #title19{
     	position: absolute;
     	width: 60%;
     	height: 20px;
     	border: 1px solid rgba(0,0,0,.6);
     	background: #d4d4d4;
     	margin-top: 600px;
     	text-align: center;
     	font-weight: bold;
     }

     #title16,#title17{
     	margin-top: 601px;
     	width: 18%;
     	height: 25px;
     	font-size: 10px;
     }

     #title17{
     	width: 15%;
     	margin-left: 52%;
     }


     #campo15, #campo16,
     #campo17, #campo18,
     #campo19{
        position: absolute;
        text-align: center;
     	margin-top: 601px;
     	margin-left: 18%;
     	border: 1px solid rgba(0,0,0,.7);
     	width: 34%;
     	height: 25px;
     	font-size: 13px;
     }

     #campo16{
     	width:33%;
     	margin-left: 67%;
     }

     #title18{
     	margin-top: 632px;
     	width: 100vh;
     	font-size: 13px;
     }

        #campo17,#campo18,
        #campo19{
        margin-left: none;
     	width: 100vh;
     	margin-top: 653px; 
     	height: 20px;
     	font-size: 13px;
     	text-align: center;
     }

     #campo17 span:first-child{
     	float: left;
     }

     #ultimo{
     margin-left:  130px;
     }

     #middleSpan{
     	margin-left: 70px;
     }

     #campo17 b:first-child{
     	float: left;
     }

     #campo18{
     	margin-top: 674px;
     	text-align: left;
     	height: 25px;
     	font-size: 13px;
     }

     #campo19{
     	margin-top: 700px;
     	font-size: 11px;
     	height: 45px;
     	text-align: justify;
     }

     #title19{
     	margin-top: 750px;
     	width: 100vh;
     	font-size: 13px;
     }

     #campo20{
     	position: absolute;
     	margin-top: 772px;
     	width: 100vh;
     	height: 85px;
     	border: 1px solid rgba(0,0,0,.8);
     	font-size: 10px;
     	text-align:justify;
     }

     .message-option{
     	position: absolute;
     	width: 190px;
     	height: 85px;
     	margin-left: 220px;
     	display: block;
     	line-height: 26px;
     }

     .seguros th{
     	background: #d4d4d4;
     	text-align: center;
     	width: 100vh;
     	font-size: 11px;
     }

     .seguros tr, .seguros td{
     	border: 1px solid rgba(0,0,0,.7);
     	text-align: center;
     	font-size: 12px;
     }

     .seguros{
     	position: absolute;
     	width: 100vh;
     	border: 1px solid rgba(0,0,0,.7);
     	margin-top: 106px;
     	font-size: 13px;
     }

     #title20 {
     	position: absolute;
     	width: 35%;
     	height: 20px;
     	top: 862px;
     	background-color: #d4d4d4;
     	border: 1px solid rgba(0,0,0,.7);
     	text-align: center;
     	font-size: 13px;
     	font-weight: bold;
     }

     #titulo0001 {
     	position: absolute;
     	width: 449px;
     	background: #d4d4d4;
     	text-align: center;
     	font-size: 13px;
     	left: 253px;
     	height: 20px;
     	top: 862px;
        font-weight: bold;
     }

     #titulo0010{
     	position: absolute;
     	width: 247px;
     	background: #d4d4d4;
     	text-align: center;
     	font-size: 13px;
     	height: 20px;
     	top: 915px;
     	font-weight: bold;

     }

  
     #campo21 {
       position: absolute;
       width: 35%;
       height: 20px;
       border: 1px solid rgba(0,0,0,.7);
       text-align: center;
       font-size: 13px;
       margin-top: 888px;
     }

     #campo22{
     	position: absolute;
     	top:888px;
     	height: 20px;
     	border: 1px solid rgab(0,0,0,.7);
        left: 253px;
     	width: 449px;
     }

     #campo23{
     	position: absolute;
     	width: 449px;
     	height: 20px;
     	left: 253px;
     	top: 915px;
     	border: 1px solid rgba(0,0,0,.7);
     	text-align: center;
     	font-size: 13px;
     }

</style>



<?php 
  if($seguros[0]['claveId'] == 72 || $seguros[0]['claveId'] == 80 || $seguros[0]['claveId'] == 128 || $seguros[0]['claveId'] == 129) { ?>

<div class="formato03">

	<div id="head">
	  <img src="assets/images/logoProteges.png">
	  <h4>PROTECCION GENERAL EN SEGUROS SA DE CV</h4>	
	  <span>Autorizacion para domiciliacion de recibos</span>
	</div>

	
	<div id="title">EMISOR</div>
	<div id="title1">DOMICILIO DEL EMISOR</div>
	<div id="title2">R.F.C.</div>

	   <div id="campo">PROTECCIÓN GENERAL EN SEGUROS SA DE CV</div>
	   <div id="campo1">CALZADA INDEPENDECIA S/N, COLONIA RIVERA 21259, MEXICALI B.C.</div>
	   <div id="campo2">PGS-021016V87</div>

	<div id="title3">SEGUROS CONTRATADOS</div>

	<table class="seguros">
	<thead>	
		<tr>
		<th>PRODUCTO</th>
		<th>CANTIDAD</th>
		<th>NO.POLIZA</th>
		<th>VIG. OTORGADA</th>
		<th>CLAVE</th>
		<th>TIPO DE TARJETA</th>
		</tr>
		<tbody>
		<?php foreach($seguros as $value) {?>
		<tr>
		  <td><?php echo $value['producto'];?></td>
		  <td><?php echo $value['descuento'];?></td>
		  <td><?php echo $value['noPoliza'];?></td>
		  <td><?php echo $value['fechaInicio'].' a '.$value['fechafin'];?></td>
		  <td><?php echo $value['clave']?></td>	
		  <td><?php echo $value['tipoTarjeta'];?></td>
		</tr>
	 <?php } ?>
		</tbody>
	</thead>	
	</table>
   
   

    <div id="title10">CLIENTE TITULAR DEL A BANCARIA(NOMBRE COMPLETO)</div>
    <div id="title11">BANCO RECEPTOR</div>

    	<div id="campo9"><?php  echo $seguros[0]['titularTarjeta'];?></div>
    	<div id="campo10"><?php echo $seguros[0]['banco'];?></div>

    <div id="title12">CLABE INTERBANCARIA (18 DIGITOS)</div>
    <div id="title13">RFC DEL CONTRANATE</div>

       <div id="campo11"><?php 
                              if($seguros[0]['tipoTarjetaId'] == 2)
                                {
                                  echo $seguros[0]['tarjeta'];
                                }elseif ($seguros[0]['tipoTarjetaId'] == 3) {
                                	echo 'null';
                                }else{
                                  echo '';
                                }?></div>
       <div id="campo112"><?php echo $seguros[0]['rfc'];?></div>

     <div id="option">
     	<b id="message-menu">Seleccionar según aplique:</b>
      <?php if( $seguros[0]['tipoTarjetaId'] == 1) { ?>			
     	<input type="checkbox">
     	<input type="checkbox" checked>
     	<input type="checkbox">
     <?php } elseif( $seguros[0]['tipoTarjetaId'] == 2) { ?>
      <input type="checkbox">
      <input type="checkbox">
      <input type="checkbox" checked>
     <?php } elseif( $seguros[0]['tipoTarjetaId'] == 3 ) { ?>
      <input type="checkbox">
      <input type="checkbox">
      <input type="checkbox"> 
      <?php } elseif($seguros[0]['bancoId'] == 80) {?> 
       <input type="checkbox" checked>
       <input type="checkbox">
       <input type="checkbox"> 
      <?php }?>
        <div class="message-option">	
     	<span >Pagomático BANAMEX</span><br>	
     	<span >Tarjeta de debíto Bancomer</span><br>		
     	<span >Tarjeta de credito</span>
        </div>
     </div>

    <div id="title14"><b>TELEFONO</b></div>
    <div id="title15">(16 DIGITOS)</div>


        <div id="campo13"><?php  if($seguros[0]['tipoTarjetaId'] == 1) {
                                          echo $seguros[0]['tarjeta'];
                                        }elseif ($seguros[0]['tipoTarjetaId'] == 3) {
                                        	echo  'null';
                                        }else{
                                        	echo '';
                                        }
                                       ?></div>
        <div id="campo14"><?php  foreach ($data as  $value) {
                                if ($value['telefono'] == $value['telefono1']) { 
                                 echo $value['telefono'];
                                 }else{
                                 	echo $value['telefono'].' '.$value['telefono1'];
                                 }
                                  }
        	               ?></div>

    <div id="title16">MES/AÑO DE VIGENCIA (TARJETA):</div>
    <div id="title17">CORREO:</div>


         <div id="campo15">00/00</div>
         <div id="campo16"><?php echo $seguros[0]['email']; ?></div>
        
    <div id="title18">CANTIDAD TOTAL</div>
         <div id="campo17">
          <?php 
                  function getTotal($array){

                  $total = 0;

                  for ($i = 0; $i < count($array); $i ++){
                       
                       $total += $array[$i]['descuento'];
                  }

                  return $total;

                 }
         ?>
         	<span>MENSUAL: $</span> <b><?php echo getTotal($seguros);?></b>
         	<span id="middleSpan">1ER PAGO: $</span> <b><?php echo getTotal($seguros); ?></b>
         	<span id="ultimo">SUBSECUENTES: $</span><b id="last"><?php echo getTotal($seguros); ?></b>
         </div>
         <div id="campo18">OBSERVACIÓN:</div>
         <div id="campo19">EN CASO QUE MI CUENTA PRESENTE INSUFICIENCIA DE FONDOS AL MOMENTO DE LA APLICACiÓN  DE LA DOMICILIACION AUTORIZADA A PROTEGES A REALIZAR LA APLICAÓN DEL PERIODO DE ADEUDI AL SIGUIENTE MES, DE SUCEDER ESTA SITUACION DOS MESES CONSECUTIVOS, ME DOY POR ENTERADO QUE SE PROCEDERA A LA CANCELACION DE LA (S) POLIZA (S) </div>

    <div id="title19">LEYENDA:</div>
         <div id="campo20">Autorizo al Banco Receptor para que realice por mi cuenta los pagos por los conceptos que en este documento se detallan, con cargo a la cuenta bancaria identificada por la CLABE. convengoen que el Banco Receptor queda liberado de toda responsabilidad si el Emisor ejercitara contra mi, devirados de la Ley o el Contrato que tengamos celebrando, y que el Banco Receptor no estará obligado a efectuar ningun reclamo al Emisor, ni a interpoener recursos de ninguna especie contramultas, sanciones o cobrosindebidos, todo lo cual, en caso deser necesario, será ejecutadopor mí. El Banco Receptor tampoco será responsable si el Emisor no entregara oportunamente los comprobantes de servicios, o si los pagos se realizan extemporániamente por razones ajenas al Banco Receptor, el cual tendrá adsoluta libertad de cancelarme este servicio si en mi cuenta no existeran fondos suficientes para cubrir uno o más de los pagos Banco Receptor, el cual tendrá absoluta libertad de cancelarme este servicio si en mi cuenta no existieran fondos suficientes para cubrir uno o más de los pagos que le requiera el emisor, o bien, esta estuviera bloqueada por algún motivo.
</div>
    </div>

    <div id="title20">LUGAR Y FECHA</div>
          <div id="campo21"><?php echo $data[0]['municipio'].' '.$data[0]['fechaCorta'];?></div>

    <div id="titulo0001" style="border: 1px solid rgba(0,0,0,.7);" >FIRMA DEL TITULAR DE LA CUENTA BANCARIA</div>
          <div id="campo22"></div>

    <div id="titulo0010" style="border: 1px solid rgba(0,0,0,.7);">CERRADOR</div>
          <div id="campo23"><?php echo $name;?></div>
</div>

<?php } ?>


<style type="text/css">

	.card02{
		width: 100vh;
		height: 950px;
		background: #fff;
	}

	.card02 img{
        vertical-align: middle;
		width: 100%;
		height: 400px;
		border-radius: 15px;
		display: block;
	}

	.card02 ul {
		position: absolute;
        top: 100px;
        left: 10px;
        margin: 0px;
        font-size: 18px;
        color:#f8f8f8;  
        list-style: none;
        font-family: Impact, Charcoal, sans-serif;
        font-weight: bolder;
	}

	#qr{
			position: absolute;
			top: 110px;
			right: 10px;
			width: 205px;
			height: 205px;
			border-radius: 10px;
			opacity: .7;
			border:solid;
		}

		#tracera{
			margin-top: 50px;
			width: 100%;
			height: 400px;
			border-radius: 15px;
			display: block;
		}

</style>

<div class="card02">
 	<img src="assets/images/card/Frente.png">
 	<ul>
 		<?php foreach($data as $clave => $value) { ?>
 		<li><?php echo $value['beneficiarios'].'<br>';?></li>
 		<?php } ?>
 		<br>
		<span>Políza GMM <?php echo $data[0]['noPoliza']; ?></span>
		<br>
		<span id="title010">Antiguedad <?php echo $data[0]['antiguedad'];?> </span>
 	</ul>
 	<?php 
        echo "<img id='qr' src='assets/images/QR/".$nombre.".png' alt='noo!'>";
        ?>
	<img src="assets/images/card/Trasera.png" id="tracera"  alt="card-trasera"> 
 </div>



<?php if($seguros[0]['poliza2020'] != null) { ?>

<style type="text/css">
	.polizas2020{
		width: 100%;
	}
</style>

<div class="polizas2020">
	
      <img src="1.jpg" style="width: 100%; height: 950px;">
      <img src="2.jpg" style="width: 100%; height: 950px;">
      <img src="3.jpg" style="width: 100%; height: 950px;">
      <img src="4.jpg" style="width: 100%; height: 950px;">
      <img src="5.jpg" style="width: 100%; height: 950px;">
      <img src="6.jpg" style="width: 100%; height: 950px;">
      
  <!--  
    <?php $pictures = count(glob('{*.jpg}',GLOB_BRACE)); ?>

   <?php if($pictures === 3) { ?>
    <img src="1.jpg" style="width: 100%; height: 950px;">
    <img src="2.jpg" style="width: 100%; height: 950px;">
    <img src="3.jpg" style="width: 100%; height: 950px;">
    <?php } ?>

    <?php if($pictures === 4) { ?>
    <img src="1.jpg" style="width: 100%; height: 950px;">
    <img src="2.jpg" style="width: 100%; height: 950px;">
    <img src="3.jpg" style="width: 100%; height: 950px;">
    <img src="4.jpg" style="width: 100%; height: 950px;">
    <?php } ?>

    <?php if($pictures == 5) { ?>
    <img src="1.jpg" style="width: 100%; height: 950px;">
    <img src="2.jpg" style="width: 100%; height: 950px;">
    <img src="3.jpg" style="width: 100%; height: 950px;">
    <img src="4.jpg" style="width: 100%; height: 950px;">
    <img src="5.jpg" style="width: 100%; height: 950px;">
    <?php } ?>

    
    <?php if($pictures == 6) { ?>
    <img src="1.jpg" style="width: 100%; height: 950px;">
    <img src="2.jpg" style="width: 100%; height: 950px;">
    <img src="3.jpg" style="width: 100%; height: 950px;">
    <img src="4.jpg" style="width: 100%; height: 950px;">
    <img src="5.jpg" style="width: 100%; height: 950px;">
    <img src="6.jpg" style="width: 100%; height: 950px;">
    <?php } ?>
    <?php if($pictures == 7) { ?>
    <img src="1.jpg" style="width: 100%; height: 950px;">
    <img src="2.jpg" style="width: 100%; height: 950px;">
    <img src="3.jpg" style="width: 100%; height: 950px;">
    <img src="4.jpg" style="width: 100%; height: 950px;">
    <img src="5.jpg" style="width: 100%; height: 950px;">
    <img src="6.jpg" style="width: 100%; height: 950px;">
    <img src="7.jpg" style="width: 100%; height: 950px;">
    <?php } ?>
    <?php if($pictures == 8) { ?>
    <img src="1.jpg" style="width: 100%; height: 950px;">
    <img src="2.jpg" style="width: 100%; height: 950px;">
    <img src="3.jpg" style="width: 100%; height: 950px;">
    <img src="4.jpg" style="width: 100%; height: 950px;">
    <img src="5.jpg" style="width: 100%; height: 950px;">
    <img src="6.jpg" style="width: 100%; height: 950px;">
    <img src="7.jpg" style="width: 100%; height: 950px;">
    <img src="8.jpg" style="width: 100%; height: 950px;">
    <?php } ?> -->
</div>
<?php } ?>
</body>
</html>
