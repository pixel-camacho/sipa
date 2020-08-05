<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Adjunto</title>
</head>

<!--Autorizacion-->
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

		#logoLeft{
			float: left;
			width:150px;
			height: 66px;
			position: absolute;
		}

		#titleCenter{
			margin-right: auto;
			margin-left: auto;
			display: block;
			text-align: center;
			width: 260px;
			font-size: 15px;
			font-weight: bold;
		}

		#codiRight{
			position: absolute;
			width: 170px;
			height: 80px;
			left: 490px;
			top: -5px;
		}

		#fecha0{
			position: absolute;
			top: 80px;
			left: 360px;
		}

		#solicitud0{
			position: absolute;
			top: 80px;
			float: right;
			margin-right: 40px;
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

		 .big-box{
		 	width: 100vh;
		 	height: 950px;
		 }

</style>

<!-- CONSTANCIA DE RECEPCIÓN DE PÓLIZA -->
<style type="text/css">
	.formato2{
       		width: 100vh;
       		height: 950px;
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
       		float: right;
       		font-size: 13px;
       		font-weight: bold;
       		font-family: 'Arial';
       	}

        #fecha00{
        	margin-left: 300px;
        }

        .titulo, #titulo1, #titulo2, #titulo3, #titulo4{
        width: 100vh;
        background-color: #d4d4d4;
        text-align: center;
        height: 20px;
        border:solid #a6a6a6;
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
			top: 110px;
		}

		#right{
			float: right;
			width: 50%;
			position: absolute;
			top: 110px;
		}

		#left span, #right span{
			position: absolute;
			text-align: justify;
			left: 3px;
			
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

</style>
	
</style>

<body>

	<!--CONSTANCIA DE RECEPCIÓN DE PÓLIZA-->

	<div class="formato2">

         	<div class="conetedor00">
         		<img src="assets/images/logoproteges.png">
         		<h3>CONSTANCIA DE RECEPCIÓN DE PÓLIZA</h3>
         		<span id="fecha00"><?php echo $data[0]['fechaActual']; ?></span>
		        <span id="poliza"><?php echo $data[0]['noPoliza'];?></span>
         	</div>

         	<h4 class="titulo">CLIENTE DEL DECUENTO</h4>
         	<div id="left">
	<label>NOMBRE: </label><span ><?php    echo $data[0]['responsable'];?></span><br>
	<label>DOMICILIO: </label><span ><?php echo $data[0]['domicilio'];?></span><span></span><br>
	<label>COLONIA: </label><span ><?php   echo $data[0]['colonia'];?></span>
	</div>

	<div id="right">
	<label>EMAIL: </label><span ><?php echo $data[0]['email'];?></span><br>
	<label>C.P:</label><span><?php echo $data[0]['cp'];?></span><span style="margin-left: 170px;"> MUNICIPIO:<?php echo $data[0]['municipio'];?></span><br>
	<label>TELEFONO: </label><span><?php 
    	                             foreach ($data as $indice => $value) {
                                             	 echo $value['telefono'].' '.$value['telefono1'];
                                            
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


<!--AUTORIZACIÓN DE DESCUENTO-->
   
   <div class="big-box">
   	
   
	<div class="container">
       <img id="logoLeft" src="assets/images/logoproteges.png" alt="Logo Proteges">
       <label id="titleCenter">AUTORIZACIÓN DE DESCUENTO</label>
       <!--<img id="codiRight" src="assets/images/logo.png"> -->
    </div>
    <span id="fecha0"><?php echo $data[0]['fechaActual']; ?></span>
    <span id="solicitud0"><?php echo $data[0]['noSolicitud']?></span>

    <h4 id="sub1">CLIENTE DEL DESCUENTO</h4>
     <div id="sectionLeft">
    	<b>Nombre: </b><label><?php echo $data[0]['responsable'];?></label><br>
    	<b>Domicilio: </b><label><?php echo $data[0]['domicilio']; ?></label><br>
    	<b>Municipio: </b><label><?php echo $data[0]['municipio'];?></label><br>
    	<b>Telefono:</b><label ><?php  foreach ($data as $value) {    
    		                          echo $value['telefono'].' '.$value['telefono1'];
    	                             }
    	?>
    		
    	</label>
      </div>
      <div id="sectionRight">
      	<b>RFC: </b><label><?php echo $data[0]['rfc'];?></label><br>
      	<b>Ext: </b><label><?php  foreach ($data as $key => $value) 
      	{
      		if($key == 0 || $key == 1 || $key == 2 || $key == 3 || $key == 4){
      			echo $value['noExterior'];
      		}
      	}

      	?></label><br>
      	<b>Email: </b><label><?php echo $data[0]['email'];?></label><br>
      	<b>Colonia: </b><label><?php echo $data[0]['colonia']; ?></label>
      </div>

    <h4 id="sub2">CENTRO DE TRABAJO</h4>
    <div id="sub2Left">
    <b>Clave: </b><label><?php echo $data[0]['clave']; ?></label><br>
    <b>Domicilio: </b><label><?php echo $data[0]['domicilioCentro'];?></label><br>
    <b>Departamento:</b><label><?php echo $data[0]['departamento']+' '+$data[0]['telefonodepart'];?></label>
    </div>
    <div id="sub2Right">
    	<b>Nombre: </b><label><?php echo $data[0]['lugar'];?></label><br><br>
    	<b id="contratante">Contratante: </b><label id="label"><?php echo $data[0]['contratante'];?></label>
    </div>

    <h4 id="sub3">DATOS DE LA POLIZA</h4>
    <div id="sub3block">
    	<b>Poliza: </b><label><?php echo $data[0]['noPoliza']; ?></label><br>
    	<b>Plan: </b><label><?php echo $data[0]['paquete'];
    	                          echo $data[0]['suma']; ?></label><br>
    	<b>Vigencia: </b><label><?php echo $data[0]['vigencia']; ?></label>
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
    	<div id="deduccionTotal"> 
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
 				<td>$2,500.00</td>
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
 				<td>$100,000.00 dlls (reembolso 7 días)</td>
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

	.card02 ul{
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
		<span id="title">Antiguedad <?php echo $data[0]['antiguedad'];?> </span>
 	</ul>
 	<?php 
        echo "<img id='qr' src='assets/images/QR/".$nombre.".png' alt='noo!'>";
        ?>

	<img src="assets/images/card/Trasera.png" id="tracera"  alt="card-trasera"> 
 	
 </div>

 <style type="text/css">
 	.formato4{
 		width: 100vh;
 		height: 950px;
 		margin-top: 40px;
 		font-size: 15px;
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

 <?php if( $data[0]['clavePago'] == 42 || $data[0]['clavePago'] == 72) { ?>

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
La presente autorización atiende al crédito personal derivado de la adquisición de <span>Seguro de: <?php echo $data[0]['tipoSeguro'];?></span>
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

<?php } ?>

</body>
</html>
