<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class latino extends CI_controller
{

	var $url ="https://servintd.latinoseguros.com.mx:8070/wsCotizadorAutosQA/Cotizador/CotizadorLatino.svc?WSDL";

	//Credencial Web Services.
	var $idApp = 30041;
	var $passApp = "CD77ED53SPROT";
	var $claveUsuario = "7753";
  var $password = "WS7753PROT";
    
	
	function __construct()
	{
		parent::__construct();

		if(!isset($_SESSION['user_id']))
		{
			$this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
		}

		$this->load->helper('url');
    $this->load->model('data_model');
    $this->load->model('Colonia_model', 'colonia');
    $this->load->model('user_model', 'usuarioo');
		$this->load->library('permission');
    $this->load->library('nusoap');

	}

function index()
{

  $colonias = $this->colonia->showAll();
  $ocupaciones = $this->ocupaciones();

  $data = ["datacolonia"=> $colonias,
           "dataocuáciones" => $ocupaciones];

  $this->load->view('header');
  $this->load->view('latino/index',$data);
  $this->load->view('footer');
}


public function XMLtoArray($xml)
{
	$xml_array = [];
    $xml_parser = xml_parser_create();

        xml_parse_into_struct($xml_parser, $xml, $vals);
        xml_parser_free($xml_parser);

        // wyznaczamy tablice z powtarzajacymi sie tagami na tym samym poziomie

        $_tmp = '';
        foreach ($vals as $xml_elem) {
            $x_tag = $xml_elem['tag'];
            $x_level = $xml_elem['level'];
            $x_type = $xml_elem['type'];
            if ($x_level != 1 && $x_type == 'close') {
                if (isset($multi_key[$x_tag][$x_level]))
                    $multi_key[$x_tag][$x_level] = 1;
                else
                    $multi_key[$x_tag][$x_level] = 0;
            }

            if ($x_level != 1 && $x_type == 'complete') {
                if ($_tmp == $x_tag)
                    $multi_key[$x_tag][$x_level] = 1;
                $_tmp = $x_tag;
            }
        }

        // jedziemy po tablicy

        foreach ($vals as $xml_elem) {
            $x_tag = $xml_elem['tag'];
            $x_level = $xml_elem['level'];
            $x_type = $xml_elem['type'];
            if ($x_type == 'open')
                $level[$x_level] = $x_tag;
            $start_level = 1;
            $php_stmt = '$xml_array';
            if ($x_type == 'close' && $x_level != 1)
                $multi_key[$x_tag][$x_level] ++;
            while ($start_level < $x_level) {
                $php_stmt .= '[$level[' . $start_level . ']]';
                if (isset($multi_key[$level[$start_level]][$start_level]) && $multi_key[$level[$start_level]][$start_level])
                    $php_stmt .= '[' . ($multi_key[$level[$start_level]][$start_level] - 1) . ']';
                $start_level++;
            }

            $add = '';
            if (isset($multi_key[$x_tag][$x_level]) && $multi_key[$x_tag][$x_level] && ($x_type == 'open' || $x_type == 'complete')) {
                if (!isset($multi_key2[$x_tag][$x_level]))
                    $multi_key2[$x_tag][$x_level] = 0;
                else
                    $multi_key2[$x_tag][$x_level] ++;
                $add = '[' . $multi_key2[$x_tag][$x_level] . ']';
            }

            if (isset($xml_elem['value']) && trim($xml_elem['value']) != '' && !array_key_exists('attributes', $xml_elem)) {
                if ($x_type == 'open')
                    $php_stmt_main = $php_stmt . '[$x_type]' . $add . '[\'content\'] = $xml_elem[\'value\'];';
                else
                    $php_stmt_main = $php_stmt . '[$x_tag]' . $add . ' = $xml_elem[\'value\'];';
                eval($php_stmt_main);
            }

            if (array_key_exists('attributes', $xml_elem)) {
                if (isset($xml_elem['value'])) {
                    $php_stmt_main = $php_stmt . '[$x_tag]' . $add . '[\'content\'] = $xml_elem[\'value\'];';
                    eval($php_stmt_main);
                }

                foreach ($xml_elem['attributes'] as $key => $value) {
                    $php_stmt_att = $php_stmt . '[$x_tag]' . $add . '[$key] = $value;';
                    eval($php_stmt_att);
                }
            }
        }

        return $xml_array;
}


public function callLatino($xml,$action)
{
    $arrayresult = array();
    $url = $this->url;
	  $headers = [ "Content-type: text/xml;charset=utf-8", "Content-length: ".strlen($xml), "SOAPAction: ".$action];
    $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_TIMEOUT, 100);
          curl_setopt($ch, CURLOPT_POST, true);
          curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
          curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

      $response = curl_exec($ch);

        if(curl_errno($ch))
     {
     	  print curl_error($ch);
          echo "Algo fallo";
     } else
     {
        $arrayresult = $this->XMLtoArray($response);
     }

 return $arrayresult;
}

 public function catalogs($tags,$param)
 {
   $result =  array();
   //$values = $param;
   $params = explode('-',$param);
   $action = 'http://tempuri.org/ICotizadorLatino/ObtenerCatalogos';
   $select = ' '; 
   $xml = '<?xml version="1.0" encoding="UTF-8"?>
   <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos" xmlns:ns2="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador" xmlns:ns3="http://tempuri.org/">
     <SOAP-ENV:Body>
       <ns3:ObtenerCatalogos>
         <ns3:datos>
           <ns2:credenciales>
             <ns1:IdApp>'.$this->idApp.'</ns1:IdApp>
             <ns1:PassApp>'.$this->passApp.'</ns1:PassApp>
             <ns1:ClaveUsuario>'.$this->claveUsuario.'</ns1:ClaveUsuario>
             <ns1:Password>'.$this->password.'</ns1:Password>
           </ns2:credenciales>
           <ns2:datosAuto>
             <ns1:ClaveProducto>'.$params[0].'</ns1:ClaveProducto>
             <ns1:Tarifa>'.$params[1].'</ns1:Tarifa>
             <ns1:TipoVehiculo>'.$params[2].'</ns1:TipoVehiculo>
             <ns1:ClavePerfil></ns1:ClavePerfil>
             <ns1:ClaveModelo></ns1:ClaveModelo>
             <ns1:ClaveMarca></ns1:ClaveMarca>
             <ns1:ClaveSubMarca></ns1:ClaveSubMarca>
             <ns1:ClaveVehiculo></ns1:ClaveVehiculo>
             <ns1:NumeroSerieAuto></ns1:NumeroSerieAuto>
             <ns1:SerieValida>true</ns1:SerieValida>
             <ns1:NumeroPlacas></ns1:NumeroPlacas>
             <ns1:NumeroMotor></ns1:NumeroMotor>
             <ns1:NumeroControlVehicular></ns1:NumeroControlVehicular>
             <ns1:NombreConductor></ns1:NombreConductor>
             <ns1:BeneficiarioPreferente></ns1:BeneficiarioPreferente>
           </ns2:datosAuto>
           <ns2:caracteristicasCotizacion>
             <ns1:ClaveEstado></ns1:ClaveEstado>
             <ns1:ClavePaquete></ns1:ClavePaquete>
             <ns1:ClaveVigencia></ns1:ClaveVigencia>
             <ns1:ClaveServicio></ns1:ClaveServicio>
             <ns1:ClaveDescuento></ns1:ClaveDescuento>
             <ns1:ClaveAgente></ns1:ClaveAgente>
             <ns1:ClaveFormaPago></ns1:ClaveFormaPago>
           </ns2:caracteristicasCotizacion>
         </ns3:datos>
       </ns3:ObtenerCatalogos>
     </SOAP-ENV:Body>
   </SOAP-ENV:Envelope>';

  $result = $this->callLatino($xml,$action);
  $catalogo = $result['S:ENVELOPE']['S:BODY']['OBTENERCATALOGOSRESPONSE']['OBTENERCATALOGOSRESULT'][$tags[0]][$tags[1]];

  if(isset($result) && !empty($catalogo) && is_array($catalogo))
  {    
      foreach ($catalogo as $value) {
        $clave = $value['A:CLAVE'];
        $select .= "<option value='$clave'>".$value['A:DESCRIPCION']."</option>";
      }
  }else
  {
     $clave = $catalogo['A:CLAVE'];
     $select .= "<option value='$clave'>".$value['A:DESCRIPCION']."</option>";
  }
  
  echo $select;

 }

 public function getCarAndDetail($soapAction ,$param ,$modelo,$paquete,$marca = null ,$submarca = null,$index)
 {

  $result = array();
  $select = ' ';
  $SOAP = strtoupper($soapAction);
  $action = "http://tempuri.org/ICotizadorLatino/".$soapAction;
  $xml = '<?xml version="1.0" encoding="UTF-8"?>
  <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos" xmlns:ns2="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador" xmlns:ns3="http://tempuri.org/">
    <SOAP-ENV:Body>
      <ns3:'.$soapAction.'>
        <ns3:datos>
          <ns2:credenciales>
            <ns1:IdApp>'.$this->idApp.'</ns1:IdApp>
            <ns1:PassApp>'.$this->passApp.'</ns1:PassApp>
            <ns1:ClaveUsuario>'.$this->claveUsuario.'</ns1:ClaveUsuario>
            <ns1:Password>'.$this->password.'</ns1:Password>
          </ns2:credenciales>
          <ns2:datosAuto>
            <ns1:ClaveProducto>'.$param[0].'</ns1:ClaveProducto>
            <ns1:Tarifa>'.$param[1].'</ns1:Tarifa>
            <ns1:TipoVehiculo>'.$param[2].'</ns1:TipoVehiculo>
            <ns1:ClavePerfil>'.$param[3].'</ns1:ClavePerfil>
            <ns1:ClaveModelo>'.$modelo.'</ns1:ClaveModelo>
            <ns1:ClaveMarca>'.$marca.'</ns1:ClaveMarca>
            <ns1:ClaveSubMarca>'.$submarca.'</ns1:ClaveSubMarca>
            <ns1:ClaveVehiculo></ns1:ClaveVehiculo>
            <ns1:NumeroSerieAuto></ns1:NumeroSerieAuto>
            <ns1:SerieValida>false</ns1:SerieValida>
            <ns1:NumeroPlacas></ns1:NumeroPlacas>
            <ns1:NumeroMotor></ns1:NumeroMotor>
            <ns1:NumeroControlVehicular></ns1:NumeroControlVehicular>
            <ns1:NombreConductor></ns1:NombreConductor>
            <ns1:BeneficiarioPreferente></ns1:BeneficiarioPreferente>
          </ns2:datosAuto>
          <ns2:caracteristicasCotizacion>
            <ns1:ClaveEstado></ns1:ClaveEstado>
            <ns1:ClavePaquete>'.$paquete.'</ns1:ClavePaquete>
            <ns1:ClaveVigencia></ns1:ClaveVigencia>
            <ns1:ClaveServicio></ns1:ClaveServicio>
            <ns1:ClaveDescuento></ns1:ClaveDescuento>
            <ns1:ClaveAgente></ns1:ClaveAgente>
            <ns1:ClaveFormaPago></ns1:ClaveFormaPago>
          </ns2:caracteristicasCotizacion>
        </ns3:datos>
      </ns3:'.$soapAction.'>
    </SOAP-ENV:Body>
  </SOAP-ENV:Envelope>';

  $result = $this->callLatino($xml,$action);
  $list = $result['S:ENVELOPE']['S:BODY'][$SOAP.'RESPONSE'][$SOAP.'RESULT'][$index[0]][$index[1]];

  if(isset($result) && !empty($list))
  {
    foreach ($list as $value) 
    {
      $clave = $value['B:CLAVE'];
      $select .= "<option value='$clave'>".$value['B:DESCRIPCION']."</option>";
    }
  }
   
   echo $select;
   
 }

 public function getMarca()
 {
   $index = array('A:MARCAS','B:MARCA');
   $soapAction = 'ObtenerMarcas';
   $param = $this->input->post('params');
   $params = explode('-',$param);
   $modelo = $this->input->post('modelo');
   $paquete = $this->input->post('paquete');
  
   $txtSelect = $this->getCarAndDetail($soapAction,$params,$modelo,$paquete,null,null,$index);

     echo $txtSelect; 
 }

 public function getSubmarca()
 {
   $index = array('A:SUBMARCAS','B:SUBMARCA');
   $soapAction = 'ObtenerSubMarcas';
   $param = $this->input->post('params');
   $params = explode('-',$param);
   $modelo = $this->input->post('modelo');
   $marca = $this->input->post('marca');
   $paquete = $this->input->post('paquete');

   $txtSelect = $this->getCarAndDetail($soapAction,$params,$modelo,$paquete,$marca,null,$index);

     echo $txtSelect;
   
 }

 public function getDecuentos ()
 {
   $result =  array();
   $action = 'http://tempuri.org/ICotizadorLatino/ObtenerDescuentosYModelos';
   $input  = $this->input->post('params');
   $param  = explode('-',$input);
   $selectPaquete = $this->input->post('paquete');
   $selectEstado = $this->input->post('estado');
   $select = '';
   $xml = '<?xml version="1.0" encoding="UTF-8"?>
   <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos" xmlns:ns2="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador" xmlns:ns3="http://tempuri.org/">
     <SOAP-ENV:Body>
       <ns3:ObtenerDescuentosYModelos>
         <ns3:datos>
           <ns2:credenciales>
             <ns1:IdApp>'.$this->idApp.'</ns1:IdApp>
             <ns1:PassApp>'.$this->passApp.'</ns1:PassApp>
             <ns1:ClaveUsuario>'.$this->claveUsuario.'</ns1:ClaveUsuario>
             <ns1:Password>'.$this->password.'</ns1:Password>
           </ns2:credenciales>
           <ns2:datosAuto>
             <ns1:ClaveProducto>'.$param[0].'</ns1:ClaveProducto>
             <ns1:Tarifa>'.$param[1].'</ns1:Tarifa>
             <ns1:TipoVehiculo>'.$param[2].'</ns1:TipoVehiculo>
             <ns1:ClavePerfil>'.$param[3].'</ns1:ClavePerfil>
             <ns1:ClaveModelo></ns1:ClaveModelo>
             <ns1:ClaveMarca></ns1:ClaveMarca>
             <ns1:ClaveSubMarca></ns1:ClaveSubMarca>
             <ns1:ClaveVehiculo></ns1:ClaveVehiculo>
             <ns1:NumeroSerieAuto></ns1:NumeroSerieAuto>
             <ns1:SerieValida>false</ns1:SerieValida>
             <ns1:NumeroPlacas></ns1:NumeroPlacas>
             <ns1:NumeroMotor></ns1:NumeroMotor>
             <ns1:NumeroControlVehicular></ns1:NumeroControlVehicular>
             <ns1:NombreConductor></ns1:NombreConductor>
             <ns1:BeneficiarioPreferente></ns1:BeneficiarioPreferente>
           </ns2:datosAuto>
           <ns2:caracteristicasCotizacion>
             <ns1:ClaveEstado>'.$selectPaquete.'</ns1:ClaveEstado>
             <ns1:ClavePaquete>'.$selectEstado.'</ns1:ClavePaquete>
             <ns1:ClaveVigencia></ns1:ClaveVigencia>
             <ns1:ClaveServicio></ns1:ClaveServicio>
             <ns1:ClaveDescuento></ns1:ClaveDescuento>
             <ns1:ClaveAgente></ns1:ClaveAgente>
             <ns1:ClaveFormaPago></ns1:ClaveFormaPago>
           </ns2:caracteristicasCotizacion>
         </ns3:datos>
       </ns3:ObtenerDescuentosYModelos>
     </SOAP-ENV:Body>
   </SOAP-ENV:Envelope>';   

   $result = $this->callLatino($xml,$action);
   $modelAndDescuento = $result['S:ENVELOPE']['S:BODY']['OBTENERDESCUENTOSYMODELOSRESPONSE']['OBTENERDESCUENTOSYMODELOSRESULT']['A:DESCUENTOS']['A:DESCUENTO'];

     if(isset($result) && !empty($modelAndDescuento))
     {
       foreach($modelAndDescuento as $value)
       {
          $clave = $value['A:CLAVE'];
          $select .= "<option value='$clave'>".$value['A:DESCRIPCION']."</option>";
       }
     }

     echo $select;

 }

public function getCoverage()
{
  $result = [];
  $select = '';
  $action = "http://tempuri.org/ICotizadorLatino/ObtenerCoberturas";
  $param = $this->input->post('params');
  $params = explode('-',$param);
  $modelo = $this->input->post('modelo');
  $marca = $this->input->post('marca');
  $subMarca = $this->input->post('submarca');
  $descripcion = $this->input->post('descripcion');
  $paquete = $this->input->post('paquete');
  $estado = $this->input->post('estado');
  $xml = '<?xml version="1.0" encoding="UTF-8"?>
  <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos" xmlns:ns2="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador" xmlns:ns3="http://tempuri.org/">
    <SOAP-ENV:Body>
      <ns3:ObtenerCoberturas>
        <ns3:datos>
          <ns2:credenciales>
            <ns1:IdApp>'.$this->idApp.'</ns1:IdApp>
            <ns1:PassApp>'.$this->passApp.'</ns1:PassApp>
            <ns1:ClaveUsuario>'.$this->claveUsuario.'</ns1:ClaveUsuario>
            <ns1:Password>'.$this->password.'</ns1:Password>
          </ns2:credenciales>
          <ns2:datosAuto>
            <ns1:ClaveProducto>'.$params[0].'</ns1:ClaveProducto>
            <ns1:Tarifa>'.$params[1].'</ns1:Tarifa>
            <ns1:TipoVehiculo>'.$params[2].'</ns1:TipoVehiculo>
            <ns1:ClavePerfil>'.$params[3].'</ns1:ClavePerfil>
            <ns1:ClaveModelo>'.$modelo.'</ns1:ClaveModelo>
            <ns1:ClaveMarca>'.$marca.'</ns1:ClaveMarca>
            <ns1:ClaveSubMarca>'.$subMarca.'</ns1:ClaveSubMarca>
            <ns1:ClaveVehiculo>'.$descripcion.'</ns1:ClaveVehiculo>
            <ns1:NumeroSerieAuto></ns1:NumeroSerieAuto>
            <ns1:SerieValida>true</ns1:SerieValida>
            <ns1:NumeroPlacas></ns1:NumeroPlacas>
            <ns1:NumeroMotor></ns1:NumeroMotor>
            <ns1:NumeroControlVehicular></ns1:NumeroControlVehicular>
            <ns1:NombreConductor></ns1:NombreConductor>
            <ns1:BeneficiarioPreferente></ns1:BeneficiarioPreferente>
          </ns2:datosAuto>
          <ns2:caracteristicasCotizacion>
            <ns1:ClaveEstado>'.$estado.'</ns1:ClaveEstado>
            <ns1:ClavePaquete>'.$paquete.'</ns1:ClavePaquete>
            <ns1:ClaveVigencia></ns1:ClaveVigencia>
            <ns1:ClaveServicio></ns1:ClaveServicio>
            <ns1:ClaveDescuento></ns1:ClaveDescuento>
            <ns1:ClaveAgente></ns1:ClaveAgente>
            <ns1:ClaveFormaPago></ns1:ClaveFormaPago>
          </ns2:caracteristicasCotizacion>
        </ns3:datos>
      </ns3:ObtenerCoberturas>
    </SOAP-ENV:Body>
  </SOAP-ENV:Envelope>';

  $result = $this->callLatino($xml,$action);
  $cobertura = $result['S:ENVELOPE']['S:BODY']['OBTENERCOBERTURASRESPONSE']['OBTENERCOBERTURASRESULT']['A:COBERTURAS']['B:COBERTURAS'];
    
    // if(isset($result) && !empty($cobertura))
    // {
    //   foreach($cobertura as $value)
    //   {
    //     $clave = $value['B:CLAVE'];
    //     $select .= "<option value='$clave'>".$value['B:DESCRIPCION']."</option>";
    //   }
    // }
  
    var_dump($cobertura);

}

public  function getQuote()
{
  $result = [];
  $action = "http://tempuri.org/ICotizadorLatino/Cotizar";
  $param = $this->input->post('params');
  $params = explode('-',$param);
  $datosAuto = $this->input->post('datacar');
  $DescripcionCotizar = $this->input->post('datacotilizar');
  $cobertura = $this->input->post('covertura');
  $select = '';
  $xml = '<?xml version="1.0" encoding="UTF-8"?>
  <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos" xmlns:ns2="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador" xmlns:ns3="http://tempuri.org/">
    <SOAP-ENV:Body>
      <ns3:Cotizar>
        <ns3:datosCotizar>
          <ns2:credenciales>
            <ns1:IdApp>'.$this->idApp.'</ns1:IdApp>
            <ns1:PassApp>'.$this->passApp.'</ns1:PassApp>
            <ns1:ClaveUsuario>'.$this->claveUsuario.'</ns1:ClaveUsuario>
            <ns1:Password>'.$this->password.'</ns1:Password>
          </ns2:credenciales>
          <ns2:caracteristicasCotizacion>
            <ns1:ClaveEstado>'.$DescripcionCotizar[0].'</ns1:ClaveEstado>
            <ns1:ClavePaquete>'.$DescripcionCotizar[1].'</ns1:ClavePaquete>
            <ns1:ClaveVigencia>'.$DescripcionCotizar[2].'</ns1:ClaveVigencia>
            <ns1:ClaveServicio>'.$DescripcionCotizar[3].'</ns1:ClaveServicio>
            <ns1:ClaveDescuento>'.$DescripcionCotizar[4].'</ns1:ClaveDescuento>
            <ns1:ClaveAgente>'.$this->claveUsuario.'</ns1:ClaveAgente>
            <ns1:ClaveFormaPago>'.$DescripcionCotizar[5].'</ns1:ClaveFormaPago>
          </ns2:caracteristicasCotizacion>
          <ns2:datosAuto>
            <ns1:ClaveProducto>'.$params[0].'</ns1:ClaveProducto>
            <ns1:Tarifa>'.$params[1].'</ns1:Tarifa>
            <ns1:TipoVehiculo>'.$params[2].'</ns1:TipoVehiculo>
            <ns1:ClavePerfil>'.$params[3].'</ns1:ClavePerfil>
            <ns1:ClaveModelo>'.datosAuto[0].'</ns1:ClaveModelo>
            <ns1:ClaveMarca>'.datosAuto[1].'</ns1:ClaveMarca>
            <ns1:ClaveSubMarca>'.datosAuto[2].'</ns1:ClaveSubMarca>
            <ns1:ClaveVehiculo>'.datosAuto[3].'</ns1:ClaveVehiculo>
            <ns1:NumeroSerieAuto></ns1:NumeroSerieAuto>
            <ns1:SerieValida>true</ns1:SerieValida>
            <ns1:NumeroPlacas></ns1:NumeroPlacas>
            <ns1:NumeroMotor></ns1:NumeroMotor>
            <ns1:NumeroControlVehicular></ns1:NumeroControlVehicular>
            <ns1:NombreConductor></ns1:NombreConductor>
            <ns1:BeneficiarioPreferente></ns1:BeneficiarioPreferente>
          </ns2:datosAuto>
          <ns2:ValorConvenido>0</ns2:ValorConvenido>
          <ns2:FechaFactura></ns2:FechaFactura>
          <ns2:ValorFactura>0</ns2:ValorFactura>
          <ns2:coberturasAmparadas>
            <ns2:CoberturaAmparada>
              <ns2:Amparada>true</ns2:Amparada>
              <ns2:Clave>'.$cobertura[0].'</ns2:Clave>
              <ns2:Descripcion>'.$cobertura[1].'</ns2:Descripcion>
              <ns2:SumaAsegurada>0</ns2:SumaAsegurada>
              <ns2:DescripcionSumaAsegurada>'.$cobertura[2].'</ns2:DescripcionSumaAsegurada>
              <ns2:PorcentajeDeducible>0</ns2:PorcentajeDeducible>
              <ns2:DescripcionDeducible>'.$cobertura[3].'</ns2:DescripcionDeducible>
              <ns2:PrimaNeta>'.$cobertura[4].'</ns2:PrimaNeta>
            </ns2:CoberturaAmparada>
          </ns2:coberturasAmparadas>
        </ns3:datosCotizar>
      </ns3:Cotizar>
    </SOAP-ENV:Body>
  </SOAP-ENV:Envelope>';

  $result = $this->callLatino($xml,$action);
  $cotizacion = $resultt['S:ENVELOPE']['S:BODY']['COTIZARRESPONSE']['COTIZARRESULT'];

  echo cotizar;

}

public function getDescripcion1()
{
  $result = array();
  $action = 'http://tempuri.org/ICotizadorLatino/ObtenerDescripcionVehiculo';
  $param = $this->input->post('params');
  $params = explode('-',$param);
  $modelo = $this->input->post('modelo');
  $marca = $this->input->post('marca');
  $subMarca = $this->input->post('submarca');
  $paquete = $this->input->post('paquete');
  $select = ' ';
  $xml = '<?xml version="1.0" encoding="UTF-8"?>
  <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos" xmlns:ns2="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador" xmlns:ns3="http://tempuri.org/">
    <SOAP-ENV:Body>
      <ns3:ObtenerDescripcionVehiculo>
        <ns3:datos>
          <ns2:credenciales>
            <ns1:IdApp>'.$this->idApp.'</ns1:IdApp>
            <ns1:PassApp>'.$this->passApp.'</ns1:PassApp>
            <ns1:ClaveUsuario>'.$this->claveUsuario.'</ns1:ClaveUsuario>
            <ns1:Password>'.$this->password.'</ns1:Password>
          </ns2:credenciales>
          <ns2:datosAuto>
            <ns1:ClaveProducto>'.$params[0].'</ns1:ClaveProducto>
            <ns1:Tarifa>'.$params[1].'</ns1:Tarifa>
            <ns1:TipoVehiculo>'.$params[2].'</ns1:TipoVehiculo>
            <ns1:ClavePerfil>'.$params[3].'</ns1:ClavePerfil>
            <ns1:ClaveModelo>'.$modelo.'</ns1:ClaveModelo>
            <ns1:ClaveMarca>'.$marca.'</ns1:ClaveMarca>
            <ns1:ClaveSubMarca>'.$subMarca.'</ns1:ClaveSubMarca>
            <ns1:ClaveVehiculo></ns1:ClaveVehiculo>
            <ns1:NumeroSerieAuto></ns1:NumeroSerieAuto>
            <ns1:SerieValida>true</ns1:SerieValida>
            <ns1:NumeroPlacas></ns1:NumeroPlacas>
            <ns1:NumeroMotor></ns1:NumeroMotor>
            <ns1:NumeroControlVehicular></ns1:NumeroControlVehicular>
            <ns1:NombreConductor></ns1:NombreConductor>
            <ns1:BeneficiarioPreferente></ns1:BeneficiarioPreferente>
          </ns2:datosAuto>
          <ns2:caracteristicasCotizacion>
            <ns1:ClaveEstado></ns1:ClaveEstado>
            <ns1:ClavePaquete>'.$paquete.'</ns1:ClavePaquete>
            <ns1:ClaveVigencia></ns1:ClaveVigencia>
            <ns1:ClaveServicio></ns1:ClaveServicio>
            <ns1:ClaveDescuento></ns1:ClaveDescuento>
            <ns1:ClaveAgente></ns1:ClaveAgente>
            <ns1:ClaveFormaPago></ns1:ClaveFormaPago>
          </ns2:caracteristicasCotizacion>
        </ns3:datos>
      </ns3:ObtenerDescripcionVehiculo>
    </SOAP-ENV:Body>
  </SOAP-ENV:Envelope>';

    $result = $this->callLatino($xml,$action);
    $descripcion = $result['S:ENVELOPE']['S:BODY']['OBTENERDESCRIPCIONVEHICULORESPONSE']['OBTENERDESCRIPCIONVEHICULORESULT']
                          ['A:VEHICULOS']['B:DESCRIPCIONVEHICULO']; 
              if(isset($result) && !empty($descripcion))
              {
                foreach($descripcion as $value)
                {
                  $clave = $value['B:CLAVE'];
                  $select .= "<option value='$clave'>".$value['B:DESCRIPCION']."</option>";

                }
             
              } 

       echo $select;
}

 public function getState()
 {
   $index1 = 'A:ESTADOS';
   $index2 = 'A:ESTADO';
   $indexs = array($index1,$index2);
   $param = $this->input->post('textsearch');
   $result = ' ';

   $result = $this->catalogs($indexs,$param);

   echo $result;
 }

 public function getPackage()
 {
   $index1 = 'A:PAQUETES';
   $index2 = 'A:PAQUETE';
   $indexs =  array($index1,$index2);
   $param = $this->input->post('textsearch');
   $result = ' ';

   $result = $this->catalogs($indexs,$param);

   echo $result;
 }


 public function getPay()
 {
   $index1 = 'A:FORMASPAGOS';
   $index2 = 'A:FORMAPAGO';
   $indexs = array($index1,$index2);
   $param = $this->input->post('textsearch');
   $result = ' ';
   
   $result = $this->catalogs($indexs,$param);

   echo $result;
 }

}

