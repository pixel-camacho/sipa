<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class latino extends CI_controller
{

	var $url ="XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX;

	//Credencial Web Services.
	var $idApp = XXXX;
	var $passApp = "XXXXXXXX";
	var $claveUsuario = "XXXXXXX";
  var $password = "XXXXXXXXXXX";

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

  $data = ["datacolonia"=> $colonias];

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
	  $headers = [ "Content-type: text/xml;charset=utf-8", 
                 "Content-length: ".strlen($xml), 
                 "SOAPAction: ".$action];
    $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_TIMEOUT, 15);
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


 public function getState()
 {
   $result =  array();
   $action = 'http://tempuri.org/ICotizadorLatino/ObtenerCatalogos';
   $select = ' '; 
   $xml = '
   <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <ObtenerCatalogos xmlns="http://tempuri.org/">
            <!-- Optional -->
            <datos>
                <!-- Optional -->
                <credenciales xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <IdApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->idApp.'</IdApp>
                    <PassApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->passApp.'</PassApp>
                    <ClaveUsuario xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->claveUsuario.'</ClaveUsuario>
                    <Password xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->password.'</Password>
                </credenciales>
                <!-- Optional -->
                <datosAuto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <ClaveProducto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">1</ClaveProducto>
                    <Tarifa xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">1704</Tarifa>
                    <TipoVehiculo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">AU</TipoVehiculo>
                    <ClavePerfil xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClavePerfil>
                    <ClaveModelo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveModelo>
                    <ClaveMarca xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveMarca>
                    <ClaveSubMarca xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveSubMarca>
                    <ClaveVehiculo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveVehiculo>
                    <NumeroSerieAuto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroSerieAuto>
                    <SerieValida xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">0</SerieValida>
                    <NumeroPlacas xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroPlacas>
                    <NumeroMotor xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroMotor>
                    <NumeroControlVehicular xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroControlVehicular>
                    <NombreConductor xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NombreConductor>
                    <BeneficiarioPreferente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></BeneficiarioPreferente>
                </datosAuto>
                <!-- Optional -->
                <caracteristicasCotizacion xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <ClaveEstado xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveEstado>
                    <ClavePaquete xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClavePaquete>
                    <ClaveVigencia xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveVigencia>
                    <ClaveServicio xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveServicio>
                    <ClaveDescuento xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveDescuento>
                    <ClaveAgente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveAgente>
                    <ClaveFormaPago xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveFormaPago>
                </caracteristicasCotizacion>
            </datos>
        </ObtenerCatalogos>
    </Body>
</Envelope>';

  $result = $this->callLatino($xml,$action);
  $catalogo = $result['S:ENVELOPE']['S:BODY']['OBTENERCATALOGOSRESPONSE']['OBTENERCATALOGOSRESULT']
                     ['A:ESTADOS']['A:ESTADO'];

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


  public function getYear ()
 {
   $result =  array();
   $action = 'http://tempuri.org/ICotizadorLatino/ObtenerDescuentosYModelos';
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
             <ns1:ClaveProducto>1</ns1:ClaveProducto>
             <ns1:Tarifa>1704</ns1:Tarifa>
             <ns1:TipoVehiculo>AU</ns1:TipoVehiculo>
             <ns1:ClavePerfil>22</ns1:ClavePerfil>
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
   $modelAndDescuento = $result['S:ENVELOPE']['S:BODY']['OBTENERDESCUENTOSYMODELOSRESPONSE']                     
                               ['OBTENERDESCUENTOSYMODELOSRESULT']['A:MODELOS']['B:STRING'];

     if(isset($result) && !empty($modelAndDescuento))
     {
       foreach($modelAndDescuento as $value)
       {
          $select .= "<option value='".$value."'>".$value."</option>";
       }
     }

     echo $select;

 }

  public function getDecuentos ()
 {
   $result =  array();
   $action = 'http://tempuri.org/ICotizadorLatino/ObtenerDescuentosYModelos';
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
             <ns1:ClaveProducto>1</ns1:ClaveProducto>
             <ns1:Tarifa>1704</ns1:Tarifa>
             <ns1:TipoVehiculo>AU</ns1:TipoVehiculo>
             <ns1:ClavePerfil>22</ns1:ClavePerfil>
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
   $modelAndDescuento = $result['S:ENVELOPE']['S:BODY']['OBTENERDESCUENTOSYMODELOSRESPONSE']
                               ['OBTENERDESCUENTOSYMODELOSRESULT']['A:DESCUENTOS']['A:DESCUENTO'];

     if(isset($result) && !empty($modelAndDescuento))
     {
       foreach($modelAndDescuento as $value)
       {
          $select .= "<option value='".$value['A:CLAVE']."'>".$value['A:DESCRIPCION']."</option>";
       }
     }

    echo $select;

 }




 public function getCarAndDetail($soapAction ,$modelo = null,$paquete = null,$marca = null ,$index)
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
            <ns1:ClaveProducto>1</ns1:ClaveProducto>
            <ns1:Tarifa>1704</ns1:Tarifa>
            <ns1:TipoVehiculo>AU</ns1:TipoVehiculo>
            <ns1:ClavePerfil>22</ns1:ClavePerfil>
            <ns1:ClaveModelo>'.$modelo.'</ns1:ClaveModelo>
            <ns1:ClaveMarca>'.$marca.'</ns1:ClaveMarca>
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


  if($list == null){

    $txtSelect = "<option value=''>No se encontraron resultados</option>";

    echo $txtSelect;
    return;

  }


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
   $modelo = $this->input->post('modelo');
   $paquete = $this->input->post('paquete');
  
   $txtSelect = $this->getCarAndDetail($soapAction,$modelo,$paquete,null,$index);

     echo $txtSelect; 
 }

 public function getSubmarca()
 {
   $index = array('A:SUBMARCAS','B:SUBMARCA');
   $soapAction = 'ObtenerSubMarcas';
   $modelo = $this->input->post('modelo');
   $marca = $this->input->post('marca');
   $paquete = $this->input->post('paquete');

   $txtSelect = $this->getCarAndDetail($soapAction,$modelo,$paquete,$marca,$index);

     echo $txtSelect;
   
 }


 public function getDescripcion()
{
  $result = array();
  $action = 'http://tempuri.org/ICotizadorLatino/ObtenerDescripcionVehiculo';
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
            <ns1:ClaveProducto>1</ns1:ClaveProducto>
            <ns1:Tarifa>1704</ns1:Tarifa>
            <ns1:TipoVehiculo>AU</ns1:TipoVehiculo>
            <ns1:ClavePerfil>22</ns1:ClavePerfil>
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

                          

      if($descripcion == null){

        $select = "<option value=''>No se encontraron resultados</option>";

        echo $select;

        return;
      }

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


public function getCoverage()
{
  $action = "http://tempuri.org/ICotizadorLatino/ObtenerCoberturas";
  $modelo = $this->input->post('modelo');
  $marca = $this->input->post('marca');
  $submarca = $this->input->post('submarca');
  $descripcion = $this->input->post('descripcion');
  $paquete = $this->input->post('paquete');
  $estado = $this->input->post('estado');
  $xml = 
  ' <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <ObtenerCoberturas xmlns="http://tempuri.org/">
            <!-- Optional -->
            <datos>
                <!-- Optional -->
                <credenciales xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <IdApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->idApp.'</IdApp>
                    <PassApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->passApp.'</PassApp>
                    <ClaveUsuario xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->claveUsuario.'</ClaveUsuario>
                    <Password xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->password.'</Password>
                </credenciales>
                <!-- Optional -->
                <datosAuto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <ClaveProducto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">1</ClaveProducto>
                    <Tarifa xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">1704</Tarifa>
                    <TipoVehiculo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">AU</TipoVehiculo>
                    <ClavePerfil xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">22</ClavePerfil>
                    <ClaveModelo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$modelo.'</ClaveModelo>
                    <ClaveMarca xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$marca.'</ClaveMarca>
                    <ClaveSubMarca xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$submarca.'</ClaveSubMarca>
                    <ClaveVehiculo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$descripcion.'</ClaveVehiculo>
                    <NumeroSerieAuto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroSerieAuto>
                    <SerieValida xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">true</SerieValida>
                    <NumeroPlacas xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroPlacas>
                    <NumeroMotor xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroMotor>
                    <NumeroControlVehicular xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroControlVehicular>
                    <NombreConductor xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NombreConductor>
                    <BeneficiarioPreferente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></BeneficiarioPreferente>
                </datosAuto>
                <!-- Optional -->
                <caracteristicasCotizacion xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <ClaveEstado xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$estado.'</ClaveEstado>
                    <ClavePaquete xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$paquete.'</ClavePaquete>
                    <ClaveVigencia xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveVigencia>
                    <ClaveServicio xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveServicio>
                    <ClaveDescuento xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveDescuento>
                    <ClaveAgente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveAgente>
                    <ClaveFormaPago xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveFormaPago>
                </caracteristicasCotizacion>
            </datos>
        </ObtenerCoberturas>
    </Body>
</Envelope>';
//$result = $this->callLatino($xml,$action);

    $url = $this->url;
    $headers = [ "Content-type: text/xml;charset=utf-8", 
                 "Content-length: ".strlen($xml), 
                 "SOAPAction: ".$action];
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
         file_put_contents('coberturas.xml', $response);
         header('Content-type: text/xml');

        echo $response;
     }

 //$cobertura = $result['S:ENVELOPE']['S:BODY']['OBTENERCOBERTURASRESPONSE']['OBTENERCOBERTURASRESULT']['A:COBERTURAS']['B:COBERTURAS'];

}

public function getColonias ()
{
  $result = [];
  $select = '';
  $action = "http://tempuri.org/ICotizadorLatino/ObtenerColonias";
  $cp     = $this->input->post('codigopostal');
  $xml    =
   '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <ObtenerColonias xmlns="http://tempuri.org/">
            <!-- Optional -->
            <datosCP>
                <!-- Optional -->
                <credenciales xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <IdApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->idApp.'</IdApp>
                    <PassApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->passApp.'</PassApp>
                    <ClaveUsuario xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->claveUsuario.'</ClaveUsuario>
                    <Password xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->password.'</Password>
                </credenciales>
                <CodigoPostal xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$cp.'</CodigoPostal>
            </datosCP>
        </ObtenerColonias>
    </Body>
</Envelope>'; 
$result = $this->callLatino($xml,$action);

$colonias = $result['S:ENVELOPE']['S:BODY']['OBTENERCOLONIASRESPONSE']['OBTENERCOLONIASRESULT']
                   ['A:COLONIA'];

foreach($colonias as $colonia)
{
  $clave = $colonia['A:CLAVE'];
  $select .= '<option value='.$clave.'>'.$colonia['A:DESCRIPCION'].'</option>';
}

echo $select;

}

public  function getQuote()
{
  $result = [];
  $action   = "http://tempuri.org/ICotizadorLatino/Cotizar";
  $modelo      = $this->input->post('modelo');
  $marca       = $this->input->post('marca');
  $submarca    = $this->input->post('submarca');
  $descripcion = $this->input->post('descripcion');
  $paquete     = $this->input->post('paquete');
  $estado      = $this->input->post('estado');
  $tipoPago    = $this->input->post('tipoPago');
  $descuento   = $this->input->post('descuento');
  $coberturas  = '
                   <CoberturaAmparada>
                       <Amparada>true</Amparada>
                       <Clave>RC</Clave>
                       <Descripcion>RESPONSBILIDAD CIVIL L.U.C.*</Descripcion>
                       <SumaAsegurada>750000</SumaAsegurada>
                       <DescripcionSumaAsegurada>750,000.00</DescripcionSumaAsegurada>
                       <PorcentajeDeducible>0</PorcentajeDeducible>
                       <DescripcionDeducible>0</DescripcionDeducible>
                       <PrimaNeta>null</PrimaNeta>
                   </CoberturaAmparada>
                    
                   <CoberturaAmparada>
                        <Amparada>true</Amparada>
                        <Clave>RCE</Clave>
                        <Descripcion>EXTENSION DE RESPONSABILIDAD CIVIL</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <DescripcionSumaAsegurada>AMPARADA</DescripcionSumaAsegurada>
                        <PorcentajeDeducible>0</PorcentajeDeducible>
                        <DescripcionDeducible>0</DescripcionDeducible>
                        <PrimaNeta>null</PrimaNeta>
                    </CoberturaAmparada>
                    
                    <CoberturaAmparada>
                        <Amparada>1</Amparada>
                        <Clave>RCC</Clave>
                        <Descripcion>RESPONSABILIDAD CIVIL CATASTROFICA POR MUERTE A TERCERAS PERSONAS</Descripcion>
                        <SumaAsegurada>500000</SumaAsegurada>
                        <DescripcionSumaAsegurada>500,000.00</DescripcionSumaAsegurada>
                        <PorcentajeDeducible>0</PorcentajeDeducible>
                        <DescripcionDeducible>0</DescripcionDeducible>
                        <PrimaNeta>null</PrimaNeta>
                    </CoberturaAmparada>
                    
                    <CoberturaAmparada>
                        <Amparada>1</Amparada>
                        <Clave>GM</Clave>
                        <Descripcion>GASTOS MEDICOS OCUPANTES L.U.C.*</Descripcion>
                        <SumaAsegurada>125000</SumaAsegurada>
                        <DescripcionSumaAsegurada>125,000.00</DescripcionSumaAsegurada>
                        <PorcentajeDeducible>0</PorcentajeDeducible>
                        <DescripcionDeducible>0</DescripcionDeducible>
                        <PrimaNeta>null</PrimaNeta>
                    </CoberturaAmparada>
                    
                     <CoberturaAmparada>
                        <Amparada>1</Amparada>
                        <Clave>DJ</Clave>
                        <Descripcion>ASESORIA LEGAL, FIANZAS Y/O CAUCIONES</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <DescripcionSumaAsegurada>AMPARADA</DescripcionSumaAsegurada>
                        <PorcentajeDeducible>0</PorcentajeDeducible>
                        <DescripcionDeducible>0</DescripcionDeducible>
                        <PrimaNeta>null</PrimaNeta>
                    </CoberturaAmparada>
                    
                     <CoberturaAmparada>
                        <Amparada>1</Amparada>
                        <Clave>AI</Clave>
                        <Descripcion>ASISTENCIA VIAL</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <DescripcionSumaAsegurada>AMPARADA</DescripcionSumaAsegurada>
                        <PorcentajeDeducible>0</PorcentajeDeducible>
                        <DescripcionDeducible>0</DescripcionDeducible>
                        <PrimaNeta>null</PrimaNeta>
                    </CoberturaAmparada>
                    
                     <CoberturaAmparada>
                        <Amparada>1</Amparada>
                        <Clave>MA</Clave>
                        <Descripcion>ACCIDENTES AL CONDUCTOR</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <DescripcionSumaAsegurada>100,000.00</DescripcionSumaAsegurada>
                        <PorcentajeDeducible>0</PorcentajeDeducible>
                        <DescripcionDeducible>0</DescripcionDeducible>
                        <PrimaNeta>null</PrimaNeta>
                    </CoberturaAmparada>';
      $paquetes = '';
  
  if($paquete == 0)
  {
     $paquetes ='<CoberturaAmparada>
                   <Amparada>true</Amparada>
                   <Clave>CR</Clave>
                   <Descripcion>ROTURA DE CRISTALES</Descripcion>
                   <SumaAsegurada>0</SumaAsegurada>
                   <DescripcionSumaAsegurada>VALOR CRISTAL</DescripcionSumaAsegurada>
                   <PorcentajeDeducible>20</PorcentajeDeducible>
                   <DescripcionDeducible>20%</DescripcionDeducible>
                   <PrimaNeta>null</PrimaNeta>
                </CoberturaAmparada>

                <CoberturaAmparada>
                   <Amparada>true</Amparada>
                   <Clave>RT</Clave>
                   <Descripcion>ROBO TOTAL</Descripcion>
                   <SumaAsegurada>0</SumaAsegurada>
                   <DescripcionSumaAsegurada>VALOR COMERCIAL</DescripcionSumaAsegurada>
                   <PorcentajeDeducible>5</PorcentajeDeducible>
                   <DescripcionDeducible>5%</DescripcionDeducible>
                   <PrimaNeta>null</PrimaNeta>
                </CoberturaAmparada>

                <CoberturaAmparada>
                    <Amparada>true</Amparada>
                    <Clave>DM</Clave>
                    <Descripcion>DAÑOS MATERIALES</Descripcion>
                    <SumaAsegurada>0</SumaAsegurada>
                    <DescripcionSumaAsegurada>VALOR COMERCIAL</DescripcionSumaAsegurada>
                    <PorcentajeDeducible>5</PorcentajeDeducible>
                    <DescripcionDeducible>5%</DescripcionDeducible>
                    <PrimaNeta>null</PrimaNeta>
                </CoberturaAmparada>
                '.$coberturas.'
               <CoberturaAmparada>
                     <Amparada>true</Amparada>
                     <Clave>AS</Clave>
                     <Descripcion>AUTO SUSTITUTO</Descripcion>
                     <SumaAsegurada>350</SumaAsegurada>
                     <DescripcionSumaAsegurada>DAÑOS Y ROBO TOTAL</DescripcionSumaAsegurada>
                     <PorcentajeDeducible>500</PorcentajeDeducible>
                     <DescripcionDeducible>500 PESOS</DescripcionDeducible>
                     <PrimaNeta>null</PrimaNeta>
                 </CoberturaAmparada>

                 <CoberturaAmparada>
                      <Amparada>true</Amparada>
                      <Clave>L10</Clave>
                      <Descripcion>LATINO MAS 10</Descripcion>
                      <SumaAsegurada>0</SumaAsegurada>
                      <DescripcionSumaAsegurada>AMPARADA</DescripcionSumaAsegurada>
                      <PorcentajeDeducible>0</PorcentajeDeducible>
                      <DescripcionDeducible>0</DescripcionDeducible>
                      <PrimaNeta>null</PrimaNeta>
                  </CoberturaAmparada>';

  }else if( $paquete == 1)
  {
    $paquetes =     $coberturas.'<CoberturaAmparada>
                    <Amparada>true</Amparada>
                    <Clave>RT</Clave>
                    <Descripcion>ROBO TOTAL</Descripcion>
                    <SumaAsegurada>0</SumaAsegurada>
                    <DescripcionSumaAsegurada>VALOR COMERCIAL</DescripcionSumaAsegurada>
                    <PorcentajeDeducible>5</PorcentajeDeducible>
                    <DescripcionDeducible>5%</DescripcionDeducible>
                    <PrimaNeta>null</PrimaNeta>
                </CoberturaAmparada>';

  }else if($paquete == 2)
  {
       $paquetes = $coberturas;
  }
  $xml = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <Cotizar xmlns="http://tempuri.org/">
            <!-- Optional -->
            <datosCotizar>
                <!-- Optional -->
                <credenciales xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <IdApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->idApp.'</IdApp>
                    <PassApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->passApp.'</PassApp>
                    <ClaveUsuario xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->claveUsuario.'</ClaveUsuario>
                    <Password xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->password.'</Password>
                </credenciales>

                <!-- Optional -->
                <caracteristicasCotizacion xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <ClaveEstado xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$estado.'</ClaveEstado>
                    <ClavePaquete xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$paquete.'</ClavePaquete>
                    <ClaveVigencia xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">0</ClaveVigencia>
                    <ClaveServicio xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">1</ClaveServicio>
                    <ClaveDescuento xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$descuento.'</ClaveDescuento>
                    <ClaveAgente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->claveUsuario.'</ClaveAgente>
                    <ClaveFormaPago xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$tipoPago.'</ClaveFormaPago>
                </caracteristicasCotizacion>

                <datosAuto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <ClaveProducto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">1</ClaveProducto>
                    <Tarifa xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">1704</Tarifa>
                    <TipoVehiculo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">AU</TipoVehiculo>
                    <ClavePerfil xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">22</ClavePerfil>
                    <ClaveModelo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$modelo.'</ClaveModelo>
                    <ClaveMarca xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$marca.'</ClaveMarca>
                    <ClaveSubMarca xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$submarca.'</ClaveSubMarca>
                    <ClaveVehiculo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$descripcion.'</ClaveVehiculo>
                    <NumeroSerieAuto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroSerieAuto>
                    <SerieValida xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">false</SerieValida>
                    <NumeroPlacas xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroPlacas>
                    <NumeroMotor xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroMotor>
                    <NumeroControlVehicular xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroControlVehicular>
                    <NombreConductor xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NombreConductor>
                    <BeneficiarioPreferente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></BeneficiarioPreferente>
                </datosAuto>
                <!-- Optional -->
                <ValorConvenido xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">0</ValorConvenido>
                <FechaFactura xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador"></FechaFactura>
                <ValorFactura xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">0</ValorFactura>
                 <!-- Optionl -->
                 <coberturasAmparadas xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">               
                <!-- Optional -->
                '.$paquetes.'
                </coberturasAmparadas>
            </datosCotizar>
        </Cotizar>
    </Body>
</Envelope>';

/*header('Content-type: text/xml');

file_put_contents('cotizar.xml', $xml);*/

$result = $this->callLatino($xml,$action);

if($result != null){

$cotizacion = $result['S:ENVELOPE']['S:BODY']["COTIZARRESPONSE"]["COTIZARRESULT"];
$dataPoliza = $cotizacion['A:IDCOTIZACIONWCF'].'/'.$cotizacion['A:NUMEROREFERENCIA'];
}
echo $dataPoliza;

}

public function saveQoute()
{
  $result    = [];
  $action    = 'http://tempuri.org/ICotizadorLatino/Guardar';
  $data      =  $this->input->post('cotizacion');
  $datosCotizacion = explode('/', $data);
  $nombre    = strtoupper($this->input->post('nombre'));
  $apPaterno = strtoupper($this->input->post('apPaterno'));
  $apMaterno = strtoupper($this->input->post('aMPaterno'));
  $Nombre    = $nombre.' '.$apPaterno.''.$apMaterno;
  $inicio    = date('d/m/Y');
  $fin       = date('d/m/Y', strtotime('+1 years'));
  $poliza    = '';
  $xml ='
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <Guardar xmlns="http://tempuri.org/">
            <!-- Optional -->
            <datosGuardar>
                <!-- Optional -->
                <credenciales xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <IdApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->idApp.'</IdApp>
                    <PassApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->passApp.'</PassApp>
                    <ClaveUsuario xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->claveUsuario.'</ClaveUsuario>
                    <Password xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->password.'</Password>
                </credenciales>
                <IDCotizacionWCF xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$datosCotizacion[0].'</IDCotizacionWCF>
                <NumeroReferencia xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$datosCotizacion[1].'</NumeroReferencia>
                <NombreAsegurado xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$Nombre.'</NombreAsegurado>
                <VigenciaInicial xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$inicio.'</VigenciaInicial>
                <VigenciaFinal xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$fin.'</VigenciaFinal>
            </datosGuardar>
        </Guardar>
    </Body>
</Envelope>'; 

/*header('Content-type: text/xml');

file_put_contents('save.xml', $xml);*/

$result  = $this->callLatino($xml,$action);

if($result != null)
{
  $save = $result['S:ENVELOPE']['S:BODY']['GUARDARRESPONSE']['GUARDARRESULT'];
}



 for ($i=0; $i < 1 ; $i++) { 
 
        $poliza .= $save['A:IDCOTIZACIONWCF'].'/';
        $poliza .= $save['A:NUMEROCOTIZACION'];
 }
 
  echo $poliza;
}



public function addCliente()
{
  $result  = [];
  $action  = 'http://tempuri.org/ICotizadorLatino/AgregarCliente';
  $cliente = '';
  $clienteDomiclio = '';

  //parametros
  $nombre     = strtoupper($this->input->post('nombre'));
  $apPaterno  = strtoupper($this->input->post('apPaterno'));
  $apMaterno  = strtoupper($this->input->post('apMaterno'));
  $nacimiento = $this->input->post('nacimiento');
  $calle      = strtoupper($this->input->post('calle'));
  $numero     = strtoupper($this->input->post('numero'));
  $colonia    = strtoupper($this->input->post('colonia'));
  $cp         = $this->input->post('cp');
  $rfc        = strtoupper($this->input->post('rfc'));
  $fechaN     = date_create($nacimiento);
  $fechaNacimiento = date_format($fechaN,'d/m/Y');

   $siglas    = substr($rfc,0,-9);
   $fecha     = substr($rfc,4,-3);
   $homo      = substr($rfc,10); 

  $xml = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <AgregarCliente xmlns="http://tempuri.org/">
            <!-- Optional -->
            <datosCliente>
                <!-- Optional -->
                <cliente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <ClaveCliente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveCliente>
                    <Nombre xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$nombre.'</Nombre>
                    <ApellidoPaterno xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$apPaterno.'</ApellidoPaterno>
                    <ApellidoMaterno xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$apMaterno.'</ApellidoMaterno>
                    <SIGLA_RFC xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$siglas.'</SIGLA_RFC>
                    <FECHA_RFC xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$fecha.'</FECHA_RFC>
                    <HOMO_RFC xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$homo.'</HOMO_RFC>
                    <FechaNacimiento xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$fechaNacimiento.'</FechaNacimiento>
                    <TipoPersona xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">1</TipoPersona>
                    <!-- Optional -->
                    <domicilios xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">
                        <!-- Optional -->
                        <Domicilio>
                            <Activo>true</Activo>
                            <Calle>'.$calle.'</Calle>
                            <ClaveColonia>'.$colonia.'</ClaveColonia>
                            <CodigoPostal>'.$cp.'</CodigoPostal>
                            <NumeroExterior>'.$numero.'</NumeroExterior>
                            <NumeroInterior>n/a</NumeroInterior>
                        </Domicilio>
                    </domicilios>
                </cliente>
                <!-- Optional -->
                <credenciales xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <IdApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->idApp.'</IdApp>
                    <PassApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->passApp.'</PassApp>
                    <ClaveUsuario xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->claveUsuario.'</ClaveUsuario>
                    <Password xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->password.'</Password>
                </credenciales>
            </datosCliente>
        </AgregarCliente>
    </Body>
</Envelope>';



$result = $this->callLatino($xml,$action);

if($result != null)
{
  $Add = $result['S:ENVELOPE']['S:BODY']['AGREGARCLIENTERESPONSE']['AGREGARCLIENTERESULT']['A:MENSAJES']['B:STRING'];


}

$cliente = explode(':', $Add);
$clienteDomiclio = $this->getClaveDomicilio(trim($cliente[1]),$calle,$colonia,$cp,$numero);

echo $clienteDomiclio.'/'.trim($cliente[1]);


}



public function getCliente()
{
  $result = [];
  $action = 'http://tempuri.org/ICotizadorLatino/ObtenerClientes';
  $clave  = '';
  //parametros

  $xml ='<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <ObtenerClientes xmlns="http://tempuri.org/">
            <!-- Optional -->
            <cliente>
                <!-- Optional -->
                <cliente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <ClaveCliente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveCliente>
                    <Nombre xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">YAEL</Nombre>
                    <ApellidoPaterno xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">RANGEL</ApellidoPaterno>
                    <ApellidoMaterno xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">FELIX</ApellidoMaterno>
                    <SIGLA_RFC xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">RAFY</SIGLA_RFC>
                    <FECHA_RFC xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">950402</FECHA_RFC>
                    <HOMO_RFC xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">PZ7</HOMO_RFC>
                    <FechaNacimiento xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></FechaNacimiento>
                    <TipoPersona xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">1</TipoPersona>
                    <!-- Optional -->
                </cliente>
                <!-- Optional -->
                <credenciales xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <IdApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">10054</IdApp>
                    <PassApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">CD77ED53SPROT</PassApp>
                    <ClaveUsuario xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">7753</ClaveUsuario>
                    <Password xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">WS7753PROT</Password>
                </credenciales>
            </cliente>
        </ObtenerClientes>
    </Body>
</Envelope>';

$result = $this->callLatino($xml,$action);

if($result != null)
{
  $cliente = $result['S:ENVELOPE']['S:BODY']['OBTENERCLIENTERESPONSE']['OBTENERCLIENTERESULT']
                    ['A:CLIENTES'];
}  
                if(count($cliente) == 1)
                {
                  echo $cliente['A:MENSAJES']['B:STRING'];
                }elseif(count($cliente) == 10)
          foreach($cliente as $index => $valor)
          {
                  if($index == 0)
                  {
                    $clave .= $valor['B:CLAVECLIENTE']; 
                  }
          }
   
   echo $clave;

}

public function getClaveDomicilio($cliente,$calle,$colonia,$cp,$numero)
{
  $result    = [];
  $action    = 'http://tempuri.org/ICotizadorLatino/AgregarDomicilioCU';
  $response  = '';
  $domicilio = '';

  $xml    = '<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <AgregarDomicilioCU xmlns="http://tempuri.org/">
            <!-- Optional -->
            <datosCliente>
                <!-- Optional -->
                <cliente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <ClaveCliente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$cliente.'</ClaveCliente>
                    <Nombre xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></Nombre>
                    <ApellidoPaterno xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ApellidoPaterno>
                    <ApellidoMaterno xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ApellidoMaterno>
                    <SIGLA_RFC xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></SIGLA_RFC>
                    <FECHA_RFC xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></FECHA_RFC>
                    <HOMO_RFC xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></HOMO_RFC>
                    <FechaNacimiento xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></FechaNacimiento>
                    <TipoPersona xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></TipoPersona>
                    <!-- Optional -->
                    <domicilios xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">
                        <!-- Optional -->
                        <Domicilio>
                            <Activo>true</Activo>
                            <Calle>'.$calle.'</Calle>
                            <ClaveColonia>'.$colonia.'</ClaveColonia>
                            <CodigoPostal>'.$cp.'</CodigoPostal>
                            <NumeroExterior>'.$numero.'</NumeroExterior>
                            <NumeroInterior></NumeroInterior>
                        </Domicilio>
                    </domicilios>
                </cliente>
                <!-- Optional -->
                <credenciales xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <IdApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->idApp.'</IdApp>
                    <PassApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->passApp.'</PassApp>
                    <ClaveUsuario xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->claveUsuario.'</ClaveUsuario>
                    <Password xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->password.'</Password>
                </credenciales>
            </datosCliente>
        </AgregarDomicilioCU>
    </Body>
</Envelope>';

file_put_contents('ClaveDomicilio.xml', $xml);
header('Content-type: text/json');

$result = $this->callLatino($xml,$action);

if($result != null)
{
   $response = $result['S:ENVELOPE']['S:BODY']['AGREGARDOMICILIOCURESPONSE']['AGREGARDOMICILIOCURESULT']['A:MENSAJES']['B:STRING'];
}

$domicilio = explode(':',$response);

return  trim($domicilio[1]);

}


public function emitir()
{
  $result   = [];
  $action   = 'http://tempuri.org/ICotizadorLatino/Emitir';
  $response = '';
  $pdf      = '';
  //parametros
  $serie           = strtoupper($this->input->post('serie'));
  $placa           = strtoupper($this->input->post('placa'));
  $conductor       = strtoupper($this->input->post('conductor'));
  $poliza          = $this->input->post('camposPoliza');
  $data            = explode('/', $poliza);
  $inicio          = date('d/m/Y');
  $fin             = date('d/m/Y', strtotime('+1 years'));
  $motor           = $this->input->post('numeroMotor');
  $cliente         = $this->input->post('cliente');

 $usuarioDomicilio = $this->input->post('cliente');
  $claves          = explode('/', $usuarioDomicilio);
  
  $xml    = '
 <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Body>
        <Emitir xmlns="http://tempuri.org/">
            <!-- Optional -->
            <datosEmitir>
                <!-- Optional -->
                <credenciales xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                   <IdApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->idApp.'</IdApp>
                    <PassApp xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->passApp.'</PassApp>
                    <ClaveUsuario xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->claveUsuario.'</ClaveUsuario>
                    <Password xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$this->password.'</Password>
                </credenciales>
                <IDCotizacionWCF xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$data[0].'</IDCotizacionWCF>
                <NumeroCotizacion xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$data[1].'</NumeroCotizacion>
                <VigenciaInicial xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$inicio.'</VigenciaInicial>
                <VigenciaFinal xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$fin.'</VigenciaFinal>
                <!-- Optional -->
                <datosAuto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">
                    <ClaveProducto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveProducto>
                    <Tarifa xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></Tarifa>
                    <TipoVehiculo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></TipoVehiculo>
                    <ClavePerfil xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClavePerfil>
                    <ClaveModelo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveModelo>
                    <ClaveMarca xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveMarca>
                    <ClaveSubMarca xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveSubMarca>
                    <ClaveVehiculo xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></ClaveVehiculo>
                    <NumeroSerieAuto xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$serie.'</NumeroSerieAuto>
                    <SerieValida xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">true</SerieValida>
                    <NumeroPlacas xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$placa.'</NumeroPlacas>
                    <NumeroMotor xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$motor.'</NumeroMotor>
                    <NumeroControlVehicular xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></NumeroControlVehicular>
                    <NombreConductor xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos">'.$conductor.'</NombreConductor>
                    <BeneficiarioPreferente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Catalogos"></BeneficiarioPreferente>
                </datosAuto>
                <ClaveCliente xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$claves[1].'</ClaveCliente>
                <ClaveDomicilio xmlns="http://schemas.datacontract.org/2004/07/WCFModelo.Cotizador">'.$claves[0].'</ClaveDomicilio>
            </datosEmitir>
        </Emitir>
    </Body>
</Envelope>';
 file_put_contents('response.xml', $xml);
 header('Content-type: text/xml');


$result = $this->callLatino($xml,$action);

if($result != null)
{
  $pdf = $result['S:ENVELOPE']['S:BODY']['EMITIRRESPONSE']['EMITIRRESULT'];
}

 foreach($pdf as $index => $info){
   
    if(!empty($pdf[':MENSAJES']) || empty($pdf[':CARATULA']))
    {
      $response = 'error '.$pdf['A:MENSAJES']['B:STRING'];
      echo $response;
      return;

    }elseif(empty($pdf[':MENSAJES']) || !empty($pdf[':CARATULA']))
    {
      $response = 'ok '.$pdf['A:CARATULA'];
      echo $response;
      return;
    }
    
 }


}

}






