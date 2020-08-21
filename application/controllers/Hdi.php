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

 		$clave = $value['CLAVE'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
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

 	foreach ($brand as $value) {

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
                <TipoVehiculoID></TipoVehiculoID>
                <Usuario>0947960001</Usuario>
            </request>
        </obtenerUsos>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

var_dump($result);

/*
$tipoSuma = $result['SOAP:ENVELOPE']['SOAP:BODY']['OBTENERTIPOSSUMAASEGURADARESPONSE']['OBTENERTIPOSSUMAASEGURADARESULT']
                   ['TIPOSSUMAASEGURADA']['TIPOSUMAASEGURADA'];
 	foreach ($tipoSuma as $value) {

 		$clave = $value['IDTIPOSUMAASEGURADA'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}

echo $select;*/
 }


 public function setPaquete()
{
  $result   = [];
  $action   = 'http://hdi.com.mx/asmx/getpackages';
  $estado   = $this->input->post('estado');
  $ciudad   = $this->input->post('ciudad');
  $marca    = $this->input->post('marca');
  $submarca = $this->input->post('submarca');
  $modelo   = $this->input->post('modelo');
  $version  = $this->input->post('version');
  $transmision = $this->input->post('transmision');
  $tipo     = $this->input->post('tipo');
  $serie    = $this->input->post('serie');
  $servicio = $this->input->post('servicio');
  $tiposuma = $this->input->post('tiposuma');
  $cp       = $this->input->post('cp');
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
        <getpackages xmlns="http://hdi.com.mx/asmx/">
            <!-- Optional -->
            <request>
                <idFormaPago>326</idFormaPago>
                <ciudad>'.$ciudad.'</ciudad>
                <estado>'.$ciudad.'</estado>
                <usuario>0947960001</usuario>
                <!-- Optional -->
                <datosVehiculo>
                    <idMarca>'.$marca.'</idMarca>
                    <idModelo>'.$modelo.'</idModelo>
                    <idTipo>'.$submarca.'</idTipo>
                    <idVersion>'.$version.'</idVersion>
                    <idTransmision>'.$transmision.'</idTransmision>
                    <idUso>4581</idUso>
                    <tipoVehiculo>'.$tipo.'</tipoVehiculo>
                    <numeroSerie>'.$serie.'</numeroSerie>
                    <pasajeros>4</pasajeros>
                    <idZonaCirculacion>0</idZonaCirculacion>
                    <idTonelaje>0</idTonelaje>
                    <idServicio>'.$servicio.'</idServicio>
                    <idRiesgoCarga>0</idRiesgoCarga>
                    <!-- Optional -->
                     <DatosAdicionales>
                        <Renovaciones></Renovaciones>
                        <idRemolque></idRemolque>
                        <CPCirculacion>'.$cp.'</CPCirculacion>
                    </DatosAdicionales>
                </datosVehiculo>
                <obtenerTodosPaquetes>true</obtenerTodosPaquetes>
                <IDTipoSumaAsegurada>'.$tiposuma.'</IDTipoSumaAsegurada>
                <SumaAsegurada>0</SumaAsegurada>
                <IvaPorcentaje>0</IvaPorcentaje>
            </request>
        </getpackages>
    </Body>
</Envelope>';
$result = $this->callHdi($xml,$action);

$cotizaciones = $result['SOAP:ENVELOPE']['SOAP:BODY']['GETPACKAGESRESPONSE']['GETPACKAGESRESULT']
                     ['INFORMACIONPAQUETES']['LISTAPAQUETES'];

var_dump($cotizaciones);




/*
$tipoSuma = $result['SOAP:ENVELOPE']['SOAP:BODY']['OBTENERTIPOSSUMAASEGURADARESPONSE']['OBTENERTIPOSSUMAASEGURADARESULT']
                   ['TIPOSSUMAASEGURADA']['TIPOSUMAASEGURADA'];
 	foreach ($tipoSuma as $value) {

 		$clave = $value['IDTIPOSUMAASEGURADA'];
 		$select .= '<option value='.$clave.'>'.$value['DESCRIPCION'].'</option>';
}

echo $select;*/

 }










}

?>