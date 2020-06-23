<html>
<head>
	<title>Recibo</title>
</head>
<style>

	body{
		margin: 0px;
		padding: 0px;
		font-family: Arial, Helvetica, sans-serif;
		font-size: 13px;
	}

	.grid{
		width: 100%;
		height: 215px;
	}

	.left{ 
		margin-top: 25px;
		width: 50%;
		float: left;
	
	}
	.right{
		width: 50%;
		float: right;
		
	}
	.grid p{
		margin: 0px;
		border: 1px solid;
	
	}

	.firmas{
		width: 100%;
		margin: 10px;

	}
	#left{
		float: left;
		width: 50%;
		text-align: center;
	}

	#right{
		float: right;
		width: 50%;
		text-align: center;
	}
		hr{
		margin-top: 50px;
		width: 300px;
	}
	.content{
		width: 100%;
		font-size: 12px;
	
	}
	#caja1{
		width: 30%;
		float: left;
	}
	.caja2{
		width: 70%;
		float: right;
	}
	div strong{
		float: right;
		font-size: 21px;
	
	}
	#importe{
		float: right;
		font-size: 12px;
		
	}
	#cantidad{
		font-size: 14px;
    	font-weight: bold;
    	float: right;
    	margin-right: 0px;
	}

</style>
<body>

	

	<div  class="content">

     <div id="caja1">
	<img src="assets/images/logoproteges.png" alt="logo">
	</div>

    <div id="caja2">
    <p >
    	<b>Protección General En Seguros, S.A de C.V</b><br>
    	Calz. Independencia S/N, Colonia La rivera, Mexicali B.C.<br>
    	Tel:(686) 555-56-30
    <strong><?php echo $ticket; ?></strong><br><br>
    <b id="importe"> <?php echo $importe; ?></b>
    </p>

    </div>
<div id="cantidad"> <?php echo $cantidad;?></div>
</div>
    

        
  <div class="grid">

    <div class="left">
	<P style="height: 60px;">Cliente:<br> 
		<?php echo $responsable;?><br>
		<?php echo $direccion; ?>
		</P>

	<p style="height: 90px;">Perido(s): <?php echo $periodo; ?>-<?php echo $periodo; ?><br>
       Concepto: <?php echo $concepto; ?>
	</p>

	<p style="height: 50px;">Fecha de Cobro: <?php echo $fecha; ?> </p>
	</div>

	<div class="right">
		<p style="height: 60px;">Asegurado:<br> <?php echo $asegurado; ?></p>
		<p style="height: 90px;">Compañia: <?php echo $compania; ?><br>
		   Poliza: <?php echo $noPoliza; ?><br>
		   Inicio Vig: <?php echo $inicio; ?><br>
		   Fin Vig: <?php echo $fin; ?><br>
		   <?php echo $contratante; ?>

		</p>

		<p style="height: 50px;" >Fecha de Dep. en Banco: <?php  echo $fechaPago; ?></p>

	</div>

	</div>

<div class="firmas">

	<div id="left">
	<label>Personal PROTEGES</label>
	<hr>
	<span><?php echo $personal; ?></span>
	</div>

    <div id="right">
	<label>Asegurado(a)</label>
	<hr>
	<span><?php echo $asegurado; ?></span>
	</div>

</div> 

<p >Recibo para la Compañia/Folio(s) Cubierto(s)</p>

</div>


<div  class="content">

     <div id="caja1" style="margin-top: 20px;">
	<img src="assets/images/logoproteges.png" alt="logo">
	</div>

    <div id="caja2">
    <p >
    	<b>Protección General En Seguros, S.A de C.V</b><br>
    	Calz. Independencia S/N, colonia la rivera, Mexicali B.C.<br>
    	Tel:(686) 555-56-30

    <strong><?php echo $ticket; ?></strong><br><br>
    <b id="importe"> <?php echo $importe; ?></b>
    </p>

    </div>
</div> 

 <div id="cantidad"><?php  echo $cantidad;?></div>

 <div class="grid">

    <div class="left">
	<P style="height: 60px;">Cliente:<br> 
		<?php echo $responsable;?><br>
		<?php echo $direccion; ?>
		</P>
	<p style="height: 90px;">Perido(s): <?php echo $periodo; ?>-<?php echo $periodo; ?><br>
       Concepto: <?php echo $concepto; ?>
	</p>
	<p style="height: 50px;">Fecha de Cobro: <?php echo $fecha; ?> </p>
	</div>

	<div class="right">
		<p style="height: 60px;">Asegurado:<br> <?php echo $asegurado; ?></p>
		<p style="height: 90px;">Compañia: <?php echo $compania; ?><br>
		   Poliza: <?php echo $noPoliza; ?><br>
		   Inicio Vig: <?php echo $inicio; ?><br>
		   Fin Vig: <?php echo $fin; ?><br>
		   <?php echo $contratante; ?>

		</p>
		<p style="height: 50px;" >Fecha de Dep. en Banco: <?php  echo $fechaPago; ?></p>
	</div>	
	</div>

	<div class="firmas">

	<div id="left">
	<label>Personal PROTEGES</label>
	<hr>
	<span><?php echo $personal; ?></span>
	</div>

    <div id="right">
	<label>Asegurado(a)</label>
	<hr>
	<span><?php echo $asegurado; ?></span>
	</div>

</div>

<p>Recibo para la Compañia/Folio(s) Cubierto(s)</p>

</body>
</html>