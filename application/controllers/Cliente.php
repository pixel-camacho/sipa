<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//Load libruary for API
class Cliente extends CI_Controller {

    function __construct() {
        parent::__construct();
//validar inicio de sesion en la aplicacion.
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
        }
		

        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('cliente_model', 'cliente');
        $this->load->library('permission');
        $this->load->library('nusoap');
	    
        }

    public function index() {
        $this->load->view('header');
        $this->load->view('cliente/index');
        $this->load->view('footer');
		
    }

    public function detalle($idcliente) {
        //next example will insert new conversation
		
        $service_url = 'http://190.9.53.22:8484/appsipaapi/detallecliente.php';
        $curl = curl_init($service_url);
        $curl_post_data = array(
            'idcliente' => $idcliente
        );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        $curl_response = curl_exec($curl);
        if ($curl_response === false) {
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('error occured during curl exec. Additioanl info: ' . var_export($info));
        }
        curl_close($curl);
        $decoded = json_decode($curl_response);

        $datoscliente = array(
            'rfc' => $decoded->rfc,
            'nombre' => $decoded->nombre,
            'fechanacimiento' => $decoded->fechanacimiento,
            'edad' => $decoded->edad,
            'sexo' => $decoded->sexo,
            'email' => $decoded->email,
            'nacionalidad' => $decoded->nacionalidad,
            'direccion' => $decoded->direccion,
            'coloniadescr' => $decoded->coloniaDescr,
            'nombrecentrotrabajo' => $decoded->nombrecentrotrabajo,
            'telefonos' => $decoded->telefonos
        );

        $data = array(
            'datoscliente' => $datoscliente,
            'idcliente' => $idcliente,
			'decoded' => $decoded
        );


        $this->load->view('header');
        $this->load->view('cliente/detalle', $data);
        $this->load->view('footer');
		
    }
   /*  public function poliza1($solicitudId)
     {  
        $service_url = "http://190.9.53.22:8484/appsipaapi/detallespoliza1.php";
        $curl = curl_init($service_url);
        $curl_post_data =  array('solicitudId' => $solicitudId);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
        $curl_response = curl_exec($curl);

        if($curl_response === false)
        {  
            $info = curl_getinfo($curl);
            curl_close($curl);
            die('ocurrio un error al ejecutar curl: '.var_export($info));
        }
        curl_close($curl);

        $decoded = json_decode($curl_response);

        $datospoliza1 = array(
            'asegurado' =>$decoded ->asegurado,
            'edadAsegurado' =>$decoded ->edadAsegurado,
            'responsable' =>$decoded ->responsable,
            'edadResponsable' => $decoded ->edadResponsable,
            'Agente' => $decoded ->Agente,
            'estatus' => $decoded ->estatus,
            'compania' => $decoded ->compania,
            'producto' => $decoded ->producto,
            'polizaAnterior' => $decoded ->polizaAnterior,
            'contratante' =>$decoded ->contratante,
            'municipio' => $decoded ->municipio,
            'paquete' => $decoded ->paquete,
            'periodoinicio' => $decoded ->periodoinicio,
            'fechaPrimer' => $decoded ->fechaPrimer,
            'periodo' => $decoded ->periodo,
            'clave' => $decoded ->clave,
            'fechaInicio' => $decoded ->fechaInicio,
            'fechaFin' => $decoded ->fechaFin,
            'total' => $decoded ->total,
            'descuento' => $decoded ->descuento,
            'solicitudId' => $decoded ->solicitudId,
            'noPoliza' => $decoded ->noPoliza);

        $data = array('solicitudId' => $solicitudId,
                      'datospoliza1' => $datospoliza1);

        $this->load->view('header');
        $this->load->view('cliente/poliza',$data);
        $this->load->view('footer');

     } */
	
      public function poliza ($solicitudId)
	  {	  		
	
		  $service_url = 'http://190.9.53.22:8484/appsipaapi/detallespoliza1.php';
          $curl = curl_init($service_url);
		  $curl_post_data = array ('solicitudId'=> $solicitudId);
		 
		  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		  curl_setopt($curl, CURLOPT_POST, true);
		  curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
		  $curl_response = curl_exec($curl);
		 
		   if($curl_response === false)
		    {
			   $info = curl_getinfo($curl);
			   curl_close($curl);
			   die('error occured during curl exec. Additional: '.var_export($info));
		    }
		   curl_close($curl);
		   $decoded = json_decode($curl_response);
		   
		  /*  $datospoliza = array(
		         'estatus' =>$decoded[0] ->estatus,
				 'compania' =>$decoded[0] -> compania,
				 'noPoliza' => $decoded[0] -> noPoliza,
				 'producto' => $decoded[0] ->producto,
				 'fechaInicio' => $decoded[0] ->fechaInicio,
				 'fechaFin' => $decoded[0] -> fechaFin,
				 'contratante' => $decoded[0] -> contratante,
				 'total' => $decoded[0] -> total,
				 'tipoPeriodo'=> $decoded[0] -> tipoPeriodo,
				 'clave' => $decoded[0] -> clave,
				 'descuento' => $decoded[0] -> descuento,
				 'rfc' => $decoded[0] -> rfc,
				 'nombre' => $decoded[0] -> nombre,
				 'apPaterno' => $decoded[0] -> apPaterno,
				 'apMaterno' => $decoded[0] -> apMaterno,
				 'edad' => $decoded[0] -> edad,
				 'rfcResponsable' => $decoded[0] -> rfcResponsable,
                 'nombreResponsable' => $decoded[0] -> nombreResponsable,
                 'apPaternoResponsable' => $decoded[0] -> apPaternoResponsable,
                 'apMaternoResponsable' => $decoded[0] -> apMaternoResponsable,
				 'edadResponsable' => $decoded[0] -> edadResponsable,
				 'periodoinicio' => $decoded[0] -> periodoinicio,
				 'municipio' => $decoded[0] -> municipio,
				 'fechaPrimer' => $decoded[0] -> fechaPrimer,
				 'Agente' => $decoded[0] -> Agente,
				 'paquete' => $decoded[0] -> paquete,
                 'solicitudIdAnt' => $decoded[0]-> solicitudIdAnt,
                 'solicitudAnterior' => $decoded[0] -> solicitudAnterior,
                 'polizaAnterior' => $decoded[0] -> polizaAnterior);*/


        $datospoliza = array(
            'asegurado' =>$decoded[0] ->asegurado,
            'edadAsegurado' =>$decoded[0]  ->edadAsegurado,
            'responsable' =>$decoded[0]  ->responsable,
            'edadResponsable' => $decoded[0] ->edadResponsable,
            'Agente' => $decoded[0] ->Agente,
            'agenteId' => $decoded[0] ->agenteId,
            'estatus' => $decoded[0] ->estatus,
            'compania' => $decoded[0] ->compania,
            'producto' => $decoded [0]->producto,
            'polizaAnterior' => $decoded [0]->polizaAnterior,
            'contratante' =>$decoded[0] ->contratante,
            'municipio' => $decoded[0] ->municipio,
            'paquete' => $decoded[0] ->paquete,
            'periodoinicio' => $decoded[0] ->periodoinicio,
            'fechaPrimer' => $decoded[0] ->fechaPrimer,
            'periodo' => $decoded[0] ->periodo,
            'clave' => $decoded[0] ->clave,
            'fechaInicio' => $decoded[0] ->fechaInicio,
            'fechaFin' => $decoded[0] ->fechaFin,
            'total' => $decoded[0] ->total,
            'descuento' => $decoded[0] ->descuento,
            'solicitudId' => $decoded[0] ->solicitudId,
            'noPoliza' => $decoded[0] ->noPoliza,
            'paqueteId' => $decoded[0] ->paqueteId);

		 
		    
		  
		 
	        $data = array ('datospoliza' => $datospoliza,
	                       'solicitudId' => $solicitudId);
				
		 $this->load->view('header');
	     $this->load->view('cliente/poliza',$data);
		 $this->load->view('footer');
     }
    public function boom()
    {
        echo 'bien !';
    }
     

     public function upload()
     {
       
     $this->load->model('document_model');
       $documentoId = $this->input->post("documentoId");
       
        $file = $_FILES['mi_file']['name'];
        $extension = pathinfo($file, PATHINFO_EXTENSION);
        $nombre =pathinfo($file, PATHINFO_FILENAME);
        $random = rand(1,9);
       
       
        
        $extensionesPermitidas = array("TIF","TIFF","pdf","PDF",'jpg','JPG','png','PNG');

         if(! in_array($extension,$extensionesPermitidas)) 
         {
            echo (json_encode(array('status'=>'wrongFile')));
            return; 
         }
        else
         {
           $nuevo_nombre = $nombre.$random.".".$extension; 
         } 

           $ruta = base_url("assets/Archivos/").$nuevo_nombre;

          $config['upload_path'] = './assets/Archivos/';
          $config['allowed_types'] = 'tif|pdf|jpg|png';
          $config['max_size'] = 0;
          $config['file_name'] = $nuevo_nombre;

          $this->load->library('upload',$config);

         if (!$this->upload->do_upload('mi_file'))
         {
           $error = array('error' => $this->upload->display_errors());
                    echo json_encode($error);
         } 
         else 
         {
           $data = array("upload_data" => $this->upload->data());
           $extension = $data['upload_data']['file_ext'];
           $nombre = $data['upload_data']['raw_name'];




           $documentArray = array('doctosSolicitudId' => $documentoId,
                                  'contenido' => $nombre,
                                  'documentoDescr' => $ruta,
                                  'titulo' => $nuevo_nombre,
                                  'extension' => $extension);

         $curl = curl_init();
           curl_setopt($curl,CURLOPT_URL,'http://190.9.53.22:8484/appsipaapi/uploadDocumento.php');
           curl_setopt($curl, CURLOPT_POST, true);
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
           curl_setopt($curl, CURLOPT_POSTFIELDS, $documentArray);
           $response = curl_exec($curl);
           curl_close($curl); 

           echo(json_encode(array('status'=>'ok')));
		}

    }

    public function generarQr($contenido,$filename)
    {
        $this->load->library('qr');
        $this->qr->generarCodigoQr($contenido,$filename);
    }


    public function consultar($url,$param)
    {

    $arrayReturn = [];
    $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $param);

    $curl_response = curl_exec($curl);

        if($curl_response === false)
        {
            $info = curl_getinfo($curl);
                    curl_close($curl);
                    die('error occured during curl exec. Additional: '.var_export($info));
        }
          curl_close($curl);
          
          $decoded = json_decode($curl_response);

          $arrayReturn = $decoded;

          return $arrayReturn;

    }


    public function imprimir($solicitudId)
    {
        $this->load->library('pdf');
        $curl_post_data = array('solicitudId' => $solicitudId);
        $decoded  = $this->consultar('http://190.9.53.22:8484/appsipaapi/infoReporte.php',$curl_post_data);

        $infoReporte = array('asegurado' => $decoded[0] ->asegurado,
                             'responsable' =>$decoded[0] ->responsable,
                             'noPoliza' =>$decoded[0] ->noPoliza,
                             'certificado' =>$decoded[0] ->certificado,
                             'inicio' =>$decoded[0] ->inicio,
                             'fin' =>$decoded[0] ->fin,
                             'antiguedad' =>$decoded[0] ->antiguedad,
                             'municipio' =>$decoded[0] ->municipio,
                             'honorario' =>$decoded[0] ->honorario,
                             'suma' =>$decoded[0] ->suma,
                             'nivel' =>$decoded[0] ->nivel,
                             'telefono' => $decoded[0] ->telefono,
                             'hoy' => $decoded[0] ->hoy);

        $this->pdf->generarPdf('cliente/reportes/pdf',$infoReporte,$infoReporte['asegurado']);
    
    }

    

    public function recibo($solicitudId){

        $this->load->library('pdf');
        $url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $periodo = explode( '/', $url);
        $curl_post_data = array('solicitudId' => $solicitudId,
                                'periodo' => $periodo[5]);
       $service_url = 'http://190.9.53.22:8484/appsipaapi/infoRecibo.php';
       
       $decoded = $this->consultar($service_url,$curl_post_data); 
         
       $infoRecibo = array('responsable' => $decoded[0] ->responsable,
                            'direccion' => $decoded[0] ->direcccion,
                            'asegurado' => $decoded[0] ->asegurado,
                            'periodo' => $decoded[0] ->periodo,
                            'fecha' => $decoded[0] ->fecha,
                            'fechaPago' => $decoded[0] ->fechaPago,
                            'concepto' => $decoded[0] ->concepto,
                            'ticket' => $decoded[0] ->ticket,
                            'importe' => $decoded[0] ->importe,
                            'compania' => $decoded[0] ->compania,
                            'contratante' => $decoded[0] ->contratante,
                            'personal' => $decoded[0] ->personal,
                            'noPoliza' => $decoded[0] ->noPoliza,
                            'inicio'  => $decoded[0] ->inicio,
                            'fin' => $decoded[0] ->fin,
                            'cantidad' => $decoded[0] ->cantidad);

      $this->pdf->generarPdf('cliente/reportes/recibo',$infoRecibo); 
    } 

    public function tarjeta($solicitudId)
    {
        $this->load->library('pdf');

      //$cadena = 'dallan camacho';
     // $codificado = convert_uuencode($cadena);

        
       //$this->generarQr($codificado,'lock2.png');

        $curl_post_data = array('solicitudId' => $solicitudId);
        $url = 'http://190.9.53.22:8484/appsipaapi/cliente/obtenerAsegurados.php';
        $decoded = $this->consultar($url,$curl_post_data);
    
         $num = count($decoded);

         if($num == 1)
         {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => true);
         }else if($num == 2)
         {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => true);
         }else if($num == 3)
         {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => true);
        }else if($num == 4)
        {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'nombre3'=> $decoded[3]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => true);
        }elseif($num == 5){

             $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'nombre3'=> $decoded[3]->nombre,
                                 'nombre4'=> $decoded[4]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => true);

        }elseif($num == 6)
        {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'nombre3'=> $decoded[3]->nombre,
                                 'nombre4'=> $decoded[4]->nombre,
                                 'nombre5'=> $decoded[5]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => true);

        }elseif($num == 7)
        {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'nombre3'=> $decoded[3]->nombre,
                                 'nombre4'=> $decoded[4]->nombre,
                                 'nombre5'=> $decoded[5]->nombre,
                                 'nombre6'=> $decoded[6]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => true);


        }else{

            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'nombre3'=> $decoded[3]->nombre,
                                 'nombre4'=> $decoded[4]->nombre,
                                 'nombre5'=> $decoded[5]->nombre,
                                 'nombre6'=> $decoded[6]->nombre,
                                 'nombre7'=> $decoded[7]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => true);
        }


     
       $this->pdf->generarCard('cliente/reportes/card',$infoTarjeta);
        
    }

 public function letterCard($solicitudId)
 {
     $this->load->library('pdf');

        
      //  $this->generarQr('LUIS MANUEL FONG AMBRIZ','LUIS MANUEL FONG AMBRIZ.png');

        $curl_post_data = array('solicitudId' => $solicitudId);
        $url = 'http://190.9.53.22:8484/appsipaapi/cliente/obtenerAsegurados.php';
        $decoded = $this->consultar($url,$curl_post_data);
    
         $num = count($decoded);

         if($num == 1)
         {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => false);
         }else if($num == 2)
         {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => false);
         }else if($num == 3)
         {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => false);
        }else if($num == 4)
        {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'nombre3'=> $decoded[3]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => false);
        }elseif($num == 5){

             $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'nombre3'=> $decoded[3]->nombre,
                                 'nombre4'=> $decoded[4]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => false);

        }elseif($num == 6)
        {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'nombre3'=> $decoded[3]->nombre,
                                 'nombre4'=> $decoded[4]->nombre,
                                 'nombre5'=> $decoded[5]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => false);

        }elseif($num == 7)
        {
            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'nombre3'=> $decoded[3]->nombre,
                                 'nombre4'=> $decoded[4]->nombre,
                                 'nombre5'=> $decoded[5]->nombre,
                                 'nombre6'=> $decoded[6]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => false);


        }else{

            $infoTarjeta = array('nombre' => $decoded[0]->nombre,
                                 'nombre1'=> $decoded[1]->nombre,
                                 'nombre2'=> $decoded[2]->nombre,
                                 'nombre3'=> $decoded[3]->nombre,
                                 'nombre4'=> $decoded[4]->nombre,
                                 'nombre5'=> $decoded[5]->nombre,
                                 'nombre6'=> $decoded[6]->nombre,
                                 'nombre7'=> $decoded[7]->nombre,
                                 'poliza' => $decoded[0]->poliza,
                                 'antiguedad' => $decoded[0]->antiguedad,
                                 'cantidad' => $num,
                                 'img' => false);
        }

       $this->pdf->generarCard('cliente/reportes/card',$infoTarjeta);
 }


  public function pagar($solicitudId)
  {
    $periodo =  $this->input->get_post('valor');
    $pago = $this->input->post('tipopago');
    $vendedor = $this->session->idusuario;
    $lineaPago = $this->input->get_post('ficha');
    $id = $solicitudId;
    $clave = $this->input->get_post('autorizacion');
    $this->load->library('pdf');
    $this->load->helper('url');

   // echo 'Id:'.$id.'<br>'.'tipoPago:'.$pago.'<br>'.'Periodo:'.$periodo.'<br>'.'Nombre:'.$vendedor.'<br>'.'fichaDeposito: '.$lineaPago.'<br>'.'noAutorizacion:'.$clave;


     $curl_post_data = array('id' => $id,
                             'periodo' => $periodo,
                             'nombre' => $vendedor,
                             'tipoPago' => $pago,
                             'noAutorizacion' => $clave,
                             'fichaDeposito' => $lineaPago);
   
    $service_url = 'http://190.9.53.22:8484/appsipaapi/cliente/pagarperiodo.php';
    $curl = curl_init($service_url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
    $curl_response = curl_exec($curl);

     if($curl_response ===  false)
     {
      $info = curl_getinfo($curl);
      curl_close($curl);
      die('un error ocurrio al ejecutar curl '.var_export($info));
     }

     if(!empty($curl_response))
     {
        //header("Location: http://190.9.53.22:8484/sipa/cliente/poliza/"+$solicitudId);
         redirect('Cliente/poliza/'.$id,'refresh'); 
        //$decoded = json_decode($curl_response);
        //$txt  =  array('mensaje' => $decoded[0]->mensaje);
       //echo $curl_response['mensaje'];
     }else
     {
        echo 'Cero resultados';
     }

        

/*
    $curl_post_data = array('solicitudId' => $solicitudId,
                             'periodo' => $periodo);
     $service_url = 'http://190.9.53.22:8484/appsipaapi/infoRecibo.php';
    $curl = curl_init($service_url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
    $curl_response = curl_exec($curl);

    if($curl_response === false)
        {
            $info = curl_getinfo($curl);
            curl_close($curl);
             die('error occured during curl exec. Additional: '.var_export($info));
        }
        curl_close($curl);
        $decoded =  json_decode($curl_response);

         $infoRecibo = array('responsable' => $decoded[0] ->responsable,
                            'direccion' => $decoded[0] ->direcccion,
                            'asegurado' => $decoded[0] ->asegurado,
                            'periodo' => $decoded[0] ->periodo,
                            'fecha' => $decoded[0] ->fecha,
                            'fechaPago' => $decoded[0] ->fechaPago,
                            'concepto' => $decoded[0] ->concepto,
                            'ticket' => $decoded[0] ->ticket,
                            'importe' => $decoded[0] ->importe,
                            'compania' => $decoded[0] ->compania,
                            'contratante' => $decoded[0] ->contratante,
                            'personal' => $decoded[0] ->personal,
                            'noPoliza' => $decoded[0] ->noPoliza,
                            'inicio'  => $decoded[0] ->inicio,
                            'fin' => $decoded[0] ->fin,
                            'cantidad' => $decoded[0] ->cantidad);

      $this->pdf->generarPdf('cliente/reportes/recibo',$infoRecibo);*/   

  } 




    public function addCliente() {

        $config = array(
            array(
                'field' => 'nombre',
                'label' => 'nombre',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'rfc',
                'label' => 'rfc',
                'rules' => 'trim|required|exact_length[13]',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'exact_length' => '16 digitos.'
                )
            ),
            array(
                'field' => 'aparterno',
                'label' => 'aparterno',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'sexo',
                'label' => 'sexo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'correo',
                'label' => 'correo',
                'rules' => 'trim|required|valid_email',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'valid_email' => 'LCorreo invalido.'
                )
            ),
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'estado',
                'label' => 'estado',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'municipio',
                'label' => 'municipio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'colonia',
                'label' => 'colonia',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'calle',
                'label' => 'calle',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'numeroexterior',
                'label' => 'numeroexterior',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'ocupacion',
                'label' => 'ocupacion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'nacionalidad',
                'label' => 'nacionalidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'lugarnacimiento',
                'label' => 'lugarnacimiento',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'fechanacimiento',
                'label' => 'fechanacimiento',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'estadocivil',
                'label' => 'estadocivil',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'centrotrabajo',
                'label' => 'centrotrabajo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'tiponomina',
                'label' => 'tiponomina',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'direccioncentrotrabajo',
                'label' => 'direccioncentrotrabajo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'estatus',
                'label' => 'estatus',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'nombre' => form_error('nombre'),
                'rfc' => form_error('rfc'),
                'aparterno' => form_error('aparterno'),
                'sexo' => form_error('sexo'),
                'correo' => form_error('correo'),
                'estado' => form_error('estado'),
                'municipio' => form_error('municipio'),
                'colonia' => form_error('colonia'),
                'calle' => form_error('calle'),
                'numeroexterior' => form_error('numeroexterior'),
                'ocupacion' => form_error('ocupacion'),
                'nacionalidad' => form_error('nacionalidad'),
                'lugarnacimiento' => form_error('lugarnacimiento'),
                'fechanacimiento' => form_error('fechanacimiento'),
                'estadocivil' => form_error('estadocivil'),
                'centrotrabajo' => form_error('centrotrabajo'),
                'tiponomina' => form_error('tiponomina'),
                'direccioncentrotrabajo' => form_error('direccioncentrotrabajo'),
                'estatus' => form_error('estatus')
            );
        } else {
            $factura = "";
            if ($this->input->post('factura') != FALSE) {
                $factura = 1;
            } else {
                $factura = 0;
            }

//             $cumpleanos = new DateTime($this->input->post('fechanacimiento'));
//            $hoy = new DateTime();
//            $annos = $hoy->diff($cumpleanos);
//            $edad= $annos->y;

            $service_url = 'http://190.9.53.22:8484/apirestfull/cliente/insertarCliente';
            $curl = curl_init($service_url);
            $curl_post_data = array(
                'nombre' => strtoupper($this->input->post('nombre')),
                'aparterno' => strtoupper($this->input->post('aparterno')),
                'amaterno' => strtoupper($this->input->post('amaterno')),
                'rfc' => strtoupper($this->input->post('rfc')),
                'sexo' => $this->input->post('sexo'),
                'correo' => $this->input->post('correo'),
                'colonia' => $this->input->post('idcolonia'),
                'calle' => strtoupper($this->input->post('calle')),
                'numeroexterior' => strtoupper($this->input->post('numeroexterior')),
                'nacionalidad' => strtoupper($this->input->post('nacionalidad')),
                'lugarnacimiento' => strtoupper($this->input->post('lugarnacimiento')),
                'ocupacion' => strtoupper($this->input->post('ocupacion')),
                'curp' => strtoupper($this->input->post('curp')),
                'fechanacimiento' => date("Y-m-d", strtotime($this->input->post('fechanacimiento'))),
                'estadocivil' => $this->input->post('estadocivil'),
                'centrotrabajo' => $this->input->post('idcentrotrabajo'),
                'direccioncentrotrabajo' => $this->input->post('direccioncentrotrabajo'),
                'tiponomina' => $this->input->post('tiponomina'),
                'estatus' => $this->input->post('estatus'),
                'factura' => $factura
            );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
            $curl_response = curl_exec($curl);
            if ($curl_response === false) {
                $info = curl_getinfo($curl);
                curl_close($curl);
                die('error occured during curl exec. Additioanl info: ' . var_export($info));
            }
            curl_close($curl);
            echo $decoded = json_decode($curl_response); 
           
        }
         echo json_encode($result);
    }
    function updateClient() {
        
        $config = array(
            array(
                'field' => 'nombrecliente',
                'label' => 'nombrecliente',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'rfc',
                'label' => 'rfc',
                'rules' => 'trim|required|exact_length[13]',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'exact_length' => '16 digitos.'
                )
            ),
            array(
                'field' => 'apellidopaterno',
                'label' => 'aparterno',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'sexo',
                'label' => 'sexo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'email',
                'label' => 'email',
                'rules' => 'trim|required|valid_email',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'valid_email' => 'LCorreo invalido.'
                )
            ),
            array(
                'field' => 'cveEstado',
                'label' => 'cveEstado',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            , 
            array(
                'field' => 'cveMunicipio',
                'label' => 'cveMunicipio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'idcoloniap',
                'label' => 'idcoloniap',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'direccion',
                'label' => 'direccion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'noExterior',
                'label' => 'noExterior',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'ocupacion',
                'label' => 'ocupacion',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'nacionalidad',
                'label' => 'nacionalidad',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'lugarNacimiento',
                'label' => 'lugarNacimiento',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'fechaNacimiento',
                'label' => 'fechaNacimiento',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'edoCivil',
                'label' => 'edoCivil',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'idcentrotrabajop',
                'label' => 'idcentrotrabajop',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'tipoNomina',
                'label' => 'tipoNomina',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'detalleCentroTrabajoId',
                'label' => 'detalleCentroTrabajoId',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'estatusCliente',
                'label' => 'estatusCliente',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
        );
        $this->form_validation->set_rules($config);
        if ($this->form_validation->run() == FALSE) {
            $result['error'] = true;
            $result['msg'] = array(
                'nombre' => form_error('nombrecliente'),
                'rfc' => form_error('rfc'),
                'aparterno' => form_error('apellidopaterno'),
                'sexo' => form_error('sexo'),
                'correo' => form_error('email'),
                'estado' => form_error('cveEstado'),
                'municipio' => form_error('cveMinicipio'),
                'colonia' => form_error('idcoloniap'),
                'calle' => form_error('direccion'),
                'numeroexterior' => form_error('noExterior'),
                'ocupacion' => form_error('ocupacion'),
                'nacionalidad' => form_error('nacionalidad'),
                'lugarnacimiento' => form_error('lugarNacimiento'),
                'fechanacimiento' => form_error('fechaNacimiento'),
                'estadocivil' => form_error('edoCivil'),
                'centrotrabajo' => form_error('idcentrotrabajop'),
                'tiponomina' => form_error('tipoNomina'),
                'direccioncentrotrabajo' => form_error('detalleCentroTrabajoId'),
                'estatus' => form_error('estatusCliente')
            );
        } else {
//            $factura = "";
//            if ($this->input->post('factura') != FALSE) {
//                $factura = 1;
//            } else {
//                $factura = 0;
//            }
//
//            $service_url = 'http://201.159.17.216:8484/apptest/cliente/insertarcliente.php';
//            $curl = curl_init($service_url);
//            $curl_post_data = array(
//                'nombre' => strtoupper($this->input->post('nombre')),
//                'aparterno' => strtoupper($this->input->post('aparterno')),
//                'amaterno' => strtoupper($this->input->post('amaterno')),
//                'rfc' => strtoupper($this->input->post('rfc')),
//                'sexo' => $this->input->post('sexo'),
//                'correo' => $this->input->post('correo'),
//                'colonia' => $this->input->post('idcolonia'),
//                'calle' => strtoupper($this->input->post('calle')),
//                'numeroexterior' => strtoupper($this->input->post('numeroexterior')),
//                'nacionalidad' => strtoupper($this->input->post('nacionalidad')),
//                'lugarnacimiento' => strtoupper($this->input->post('lugarnacimiento')),
//                'ocupacion' => strtoupper($this->input->post('ocupacion')),
//                'curp' => strtoupper($this->input->post('curp')),
//                'fechanacimiento' => date("Y-m-d", strtotime($this->input->post('fechanacimiento'))),
//                'estadocivil' => $this->input->post('estadocivil'),
//                'centrotrabajo' => $this->input->post('idcentrotrabajo'),
//                'direccioncentrotrabajo' => $this->input->post('direccioncentrotrabajo'),
//                'tiponomina' => $this->input->post('tiponomina'),
//                'estatus' => $this->input->post('estatus'),
//                'factura' => $factura
//            );
//            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($curl, CURLOPT_POST, true);
//            curl_setopt($curl, CURLOPT_POSTFIELDS, $curl_post_data);
//            $curl_response = curl_exec($curl);
//            if ($curl_response === false) {
//                $info = curl_getinfo($curl);
//                curl_close($curl);
//                die('error occured during curl exec. Additioanl info: ' . var_export($info));
//            }
//            curl_close($curl);
//            echo $decoded = json_decode($curl_response); 
           
        }
         echo json_encode($result);
    }

}
