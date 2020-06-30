<!DOCTYPE html>
<html lang="in">
<head>
	<title>Tarjeta</title>
	<style type="text/css">
		#frente{
			width: 1063px;
			height: 590px;
			border-radius: 15px;
			position: absolute;
			display: block;
		}
		#asegurados{
			 position: absolute;
             top: 145px;
             left: 40px;
             margin: 0px;
             font-size: 27px;
             color:#f8f8f8;  
             list-style: none;
             font-family: Impact, Charcoal, sans-serif;
             font-weight: bolder;
             
		}
		#qr{
			position: absolute;
			top: 160px;
			right: 35px;
			width: 300px;
			height: 300px;
			border-radius: 10px;
			opacity: .7;
			border:solid;
		}
		#atras{
			width: 1063px;
			height: 590px;
			border-radius: 15px;
			display: block;
		}
		
	</style>
</head>
<body>
	<?php if($img) { ?>
	<img src="assets/images/card/Frente.png" id="frente" alt="card-frontal">
		<ul id="asegurados">
			<li id="asegurado">

				
 
				<?php if($cantidad == 1) { ?>
				<span>
					<?php echo $nombre?>	
				</span>
			    <?php } elseif ($cantidad == 2) {
			    	echo $nombre.'<br>'.$nombre1; 
			          }elseif ($cantidad == 3) {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2; 
			          } elseif($cantidad == 4) {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2.'<br>'.$nombre3; 
			          }elseif($cantidad == 5)
			          {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2.'<br>'.$nombre3.'<br>'.$nombre4; 
			          }elseif ($cantidad == 6) {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2.'<br>'.$nombre3.'<br>'.$nombre4.
			          	             '<br>'.$nombre5;
			          }elseif($cantidad == 7)
			          {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2.'<br>'.$nombre3.'<br>'.$nombre4.
			          	             '<br>'.$nombre5.'<br>'.$nombre6;
			          }else
			          {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2.'<br>'.$nombre3.'<br>'.$nombre4.
			          	             '<br>'.$nombre5.'<br>'.$nombre6.'<br>'.$nombre7;
			          }
			    ?>
				 
			</li>
				<br>
				<span>Políza GMM <?php echo $poliza; ?></span>
				<br>
				<span id="title">Antiguedad <?php echo $antiguedad ;?> </span>
			</li>
		</ul>
		<?php 

             echo "<img id='qr' src='assets/images/QR/".$nombre.".png' alt='noo!'>";
           
		?>
<?php  } elseif(!$img) {?>

	<style type="text/css">
		#asegurados {
			color: black;
			font-size: 35px;
			top: 110px;
			left: 10px;
		}
		#qr{
			position: absolute;
			top: 180px;
			right: 5px;
			width: 300px;
			height: 300px;
		}
		
	</style>

	<ul id="asegurados">
			<li id="asegurado" >

				
 
				<?php if($cantidad == 1) { ?>
				<span>
					<?php echo $nombre?>	
				</span>
			    <?php } elseif ($cantidad == 2) {
			    	echo $nombre.'<br>'.$nombre1; 
			          }elseif ($cantidad == 3) {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2; 
			          } elseif($cantidad == 4) {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2.'<br>'.$nombre3; 
			          }elseif($cantidad == 5)
			          {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2.'<br>'.$nombre3.'<br>'.$nombre4; 
			          }elseif ($cantidad == 6) {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2.'<br>'.$nombre3.'<br>'.$nombre4.
			          	             '<br>'.$nombre5;
			          }elseif($cantidad == 7)
			          {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2.'<br>'.$nombre3.'<br>'.$nombre4.
			          	             '<br>'.$nombre5.'<br>'.$nombre6;
			          }else
			          {
			          	echo $nombre.'<br>'.$nombre1.'<br>'.$nombre2.'<br>'.$nombre3.'<br>'.$nombre4.
			          	             '<br>'.$nombre5.'<br>'.$nombre6.'<br>'.$nombre7;
			          }
			    ?>
				 
			</li>
				<br>
				<span>Políza GMM <?php echo $poliza; ?></span>
				<br>
				<span id="title">Antiguedad <?php echo $antiguedad ;?> </span>
			</li>
		</ul>
	 <?php 
         
      echo "<img id='qr' src='assets/images/QR/".$nombre.".png' alt='noo!'>";
          
	 	?>
	   
   

<?php } ?>

<?php if($img) { ?>
<img src="assets/images/card/Trasera.png" id="atras"  alt="card-trasera"> 
<?php  }?>

</body>
</html>
