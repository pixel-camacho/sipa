<?php

defined('BASEPATH') OR exit('No direct script access allowed');


 class Hdi extends CI_controller
 {
 	

  var $url = "http://enterpriseservices.implementation.hdi.com.mx/B2B/Partners/WCF/Autos/PublicServicesAutos.asmx?WSDL";

   //credenciales hdi
   var $usuario = 0947960001;
   var $pasword ='PrGAHIMP*01';

 	function __construct()
 	{
 		parent::__construct();

 				if(!isset($_SESSION['user_id']))
		{
			$this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
		}

		$this->load->helper('url');
		$this->load->model('Colonia_model', 'colonia');
		$this->load->library('permission');
		$this->load->library('nusoap');
 	}

public function index()
{
     $colonias = $this->colonia->showAll();
     $data = ["datacolonia" => $colonias];

	$this->load->view('header');
	$this->load->view('hdi/index',$data);
	$this->load->view('footer');
}

  function array_to_xml($array, $xml_info) {
    foreach($array as $key => $value) {
        if(is_array($value)) {
            if(!is_numeric($key)){
                $subnode = $xml_info->addChild("$key");
                array_to_xml($value, $subnode);
            }else{
                $subnode = $xml_info->addChild("item$key");
                array_to_xml($value, $subnode);
            }
        }else {
            $xml_info->addChild("$key",htmlspecialchars("$value"));
        }
    }
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

public function callHdi($xml,$action)
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

public function getTypeCar()
{
  $result = [];
  $action = 'http://hdi.com.mx/asmx/GetVehicleTypes';
  $select = '';
  $xml = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <GetVehicleTypes xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <usuario>
                <usuario>0947960001</usuario>
            </usuario>
        </GetVehicleTypes>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$type = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETVEHICLETYPESRESPONSE']['GETVEHICLETYPESRESULT']
               ['TIPOSVEHICULO']['TIPOVEHICULO'];

 	foreach ($type as $value) {

 		if($value['CLAVE'] == 3829 || $value['CLAVE'] == 4579)
 		{
 		 $clave = $value['CLAVE'];
 		 $select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';	
 		}

 		
}
echo $select;
 }


public function getBrand()
{
  $result = [];
  $year   = $this->input->post('year');
  $tipo  = $this->input->post('tipo'); 
  $action = 'http://hdi.com.mx/asmx/getMake';
  $select = '';
  $xml    = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getMake xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <IdTipoVehiculo>'.$tipo.'</IdTipoVehiculo>
                <IdModelo>'.$year.'</IdModelo>
                <usuario>0947960001</usuario>
            </request>
        </getMake>
    </Body>
    </Envelope>';
$result = $this->callHdi($xml,$action);

$brand = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETMAKERESPONSE']['GETMAKERESULT']
                ['LISTAMARCAS']['MARCA'];

 	foreach ($brand as $key => $value) {

 		 $clave = $value['CLAVE'];
 		 $select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';	
}

echo $select;

 }

 public function getSubBrand()
{
  $result = [];
  $year   = $this->input->post('year');
  $tipo  = $this->input->post('tipo'); 
  $marca   = $this->input->post('marca');
  $action = 'http://hdi.com.mx/asmx/gettypes';
  $select = '';
  $xml    = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <gettypes xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <IdTipoVehiculo>'.$tipo.'</IdTipoVehiculo>
                <IdMarca>'.$marca.'</IdMarca>
                <IdModelo>'.$year.'</IdModelo>
            </request>
        </gettypes>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$subBrand = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETTYPESRESPONSE']['GETTYPESRESULT']
               ['LISTATIPOS']['TIPO'];

 	foreach ($subBrand as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value="'.$clave.'">'.$value['DESCRIPCION'].'</option>';
}

echo $select;

 }


 public function getVersion()
{
  $result   = [];
  $year     = $this->input->post('year');
  $tipo     = $this->input->post('tipo'); 
  $marca    = $this->input->post('marca');
  $submarca = $this->input->post('submarca');
  $action   = 'http://hdi.com.mx/asmx/getversions';
  $select   = '';
  $xml      = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getversions xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <IdTipoVehiculo>'.$tipo.'</IdTipoVehiculo>
                <IdMarca>'.$marca.'</IdMarca>
                <IdTipo>'.$submarca.'</IdTipo>
                <IdModelo>'.$year.'</IdModelo>
                <usuario>0947960001</usuario>
            </request>
        </getversions>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

 $version = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETVERSIONSRESPONSE']['GETVERSIONSRESULT']
                   ['LISTAVERSIONES']['VERSION'];

 	foreach ($version as $value) {

        $clave = $value['CLAVE'];
 		$select .= '<option value="'.$clave.'">'.$value['DESCRIPCION'].'</option>';
}
echo $select;

 }

 public function getTransmision()
{
  $result   = [];
  $year     = $this->input->post('year');
  $tipo     = $this->input->post('tipo'); 
  $marca    = $this->input->post('marca');
  $submarca = $this->input->post('submarca');
  $version  = $this->input->post('version');
  $action   = 'http://hdi.com.mx/asmx/gettransmission';
  $select   = '';
  $xml      = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <gettransmission xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <IdTipoVehiculo>'.$tipo.'</IdTipoVehiculo>
                <IdMarca>'.$marca.'</IdMarca>
                <IdTipo>'.$submarca.'</IdTipo>
                <IdVersion>'.$version.'</IdVersion>
                <IdModelo>'.$year.'</IdModelo>
            </request>
        </gettransmission>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$transmision = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETTRANSMISSIONRESPONSE']['GETTRANSMISSIONRESULT']
               ['LISTATRANSMISIONES']['TRANSMISION'];

 		$clave = $transmision['CLAVE'];
 		$select = '<option value='.$clave.'>'.$transmision['DESCRIPCION'].'</option>';

echo $select;

 }

 public function getModel()
{
  $result   = [];
  $tipo     = $this->input->post('tipo'); 
  $marca    = $this->input->post('marca');
  $submarca = $this->input->post('submarca');
  $version  = $this->input->post('version');
  $transmision = $this->input->post('transmision');
  $action   = 'http://hdi.com.mx/asmx/getmodel';
  $select   = '';
  $xml      = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getmodel xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <IdTipoVehiculo>'.$tipo.'</IdTipoVehiculo>
                <IdMarca>'.$marca.'</IdMarca>
                <IdTipo>'.$submarca.'</IdTipo>
                <IdVersion>'.$version.'</IdVersion>
                <IdTransmision>'.$transmision.'</IdTransmision>
                <Usuario>0947960001</Usuario>
            </request>
        </getmodel>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$modelo = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETMODELRESPONSE']['GETMODELRESULT']
               ['LISTAMODELOS']['MODELO'];

 	foreach ($modelo as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}

echo $select;

 }

  public function getDescripcion()
{
  $result   = [];
  $tipo     = $this->input->post('tipo'); 
  $marca    = $this->input->post('marca');
  $submarca = $this->input->post('submarca');
  $version  = $this->input->post('version');
  $transmision = $this->input->post('transmision');
  $modelo   = $this->input->post('modelo');
  $action   = 'http://hdi.com.mx/asmx/getinfovehicle';
  $xml      = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getinfovehicle xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <IdTipoVehiculo>'.$tipo.'</IdTipoVehiculo>
                <IdMarca>'.$marca.'</IdMarca>
                <IdTipo>'.$submarca.'</IdTipo>
                <IdVersion>'.$version.'</IdVersion>
                <idModelo>'.$modelo.'</idModelo>
                <idTransmision>'.$transmision.'</idTransmision>
            </request>
        </getinfovehicle>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$descripcion = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETINFOVEHICLERESPONSE']['GETINFOVEHICLERESULT']
               ['DATOSVEHICULO'];

echo $descripcion['IDVEHICULO'].'-'.$descripcion['PASAJEROS'];

 }

 public function validadSerie(){

  $result = [];
  $action = 'http://hdi.com.mx/asmx/ValidarNumeroDeSerie';
  $serie  = $this->input->post('serie');
  $modelo = $this->input->post('modelo');
  $xml    = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <ValidarNumeroDeSerie xmlns="http://hdi.com.mx/asmx/">
            <NumeroSerie>'.$serie.'</NumeroSerie>
            <Modelo>'.$modelo.'</Modelo>
        </ValidarNumeroDeSerie>
    </Body>
</Envelope>'; 
$result = $this->callHdi($xml,$action);
$valido = $result['SOAP:ENVELOPE']['SOAP:BODY']['VALIDARNUMERODESERIERESPONSE'];
$cantidad = count($valido);

if($cantidad === 1 )
{
	echo 'Numero de serie valido';

	return;
}else if($cantidad === 2){

echo $valido['VALIDARNUMERODESERIERESULT'];

 }

}

  public function getEstado()
{
  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/Getstates';
  $select   = '';
  $xml      = '
 <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <Getstates xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <idPais></idPais>
            </request>
        </Getstates>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$estados = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETSTATESRESPONSE']['GETSTATESRESULT']
                  ['LISTAESTADOS']['ESTADO'];

 	foreach ($estados as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}

echo $select;

 }

 public function getCiudad()
{
  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/getcities';
  $estado   = $this->input->post('estado');
  $select   = '';
  $xml      = '
 <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getcities xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <IdEstado>'.$estado.'</IdEstado>
            </request>
        </getcities>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$ciudades = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETCITIESRESPONSE']['GETCITIESRESULT']
                   ['LISTACIUDADES']['CIUDAD'];

 	foreach ($ciudades as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}

echo $select;

 }

  public function getPayMethod()
{
  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/getpaymentmethod';
  $select   = '';
  $xml      = '
 <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getpaymentmethod xmlns="http://hdi.com.mx/asmx/"/>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$pagos = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETPAYMENTMETHODRESPONSE']['GETPAYMENTMETHODRESULT']
                ['LISTAFORMASPAGO']['FORMAPAGO'];

 	foreach ($pagos as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}

echo $select;

 }

 public function setSumAsegurada()
{
  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/obtenerTiposSumaAsegurada';
  $select   = '';
  $xml      = '
 <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <obtenerTiposSumaAsegurada xmlns="http://hdi.com.mx/asmx/"/>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$tipoSuma = $result['SOAP:ENVELOPE']['SOAP:BODY']['OBTENERTIPOSSUMAASEGURADARESPONSE']['OBTENERTIPOSSUMAASEGURADARESULT']
                   ['TIPOSSUMAASEGURADA']['TIPOSUMAASEGURADA'];

 	foreach ($tipoSuma as $value) {

 		$clave = $value['IDTIPOSUMAASEGURADA'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}

echo $select;

 }

  public function getServices()
{
  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/getservices';
  $select   = '';
  $xml      = '
 <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getservices xmlns="http://hdi.com.mx/asmx/"/>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$tipoSuma = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETSERVICESRESPONSE']['GETSERVICESRESULT']
                   ['LISTASERVICIOS']['SERVICIO'];
 	foreach ($tipoSuma as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}

echo $select;

 }


 public function getUse()
{
  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/obtenerUsos';
  $tipo     = $this->input->post('tipo');
  $select   = '';
  $xml      = '
 <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <obtenerUsos xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <TipoVehiculoID>'.$tipo.'</TipoVehiculoID>
                <Usuario>0947960001</Usuario>
            </request>
        </obtenerUsos>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$tipoSuma = $result['SOAP:ENVELOPE']['SOAP:BODY']['OBTENERUSOSRESPONSE']['OBTENERUSOSRESULT']
                   ['LISTAUSOS']['USO'];
 	foreach ($tipoSuma as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}

echo $select;
 }

  public function getConducto()
{
  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/getconduct';
  $select   = '';
  $xml      = '
 <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getconduct xmlns="http://hdi.com.mx/asmx/"/>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$conducto = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETCONDUCTRESPONSE']['GETCONDUCTRESULT']
                   ['LISTACONDUCTOS']['CONDUCTOCOBROFIELD'];
 	foreach ($conducto as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}

echo $select;

 }


  public function getCivil()
{
  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/Getcivilstatus';
  $select   = '';
  $xml      = '
 <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <Getcivilstatus xmlns="http://hdi.com.mx/asmx/"/>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$tipoSuma = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETCIVILSTATUSRESPONSE']['GETCIVILSTATUSRESULT']
                   ['LISTAESTADOSCIVILES']['ESTADOCIVIL'];
 	foreach ($tipoSuma as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}
echo $select;
}

public function getOcupacionConductor()
{
	$result = [];
	$action = 'http://hdi.com.mx/asmx/getoccupationsConductor';
	$select = '';
	$xml    = '
	<Envelope xmlns="http://www.w3.org/2003/05/soap-envelope">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getoccupationsConductor xmlns="http://hdi.com.mx/asmx/"/>
    </Body>
</Envelope>';

$result = $this->callHdi($xml,$action);
$ocupaciones = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETOCCUPATIONSCONDUCTORRESPONSE']['GETOCCUPATIONSCONDUCTORRESULT']
                      ['LISTAOCUPACIONES']['OCUPACION'];
          
          foreach($ocupaciones AS $ocupacion)
          {
          	$clave  = $ocupacion['CLAVE'];
          	$select .= '<option value='.$clave.'>'.$ocupacion['DESCRIPCION'].'</option>';

          }

          echo $select;
}


  public function getOcupacion()
{
  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/getoccupations';
  $select   = '';
  $xml      = '
<Envelope xmlns="http://www.w3.org/2003/05/soap-envelope">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getoccupations xmlns="http://hdi.com.mx/asmx/"/>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$tipoSuma = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETOCCUPATIONSRESPONSE']['GETOCCUPATIONSRESULT']
                   ['LISTAOCUPACIONES']['OCUPACION'];
 	foreach ($tipoSuma as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}
echo $select;
}

public function getGiros()
{
	$result = [];
	$action = 'http://hdi.com.mx/asmx/getgirosactividad';
    $select = '';
    $xml = '
    <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getgirosactividad xmlns="http://hdi.com.mx/asmx/"/>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

if(!empty($result))
{
	$giros = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETGIROSACTIVIDADRESPONSE']['GETGIROSACTIVIDADRESULT']
                ['LISTAGIROSACTIVIDADES']['GIROACTIVIDAD'];
}

foreach($giros as $giro)
{
	$clave   = $giro['CLAVE'];
	$select .= '<option value='.$clave.'>'.$giro['DESCRIPCION'].'</option>';
}
echo $select;
}

public function getNacionalidad()
{

  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/getnatioality';
  $select   = '';
  $xml      = '
<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getnatioality xmlns="http://hdi.com.mx/asmx/"/>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$nacionalidad = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETNATIOALITYRESPONSE']['GETNATIOALITYRESULT']
                       ['LISTANACIONALIDADES']['NACIONALIDAD'];

 	foreach ($nacionalidad as $value) {

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}
echo $select;

}

 public function setPaquete()
{
  $result     = [];
  $action     = 'http://hdi.com.mx/asmx/getpackages';
  $estado     = $this->input->post('estado');
  $ciudad     = $this->input->post('ciudad');
  $pago       = $this->input->post('pago');
  $marca      = $this->input->post('marca');
  $submarca   = $this->input->post('submarca');
  $modelo     = $this->input->post('modelo');
  $version    = $this->input->post('version');
  $transmision = $this->input->post('transmision');
  $tipo       = $this->input->post('tipo');
  $serie      = $this->input->post('serie');
  $tiposuma   = $this->input->post('tiposuma');
  $cp         = $this->input->post('cp');
  $uso        = $this->input->post('uso');
  $detalles   = $this->input->post('detalles');
  $detalle    = explode('-', $detalles);
  $servicio   = $this->input->post('servicio');
  $ocupacion  = $this->input->post('ocupacion');
  $sexo       = $this->input->post('sexo');
  $civil      = $this->input->post('civil');
  $nombre     = $this->input->post('nombre');
  $apMaterno  = $this->input->post('apMaterno');
  $apPaterno  = $this->input->post('apPaterno');
  $nacimiento = $this->input->post('nacimiento');
  $inicio     = $this->input->post('inicio');
  $rfc        = $this->input->post('rfc');
  $xml = '
  <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:asmx="http://hdi.com.mx/asmx/">
 <soapenv:Header>
      <asmx:AuthenticateHeader>
         <asmx:siteID>0947960001</asmx:siteID>
         <asmx:sitePwd>PrGAHIMP*01</asmx:sitePwd>
      </asmx:AuthenticateHeader>
   </soapenv:Header>
   <soapenv:Body>
      <asmx:getpackages>
         <asmx:request>
            <asmx:idFormaPago>'.$pago.'</asmx:idFormaPago>
            <asmx:ciudad>'.$ciudad.'</asmx:ciudad>
            <asmx:estado>'.$estado.'</asmx:estado>
            <asmx:datosVehiculo>
               <asmx:idVehiculo>'.$detalle[0].'</asmx:idVehiculo>
               <asmx:idMarca>'.$marca.'</asmx:idMarca>
               <asmx:idModelo>'.$modelo.'</asmx:idModelo>
               <asmx:idTipo>'.$submarca.'</asmx:idTipo>
               <asmx:idVersion>'.$version.'</asmx:idVersion>
               <asmx:idTransmision>'.$transmision.'</asmx:idTransmision>
               <asmx:idUso>'.$uso.'</asmx:idUso>
               <asmx:tipoVehiculo>'.$tipo.'</asmx:tipoVehiculo>
               <asmx:numeroMotor>0</asmx:numeroMotor>
               <asmx:placas>0</asmx:placas>
               <asmx:color>0</asmx:color>
               <asmx:numeroSerie></asmx:numeroSerie>
               <asmx:pasajeros>0</asmx:pasajeros>
               <asmx:idZonaCirculacion>0</asmx:idZonaCirculacion>
               <asmx:idTonelaje>0</asmx:idTonelaje>
               <asmx:idServicio>'.$servicio.'</asmx:idServicio>
               <asmx:Conductor>
                  <asmx:ApellidoPaterno>'.$apPaterno.'</asmx:ApellidoPaterno>
                  <asmx:ApellidoMaterno>'.$apMaterno.'</asmx:ApellidoMaterno>
                  <asmx:Nombres>
                     <asmx:PrimerNombre>'.$nombre.'</asmx:PrimerNombre>
                     <asmx:SegundoNombre></asmx:SegundoNombre>
                  </asmx:Nombres>
                  <asmx:FechaDeNacimiento>'.$nacimiento.'</asmx:FechaDeNacimiento>
                  <asmx:RFC>'.$rfc.'</asmx:RFC>
                  <asmx:Sexo>'.$sexo.'</asmx:Sexo>
                  <asmx:EstadoCivil>'.$civil.'</asmx:EstadoCivil>
                  <asmx:Ocupacion>'.$ocupacion.'</asmx:Ocupacion>
                  <asmx:CuentaConCochera>false</asmx:CuentaConCochera>
               </asmx:Conductor>
               <asmx:DatosAdicionales>
                  <asmx:Renovaciones>0</asmx:Renovaciones>
                  <asmx:idRemolque>4603</asmx:idRemolque>
                  <asmx:CPCirculacion>'.$cp.'</asmx:CPCirculacion>
               </asmx:DatosAdicionales>
            </asmx:datosVehiculo>
            <asmx:usuario>0947960001</asmx:usuario>
            <asmx:obtenerTodosPaquetes>false</asmx:obtenerTodosPaquetes>
            <asmx:paquetesConCambios>
               <asmx:PaqueteCoberturas>
                  <asmx:Clave>19</asmx:Clave>
                  <asmx:CoberturasObligatorias>

                  <asmx:Cobertura>
                        <asmx:Regla>287</asmx:Regla>
                        <asmx:Clave>233</asmx:Clave>
                        <asmx:Descripcion>Daños Materiales</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>5</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura>

                     <asmx:Cobertura>
                        <asmx:Regla>339</asmx:Regla>
                        <asmx:Clave>236</asmx:Clave>
                        <asmx:Descripcion>Robo Total</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>10</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura>

                     <asmx:Cobertura>
                        <asmx:Regla>655</asmx:Regla>
                        <asmx:Clave>253</asmx:Clave>
                        <asmx:Descripcion>Responsabilidad Civil (Límite Único y Co</asmx:Descripcion>
                        <asmx:SumaAsegurada>1500000</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura>

                     <asmx:Cobertura>
                        <asmx:Regla>295</asmx:Regla>
                        <asmx:Clave>242</asmx:Clave>
                        <asmx:Descripcion>Asistencia Jurídica</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>6923</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura>

                     <asmx:Cobertura>
                        <asmx:Regla>513</asmx:Regla>
                        <asmx:Clave>365</asmx:Clave>
                        <asmx:Descripcion>Asistencia Funeraria</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>22765</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura>  

                      <asmx:Cobertura>
                        <asmx:Regla>317</asmx:Regla>
                        <asmx:Clave>264</asmx:Clave>
                        <asmx:Descripcion>Extensión de Responsabilidad Civil para Automóvil Particular</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura>                      
                  </asmx:CoberturasObligatorias>

                  <asmx:CoberturasObligatoriasOpcionales>
                     <asmx:Cobertura>
                        <asmx:Regla>292</asmx:Regla>
                        <asmx:Clave>239</asmx:Clave>
                        <asmx:Descripcion>Gastos Médicos Ocupantes (Límite Único C</asmx:Descripcion>
                        <asmx:SumaAsegurada>20000</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura> 

                     <asmx:Cobertura>
                        <asmx:Regla>653</asmx:Regla>
                        <asmx:Clave>366</asmx:Clave>
                        <asmx:Descripcion>Responsabilidad Civil Exceso por Muerte</asmx:Descripcion>
                        <asmx:SumaAsegurada>2000000</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura> 

                     <asmx:Cobertura>
                        <asmx:Regla>398</asmx:Regla>
                        <asmx:Clave>267</asmx:Clave>
                        <asmx:Descripcion>Responsabilidad Civil Familiar</asmx:Descripcion>
                        <asmx:SumaAsegurada>100000</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura> 

                     <asmx:Cobertura>
                        <asmx:Regla>302</asmx:Regla>
                        <asmx:Clave>249</asmx:Clave>
                        <asmx:Descripcion>Asistencia en viajes</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>6923</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura> 

                     <asmx:Cobertura>
                        <asmx:Regla>322</asmx:Regla>
                        <asmx:Clave>269</asmx:Clave>
                        <asmx:Descripcion>Asistencia Médica</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>6923</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>true</asmx:Calculada>
                     </asmx:Cobertura> 
                  </asmx:CoberturasObligatoriasOpcionales>

                  <asmx:CoberturasOpcionales>
                   <asmx:Cobertura>
                        <asmx:Regla>301</asmx:Regla>
                        <asmx:Clave>248</asmx:Clave>
                        <asmx:Descripcion>Exención de Deducible Por Pérdida Total Por Daños Materiales</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>false</asmx:Calculada>
                     </asmx:Cobertura> 

                     <asmx:Cobertura>
                        <asmx:Regla>409</asmx:Regla>
                        <asmx:Clave>250</asmx:Clave>
                        <asmx:Descripcion>Gastos médicos al conductor</asmx:Descripcion>
                        <asmx:SumaAsegurada>20000</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>false</asmx:Calculada>
                     </asmx:Cobertura> 

                      <asmx:Cobertura>
                        <asmx:Regla>689</asmx:Regla>
                        <asmx:Clave>355</asmx:Clave>
                        <asmx:Descripcion>Responsabilidad Civil Ocupantes</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>false</asmx:Calculada>
                     </asmx:Cobertura>

                     <asmx:Cobertura>
                        <asmx:Regla>361</asmx:Regla>
                        <asmx:Clave>235</asmx:Clave>
                        <asmx:Descripcion>Accidentes Automovilísticos al Conductor</asmx:Descripcion>
                        <asmx:SumaAsegurada>100000</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>false</asmx:Calculada>
                     </asmx:Cobertura> 

                     <asmx:Cobertura>
                        <asmx:Regla>308</asmx:Regla>
                        <asmx:Clave>255</asmx:Clave>
                        <asmx:Descripcion>Responsabilidad Civil al Viajero</asmx:Descripcion>
                        <asmx:SumaAsegurada>3160</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>false</asmx:Calculada>
                     </asmx:Cobertura> 

                     <asmx:Cobertura>
                        <asmx:Regla>319</asmx:Regla>
                        <asmx:Clave>266</asmx:Clave>
                        <asmx:Descripcion>Responsabilidad USA y Canadá</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>false</asmx:Calculada>
                     </asmx:Cobertura> 

                      <asmx:Cobertura>
                        <asmx:Regla>321</asmx:Regla>
                        <asmx:Clave>268</asmx:Clave>
                        <asmx:Descripcion>Ayuda para gastos de transporte</asmx:Descripcion>
                        <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>0</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>false</asmx:Calculada>
                     </asmx:Cobertura> 

                     <asmx:Cobertura>
                        <asmx:Regla>414</asmx:Regla>
                        <asmx:Clave>342</asmx:Clave>
                        <asmx:Descripcion>Auto Siempre</asmx:Descripcion>
                        <asmx:SumaAsegurada>5</asmx:SumaAsegurada>
                        <asmx:Deducible>0</asmx:Deducible>
                        <asmx:ProveedorAsistencia>6923</asmx:ProveedorAsistencia>
                        <asmx:PrimaNeta>0</asmx:PrimaNeta>
                        <asmx:Calculada>false</asmx:Calculada>
                     </asmx:Cobertura>                                                                                         
                  </asmx:CoberturasOpcionales>
               </asmx:PaqueteCoberturas>
            </asmx:paquetesConCambios>
            <asmx:listaPaquetesACalcular>
               <asmx:StringArray>
                  <asmx:string>19</asmx:string>
               </asmx:StringArray>
            </asmx:listaPaquetesACalcular>
            <asmx:IDTipoSumaAsegurada>'.$tiposuma.'</asmx:IDTipoSumaAsegurada>
            <asmx:SumaAsegurada>0</asmx:SumaAsegurada>
            <asmx:IvaPorcentaje>0</asmx:IvaPorcentaje>
            <asmx:vigencia>
               <asmx:Inicial>2020-09-01T00:00:00</asmx:Inicial>
               <asmx:Final>2021-09-01T00:00:00</asmx:Final>
            </asmx:vigencia>
         </asmx:request>
      </asmx:getpackages>
   </soapenv:Body>
</soapenv:Envelope>';

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
     	file_put_contents('cotizacion.xml',$response);
     	header('Content-type: text/xml');
     }
 }


 public function getCoberturasPaquetes($tipoAuto = null, $paquete = null, $inicio = null , $fin = null)
 {

  $coberturas = '';

  if($tipoAuto == 3829 )
  {


    switch ($paquete) {

      case 19:
        
        $coberturas = '<Clave>23</Clave>
                   <Descripcion>AMPLIO PICK UPS</Descripcion>
                   <Vigencia>
                       <Inicial>'.$inicio.'</Inicial>
                       <Final>'.$fin.'</Final>
                  </Vigencia>
                  <CoberturasObligatorias>
                  <Cobertura>
                        <Regla>287</Regla>
                        <Clave>233</Clave>
                        <Descripcion>Daños Materiales</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>5</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>339</Regla>
                        <Clave>236</Clave>
                        <Descripcion>Robo Total</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>10</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>655</Regla>
                        <Clave>253</Clave>
                        <Descripcion>Responsabilidad Civil (Límite Único y Co</Descripcion>
                        <SumaAsegurada>1500000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>295</Regla>
                        <Clave>242</Clave>
                        <Descripcion>Asistencia Jurídica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     </CoberturasObligatorias>
                  <CoberturasObligatoriasOpcionales>
                      <Cobertura>
                        <Regla>292</Regla>
                        <Clave>239</Clave>
                        <Descripcion>Gastos Médicos Ocupantes (Límite Único C</Descripcion>
                        <SumaAsegurada>20000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>653</Regla>
                        <Clave>366</Clave>
                        <Descripcion>Responsabilidad Civil Exceso por Muerte</Descripcion>
                        <SumaAsegurada>2000000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>398</Regla>
                        <Clave>267</Clave>
                        <Descripcion>Responsabilidad Civil Familiar</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>302</Regla>
                        <Clave>249</Clave>
                        <Descripcion>Asistencia en viajes</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>322</Regla>
                        <Clave>269</Clave>
                        <Descripcion>Asistencia Médica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>  
                  </CoberturasObligatoriasOpcionales>
                  <CoberturasOpcionales>
                  <Cobertura>
                        <Regla>361</Regla>
                        <Clave>235</Clave>
                        <Descripcion>Accidentes Automovilísticos al Conductor</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>   
                     <Cobertura>
                        <Regla>308</Regla>
                        <Clave>255</Clave>
                        <Descripcion>Responsabilidad Civil al Viajero</Descripcion>
                        <SumaAsegurada>3160</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>319</Regla>
                        <Clave>266</Clave>
                        <Descripcion>Responsabilidad USA y Canadá</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>   
                      <Cobertura>
                        <Regla>321</Regla>
                        <Clave>268</Clave>
                        <Descripcion>Ayuda para gastos de transporte</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>
                  </CoberturasOpcionales>
                  <Ajuste>
                     <PorcentajeAjuste>0</PorcentajeAjuste>
                     <TipoAjuste>4612</TipoAjuste>
                 </Ajuste>';
        break;
                case 21:
                  
                 $coberturas = '<Clave>24</Clave>
                   <Descripcion>LIMITADO PICK UPS</Descripcion>
                   <Vigencia>
                       <Inicial>'.$inicio.'</Inicial>
                       <Final>'.$fin.'</Final>
                  </Vigencia>
                  <CoberturasObligatorias>
                     <Cobertura>
                        <Regla>339</Regla>
                        <Clave>236</Clave>
                        <Descripcion>Robo Total</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>10</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>655</Regla>
                        <Clave>253</Clave>
                        <Descripcion>Responsabilidad Civil (Límite Único y Co</Descripcion>
                        <SumaAsegurada>1500000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>295</Regla>
                        <Clave>242</Clave>
                        <Descripcion>Asistencia Jurídica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     </CoberturasObligatorias>
                  <CoberturasObligatoriasOpcionales>
                      <Cobertura>
                        <Regla>292</Regla>
                        <Clave>239</Clave>
                        <Descripcion>Gastos Médicos Ocupantes (Límite Único C</Descripcion>
                        <SumaAsegurada>20000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>653</Regla>
                        <Clave>366</Clave>
                        <Descripcion>Responsabilidad Civil Exceso por Muerte</Descripcion>
                        <SumaAsegurada>2000000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>398</Regla>
                        <Clave>267</Clave>
                        <Descripcion>Responsabilidad Civil Familiar</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>302</Regla>
                        <Clave>249</Clave>
                        <Descripcion>Asistencia en viajes</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>322</Regla>
                        <Clave>269</Clave>
                        <Descripcion>Asistencia Médica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>  
                  </CoberturasObligatoriasOpcionales>
                  <CoberturasOpcionales>
                  <Cobertura>
                        <Regla>361</Regla>
                        <Clave>235</Clave>
                        <Descripcion>Accidentes Automovilísticos al Conductor</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>   
                     <Cobertura>
                        <Regla>308</Regla>
                        <Clave>255</Clave>
                        <Descripcion>Responsabilidad Civil al Viajero</Descripcion>
                        <SumaAsegurada>3160</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>319</Regla>
                        <Clave>266</Clave>
                        <Descripcion>Responsabilidad USA y Canadá</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>   
                      <Cobertura>
                        <Regla>321</Regla>
                        <Clave>268</Clave>
                        <Descripcion>Ayuda para gastos de transporte</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>
                  </CoberturasOpcionales>
                  <Ajuste>
                     <PorcentajeAjuste>0</PorcentajeAjuste>
                     <TipoAjuste>4612</TipoAjuste>
                  </Ajuste>';
                  break;

                case 22:
                  
                  $coberturas = '<Clave>25</Clave>
                   <Descripcion>BASICO PICK UPS</Descripcion>
                   <Vigencia>
                       <Inicial>'.$inicio.'</Inicial>
                       <Final>'.$fin.'</Final>
                  </Vigencia>
                  <CoberturasObligatorias>
                     <Cobertura>
                        <Regla>655</Regla>
                        <Clave>253</Clave>
                        <Descripcion>Responsabilidad Civil (Límite Único y Co</Descripcion>
                        <SumaAsegurada>1500000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>295</Regla>
                        <Clave>242</Clave>
                        <Descripcion>Asistencia Jurídica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     </CoberturasObligatorias>
                  <CoberturasObligatoriasOpcionales>
                      <Cobertura>
                        <Regla>292</Regla>
                        <Clave>239</Clave>
                        <Descripcion>Gastos Médicos Ocupantes (Límite Único C</Descripcion>
                        <SumaAsegurada>20000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>653</Regla>
                        <Clave>366</Clave>
                        <Descripcion>Responsabilidad Civil Exceso por Muerte</Descripcion>
                        <SumaAsegurada>2000000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>398</Regla>
                        <Clave>267</Clave>
                        <Descripcion>Responsabilidad Civil Familiar</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>302</Regla>
                        <Clave>249</Clave>
                        <Descripcion>Asistencia en viajes</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>322</Regla>
                        <Clave>269</Clave>
                        <Descripcion>Asistencia Médica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>  
                  </CoberturasObligatoriasOpcionales>
                  <CoberturasOpcionales>
                  <Cobertura>
                        <Regla>361</Regla>
                        <Clave>235</Clave>
                        <Descripcion>Accidentes Automovilísticos al Conductor</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>   
                     <Cobertura>
                        <Regla>308</Regla>
                        <Clave>255</Clave>
                        <Descripcion>Responsabilidad Civil al Viajero</Descripcion>
                        <SumaAsegurada>3160</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>319</Regla>
                        <Clave>266</Clave>
                        <Descripcion>Responsabilidad USA y Canadá</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>   
                      <Cobertura>
                        <Regla>321</Regla>
                        <Clave>268</Clave>
                        <Descripcion>Ayuda para gastos de transporte</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>
                  </CoberturasOpcionales>
                  <Ajuste>
                     <PorcentajeAjuste>0</PorcentajeAjuste>
                     <TipoAjuste>4612</TipoAjuste>
                  </Ajuste>';

                  break;

              case  144:

              $coberturas = '
                  <Clave>146</Clave>
                   <Descripcion>RC EXCESO PERSONAS</Descripcion>
                   <Vigencia>
                       <Inicial>'.$inicio.'</Inicial>
                       <Final>'.$fin.'</Final>
                  </Vigencia>
                  <CoberturasObligatoriasOpcionales>
                  <Cobertura>
                        <Regla>917</Regla>
                        <Clave>366</Clave>
                        <Descripcion>Responsabilidad Civil Exceso por Muerte</Descripcion>
                        <SumaAsegurada>2000000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                    </Cobertura>
                    </CoberturasObligatoriasOpcionales>
                      <Ajuste>
                     <PorcentajeAjuste>0</PorcentajeAjuste>
                     <TipoAjuste>4612</TipoAjuste>
                  </Ajuste>';
                break;
    }
  }elseif ($tipoAuto == 4579) {
    
    switch ($paquete) {

      case 19:
        
        $coberturas = '<Clave>19</Clave>
                   <Descripcion>AMPLIA AUTOS RESIDENTES</Descripcion>
                   <Vigencia>
                       <Inicial>'.$inicio.'</Inicial>
                       <Final>'.$fin.'</Final>
                  </Vigencia>
                  <CoberturasObligatorias>
                  <Cobertura>
                        <Regla>287</Regla>
                        <Clave>233</Clave>
                        <Descripcion>Daños Materiales</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>5</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>339</Regla>
                        <Clave>236</Clave>
                        <Descripcion>Robo Total</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>10</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>655</Regla>
                        <Clave>253</Clave>
                        <Descripcion>Responsabilidad Civil (Límite Único y Co</Descripcion>
                        <SumaAsegurada>1500000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>295</Regla>
                        <Clave>242</Clave>
                        <Descripcion>Asistencia Jurídica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>513</Regla>
                        <Clave>365</Clave>
                        <Descripcion>Asistencia Funeraria</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>22765</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>   
                      <Cobertura>
                        <Regla>317</Regla>
                        <Clave>264</Clave>
                        <Descripcion>Extensión de Responsabilidad Civil para Automóvil Particular</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>                      
                  </CoberturasObligatorias>
                  <CoberturasObligatoriasOpcionales>
                     <Cobertura>
                        <Regla>292</Regla>
                        <Clave>239</Clave>
                        <Descripcion>Gastos Médicos Ocupantes (Límite Único C</Descripcion>
                        <SumaAsegurada>20000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>653</Regla>
                        <Clave>366</Clave>
                        <Descripcion>Responsabilidad Civil Exceso por Muerte</Descripcion>
                        <SumaAsegurada>2000000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>398</Regla>
                        <Clave>267</Clave>
                        <Descripcion>Responsabilidad Civil Familiar</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>302</Regla>
                        <Clave>249</Clave>
                        <Descripcion>Asistencia en viajes</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>322</Regla>
                        <Clave>269</Clave>
                        <Descripcion>Asistencia Médica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                  </CoberturasObligatoriasOpcionales>
                  <CoberturasOpcionales>
                   <Cobertura>
                        <Regla>301</Regla>
                        <Clave>248</Clave>
                        <Descripcion>Exención de Deducible Por Pérdida Total Por Daños Materiales</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>409</Regla>
                        <Clave>250</Clave>
                        <Descripcion>Gastos médicos al conductor</Descripcion>
                        <SumaAsegurada>20000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura> 
                      <Cobertura>
                        <Regla>689</Regla>
                        <Clave>355</Clave>
                        <Descripcion>Responsabilidad Civil Ocupantes</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>  
                     <Cobertura>
                        <Regla>361</Regla>
                        <Clave>235</Clave>
                        <Descripcion>Accidentes Automovilísticos al Conductor</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>   
                     <Cobertura>
                        <Regla>308</Regla>
                        <Clave>255</Clave>
                        <Descripcion>Responsabilidad Civil al Viajero</Descripcion>
                        <SumaAsegurada>3160</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>319</Regla>
                        <Clave>266</Clave>
                        <Descripcion>Responsabilidad USA y Canadá</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>   
                      <Cobertura>
                        <Regla>321</Regla>
                        <Clave>268</Clave>
                        <Descripcion>Ayuda para gastos de transporte</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>414</Regla>
                        <Clave>342</Clave>
                        <Descripcion>Auto Siempre</Descripcion>
                        <SumaAsegurada>5</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>                                                          
                  </CoberturasOpcionales>
                  <Ajuste>
                     <PorcentajeAjuste>0</PorcentajeAjuste>
                     <TipoAjuste>4612</TipoAjuste>
                  </Ajuste>';
        break;

             case 21:
             $coberturas = '<Clave>21</Clave>
                   <Descripcion>LIMITADA AUTOS RESIDENTES</Descripcion>
                   <Vigencia>
                       <Inicial>'.$inicio.'</Inicial>
                       <Final>'.$fin.'</Final>
                  </Vigencia>
                  <CoberturasObligatorias>
                    <Cobertura>
                        <Regla>339</Regla>
                        <Clave>236</Clave>
                        <Descripcion>Robo Total</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>10</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>655</Regla>
                        <Clave>253</Clave>
                        <Descripcion>Responsabilidad Civil (Límite Único y Combinado)</Descripcion>
                        <SumaAsegurada>1500000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>295</Regla>
                        <Clave>242</Clave>
                        <Descripcion>Asistencia Jurídica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                  </CoberturasObligatorias>
                  <CoberturasObligatoriasOpcionales>
                     <Cobertura>
                        <Regla>292</Regla>
                        <Clave>239</Clave>
                        <Descripcion>Gastos Médicos Ocupantes (Límite Único Combinado)</Descripcion>
                        <SumaAsegurada>20000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>317</Regla>
                        <Clave>264</Clave>
                        <Descripcion>Extensión de Responsabilidad Civil para Automóvil Particular</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>  
                     <Cobertura>
                        <Regla>653</Regla>
                        <Clave>366</Clave>
                        <Descripcion>Responsabilidad Civil Exceso por Muerte</Descripcion>
                        <SumaAsegurada>2000000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>398</Regla>
                        <Clave>267</Clave>
                        <Descripcion>Responsabilidad Civil Familiar</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>322</Regla>
                        <Clave>269</Clave>
                        <Descripcion>Asistencia Médica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>  
                     <Cobertura>
                        <Regla>513</Regla>
                        <Clave>365</Clave>
                        <Descripcion>Asistencia Funeraria</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>22765</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>             
                  </CoberturasObligatoriasOpcionales>
                  <CoberturasOpcionales>
                    <Cobertura>
                        <Regla>305</Regla>
                        <Clave>252</Clave>
                        <Descripcion>Adaptaciones y conversiones (RT)</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>22765</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                      </Cobertura>
                      <Cobertura>
                        <Regla>316</Regla>
                        <Clave>263</Clave>
                        <Descripcion>Equipo especial robo total</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>22765</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                      </Cobertura>
                      <Cobertura>
                        <Regla>689</Regla>
                        <Clave>355</Clave>
                        <Descripcion>Responsabilidad Civil Ocupantes</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>
                        <Cobertura>
                        <Regla>361</Regla>
                        <Clave>235</Clave>
                        <Descripcion>Accidentes Automovilísticos al Conductor</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>
                      <Cobertura>
                        <Regla>319</Regla>
                        <Clave>266</Clave>
                        <Descripcion>Responsabilidad USA y Canadá</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>   
                      <Cobertura>
                        <Regla>321</Regla>
                        <Clave>268</Clave>
                        <Descripcion>Ayuda para gastos de transporte</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>      
                  </CoberturasOpcionales>
                  <Ajuste>
                     <PorcentajeAjuste>0</PorcentajeAjuste>
                     <TipoAjuste>4612</TipoAjuste>
                  </Ajuste>';
           break;

              case 22:

                $coberturas = '<Clave>22</Clave>
                   <Descripcion>BASICO AUTOS RESIDENTES</Descripcion>
                   <Vigencia>
                       <Inicial>'.$inicio.'</Inicial>
                       <Final>'.$fin.'</Final>
                  </Vigencia>
                  <CoberturasObligatorias>
                     <Cobertura>
                        <Regla>655</Regla>
                        <Clave>253</Clave>
                        <Descripcion>Responsabilidad Civil (Límite Único y Co</Descripcion>
                        <SumaAsegurada>1500000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                      </Cobertura>
                      <Cobertura>
                        <Regla>295</Regla>
                        <Clave>242</Clave>
                        <Descripcion>Asistencia Jurídica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                      </Cobertura>
                  </CoberturasObligatorias>
                  <CoberturasObligatoriasOpcionales>
                      <Cobertura>
                        <Regla>292</Regla>
                        <Clave>239</Clave>
                        <Descripcion>Gastos Médicos Ocupantes (Límite Único C</Descripcion>
                        <SumaAsegurada>20000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                      </Cobertura>
                      <Cobertura>
                        <Regla>317</Regla>
                        <Clave>264</Clave>
                        <Descripcion>Extensión de Responsabilidad Civil para Automóvil Particular</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>  
                     <Cobertura>
                        <Regla>653</Regla>
                        <Clave>366</Clave>
                        <Descripcion>Responsabilidad Civil Exceso por Muerte</Descripcion>
                        <SumaAsegurada>2000000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                     <Cobertura>
                        <Regla>398</Regla>
                        <Clave>267</Clave>
                        <Descripcion>Responsabilidad Civil Familiar</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>302</Regla>
                        <Clave>249</Clave>
                        <Descripcion>Asistencia en viajes</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>322</Regla>
                        <Clave>269</Clave>
                        <Descripcion>Asistencia Médica</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>6923</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura> 
                     <Cobertura>
                        <Regla>513</Regla>
                        <Clave>365</Clave>
                        <Descripcion>Asistencia Funeraria</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>22765</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>  
                  </CoberturasObligatoriasOpcionales>
                  <CoberturasOpcionales>
                     <Cobertura>
                        <Regla>689</Regla>
                        <Clave>355</Clave>
                        <Descripcion>Responsabilidad Civil Ocupantes</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>
                        <Cobertura>
                        <Regla>361</Regla>
                        <Clave>235</Clave>
                        <Descripcion>Accidentes Automovilísticos al Conductor</Descripcion>
                        <SumaAsegurada>100000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>
                      <Cobertura>
                        <Regla>319</Regla>
                        <Clave>266</Clave>
                        <Descripcion>Responsabilidad USA y Canadá</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>false</Calculada>
                     </Cobertura>
                  </CoberturasOpcionales>
                  <Ajuste>
                     <PorcentajeAjuste>0</PorcentajeAjuste>
                     <TipoAjuste>4612</TipoAjuste>
                  </Ajuste>';
                break;

              case 144:
                
                 $coberturas = '
                 <Clave>144</Clave>
                   <Descripcion>RC EXCESO PERSONAS</Descripcion>
                   <Vigencia>
                       <Inicial>'.$inicio.'</Inicial>
                       <Final>'.$fin.'</Final>
                  </Vigencia>
                  <CoberturasObligatorias>
                      <Cobertura>
                        <Regla>513</Regla>
                        <Clave>365</Clave>
                        <Descripcion>Asistencia Funeraria</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>22765</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>   
                      <Cobertura>
                        <Regla>317</Regla>
                        <Clave>264</Clave>
                        <Descripcion>Extensión de Responsabilidad Civil para Automóvil Particular</Descripcion>
                        <SumaAsegurada>0</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                     </Cobertura>
                   </CoberturasObligatorias>
                  <CoberturasObligatoriasOpcionales>
                  <Cobertura>
                        <Regla>917</Regla>
                        <Clave>366</Clave>
                        <Descripcion>Responsabilidad Civil Exceso por Muerte</Descripcion>
                        <SumaAsegurada>2000000</SumaAsegurada>
                        <Deducible>0</Deducible>
                        <ProveedorAsistencia>0</ProveedorAsistencia>
                        <PrimaNeta>0</PrimaNeta>
                        <Calculada>true</Calculada>
                    </Cobertura>
                    </CoberturasObligatoriasOpcionales>
                      <Ajuste>
                     <PorcentajeAjuste>0</PorcentajeAjuste>
                     <TipoAjuste>4612</TipoAjuste>
                  </Ajuste>';

                break;
    }
  }

  return $coberturas;

 }

 public function saveCotizacion()
 {
  
  $result     = [];
  $action     = 'http://hdi.com.mx/asmx/savequote';
  $estado     = $this->input->post('estado');
  $ciudad     = $this->input->post('ciudad');
  $pago       = $this->input->post('pago');
  $marca      = $this->input->post('marca');
  $submarca   = $this->input->post('submarca');
  $modelo     = $this->input->post('modelo');
  $version    = $this->input->post('version');
  $transmision = $this->input->post('transmision');
  $tipo       = $this->input->post('tipo');
  $serie      = strtoupper($this->input->post('serie'));
  $tiposuma   = $this->input->post('tiposuma');
  $cp         = $this->input->post('cp');
  $uso        = $this->input->post('uso');
  $detalles   = $this->input->post('detalles');
  $detalle    = explode('-', $detalles);
  $servicio   = $this->input->post('servicio');
  $ocupacion  = $this->input->post('ocupacion');
  $sexo       = $this->input->post('sexo');
  $civil      = $this->input->post('civil');
  $nombre     = strtoupper($this->input->post('nombre'));
  $apMaterno  = strtoupper($this->input->post('apMaterno'));
  $apPaterno  = strtoupper($this->input->post('apPaterno'));
  $nacimiento = $this->input->post('nacimiento');
  $inicio     = $this->input->post('inicio');
  $fin        = date('Y-m-d', strtotime('+364 days'));
  $rfc        = strtoupper($this->input->post('rfc'));
  $color      = strtoupper($this->input->post('color'));
  $placa      = strtoupper($this->input->post('placa'));
  $calle      = strtoupper($this->input->post('direccion'));
  $nacionalidad = $this->input->post('nacionalidad');
  $telefono   = $this->input->post('telefono');
  $numero     = $this->input->post('numero');
  $colonia    = strtoupper($this->input->post('colonia'));
  $giro       = $this->input->post('giro');
  $conducto   = $this->input->post('conducto');
  $ocupacionC =$this->input->post('ocupacionC');
  $tipoConducto = ''; 
  $coberturas = '';
  $paquete    = $this->input->post('paquete');

  $newPaquete = '';


  if($tipo == 3829 )
  {

    switch ($paquete) {
      
      case 19:
         $newPaquete = 23;
        break;

      case 21:
         $newPaquete = 24;
        break;

      case 22:
         $newPaquete = 25;
        break;
      
      case 144:
         $newPaquete = 146;
        break;
    }
  }elseif ($tipo == 4579) {

    switch ($paquete) {
      
      case 19:
         $newPaquete = 19;
        break;

      case 21:
         $newPaquete = 21;
        break;

      case 22:
         $newPaquete = 22;
        break;
      
      case 144:
         $newPaquete = 144;
        break;
  }
}

  $coberturas = $this->getCoberturasPaquetes($tipo,$paquete,$inicio,$fin);


   if($conducto == 1)
   {
    $tipoConducto='';
   }elseif($conducto == 4)
   {
    $tipoConducto = '
                  <InformacionPago>
                     <idBanco></idBanco>
                     <idTipoTarjeta></idTipoTarjeta>
                     <numCuentaHabiente></numCuentaHabiente>
                     <nombreTitularTarjeta></nombreTitularTarjeta>
                     <numVencimientoTarjeta></numVencimientoTarjeta>
                     <numCodigoSeguridad></numCodigoSeguridad>
                     <activarEmitirDespuesDePagar>true</activarEmitirDespuesDePagar>
                  </InformacionPago>';
   }



  $xml  = '
  <Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/" >
  <Header>
      <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
         <siteID>0947960001</siteID>
         <sitePwd>PrGAHIMP*01</sitePwd>
      </AuthenticateHeader>
   </Header>
   <Body>
      <savequote xmlns="http://hdi.com.mx/asmx/">
         <request>
            <datosCotizacion>
               <PaqueteCoberturas>
                 '.$coberturas.'   
             </PaqueteCoberturas>
               <CaracteristicasVehiculo>
                <idVehiculo>'.$detalle[0].'</idVehiculo>
               <idMarca>'.$marca.'</idMarca>
               <idModelo>'.$modelo.'</idModelo>
               <idTipo>'.$submarca.'</idTipo>
               <idVersion>'.$version.'</idVersion>
               <idTransmision>'.$transmision.'</idTransmision>
               <idUso>'.$uso.'</idUso>
               <tipoVehiculo>'.$tipo.'</tipoVehiculo>
               <numeroMotor>0</numeroMotor>
               <placas>'.$placa.'</placas>
               <color>'.$color.'</color>
               <numeroSerie>'.$serie.'</numeroSerie>
               <pasajeros>'.$detalle[1].'</pasajeros>
               <idZonaCirculacion>0</idZonaCirculacion>
               <idTonelaje>0</idTonelaje>
               <idServicio>0</idServicio>
             <Conductor>
                   <ApellidoPaterno>'.$apPaterno.'</ApellidoPaterno>
                   <ApellidoMaterno>'.$apMaterno.'</ApellidoMaterno>
                <Nombres>
                     <PrimerNombre>'.$nombre.'</PrimerNombre>
                     <SegundoNombre></SegundoNombre>
                </Nombres>
                  <FechaDeNacimiento>'.$nacimiento.'</FechaDeNacimiento>
                  <RFC>'.$rfc.'</RFC>
                  <Sexo>'.$sexo.'</Sexo>
                  <EstadoCivil>'.$civil.'</EstadoCivil>
                  <Ocupacion>'.$ocupacionC.'</Ocupacion>
                  <CuentaConCochera>false</CuentaConCochera>
              </Conductor>
                  <AjusteAdicional>
                     <IdConductoCobro>1</IdConductoCobro>
                  </AjusteAdicional>
                  <DatosAdicionales>
                     <Renovaciones>0</Renovaciones>
                     <idRemolque>4603</idRemolque>
                     <CPCirculacion>'.$cp.'</CPCirculacion>
                  </DatosAdicionales>
               </CaracteristicasVehiculo>
               <Cliente>
                 <idTipoPersona>00</idTipoPersona>
                  <actividadPolitica>false</actividadPolitica>
                  <apellidoMaterno>'.$apMaterno.'</apellidoMaterno>
                  <apellidoPaterno>'.$apPaterno.'</apellidoPaterno>
                  <estadoCivil>'.$civil.'</estadoCivil>
                  <fechaNacimiento>'.$nacimiento.'</fechaNacimiento>
                  <giroActividad>'.$giro.'</giroActividad>
                  <ocupacion>'.$ocupacion.'</ocupacion>
                  <primerNombre>'.$nombre.'</primerNombre>
                  <rfc>'.$rfc.'</rfc>
                  <segundoNombre></segundoNombre>
                  <sexo>'.$sexo.'</sexo>
                  <Direccion>
                     <calle>'.$calle.'</calle>
                     <ciudad>'.$ciudad.'</ciudad>
                     <codigoPostal>'.$cp.'</codigoPostal>
                     <colonia>'.$colonia.'</colonia>
                     <estado>'.$estado.'</estado>
                     <nacionalidad>'.$nacionalidad.'</nacionalidad>
                     <pais>00007</pais>
                     <telefonoCasa>'.$telefono.'</telefonoCasa>
                     <numeroExterior>'.$numero.'</numeroExterior>
                     <numeroInterior></numeroInterior>
                  </Direccion>
               </Cliente>
               <fechaInicioVigencia>'.$inicio.'</fechaInicioVigencia>
               <idFormaPago>'.$pago.'</idFormaPago>
               <idConductoCobro>'.$conducto.'</idConductoCobro>
               '.$tipoConducto.'
               <idEstado>'.$estado.'</idEstado>
               <idCiudad>'.$ciudad.'</idCiudad>
               <PaqueteEmitir>
                  <IdPaquete>'.$newPaquete.'</IdPaquete>
                  <ListaCondiciones>
                     <CondicionesTarificar>
                        <DeducibleDM>5</DeducibleDM>
                        <DeducibleRT>10</DeducibleRT>
                     </CondicionesTarificar>
                  </ListaCondiciones>
                  <ListaConfiguraciones>
                     <ConfiguracionPaquete>
                        <UsuarioCotiza>0947960001</UsuarioCotiza>
                        <InicioVigencia>'.$inicio.'</InicioVigencia>
                        <FinVigencia>'.$fin.'</FinVigencia>
                         <EsCotizacionDiasPorMes>false</EsCotizacionDiasPorMes>
                        <Descuento>0</Descuento>
                        <AgenteCotiza>0947960001</AgenteCotiza>
                     </ConfiguracionPaquete>
                  </ListaConfiguraciones>
               </PaqueteEmitir>
               <IDTipoSumaAsegurada>'.$tiposuma.'</IDTipoSumaAsegurada>
               <SumaAsegurada>0</SumaAsegurada>
               <porcentajeIva>0</porcentajeIva>
               <tipoPersona>00</tipoPersona>
            </datosCotizacion>
            <usuario>0947960001</usuario>
         </request>
      </savequote>
   </Body>
</Envelope>';

/*
header('Content-type: text/xml');

file_put_contents('savequote-request.xml', $xml);
 
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
      file_put_contents('savequote-response.xml',$response);
      header('Content-type: text/xml');

     }*/

     $result = $this->callHdi($xml,$action);

 if($result != null)
 {
 	$informacionPoliza = $result['SOAP:ENVELOPE']['SOAP:BODY']['SAVEQUOTERESPONSE']['SAVEQUOTERESULT']['INFORMACIONCOTIZACION'];
 }


  if(empty($informacionPoliza['ERRORES']))
  {

  	echo $informacionPoliza['IDCOTIZACION'];
  
  }else{

   echo 'error'.$informacionPoliza['ERRORES']['MENSAJE']['DESCRIPCION'];

  }

 }


 public function emitir()
 {
 	$result   = [];
 	$action   = 'http://hdi.com.mx/asmx/EmiteCotizacionGuardada';

 	// paquetes y coberturas
 	$cotizacion = $this->input->post('cotizacion');
  $paquete    = $this->input->post('paquete');
  $coberturas = '';

 	// descripcion vehiculo
    $marca    = $this->input->post('marca');
    $submarca = $this->input->post('submarca');
    $modelo   = $this->input->post('modelo');
    $version  = $this->input->post('version');
    $transmision = $this->input->post('transmision');
    $tipo     = $this->input->post('tipo');
    $serie    = strtoupper($this->input->post('serie'));
    $uso      = $this->input->post('uso');
    $detalles = $this->input->post('detalles');
    $detalle  = explode('-', $detalles);
    $color    = strtoupper($this->input->post('color'));
    $placa    = strtoupper($this->input->post('placa'));

    //informacion general
    $servicio   = $this->input->post('servicio');
    $tiposuma   = $this->input->post('tiposuma');
    $cp         = $this->input->post('cp');
    $conducto   = $this->input->post('conducto');
    $inicio     = $this->input->post('inicio');
    $fin        = date('Y-m-d', strtotime('+364 days'));
    $pago       = $this->input->post('pago');
    $ocupacionC = $this->input->post('ocupacionC');

    //cliente
    $nombre       = strtoupper($this->input->post('nombre'));
    $apPaterno    = strtoupper($this->input->post('apPaterno'));
    $apMaterno    = strtoupper($this->input->post('apMaterno'));
    $nacimiento   = $this->input->post('nacimiento');
    $sexo         = $this->input->post('sexo');
    $civil        = $this->input->post('civil');
    $ocupacion    = $this->input->post('ocupacion');
    $giro         = $this->input->post('giro');
    $nacionalidad = $this->input->post('nacionalidad');
    $rfc          = strtoupper($this->input->post('rfc'));
    $telefono     = $this->input->post('telefono');

    //domicilio
    $calle        = strtoupper($this->input->post('calle'));
    $estado       = $this->input->post('estado');
    $ciudad       = $this->input->post('ciudad');
    $colonia      = strtoupper($this->input->post('colonia'));
    $numero       = $this->input->post('numero');

    $documentoPdf = '';
    $newPaquete = '';

    if($tipo == 3829 )
  {

    switch ($paquete) {
      
      case 19:
         $newPaquete = 23;
        break;

      case 21:
         $newPaquete = 24;
        break;

      case 22:
         $newPaquete = 25;
        break;
      
      case 144:
         $newPaquete = 146;
        break;
    }
  }elseif ($tipo == 4579) {

    switch ($paquete) {
      
      case 19:
         $newPaquete = 19;
        break;

      case 21:
         $newPaquete = 21;
        break;

      case 22:
         $newPaquete = 22;
        break;
      
      case 144:
         $newPaquete = 144;
        break;
  }
}

    $coberturas = $this->getCoberturasPaquetes($tipo,$paquete,$inicio,$fin);
  
$xml = '<Envelope xmlns="http://www.w3.org/2003/05/soap-envelope">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <EmiteCotizacionGuardada xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <IdCotizacion>'.$cotizacion.'</IdCotizacion>
                <IdAgencia>00044</IdAgencia>
                <IdUsuario>0947960001</IdUsuario>
                <!-- Optional -->
                <listaDatosCotizacion>
                    <!-- Optional -->
                    <DatosCotizacion>
                        <!-- Optional -->
                        <PaqueteCoberturas>
                        '.$coberturas.'
                        </PaqueteCoberturas>
                        <!-- Optional -->
                        <CaracteristicasVehiculo>
                            <idVehiculo>'.$detalle[0].'</idVehiculo>
                            <idMarca>'.$marca.'</idMarca>
                            <idModelo>'.$modelo.'</idModelo>
                            <idTipo>'.$submarca.'</idTipo>
                            <idVersion>'.$version.'</idVersion>
                            <idTransmision>'.$transmision.'</idTransmision>
                            <idUso>'.$uso.'</idUso>
                            <tipoVehiculo>'.$tipo.'</tipoVehiculo>
                            <numeroMotor>0</numeroMotor>
                            <placas>'.$placa.'</placas>
                            <color>'.$color.'</color>
                            <numeroSerie>'.$serie.'</numeroSerie>
                            <pasajeros>'.$detalle[1].'</pasajeros>
                            <idZonaCirculacion>0</idZonaCirculacion>
                            <idTonelaje>0</idTonelaje>
                            <idServicio>0</idServicio>
                            <idRiesgoCarga>0</idRiesgoCarga>
                            <!-- Optional -->
                            <Conductor>
                                <ApellidoPaterno>'.$apPaterno.'</ApellidoPaterno>
                                <ApellidoMaterno>'.$apMaterno.'</ApellidoMaterno>
                                <!-- Optional -->
                                <Nombres>
                                    <PrimerNombre>'.$nombre.'</PrimerNombre>
                                    <SegundoNombre></SegundoNombre>
                                </Nombres>
                                <FechaDeNacimiento>'.$nacimiento.'</FechaDeNacimiento>
                                <RFC>'.$rfc.'</RFC>
                                <Sexo>'.$sexo.'</Sexo>
                                <EstadoCivil>'.$civil.'</EstadoCivil>
                                <Ocupacion>'.$ocupacionC.'</Ocupacion>
                                <CuentaConCochera>false</CuentaConCochera>
                            </Conductor>
                            <!-- Optional -->
                            <AjusteAdicional>
                                <IdConductoCobro>1</IdConductoCobro>
                            </AjusteAdicional>
                            <!-- Optional -->
                            <DatosAdicionales>
                                <Renovaciones>0</Renovaciones>
                                <idRemolque>4603</idRemolque>
                                <CPCirculacion>'.$cp.'</CPCirculacion>
                            </DatosAdicionales>
                        </CaracteristicasVehiculo>
                        <!-- Optional -->
                        <Cliente>
                            <idTipoPersona>00</idTipoPersona>
                            <actividadPolitica>false</actividadPolitica>
                            <apellidoMaterno>'.$apMaterno.'</apellidoMaterno>
                            <apellidoPaterno>'.$apPaterno.'</apellidoPaterno>
                            <estadoCivil>'.$civil.'</estadoCivil>
                            <fechaNacimiento>'.$nacimiento.'</fechaNacimiento>
                            <giroActividad>'.$giro.'</giroActividad>
                            <ocupacion>'.$ocupacion.'</ocupacion>
                            <primerNombre>'.$nombre.'</primerNombre>
                            <rfc>'.$rfc.'</rfc>
                            <segundoNombre>'.$nombre.'</segundoNombre>
                            <sexo>'.$sexo.'</sexo>
                            <!-- Optional -->
                            <Direccion>
                                <calle>'.$calle.'</calle>
                                <ciudad>'.$ciudad.'</ciudad>
                                <codigoPostal>'.$cp.'</codigoPostal>
                                <colonia>'.$colonia.'</colonia>
                                <estado>'.$estado.'</estado>
                                <nacionalidad>'.$nacionalidad.'</nacionalidad>
                                <pais>00007</pais>
                                <telefonoCasa>'.$telefono.'</telefonoCasa>
                                <numeroExterior>'.$numero.'</numeroExterior>
                                <numeroInterior></numeroInterior>
                            </Direccion>
                        </Cliente>
                        <fechaInicioVigencia>'.$inicio.'</fechaInicioVigencia>
                        <idFormaPago>'.$pago.'</idFormaPago>
                        <idConductoCobro>'.$conducto.'</idConductoCobro>
                        <!-- Optional -->
                        <PaqueteEmitir>
                            <IdPaquete>'.$newPaquete.'</IdPaquete>
                            <!-- Optional -->
                            <ListaCondiciones>
                                <!-- Optional -->
                                <CondicionesTarificar>
                                    <DeducibleDM>5</DeducibleDM>
                                    <DeducibleRT>10</DeducibleRT>
                                </CondicionesTarificar>
                            </ListaCondiciones>
                            <!-- Optional -->
                            <ListaConfiguraciones>
                                <!-- Optional -->
                                <ConfiguracionPaquete>
                                    <UsuarioCotiza>0947960001</UsuarioCotiza>
                                    <InicioVigencia>'.$inicio.'</InicioVigencia>
                                    <FinVigencia>'.$fin.'</FinVigencia>
                                    <EsCotizacionDiasPorMes>false</EsCotizacionDiasPorMes>
                                    <Descuento>0</Descuento>
                                    <AgenteCotiza>0947960001</AgenteCotiza>
                                </ConfiguracionPaquete>
                            </ListaConfiguraciones>
                        </PaqueteEmitir>
                        <IDTipoSumaAsegurada>'.$tiposuma.'</IDTipoSumaAsegurada>
                        <SumaAsegurada>0</SumaAsegurada>
                        <InformacionAdicionalCorredor>
                            <FechaEmisionFactura>'.$inicio.'</FechaEmisionFactura>
                        </InformacionAdicionalCorredor>
                        <!-- Optional -->
                    </DatosCotizacion>
                </listaDatosCotizacion>
                <IdPromocion>0947960001</IdPromocion>
            </request>
        </EmiteCotizacionGuardada>
    </Body>
</Envelope>';

/*header('Content-type: text/xml');

file_put_contents('emitir-request.xml', $xml);

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
          echo "Algo fallo1";
     } else
     {
      file_put_contents('emitir-response.xml',$response);
      header('Content-type: text/xml');

     }*/

$result =  $this->callHdi($xml,$action);


if(!empty($result)){

    $data = $result['SOAP:ENVELOPE']['SOAP:BODY']['EMITECOTIZACIONGUARDADARESPONSE']
                   ['EMITECOTIZACIONGUARDADARESULT']['INFOEMISION'];
}

if(empty($data['ERRORES']))
{

 $pdf = $this->polizaPdf($data['IDCOTIZACION'],$data['IDPOLIZA']);

     foreach($pdf AS $poliza)
     {
        $documentoPdf = $poliza['BYTEARRAY'];
     }


 header('Content-type: application/pdf');
 header('Content-Disposition: attachment; filename="poliza.pdf"');
 echo $documentoPdf;

	//echo $data['IDCOTIZACION'].'-'.$data['IDPOLIZA'];

}else{

    echo 'error'.$data['ERRORES']['MENSAJE']['DESCRIPCION'];
}

}

public function polizaPdf($cotizacion,$poliza)
{
	$resutl     = [];
	$action     = 'http://hdi.com.mx/asmx/getpolicipdf';   
	$xml    = '
	<Envelope xmlns="http://schemas.xmlsoap.org/soap/envelope/">
    <Header>
        <AuthenticateHeader xmlns="http://hdi.com.mx/asmx/">
            <siteID>0947960001</siteID>
            <sitePwd>PrGAHIMP*01</sitePwd>
        </AuthenticateHeader>
    </Header>
    <Body>
        <getpolicipdf xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <Cotizacion>'.$cotizacion.'</Cotizacion>
                <NumeroPoliza>'.$poliza.'</NumeroPoliza>
                <usuario>0947960001</usuario>
                <Agencia>00044</Agencia>
                <NumeroDocumento>0</NumeroDocumento>
            </request>
        </getpolicipdf>
    </Body>
</Envelope>';
/*
header('Content-type: text/xml');

file_put_contents('getPDF-request.xml', $xml);

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
          echo "Algo fallo1";
     } else
     {
      file_put_contents('getPDF-response.xml',$response);
      header('Content-type: text/xml');

     }*/

$result = $this->callHdi($xml,$action);

if(!empty($result))
{
	$pdf = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETPOLICIPDFRESPONSE']['GETPOLICIPDFRESULT'];
                  ['BYTEARRAYCONTRACT']; 
}

return $pdf;

}

}

?>



