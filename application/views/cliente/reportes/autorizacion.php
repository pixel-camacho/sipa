<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Autorizacion de descuento</title>

	<style type="text/css">
		body{ 
			font-family: 'Gadugi','Calibri'; 
			font-size: 12px;
			margin: 0;
			padding: 0;
			background: url('assets/images/background.png'); 
			background-position: center;
			background-repeat: no-repeat;
			background-size: cover;
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
			max-width: 170px;
			height: 50px;
			margin-left: 495px;
			margin-top: -15px;
			font-family: 'Libre Barcode 128', cursive;
			font-size: 34pt;
			text-align: center;
		}

		#fecha{
			position: absolute;
			top: 50px;
			left: 360px;
			margin-right: 160px;
		}

		#solicitud{
			position: absolute;
			top: 50px;
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

		.contenedor{
			position: absolute;
			top: 580px;
			width: 100vh;
			height: 70px;
		}

		#left{
			float: left;
			width: 58%;
		}

		#left p{
			margin-left: 40px;
			margin-bottom: 25px;
		}


		#left p:last-child{
			margin-left: 100px;
		}

		#left hr{
			margin: 0;
			padding: 0;
			width: 200px;
			margin-left: 200px;
			margin-top: -25px;
			border: 2px solid #d4d4d4;
		}

		#right{
			float: right;
			width: 40%;
		}
		#right p{
			margin-bottom: 25px;
		}

		#right hr{
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


		 #deduccionTotal{
			position: absolute;
			width: 120px;
			height: 17px;
			margin-left: 240px;
			bottom: 425px;
			text-align: center;
		}



	</style>
</head>
<body>
	<div class="container">
       <img id="logoLeft" src="assets/images/logoproteges.png" alt="Logo Proteges">
       <label id="titleCenter">AUTORIZACIÓN DE DESCUENTO</label>

       <label id="codiRight"><?php echo $data[0]['noSolicitud'];?>|20</label>
      <!-- <img id="codiRight" src="assets/images/logo.png">  -->
          </div>


    <span id="fecha"><?php echo $data[0]['fechaActual']; ?></span>
    <span id="solicitud"><?php echo $data[0]['noSolicitud']?></span>

    <h4 id="sub1">CLIENTE DEL DESCUENTO</h4>
     <div id="sectionLeft">
    	<b>Nombre: </b><label><?php echo $data[0]['responsable'];?></label><br>
    	<b>Domicilio: </b><label><?php echo $data[0]['domicilio']; ?></label><br>
    	<b>Municipio: </b><label><?php echo $data[0]['municipio'];?></label><br>
    	<b>Telefono:</b><label><?php 
    	                              foreach ($data as $value) {   

    		                          if($value['telefono'] == $value['telefono1']) {
                                             	 echo $value['telefono'];
                                             	}else{
                                             		echo $value['telefono'].' '.$value['telefono1'];
                                             	}
    	                             }?>
    	</label>
      </div>
      <div id="sectionRight">
      	<b>RFC: </b><label><?php echo $data[0]['rfc'];?></label><br>
      	<b>Ext: </b><label>S/N</label><br>
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
    	<b>Plan: </b><label><?php echo $data[0]['paquete']; ?></label><br>
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

      	<div class="contenedor">
    	<div id="left">
    	<p>DEDUCCION AUTORIZADA: </p><hr> 
    	<div id="deduccionTotal"> 
    	<span><?php  echo $data[0]['descuentoTotal'];?></span>
    	</div>
    	<p>PROMOTOR: </p> <hr>
    	</div>

         <div id="right">
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



</body>
</html>