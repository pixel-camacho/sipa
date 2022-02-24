<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//Load libruary for API
class EmitirANA extends CI_Controller {
  
    function __construct() {
		
        parent::__construct();
        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
        }
		
        $this->load->helper('url');
        $this->load->library('nusoap');
        $this->load->model('data_model');
        $this->load->model('periodo_model');
        $this->load->model('estado_model', 'estado');
        $this->load->model('colonia_model', 'colonia');
        $this->load->model('user_model', 'usuarioo');
        $this->load->model('ventaana_model', 'venta');
        $this->load->library('permission');
    }

    public function index() {
        //Permission::grant(uri_string());
        $colonias = $this->colonia->showAll();
        $ocupaciones = $this->ocupaciones();
        //var_dump($ocupaciones);
        $colores = $this->colores();

        $data = array(
            'datacolonias' => $colonias,
            'dataocupaciones' => $ocupaciones,
            'datacolores' => $colores
        );
        $this->load->view('header');
        $this->load->view('ana/index', $data);
        $this->load->view('footer');
    }

    public function searchVehicleYear() {
        $modelo = $this->input->post('textsearch');
        $select = "";
        $xml = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/">
                <soap:Header/>
                <soap:Body>
                   <tem:Marca>
                      <tem:Negocio>' . $this->negocio . '</tem:Negocio>
                      <tem:Modelo>' . $modelo . '</tem:Modelo>
                      <tem:Categoria>100</tem:Categoria>
                      <!--Optional:-->
                      <tem:Usuario>' . $this->usuario . '</tem:Usuario>
                      <!--Optional:-->
                      <tem:Clave>' . $this->clave . '</tem:Clave>
                   </tem:Marca>
                </soap:Body>
             </soap:Envelope>';

        $data = $this->catalogosWS($this->url, $xml);
        if (isset($data) && !empty($data["TRANSACCIONES"]["MARCA"])) {
            foreach ($data ["TRANSACCIONES"]["MARCA"] as $value) {
                $nuevoid = $value["ID"] . "-" . "2804";
               $select .= "<option value='" . $nuevoid . "'>" . $value["content"] . "</option>";
            }
        }
        echo $select;
    }

    public function searchModelBrand() {
		
        $modelo = $this->input->post('year');
        $marca = $this->input->post('marca');
        $porciones = explode("-", $marca);
        $marcaana = $porciones[0];
        $marcalatino = $porciones[1];
        $select = "";
        $xml = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/">
                <soap:Header/>
                <soap:Body>
                   <tem:SubMarca>
                      <tem:Negocio>' . $this->negocio . '</tem:Negocio>
                      <!--Optional:-->
                      <tem:Marca>' . $marcaana . '</tem:Marca>
                      <tem:Modelo>' . $modelo . '</tem:Modelo>
                      <tem:Categoria>100</tem:Categoria>
                      <!--Optional:-->
                      <tem:Usuario>' . $this->usuario . '</tem:Usuario>
                      <!--Optional:-->
                      <tem:Clave>' . $this->clave . '</tem:Clave>
                   </tem:SubMarca>
                </soap:Body>
             </soap:Envelope>';

        $data = $this->catalogosWS($this->url, $xml);
        //print_r($data);

        if (isset($data["TRANSACCIONES"]["SUBMARCA"]["content"]) && !empty($data["TRANSACCIONES"]["SUBMARCA"]["content"])) {
            $idsubmarca = $marca . "-" . $data["TRANSACCIONES"]["SUBMARCA"]["CLAVE"];
            $select .= "<option value='" . $idsubmarca . "'>" . $data["TRANSACCIONES"]["SUBMARCA"]["content"] . "</option>";
        } else {
            foreach ($data ["TRANSACCIONES"]["SUBMARCA"] as $value) {
                $idsubmarca = $marca . "-" . $value["CLAVE"];
                $select .= "<option value='" . $idsubmarca . "'>" . $value["content"] . "</option>";
            }
        }


//        if (isset($data) && !empty($data["TRANSACCIONES"]["SUBMARCA"])) {
//            foreach ($data ["TRANSACCIONES"]["SUBMARCA"] as $value) {
//                $idsubmarca = $marca . "-" . $value["CLAVE"];
//                $select .= "<option value='" . $idsubmarca . "'>" . $value["content"] . "</option>";
//            }
//        }
        echo $select;
    }

    public function searchDescriptionBrand() {
        $year = $this->input->post('year');
        $modelo = $this->input->post('modelo');
        $porciones = explode("-", $modelo);
        $marcaana = $porciones[0];
        $marcalatino = $porciones[1];
        $submarcaana = $porciones[2];
        $select = "";
        $xml = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/">
   <soap:Header/>
   <soap:Body>
      <tem:Vehiculo>
         <tem:Negocio>' . $this->negocio . '</tem:Negocio>
         <!--Optional:-->
         <tem:Marca>' . $marcaana . '</tem:Marca>
         <tem:Submarca>' . $submarcaana . '</tem:Submarca>
         <tem:Modelo>' . $year . '</tem:Modelo>
         <!--Optional:-->
         <tem:Usuario>' . $this->usuario . '</tem:Usuario>
         <!--Optional:-->
         <tem:Clave>' . $this->clave . '</tem:Clave>
      </tem:Vehiculo>
   </soap:Body>
</soap:Envelope>';
        $data = $this->catalogosWS($this->url, $xml);
        //print_r($data);
        if (isset($data["TRANSACCIONES"]["VEHICULO"]["content"]) && !empty($data["TRANSACCIONES"]["VEHICULO"]["content"])) {
            $iddescripcion = $modelo . "-" . $data["TRANSACCIONES"]["VEHICULO"]["CLAVE"];
            $select .= "<option value='" . $iddescripcion . "'>" . $data["TRANSACCIONES"]["VEHICULO"]["content"] . "</option>";
        } else {
            foreach ($data ["TRANSACCIONES"]["VEHICULO"] as $value) {
                $iddescripcion = $modelo . "-" . $value["CLAVE"];
                $select .= "<option value='" . $iddescripcion . "'>" . $value["content"] . "</option>";
            }
        }
        echo $select;
    }

    public function catalogosWS($url, $xml) {
        
        $arrayresult = array();
        $headers = ["Content-type: text/xml", "Content-length: " . strlen($xml), "Connection: close",];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
            echo "Algo fallo";
        } else {
            $xml_handle = new DOMDocument();

            $xml_handle->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $arrayresult = $this->XMLtoArray($xml_handle->textContent);
        }

        return $arrayresult;
    }

    public function ocupaciones() {
        $xmlocupacion = '<?xml version="1.0" encoding="UTF-8"?>
                <SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://tempuri.org/">
                  <SOAP-ENV:Body>
                    <ns1:Ocupacion>
                      <ns1:Negocio>' . $this->negocio . '</ns1:Negocio>
                      <ns1:Usuario>' . $this->usuario . '</ns1:Usuario>
                      <ns1:Clave>' . $this->clave . '</ns1:Clave>
                    </ns1:Ocupacion>
                  </SOAP-ENV:Body>
                </SOAP-ENV:Envelope>';
        $url = $this->url;
        $datosocupacionaarray = $this->catalogosWS($url, $xmlocupacion);
        $arrayresultocupacion = $datosocupacionaarray["TRANSACCIONES"]["OCUPACION"];
        //return json_decode($arrayresultocupacion);
        return $arrayresultocupacion;
    }

    public function colores() {
        $xmlcolores = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://tempuri.org/">
  <SOAP-ENV:Body>
    <ns1:Color>
      <ns1:Negocio>' . $this->negocio . '</ns1:Negocio>
      <ns1:Usuario>' . $this->usuario . '</ns1:Usuario>
      <ns1:Clave>' . $this->clave . '</ns1:Clave>
    </ns1:Color>
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
        $url = $this->url;
        $datosocoloresaarray = $this->catalogosWS($url, $xmlcolores);
        $arrayresultocolores = $datosocoloresaarray["TRANSACCIONES"]["COLOR"];
        return $arrayresultocolores;
    }

    public function coloniaxcp() {
        $xmlcolonias = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://tempuri.org/">
  <SOAP-ENV:Body>
    <ns1:ColxCP >
      <ns1:Negocio>' . $this->negocio . '</ns1:Negocio>
      <ns1:CP>' . $this->input->post('b') . '</ns1:CP>
      <ns1:Usuario>' . $this->usuario . '</ns1:Usuario>
      <ns1:Clave>' . $this->clave . '</ns1:Clave>
    </ns1:ColxCP >
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
        //$this->input->post('b')
        $url = $this->url;
        $datoscoloniasarray = $this->catalogosWS($url, $xmlcolonias);
        $arrayresultocolonias = $datoscoloniasarray["TRANSACCIONES"]["COLONIAS"];
        $select = "";
        if (isset($datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["content"]) && !empty($datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["content"])) {
            $select .= "<option value='" . $datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["content"] . "'>" . $datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["content"] . "</option>";
        } else {
            foreach ($arrayresultocolonias as $value) {
                $select .= "<option value='" . $value["content"] . "'>" . $value["content"] . "</option>";
            }
        }
        echo $select;
    }

    public function municipioxcp() {
        $xmlcolonias = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://tempuri.org/">
  <SOAP-ENV:Body>
    <ns1:ColxCP >
      <ns1:Negocio>' . $this->negocio . '</ns1:Negocio>
      <ns1:CP>' . $this->input->post('b') . '</ns1:CP>
      <ns1:Usuario>' . $this->usuario . '</ns1:Usuario>
      <ns1:Clave>' . $this->clave . '</ns1:Clave>
    </ns1:ColxCP >
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
        //$this->input->post('b')
        $url = $this->url;
        $datoscoloniasarray = $this->catalogosWS($url, $xmlcolonias);
        //var_dump($datoscoloniasarray);
        $arrayresultocolonias = $datoscoloniasarray["TRANSACCIONES"]["COLONIAS"];
        $select = "";
        if (isset($datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["IDDELMUN"]) && !empty($datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["IDDELMUN"])) {
            $select .= "<option value='" . $datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["IDDELMUN"] . "'>" . $datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["DELMUN"] . "</option>";
        } else {
            foreach ($arrayresultocolonias as $value) {
                $select .= "<option value='" . $value["IDDELMUN"] . "'>" . $value["DELMUN"] . "</option>";
            }
        }
        echo $select;
    }

    public function estadoxcp() {
        $xmlcolonias = '<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://tempuri.org/">
  <SOAP-ENV:Body>
    <ns1:ColxCP >
      <ns1:Negocio>' . $this->negocio . '</ns1:Negocio>
      <ns1:CP>' . $this->input->post('b') . '</ns1:CP>
      <ns1:Usuario>' . $this->usuario . '</ns1:Usuario>
      <ns1:Clave>' . $this->clave . '</ns1:Clave>
    </ns1:ColxCP >
  </SOAP-ENV:Body>
</SOAP-ENV:Envelope>';
        //$this->input->post('b')
        $url = $this->url;
        $datoscoloniasarray = $this->catalogosWS($url, $xmlcolonias);
        //var_dump($datoscoloniasarray);
        $arrayresultocolonias = $datoscoloniasarray["TRANSACCIONES"]["COLONIAS"];
        $select = "";
        if (isset($datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["IDESTADO"]) && !empty($datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["IDESTADO"])) {
            $select .= "<option value='" . $datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["IDESTADO"] . "'>" . $datoscoloniasarray["TRANSACCIONES"]["COLONIAS"]["ESTADO"] . "</option>";
        } else {
            foreach ($arrayresultocolonias as $value) {
                $select .= "<option value='" . $value["IDESTADO"] . "'>" . $value["ESTADO"] . "</option>";
            }
        }
        echo $select;
    }

    public function XMLtoArray($XML) {
        $xml_array = [];
        $xml_parser = xml_parser_create();

        xml_parse_into_struct($xml_parser, $XML, $vals);
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

    public function obtenerClaveDelEstado($cp) {
      $xml = '<soap:Envelope xmlns:soap="http://www.w3.org/2003/05/soap-envelope" xmlns:tem="http://tempuri.org/">
                <soap:Header/>
                <soap:Body>
                  <tem:ColxCP>
                    <tem:Negocio>' . $this->negocio . '</tem:Negocio>
                    <!--Optional:-->
                    <tem:CP>'.$cp.'</tem:CP>
                    <!--Optional:-->
                    <tem:Usuario>' . $this->usuario . '</tem:Usuario>
                    <!--Optional:-->
                    <tem:Clave>' . $this->clave . '</tem:Clave>
                 </tem:ColxCP>
                </soap:Body>
             </soap:Envelope>';

        $data = $this->catalogosWS($this->url, $xml);
       // print_r($data);
        $estado="";
        $municipio="";
        $claveestado="";
        $claveestadomunicipio="";
        if (isset($data["TRANSACCIONES"]["COLONIAS"]["content"]) && !empty($data["TRANSACCIONES"]["COLONIAS"]["content"])) {

            $estado = $data["TRANSACCIONES"]["COLONIAS"]["ESTADO"];
            $municipio = $data["TRANSACCIONES"]["COLONIAS"]["DELMUN"];
            $idestado=$data["TRANSACCIONES"]["COLONIAS"]["IDESTADO"];
            $idmunicipio=$data["TRANSACCIONES"]["COLONIAS"]["IDDELMUN"];
            $claveestado = str_pad($idestado, 2, "0", STR_PAD_LEFT);;
           $claveestadomunicipio = $claveestado . str_pad($idmunicipio, 3, "0", STR_PAD_LEFT);                
                            
        } else {
                            
             $estado = $data["TRANSACCIONES"]["COLONIAS"][0]["ESTADO"];
             $municipio = $data["TRANSACCIONES"]["COLONIAS"][0]["DELMUN"];
            $idestado=$data["TRANSACCIONES"]["COLONIAS"][0]["IDESTADO"];
            $idmunicipio=$data["TRANSACCIONES"]["COLONIAS"][0]["IDDELMUN"];
            $claveestado = str_pad($idestado, 2, "0", STR_PAD_LEFT);;
            $claveestadomunicipio = $claveestado . str_pad($idmunicipio, 3, "0", STR_PAD_LEFT);
        } 
         $datareturn = array(
            'clavepoblacionana' => $claveestadomunicipio,
            'nombrepoblacionana' => $municipio,
            'numeropoblacion' => $idmunicipio,
            'nombreestado' => $estado
        ); 
        return $datareturn;
    }

    public function test() {
   
        echo $this->session->idusuario;
    }

    public function emitir() {
        
        $datausuario = $this->usuarioo->detalleUsuario($this->session->user_id);
        $idusuario = $datausuario->idusuario;
        $var= $this->input->post('descripcion');
         
        $porciones = explode("-", $var);
        $marcaana = $porciones[0];
        $marcalatino = $porciones[1];
        $submarcaana = $porciones[2];
        $iddescripcion = $porciones[3];
        $year = $this->input->post('year');
        $serie = strtoupper($this->input->post('serie'));
        $placas = strtoupper($this->input->post('placas'));
        $nombre = strtoupper($this->input->post('nombre'));
        $apellidop = strtoupper($this->input->post('apellidop'));
        $apellidom = strtoupper($this->input->post('apellidom'));
        $fechanacimiento = $this->input->post('fechanacimiento');
        $nacimientocontratante =date("d/m/Y", strtotime($fechanacimiento));
        $rfc = strtoupper($this->input->post('rfc'));
        $genero = $this->input->post('genero');
        $ocupacion = strtoupper($this->input->post('ocupacion'));
        $correo = $this->input->post('correo');
        $telefono = $this->input->post('telefono');
        $calle = strtoupper($this->input->post('calle'));
        $numeroexterior = $this->input->post('numeroexterior');
        $codigopostal = $this->input->post('codigopostal');
        $municipio = $this->input->post('municipio');
        $estado = $this->input->post('estado');
        $colonia = $this->input->post('colonia');
        $fechainicio =  $this->input->post('finicio');
        //$fechafin = date('d/m/Y', strtotime('+1 years'));
        $color = str_pad($this->input->post('color'), 2, "0", STR_PAD_LEFT);
        $datopoblacionana = $this->obtenerClaveDelEstado($codigopostal);
        $clavepoblacionana = $datopoblacionana["clavepoblacionana"];
        $nombrepoblacionana = $datopoblacionana["nombrepoblacionana"];
        $descripcionvehiculo = $this->obtenerDescripcionVehiculoAna($marcaana, $submarcaana, $year, $iddescripcion);
        $recargo = $this->input->post('recargo');
        $tipopoliza = $this->input->post('tipopoliza');
        $amis="";         
        $numeromotor="";
        $descripcionamis="";
         $modelo_vehiculo="";
        if ($this->input->post('fronterizo') == 0) {
            //Es nacional
            $amis .= $iddescripcion;   
            $descripcionamis.=$descripcionvehiculo;
             $modelo_vehiculo=$year;
        } else if ($this->input->post('fronterizo') == 1) {
            //$newdescription.=$this->input->post('descripcionfronterizo');
            //Es fronterizo
            $modelo_vehiculo=$this->input->post('modelovehiculo');
            if ($this->input->post('tipovehiculo') === "0") {
                //Auto
                $amis .= "Y0009002";
                $descripcionamis.=strtoupper($this->input->post('descripcionfronterizo'));
                $numeromotor.=$this->input->post('numeromotor');
            } elseif ($this->input->post('tipovehiculo') === "1") {
                //Pick up
                $amis .= "10009001";
                $descripcionamis.=strtoupper($this->input->post('descripcionfronterizo'));
                $numeromotor.=$this->input->post('numeromotor');
            } else {
                //Fuera del ciclo
            }
        } else {
            //Fuera del ciclo
        }
      $xmlplan = "";
        $fechafin = "";
        if ($tipopoliza == "1") {
            $fechafin .= date('d/m/Y', strtotime('+1 years'));
            $xmlplan .= '<transacciones xmlns=""><transaccion version="1" tipotransaccion="E" cotizacion="" negocio="' . $this->negocio_cobro_rc_referenciado . '" tiponegocio=""><vehiculo id="1" amis="' . $amis . '" modelo="' . $modelo_vehiculo . '" descripcion="' . $descripcionamis . '" uso="1" servicio="1" plan="29" motor="' . $numeromotor . '" serie="' . $serie . '" repuve="" placas="' . $placas . '" conductor="" conductorliciencia="" conductorfecnac="" conductorocupacion="" estado="' . $clavepoblacionana . '" poblacion="' . $nombrepoblacionana . '" color="' . $color . '" dispositivo="" fecdispositivo="" tipocarga="" tipocargadescripcion=""><cobertura id="25" desc="" sa="200000" tipo="" ded="" pma="" /><cobertura id="26" desc="" sa="200000" tipo="" ded="" pma="" /><cobertura id="27" desc="" sa="" tipo="" ded="" pma="" /><cobertura id="06" desc="" sa="" tipo="" ded="" pma="" /></vehiculo><asegurado id="" nombre="' . $nombre . '" paterno="' . $apellidop . '" materno="' . $apellidom . '" calle="' . $calle . '" numerointerior="" numeroexterior="' . $numeroexterior . '" colonia="' . $colonia . '" poblacion="' . $nombrepoblacionana . '" estado="' . $clavepoblacionana . '" cp="' . $codigopostal . '" pais="MEXICO" tipopersona="1"><argumento id="2" tipo="" campo="" valor="' . $correo . '"/><argumento id="3" tipo="" campo="" valor="' . $telefono . '"/><argumento id="4" tipo="" campo="" valor="' . $rfc . '"/><argumento id="5" tipo="" campo="" valor=""/><argumento id="6" tipo="" campo="" valor="M1"/><argumento id="7" tipo="" campo="" valor="C3"/><argumento id="8" tipo="" campo="" valor="123456789012"/><argumento id="9" tipo="" campo="" valor="' . $ocupacion . '"/><argumento id="19" tipo="" campo="" valor="' . $nacimientocontratante . '"/></asegurado><poliza id="" tipo="A" endoso="" fecemision="" feciniciovig="' . $fechainicio . '" fecterminovig="' . $fechafin . '" moneda="0" bonificacion="20" formapago="C" agente="06933" tarifacuotas="1704" tarifavalores="1704" tarifaderechos="1704" beneficiario="" politicacancelacion="1"><argumento id="21" tipo="" campo="" valor="27"/><argumento id="37" tipo="" campo="" valor="' . $recargo . '"/></poliza><prima primaneta="" derecho="" recargo="" impuesto="" primatotal="" comision=""/><recibo id="" feciniciovig="" fecterminovig="" primaneta="" derecho="" recargo="" impuesto="" primatotal="" comision="" cadenaoriginal="" sellodigital="" fecemision="" serie="" folio="" horaemision="" numeroaprobacion="" anoaprobacion="" numseriecertificado=""/><error/></transaccion></transacciones>';
        } else if ($tipopoliza == "0") {
            $fechafin .= date('d/m/Y', strtotime('+180 days'));
            $xmlplan .= '<transacciones xmlns=""><transaccion version="1" tipotransaccion="E" cotizacion="" negocio="' . $this->negocio_cobro_rc_referenciado . '" tiponegocio=""><vehiculo id="1" amis="' . $amis . '" modelo="' . $modelo_vehiculo . '" descripcion="' . $descripcionamis . '" uso="1" servicio="1" plan="29" motor="' . $numeromotor . '" serie="' . $serie . '" repuve="" placas="' . $placas . '" conductor="" conductorliciencia="" conductorfecnac="" conductorocupacion="" estado="' . $clavepoblacionana . '" poblacion="' . $nombrepoblacionana . '" color="' . $color . '" dispositivo="" fecdispositivo="" tipocarga="" tipocargadescripcion=""><cobertura id="25" desc="" sa="200000" tipo="" ded="" pma="" /><cobertura id="26" desc="" sa="200000" tipo="" ded="" pma="" /><cobertura id="27" desc="" sa="" tipo="" ded="" pma="" /><cobertura id="06" desc="" sa="" tipo="" ded="" pma="" /></vehiculo><asegurado id="" nombre="' . $nombre . '" paterno="' . $apellidop . '" materno="' . $apellidom . '" calle="' . $calle . '" numerointerior="" numeroexterior="' . $numeroexterior . '" colonia="' . $colonia . '" poblacion="' . $nombrepoblacionana . '" estado="' . $clavepoblacionana . '" cp="' . $codigopostal . '" pais="MEXICO" tipopersona="1"><argumento id="2" tipo="" campo="" valor="' . $correo . '"/><argumento id="3" tipo="" campo="" valor="' . $telefono . '"/><argumento id="4" tipo="" campo="" valor="' . $rfc . '"/><argumento id="5" tipo="" campo="" valor=""/><argumento id="6" tipo="" campo="" valor="M1"/><argumento id="7" tipo="" campo="" valor="C3"/><argumento id="8" tipo="" campo="" valor="123456789012"/><argumento id="9" tipo="" campo="" valor="' . $ocupacion . '"/><argumento id="19" tipo="" campo="" valor="' . $nacimientocontratante . '"/></asegurado><poliza id="" tipo="A" endoso="" fecemision="" feciniciovig="' . $fechainicio . '" fecterminovig="' . $fechafin . '" moneda="0" bonificacion="20" formapago="C" agente="06933" tarifacuotas="1704" tarifavalores="1704" tarifaderechos="1704" beneficiario="" politicacancelacion="1"><argumento id="21" tipo="" campo="" valor="27" /><argumento id="25" tipo="" campo="" valor=""/><argumento id="34" tipo="" campo="" valor=""/><argumento id="37" tipo="" campo="" valor="' . $recargo . '"/></poliza><prima primaneta="" derecho="" recargo="" impuesto="" primatotal="" comision=""/><recibo id="" feciniciovig="" fecterminovig="" primaneta="" derecho="" recargo="" impuesto="" primatotal="" comision="" cadenaoriginal="" sellodigital="" fecemision="" serie="" folio="" horaemision="" numeroaprobacion="" anoaprobacion="" numseriecertificado=""/><error/></transaccion></transacciones>';
        } else {
            
        }
       // echo $amis;
       // echo $this->input->post('tipovehiculo');
   //  print_r($xmlplan);
        
        
//                    $datar=array(
//                        'error'=>0,
//                        'msgerror'=>'Error mensaje',
//                          'descarga'=>"https://codepen.io/tylerama/pen/jyefb"
//                    );
//                    echo json_encode($datar);




        $negociop = $this->negocio_cobro_rc_referenciado;
        $usuariop = $this->usuario_cobro_rc_referenciado;
        $clavep = $this->clave_cobro_rc_referenciado;
        $msgerror = "";
        $idpoliza = "";
        $idpolizamodificado = "";
        $endoso = "";
        $iddocumento = "";
        $numerocuenta = "";
        $numeroreferencia = "";
        $primatotal = "";
        $xmlemision = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:Transaccion>
         <!--Optional:-->
         <tem:XML> ' . $xmlplan . '</tem:XML>
         <tem:Tipo>Emision</tem:Tipo>
         <!--Optional:-->
         <tem:Usuario>' . $usuariop . '</tem:Usuario>
         <!--Optional:-->
         <tem:Clave>' . $clavep . '</tem:Clave>
      </tem:Transaccion>
   </soapenv:Body>
</soapenv:Envelope>';

 
        $url = $this->url;
        $headers = ["Content-type: text/xml", "Content-length: " . strlen($xmlemision), "Connection: close",];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlemision);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
            echo "Algo fallo";
        } else {

            $xml_handle = new DOMDocument();
            $xml_handle->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $arraystring = $this->XMLtoArray($xml_handle->textContent);


            $msgerror = (isset($arraystring['TRANSACCIONES']['TRANSACCION']['ERROR']) && !empty($arraystring['TRANSACCIONES']['TRANSACCION']['ERROR'])) ? $arraystring['TRANSACCIONES']['TRANSACCION']['ERROR'] : '';
            $idpoliza = (isset($arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['ID']) && !empty($arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['ID'])) ? substr($arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['ID'], 0, 11) : '';
            $idpolizaoriginal = (isset($arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['ID']) && !empty($arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['ID'])) ? $arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['ID'] : '';
            $endoso = (isset($arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['ENDOSO']) && !empty($arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['ENDOSO'])) ? $arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['ENDOSO'] : '';
            $numerocuenta = (isset($arraystring['TRANSACCIONES']['TRANSACCION']['RECIBO']['CUENTA']) && !empty($arraystring['TRANSACCIONES']['TRANSACCION']['RECIBO']['CUENTA'])) ? $arraystring['TRANSACCIONES']['TRANSACCION']['RECIBO']['CUENTA'] : '';
            $numeroreferencia = (isset($arraystring['TRANSACCIONES']['TRANSACCION']['RECIBO']['REFERENCIA']) && !empty($arraystring['TRANSACCIONES']['TRANSACCION']['RECIBO']['REFERENCIA'])) ? $arraystring['TRANSACCIONES']['TRANSACCION']['RECIBO']['REFERENCIA'] : '';
            $primatotal = (isset($arraystring['TRANSACCIONES']['TRANSACCION']['RECIBO']['PRIMATOTAL']) && !empty($arraystring['TRANSACCIONES']['TRANSACCION']['RECIBO']['PRIMATOTAL'])) ? $arraystring['TRANSACCIONES']['TRANSACCION']['RECIBO']['PRIMATOTAL'] : '';
            if (empty($msgerror)) {
                $msgerrorimpre = "";
                $linkdescargar = "";
                $xmlim = '<transacciones xmlns=""><transaccion version="1" tipotransaccion="I" negocio="' . $negociop . '"><poliza id="' . $idpoliza . '" endoso="' . $endoso . '" inciso="1" link=""/><error/></transaccion></transacciones>';
                $xmlimpresion = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
   <soapenv:Header/>
   <soapenv:Body>
      <tem:Transaccion>
         <!--Optional:-->
         <tem:XML> ' . $xmlim . '</tem:XML>
         <tem:Tipo>Impresion</tem:Tipo>
         <!--Optional:-->
         <tem:Usuario>' . $usuariop . '</tem:Usuario>
         <!--Optional:-->
         <tem:Clave>' . $clavep . '</tem:Clave>
      </tem:Transaccion>
   </soapenv:Body>
</soapenv:Envelope>';


                $url = $this->url;
                $headers = ["Content-type: text/xml", "Content-length: " . strlen($xmlimpresion), "Connection: close",];
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_TIMEOUT, 100);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlimpresion);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                $data = curl_exec($ch);
                if (curl_errno($ch)) {
                    print curl_error($ch);
                    echo "Algo fallo";
                } else {
                    $xml_handle = new DOMDocument();
                    $xml_handle->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                    $arraystring = $this->XMLtoArray($xml_handle->textContent);
                    $linkdescargar .= (isset($arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['LINK']) && !empty($arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['LINK'])) ? $arraystring['TRANSACCIONES']['TRANSACCION']['POLIZA']['LINK'] : '';
                    $msgerrorimpre .= (isset($arraystring['TRANSACCIONES']['TRANSACCION']['ERROR']) && !empty($arraystring['TRANSACCIONES']['TRANSACCION']['ERROR'])) ? $arraystring['TRANSACCIONES']['TRANSACCION']['ERROR'] : '';
                }
                if (empty($msgerrorimpre)) {
//                   $ch = curl_init();
//                    $data = array(
//                        'rfc' => $rfc,
//                        'fechainicio' => $fechainicio,
//                        'fechafin' => $fechafin,
//                        'nombre' => $nombre,
//                        'apaterno' => $apellidop,
//                        'amaterno' => $apellidom,
//                        'calle' => $calle,
//                        'numeroexterior' => $numeroexterior,
//                        'fechanacimiento' => $fechanacimiento,
//                        'serie' => $serie,
//                        'modelo' => $year,
//                        'idusuario' => $idusuario,
//                        'primaneta' => $primatotal,
//                        'descripcionvehiculo' => $newdescription,
//                        'correo' => $correo,
//                        'poliza' => substr($idpoliza, 2, 9)
//                    );
//                    $postvars = '';
//                    foreach ($data as $key => $value) {
//                        $postvars .= $key . "=" . $value . "&";
//                    }
//// definimos la URL a la que hacemos la petición
//                    curl_setopt($ch, CURLOPT_URL, "http://201.159.17.216:8484/apiSIPA/Solicitud/registrarSolicitudSIPA");
//// indicamos el tipo de petición: POST
//                    curl_setopt($ch, CURLOPT_POST, TRUE);
//// definimos cada uno de los parámetros
//                    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
//
//// recibimos la respuesta y la guardamos en una variable
//                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//                    $remote_server_output = curl_exec($ch);
//
//// cerramos la sesión cURL
//                    curl_close($ch);
//
//// hacemos lo que queramos con los datos recibidos
//// por ejemplo, los mostramos
//                    //print_r($remote_server_output);
//
//
                    $datavehiculo = array(
                        'plan'=>$tipopoliza,
                        'poliza' => substr($idpoliza, 2, 9),
                        'nombre' => $nombre,
                        'apellidop' => $apellidop,
                        'apellidom' => $apellidom,
                        'telefono' => $telefono,
                        'correo' => $correo,
                        'fechanacimiento' => $fechanacimiento,
                        'rfc' => $rfc,
                        'estado' => $estado,
                        'municipio' => $nombrepoblacionana,
                        'colonia' => $colonia,
                        'cp' => $codigopostal,
                        'primatotal' => $primatotal,
                        'recargo' => $recargo,
                        'fronterizo'=>$this->input->post('fronterizo'),
                        'tipovehiculo'=>$this->input->post('tipovehiculo'),
                        'nomotor'=>$numeromotor,
                        'year' => $year,
                        'serie' => $serie,
                        'descripcion' => $descripcionamis,
                        'fechainicio' => date('Y-m-d'),
                        'fechafin' => date('Y-m-d', strtotime('+1 years')),
                        'link' => $linkdescargar,
                        'idusuario' => $this->session->idusuario,
                        'fecharegistro' => date('Y-m-d H:i:s'),
                        'activaCorteCaja'=>0,
                        'activaSubidoSip'=>0,
                        'activaCancelada'=>0,
                        'autorizarCancelacion'=>0
                    );
                    $this->venta->addVenta($datavehiculo);
                    $datar = array(
                        'error' => 0,
                        'msgerror' => "",
                        'descarga' => $linkdescargar
                    );
                    echo json_encode($datar);
                } else {
                    //Error en la impresion de la poliza.
                    $datar = array(
                        'error' => 1,
                        'msgerror' => $msgerrorimpre,
                        'descarga' => "",
                        'fronterizo'=>$this->input->post('fronterizo')
                    );
                    echo json_encode($datar);
                }
            } else {
                //Error en la emision de la poliza.
                $datar = array(
                    'error' => 1,
                    'msgerror' => $msgerror,
                    'descarga' => "",
                    'fronterizo'=>$this->input->post('fronterizo')
                );
                echo json_encode($datar);
            } 
        } 
    }

    public function obtenerDescripcionVehiculoAna($marca, $submarca, $year, $iddescripcion) {
        $descriptionvehicle = "";
        $xmlimpresion = '<soapenv:Envelope xmlns:soapenv="http://schemas.xmlsoap.org/soap/envelope/" xmlns:tem="http://tempuri.org/">
 <soapenv:Header/>
   <soapenv:Body>
      <tem:Vehiculo> 
         <tem:Negocio>' . $this->negocio . '</tem:Negocio> 
         <tem:Marca>' . $marca . '</tem:Marca> 
         <tem:Submarca>' . $submarca . '</tem:Submarca> 
         <tem:Modelo>' . $year . '</tem:Modelo>  
         <tem:Usuario>' . $this->usuario . '</tem:Usuario> 
         <tem:Clave>' . $this->clave . '</tem:Clave>
      </tem:Vehiculo>
   </soapenv:Body>
</soapenv:Envelope>';



        $url = $this->url;
        $headers = ["Content-type: text/xml", "Content-length: " . strlen($xmlimpresion), "Connection: close",];
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xmlimpresion);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $data = curl_exec($ch);
        if (curl_errno($ch)) {
            print curl_error($ch);
            echo "Algo fallo";
        } else {
            $xml_handle = new DOMDocument();
            $xml_handle->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
            $arraystring = $this->XMLtoArray($xml_handle->textContent);



            if (isset($arraystring['TRANSACCIONES']['VEHICULO']['CLAVE'])) {
                if ($arraystring['TRANSACCIONES']['VEHICULO']['CLAVE'] == $iddescripcion) {
                    $descriptionvehicle = $arraystring['TRANSACCIONES']['VEHICULO']['content'];
                }
            } else {
                foreach ($arraystring['TRANSACCIONES']['VEHICULO'] as $value) {
                    // echo $value['content'];
                    if ($value['CLAVE'] == $iddescripcion) {
                        $descriptionvehicle = $value['content'];
                    }
                }
            }
        }

        return $descriptionvehicle;
    }

}
