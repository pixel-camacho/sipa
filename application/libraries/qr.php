<?php
     defined('BASEPATH') OR exit('No direct script access allowed');

     require_once 'phpqrcode/qrlib.php';

     
     class qr
     {
     	
     	public function generarCodigoQr($contentQr,$filename)
     	{
     		$direccion = "assets/images/QR";

     		if(! file_exists($direccion))
     		{
     			mkdir($direccion);
     		}

          $direccionFile = $direccion.'/'.$filename;

          $tamaño = 10;
          $precision = 'H';
          $frameSize = 1;

         $QR = QRcode::png($contentQr,$direccionFile, $precision, $tamaño, $frameSize);

            
     	}
     }