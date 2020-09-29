<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class zurich extends CI_Controller
{

	//credenciales
	var $agente     = xxxxx;
	var $oficina    = xx;
	var $noRelacion = xxxxxxxxx;
	var $usuario    = 'XXXXXXXXXXXX';
	//ligas
	var $catalogos = 'http://pruebas.autolinea.ezurich.com.mx/ZurichWS_QA/autos/consultaCatalogosAutos/publicService?wsdl';
	var $ubicacion = 'http://pruebas.autolinea.ezurich.com.mx/ZurichWS_QA/catalogos/obtenerCatEstMunAsentCp/publicService?wsdl';
	var $detalles  = 'http://pruebas.autolinea.ezurich.com.mx/ZurichWS_QA/autos/consultaClavesVehiculos/publicService?wsdl'; 
	var $cotizar   = 'http://pruebas.autolinea.ezurich.com.mx/ZurichWS_QA/autos/solCotV2/publicService?wsdl';
	var $recuperar = 'http://pruebas.autolinea.ezurich.com.mx/ZurichWS_QA/autos/recuperaCotV2/publicService?wsdl';


	function __construct()
	{
		parent::__construct();

		if(!isset($_SESSION['user_id'])){

			$this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
		}

	$this->load->helper('url');
    $this->load->model('data_model');
	$this->load->library('permission');
    $this->load->library('nusoap');
	}

	public function index (){

		$this->load->view('header');
		$this->load->view('zurich/index');
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

public function zurichCall($xml,$action = null,$direccion)
{
    $arrayresult = array();
	$headers = [ "Content-type: text/xml;charset=utf-8", 
                 "Content-length: ".strlen($xml), 
                 "SOAPAction: ".$action];

    $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
          curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_TIMEOUT, 20);
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


public function getBrand()
{
	$result = [];
	$action = '';
	$marcas = '';
	$select = '';

	$url = $this->catalogo;
	$tipoVehiculo = $this->input->post('car');

	$xml    = '
 <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
   <soapenv:Header>
    <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<UsernameToken xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<Username>'.$this->usuario.'</Username>
	<Password>'.$this->usuario.'</Password>
	</UsernameToken>
	</wsse:Security>
  </soapenv:Header> 
   <soapenv:Body>
      <web:SolicitudCatalogoMarcas>
         <web:numRequest>11</web:numRequest>
         <web:catalogo>MARCA</web:catalogo>
         <web:usuario>'.$this->usuario.'</web:usuario>
         <web:agente>'.$this->agente.'</web:agente>
         <web:numRelacion>'.$this->noRelacion.'</web:numRelacion>
         <web:tipoVehiculo>'.$tipoVehiculo.'</web:tipoVehiculo>
      </web:SolicitudCatalogoMarcas>
   </soapenv:Body>
</soapenv:Envelope>';

$result = $this->zurichCall($xml,$action,$url);
$marcas = $result['soap:Envelope']['soap:Body']['tns:ResuestaCatalogoMarcas'];

  foreach ($marcas as $index => $marca) {
   	        
   	        if($index == ':marca' )
   	        {
   	          $clave = $marca['tns:claveMarca']; 
              $select .= '<option value='.$clave.'>'.$marca['tns:descripcion'].'</option>';
   	        }
        }

      echo $select;
}


public function getSubBrand()
{
	$result    = [];
	$action    = '';
	$subMarcas = '';
	$select    = '';

	$url          = $this->catalogos;
	$tipoVehiculo = $this->input->post('car');
	$marca        = $this->input->post('marca');

	$xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
   <soapenv:Header>
    <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<UsernameToken xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<Username>'.$this->usuario.'</Username>
	<Password>'.$this->usuario.'</Password>
	</UsernameToken>
	</wsse:Security>
  </soapenv:Header> 
   <soapenv:Body>
      <web:reqCatSubMarcasAuto>
         <web:numRequest>12</web:numRequest>
         <web:catalogo>SUBMA</web:catalogo>
         <web:usuario>'.$this->usuario.'</web:usuario>
         <web:agente>'.$this->agente.'</web:agente>
         <web:claveMarca>'.$marca.'</web:claveMarca>
         <web:numRelacion>'.$this->noRelacion.'</web:numRelacion>
         <web:tipoVehiculo>'.$tipoVehiculo.'</web:tipoVehiculo>
      </web:reqCatSubMarcasAuto>
   </soapenv:Body>
</soapenv:Envelope>';

$result     = $this->zurichCall($xml,$action,$url);
$subMarcas  = $result['soap:Envelope']['soap:Body']['tns:resCatSubMarcasAuto'];

  foreach ($subMarcas as $index => $subMarca) {
  	
  	if($index == ':subMarcaAuto')
  	{
  		$clave   = $subMarca['tns:claveSubMarcaAuto'];
  		$select  .= '<option value='.$clave.'>'.$subMarca['tns:descripcion'].'</option>';
  	}
  }

  echo $select;
}

public function getModel()
{
	$resutl  = [];
	$action  = '';
	$modelos = '';
	$select  = '';

	$url           = $this->catalogos;
	$tipoVehiculo  = $this->input->post('car');
	$marca         = $this->input->post('marca');
	$submarca      = $this->input->post('submarca');

	$xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
   <soapenv:Header>
    <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<UsernameToken xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<Username>'.$this->usuario.'</Username>
	<Password>'.$this->usuario.'</Password>
	</UsernameToken>
	</wsse:Security>
  </soapenv:Header> 
   <soapenv:Body>
      <web:SolicitudCatalogoModelos>
         <web:numRequest>13</web:numRequest>
         <web:catalogo>MODEL</web:catalogo>
         <web:cveMarca>'.$marca.'</web:cveMarca>
         <web:cveSubMarca>'.$submarca.'</web:cveSubMarca>
         <web:numRelacion>'.$this->noRelacion.'</web:numRelacion>
         <web:usuario>'.$this->usuario.'</web:usuario>
         <web:agente>'.$this->agente.'</web:agente>
         <web:tipoVehiculo>'.$tipoVehiculo.'</web:tipoVehiculo>
      </web:SolicitudCatalogoModelos>
   </soapenv:Body>
</soapenv:Envelope>';

$result  = $this->zurichCall($xml,$action,$url);
$modelos = $result['soap:Envelope']['soap:Body']['tns:RespuestaCatalogoModelos'];

  foreach ($modelos as $index => $modelo) {
  	        
  	        if($index == ':modelo')
  	        {
  		      $select  .= '<option value='.$modelo['tns:modelo'].'>'.$modelo['tns:modelo'].'</option>';
  	        }
        }

        echo $select;
}

public function getLoad ()
{
	$result = [];
	$action = '';
	$cargas = '';
	$select = '';

	$url          = $this->catalogos;
	$tipoVehiculo = $this->input->post('car');
	$uso          = $this->input->post('uso');

	$xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
   <soapenv:Header>
    <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<UsernameToken xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<Username>'.$this->usuario.'</Username>
	<Password>'.$this->usuario.'</Password>
	</UsernameToken>
	</wsse:Security>
  </soapenv:Header> 
   <soapenv:Body>
      <web:CatTipoCargaNumeroRelacionReq>
         <web:numRequest>2</web:numRequest>
         <web:nombreCatalogo>TPCAR</web:nombreCatalogo>
         <web:numRelacion>'.$this->noRelacion.'</web:numRelacion>
         <web:tipoVehiculo>'.$tipoVehiculo.'</web:tipoVehiculo>
         <web:tipoUso>'.$uso.'</web:tipoUso>
         <web:usuario>'.$this->usuario.'</web:usuario>
         <web:agente>'.$this->agente.'</web:agente>
      </web:CatTipoCargaNumeroRelacionReq>
   </soapenv:Body>
</soapenv:Envelope>';

$result = $this->zurichCall($xml,$action,$url);
$cargas = $result['soap:Envelope']['soap:Body']['tns:CatTipoCargaNumeroRelacionResp'];

   foreach($cargas as $index => $carga){

   	   if($index == ':elementosCatTipoCargaNumsRel'){
         $clave = $carga['tns:idTipoCarga'];
         $select .= '<option value='.$clave.'>'.$carga['tns:descElemento'].'</option>'; 
   	   }
   }

   echo $select;

}

public function getUse()
{

	$result = [];
	$action = '';
	$usos = '';
	$select = '';

	$url          = $this->catalogos;
	$tipoVehiculo = $this->input->post('car');

	$xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
   <soapenv:Header>
    <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<UsernameToken xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<Username>'.$this->usuario.'</Username>
	<Password>'.$this->usuario.'</Password>
	</UsernameToken>
	</wsse:Security>
  </soapenv:Header> 
   <soapenv:Body>
      <web:CatTipoUsoReq>
         <web:numRequest>16</web:numRequest>
         <web:catalogo>USO</web:catalogo>
         <web:tipoVehiculo>'.$tipoVehiculo.'</web:tipoVehiculo>
         <web:numRelacion>'.$this->noRelacion.'</web:numRelacion>
         <web:usuario>'.$this->usuario.'</web:usuario>
         <web:agente>'.$this->agente.'</web:agente>
      </web:CatTipoUsoReq>
   </soapenv:Body>
</soapenv:Envelope>';

$result = $this->zurichCall($xml,$action,$url);
$usos = $result['soap:Envelope']['soap:Body']['tns:CatTipoUsoRes'];

   foreach($usos as $index => $uso){

   	   if($index == ':tipoUso'){
         $clave = $uso['tns:cveTipoUso'];
         $select .= '<option value='.$clave.'>'.$uso['tns:descripcion'].'</option>'; 
   	   }
   }

   echo $select;

}

public function getPayment()
{
	$result    = [];
	$action    = '';
	$tipoPagos = '';
	$select    = '';

	$url          = $this->catalogos;

	$xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
   <soapenv:Header>
    <wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<UsernameToken xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
	<Username>'.$this->usuario.'</Username>
	<Password>'.$this->usuario.'</Password>
	</UsernameToken>
	</wsse:Security>
  </soapenv:Header> 
   <soapenv:Body>
      <web:CatMedioPagoNumeroRelacionReq>
         <web:claveCatalogo>5</web:claveCatalogo>
         <web:numRelacion>'.$noRelacion.'</web:numRelacion>
         <web:agente>'.$this->agente.'</web:agente>
         <web:usuario>'.$this->usuario.'</web:usuario>
         <web:formaPago>C</web:formaPago>
      </web:CatMedioPagoNumeroRelacionReq>
   </soapenv:Body>
</soapenv:Envelope>';

$result = $this->zurichCall($xml,$action,$url);
$tipoPagos = $result['soap:Envelope']['soap:Body']['tns:CatMedioPagoNumeroRelacionResp'];

   foreach($tipoPagos as $index => $pago){

   	   if($index == ':elementosCMedioPagoNumeroRelacion'){
         $clave = $carga['tns:claveElemento'];
         $select .= '<option value='.$clave.'>'.$carga['tns:descElemento'].'</option>'; 
   	   }
   }

   echo $select;

}

public function getClaveZurich()
{
	$result = [];
	$action = '';
	$claves = '';
	$select = '';

	$url          = $this->detalles;
	$tipoVehiculo = $this->input->post('car');
	$marca        = $this->input->post('marca');
	$submarca     = $this->input->post('submarca');
	$modelo       = $this->input->post('modelo');

	$xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
<soapenv:Header>
		<wsse:Security
			xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
			<UsernameToken
				xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				<Username>'.$this->usuario.'</Username>
				<Password>'.$this->usuario.'</Password>
			</UsernameToken>
		</wsse:Security>
	</soapenv:Header> 
   <soapenv:Body>
      <web:reqClaveZurichAuto>
         <web:numRequest>14</web:numRequest>
         <web:catalogo>CAUTO</web:catalogo>
         <web:tipoVehiculo>'.$tipoVehiculo.'</web:tipoVehiculo>
         <web:marca>'.$marca.'</web:marca>
         <web:submarca>'.$submarca.'</web:submarca>
         <web:modelo>'.$modelo.'</web:modelo>
         <web:numRelacion>'.$this->noRelacion.'</web:numRelacion>
         <web:usuario>'.$this->usuario.'</web:usuario>
         <web:agente>'.$this->agente.'</web:agente>
      </web:reqClaveZurichAuto>
   </soapenv:Body>
</soapenv:Envelope>';

$result = $this->zurichCall($xml,$action,$url);
$claves = $result['soap:Envelope']['soap:Body']['tns:resClaveZurichAuto'];

   foreach($claves as $index => $clave){

   	   if($index == ':elementosCMedioPagoNumeroRelacion'){
         $id = $clave['tns:clave'];
         $select .= '<option value='.$id.'>'.$clave['tns:descripcion'].'</option>'; 
   	   }
   }

   echo $select;

}


public function getState()
{
	$result   = [];
	$action   = '';
	$estados  = '';
	$select   = '';

	$url = $this->ubicacion;

	$xml = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
    <soapenv:Header>
		<wsse:Security
			xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
			<UsernameToken
				xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				<Username>'.$this->usuario.'</Username>
				<Password>'.$this->usuario.'</Password>
			</UsernameToken>
		</wsse:Security>
	</soapenv:Header>
   <soapenv:Body>
      <web:CatalogosEstadosReq>
         <web:id_proceso>01</web:id_proceso>
      </web:CatalogosEstadosReq>
   </soapenv:Body>
</soapenv:Envelope>';

$result  = $this->zurichCall($xml,$action,$url);
$estados = $result['soap:Envelope']['soap:Body']['tns:CatalogosEstadosRes'];

    foreach ($estados as $estado) {
     	
     	if(empty($estado['tns:mensajeError']))
     	 { 
           $clave  = $estado['tns:claveEstado'];
           $select .= '<option value='.$clave.'>'.$estado['tns:descripcionEstado'].'</option>'; 

     	 }else{
     	 	echo 'problema: '.$estado['tns:mensajeError'];
     	 }
     } 

     echo $select;
}

public function getCity()
{
	$result      = [];
	$action      = '';
	$municipios  = '';
	$select      = '';

	$url    = $this->ubicacion;
	$estado = $this->input->post('estado');

	$xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
    <soapenv:Header>
		<wsse:Security
			xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
			<UsernameToken
				xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				<Username>'.$this->usuario.'</Username>
				<Password>'.$this->usuario.'</Password>
			</UsernameToken>
		</wsse:Security>
	</soapenv:Header>
   <soapenv:Body>
      <web:CatalogosMunicipiosReq>
         <web:id_proceso>02</web:id_proceso>
         <web:clave_estado>'.$estado.'</web:clave_estado>
      </web:CatalogosMunicipiosReq>
   </soapenv:Body>
</soapenv:Envelope>';

$result     = $this->zurichCall($xml,$action,$url);
$municipios = $result['soap:Envelope']['soap:Body']['tns:CatalogosMunicipiosRes'];

    foreach ($municipios as  $municipio) {
    	
    	     if(empty($municipio['tns:mensajeError'])){

    	        foreach ($municipio['tns:elementosMunicipios'] as $value) {
    	        	
    	        	$clave  = $value['tns:claveMunicipio'];
    	        	$select = '<option value='.$clave.'>'.$value['tns:descripcionMunicipio'].'</option>';
    	        }

    	     }else
    	     {
    	     	echo 'problema: '.$municipio['tns:mensajeError'];
    	     }
    }

    echo $select;
}

public function getAsentamiento()
{
	$result   = [];
	$action   = '';
	$ccodigos = '';
	$select   = '';

	$url          = $this->ubicacion;
	$codigopostal = $this->input->post('codigopostal');

	$xml = '
<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
    <soapenv:Header>
		<wsse:Security
			xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
			<UsernameToken
				xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
				<Username>PROTE83129ws</Username>
				<Password>PROTE83129ws</Password>
			</UsernameToken>
		</wsse:Security>
	</soapenv:Header>
   <soapenv:Body>
      <web:CatAsentamientosPorCpReq>
	    <web:id_proceso>04</web:id_proceso>
         <web:codigo_postal>21138</web:codigo_postal>
         <web:numero_relacion>0</web:numero_relacion>
         <web:usuario></web:usuario>
         <web:clave_agente>0</web:clave_agente>
         <web:clave_ramo>0</web:clave_ramo>
      </web:CatAsentamientosPorCpReq>
   </soapenv:Body>
</soapenv:Envelope>';

$result   = $this->zurichCall($xml,$action,$url);
$codigos  = $result['soap:Envelope']['soap:Body']['tns:CatAsentamientosPorCpRes'];

       if(count($codigos) == 8 )
       {
       	foreach ($codigos as $codigo) {
       		
       		if($codigo['tns:elementosAsentamientosPorCp'])
       		{
       			$clave   = $codigo['tns:claveAsentamiento'];
       			$select .= '<option value='.$clave.'>'.$codigo['tns:descripcionAsentamiento'].'</option>';
       		}
       	}

       }else{

       	  foreach ($codigos as $index => $codigo) {
       	  	 
       	  	 if($index == ':mensajeError')
       	  	 {
       	  	 	echo 'Problema:  '.$codigo['tns:mensajeError'];
       	  	 }
       	  	 
       	  }
       }

       echo $select;
}

public function cotizacion ()
{
	$result = [];
	$action = '';
	$folios = '';
    
    $url          = $this->cotizacion;
    $tipoVehiculo = $this->input->post('car');
    $clave        = $this->input->post('zurich');
    $modelo       = $this->input->post('modelo');
    $estado       = $this->input->post('estado');
    $municipio    = $this->input->post('municipio');
    $tipoValor    = $this->input->post('tipoValor');
    $tipouso      = $this->input->post('tipouso');
    $carga        = $this->input->post('carga');
    $tipopersona  = $this->input->post('persona');
    $edad         = $this->input->post('edad');
    $genero       = $this->input->post('genero');
    $estadoCivil  = $this->input->post('estadocivil');
    $inicio       = date('Y m d');
    $fin          = date('Y m d',strtotime('+1 years'));
    $codigopostal = $this->input->post('codigopostal');

    $xml = '
 <soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:web="http://webservices.zurich.com/">
   <soapenv:Header>
   	<wsse:Security xmlns:wsse="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
         <UsernameToken xmlns="http://docs.oasis-open.org/wss/2004/01/oasis-200401-wss-wssecurity-secext-1.0.xsd">
            <Username>'.$this->usuario.'</Username>
            <Password>'.$this->usuario.'</Password> 
         </UsernameToken>
     </wsse:Security>
 </soapenv:Header>
   <soapenv:Body>
      <web:SOLICITUD_COT_AUTOS_REQ>
         <web:num_req>8</web:num_req>
         <web:usuario>'.$this->usuario.'</web:usuario>
         <web:idOficina>'.$this->oficina.'</web:idOficina>
         <web:programaComercial>'.$this->noRelacion.'</web:programaComercial>
         <web:tipoVehiculo>'.$tipoVehiculo.'</web:tipoVehiculo>
         <web:cve_zurich>'.$clave.'</web:cve_zurich>
         <web:modelo>'.$modelo.'</web:modelo>
         <web:id_estado>'.$estado.'</web:id_estado>
         <web:id_ciudad>'.$municipio.'</web:id_ciudad>
         <web:id_tipoValor>'.$tipoValor.'</web:id_tipoValor>
         <web:id_tipoUso>'.$tipouso.'</web:id_tipoUso>
         <web:cve_agente>'.$this->agente.'</web:cve_agente>
         <web:tipo_producto>0</web:tipo_producto>
         <web:tipo_carga>'.$carga.'</web:tipo_carga>
         <web:tipo_persona>'.$tipopersona.'</web:tipo_persona>
         <web:edad>'.$edad.'</web:edad>
         <web:genero>'.$genero.'</web:genero>
         <web:estadoCivil>'.$estadoCivil.'</web:estadoCivil>
         <web:ocupacion>1</web:ocupacion>
         <web:giro>1</web:giro>
         <web:nacionalidad>0</web:nacionalidad>
         <web:id_moneda>0</web:id_moneda>
         <web:fecha_inicio>'.$inicio.'</web:fecha_inicio>
         <web:fecha_fin>'.$fin.'</web:fecha_fin>
         <web:monto_asegurado>394900</web:monto_asegurado>
         <web:codigoPostal>'.$codigopostal.'</web:codigoPostal>
         <web:situacionVehiculo></web:situacionVehiculo>
         <web:mesesVigencia>12</web:mesesVigencia>
         <web:tipoMovimiento>1</web:tipoMovimiento>
         <web:polizaAnterior>0</web:polizaAnterior>
      </web:SOLICITUD_COT_AUTOS_REQ>
   </soapenv:Body>
</soapenv:Envelope>';

$result = $this->zurichCall($xml,$action,$url);
$folios = $result['soap:Envelope']['soap:Body']['tns:SOLICITUD_COT_AUTOS_RES'];

  foreach ($folios as $index => $folio) {
  	
  	      if($folio['tns:status'] == 999)
  	      {
  	      	echo 'problema: '.$folio['tns:mensaje']; 
  	      	return;
  	      }else
  	      {
  	      	echo $folio['tns:folio_cotizacion'];
  	      	return;
  	      }
  }

}







}
