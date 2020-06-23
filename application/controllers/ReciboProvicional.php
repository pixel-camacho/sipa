<?php

defined('BASEPATH') OR exit('No direct script access allowed');

//Load libruary for API
class ReciboProvicional extends CI_Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
            return redirect('login');
        }
        $this->load->helper('url');
        $this->load->model('data_model');
        $this->load->model('recibo_model', 'recibo');
         $this->load->model('user_model', 'usuario');
        $this->load->library('permission');
        $this->load->library('html2pdf');
    }

    public function index() {
        $this->load->view('header');
        $this->load->view('reporte/recibo/index');
        $this->load->view('footer');
    }

    public function addRecibo() {
        //Permission::grant(uri_string());
        $config = array(
            array(
                'field' => 'idcliente',
                'label' => 'SIP',
                'rules' => 'trim|required|numeric',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'numeric' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'poliza',
                'label' => 'poliza',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'cantidad',
                'label' => 'cantidad',
                'rules' => 'trim|required|decimal',
                'errors' => array(
                    'required' => 'Campo obligatorio.',
                    'decimal' => 'Cantidad con decimales.'
                )
            ),
            array(
                'field' => 'fechainicio',
                'label' => 'fechainicio',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            ),
            array(
                'field' => 'periodo',
                'label' => 'periodo',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'producto',
                'label' => 'producto',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'compania',
                'label' => 'compania',
                'rules' => 'trim|required',
                'errors' => array(
                    'required' => 'Campo obligatorio.'
                )
            )
            ,
            array(
                'field' => 'formapago',
                'label' => 'formapago',
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
                'idcliente' => form_error('idcliente'),
                'poliza' => form_error('poliza'),
                'cantidad' => form_error('cantidad'),
                'fechainicio' => form_error('fechainicio'),
                'periodo' => form_error('periodo'),
                'producto' => form_error('producto'),
                'compania' => form_error('compania'),
                'formapago' => form_error('formapago')
            );
        } else {
            $idformapago = $this->input->post('formapago');
            $date = str_replace('/', '-', $this->input->get_post('fechainicio'));
            $date = strtotime($date);
            $new_date = strtotime('+ 1 year', $date);
            if ($idformapago === 1) {
                $data = array(
                    'idcliente' => $this->input->post('idcliente'),
                    'poliza' => $this->input->post('poliza'),
                    'cantidad' => $this->input->post('cantidad'),
                    'fechainicio' => $this->input->post('fechainicio'),
                    'fechafin ' => date('Y-m-d', $new_date),
                    'periodocobro' => $this->input->post('periodo'),
                    'idproducto' => $this->input->post('producto'),
                    'idcompania' => $this->input->post('compania'),
                    'subido ' => 0,
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $idrecibo = $this->recibo->addReciboProvicional($data);
                $datedetalle = array(
                    'idrecibo' => $idrecibo,
                    'idtipo' => $this->input->post('formapago'),
                    'autorizacion' => '',
                    'banco' => '',
                    'ticket' => '',
                    'idusuario' => $this->session->user_id,
                    'fecharegistro' => date('Y-m-d H:i:s')
                );
                $this->recibo->addDetalleRecibo($datedetalle);
            } else {
                $config = array(
                    array(
                        'field' => 'autorizacion',
                        'label' => 'autorizacion',
                        'rules' => 'trim|required|numeric',
                        'errors' => array(
                            'required' => 'Campo obligatorio.',
                            'numeric' => 'Solo numero.'
                        )
                    ),
                    array(
                        'field' => 'banco',
                        'label' => 'banco',
                        'rules' => 'trim|required',
                        'errors' => array(
                            'required' => 'Campo obligatorio.'
                        )
                    ), 
                    array(
                        'field' => 'file',
                        'label' => 'file',
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
                        'autorizacion' => form_error('autorizacion'),
                        'banco' => form_error('banco'),
                        'file' => form_error('file')
                    );
                } else {
                    $url = "../escaneado";
                    $image = basename($_FILES['file']['name']);
                    $image = str_replace(' ', '|', $image);
                    $type = explode(".", $image);
                    $type = $type[count($type) - 1];
                    if (in_array($type, array('jpg', 'jpeg', 'png', 'gif'))) {
                        $nombrefile = uniqid(rand()). "." . $type;
                        $tmppath = "escaneado/" . $nombrefile;
                        if (is_uploaded_file($_FILES["file"]["tmp_name"])) {
                            move_uploaded_file($_FILES['file']['tmp_name'], $tmppath);
                           
                            $data = array(
                                'idcliente' => $this->input->post('idcliente'),
                                'poliza' => $this->input->post('poliza'),
                                'cantidad' => $this->input->post('cantidad'),
                                'fechainicio' => $this->input->post('fechainicio'),
                                'fechafin ' => date('Y-m-d', $new_date),
                                'periodocobro' => $this->input->post('periodo'),
                                'idproducto' => $this->input->post('producto'),
                                'idcompania' => $this->input->post('compania'),
                                'subido ' => 0,
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s')
                            );
                            $idrecibo = $this->recibo->addReciboProvicional($data);
                            $datedetalle = array(
                                'idrecibo' => $idrecibo,
                                'idtipo' => $this->input->post('formapago'),
                                'autorizacion' => $this->input->post('autorizacion'),
                                'banco' => $this->input->post('banco'),
                                'ticket' => $nombrefile,
                                'idusuario' => $this->session->user_id,
                                'fecharegistro' => date('Y-m-d H:i:s')
                            );
                            $this->recibo->addDetalleRecibo($datedetalle);
                            return $tmppath;
                        }
                    } else {
                      //  redirect(base_url() . 'index.php/Welcome/not_img', 'refresh');
                        $result['error'] = true;
                            $result['msg'] = array(
                                'mensaje' => "Solo permite imagen o PDF."
                            );
                    }

                   
                }
            }
        }
        echo json_encode($result);
    }

    public function allRecibos() {
        $registros = $this->recibo->showAllRecibosPorUsuario($this->session->user_id);
        echo json_encode($registros);
    }

    public function upload($idrecibo) {
        
    }
            
    public function imprimir($idrecibo) {
        //$this->numtoletras(5696.98);
        //$this->load->library('tcpdf');
        $this->load->library('tcpdf');
        $detalle = $this->recibo->detalleRecibo($idrecibo);
        $detallerecibo = $this->recibo->obtenerFormaPago($idrecibo);
        $detalleusuario = $this->usuario->detalleUsuario($this->session->user_id);
         $formapago = "";
         $autorizacion="";
        switch ($detallerecibo->idtipo) {
            case 1:
                $formapago .= "Efectivo";
                break;
            case 2:
                $formapago .= "Cheque";
                 $autorizacion.="#".$detallerecibo->autorizacion;
                break;
            case 3:
                $formapago .= "Tarjeta de Credito";
                  $autorizacion.="#".$detallerecibo->autorizacion;
                break;
            case 4:
                $formapago .= "Deposito Bancario";
                  $autorizacion.="#".$detallerecibo->autorizacion;
                break;
             case 5:
                $formapago .= "Pago CIA";
                break;
             case 7:
                $formapago .= "Tarjeta de Debido";
                  $autorizacion.="#".$detallerecibo->autorizacion;
                break;
            default:
                 $formapago .= "NO DEFINIDO";
                break;
        }
        $producto = "";
        switch ($detalle->idproducto) {
            case 3:
                $producto .= "HOGAR";
                break;
            case 5:
                $producto .= "VIDA";
                break;
            case 6:
                $producto .= "GMM";
                break;
            case 7:
                $producto .= "AUTOS";
                break;
            default:
                 $producto .= "NO DEFINIDO";
                break;
        }
        $compania = "";
        switch ($detalle->idcompania) {
            case 10:
                $compania .= "LATINO SEGUROS S.A.";
                break;
            case 11:
                $compania .= "HDI SEGUROS";
                break;
            case 30:
                $compania .= "QUALITAS AUTOS MX";
                break;
            case 31:
                $compania .= "GENERAL DE SEGUROS";
                break;
             case 35:
                $compania .= "ABA SEGUROS";
                break;
             case 39:
                $compania .= "GRUPO N PROVINCIAL, S.A.B.";
                break;
             case 43:
                $compania .= "NATIONAL UNITY INSURANCE COMPANY";
                break;
             case 44:
                $compania .= "CRUCE SEGURO";
                break;
             case 62:
                $compania .= "ANA SEGUROS SA DE CV";
                break;
             case 63:
                $compania .= "METROPOLITANA";
                break;
             case 64:
                $compania .= "THONA SEGUROS";
                break;
             case 66:
                $compania .= "ATLAS SEGUROS";
                break;
             case 67:
                $compania .= "SISNOVA";
                break;
            default:
                 $compania .= "NO DEFINIDO";
                break;
        }
        $ch = curl_init();
        $data = array(
            'idcliente' => $detalle->idcliente
        );
        $postvars = '';
        foreach ($data as $key => $value) {
            $postvars .= $key . "=" . $value . "&";
        }
// definimos la URL a la que hacemos la petición
        curl_setopt($ch, CURLOPT_URL, "http://201.159.17.216:8484/apiSIPA/Cliente/detalleCliente");
// indicamos el tipo de petición: POST
        curl_setopt($ch, CURLOPT_POST, TRUE);
// definimos cada uno de los parámetros
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);

// recibimos la respuesta y la guardamos en una variable
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $remote_server_output = curl_exec($ch);
        $dataresult = json_decode($remote_server_output);


// cerramos la sesión cURL
        curl_close($ch);


        ob_start();
        error_reporting(E_ALL & ~E_NOTICE);
        ini_set('display_errors', 0);
        ini_set('log_errors', 1);
        $linkimge = base_url() . '/assets/images/logo.png';
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetCreator('');
        $pdf->SetAuthor('');
        $pdf->SetTitle('Recibo de cobro');
        $pdf->SetSubject('');
        $pdf->SetKeywords('');
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetDefaultMonospacedFont('');
        $pdf->SetMargins(10, 20, 10, true);
        $pdf->SetAutoPageBreak(TRUE, 10);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setLanguageArray($l);
        $pdf->SetDisplayMode('fullpage', 'SinglePage', 'UseNone');
        //$pdf->SetTextColor(119, 119, 119);
        //$pdf->SetDrawColor(119, 119, 119, false, '');
        $pdf->AddPage('P', 'A4');
        $tbl = '<style type="text/css">
table {
  border-collapse: separate;
  border-spacing:  0px;
}	
	body{
		font-family:Arial, Helvetica, sans-serif;
	}
</style>
<page>
<table border="" width="560" cellpadding="0" cellspacing="0" >
	<tr>
		<td width="100" style=""><img  align="center" class="imgtitle" src="' . $linkimge . '"; /></td>
		<td colspan="8" width="300" style="font-size: 27px; font-weight: bold;"> 
		PROTECCIÓN GENERAL EN SEGUROS S.A. DE. C.V.<br>
		  Centro Comercial Plaza Fiesta Loc. 5 y 6b<br>
		  Centro Civico Mexicali B.C.<br>
		  Tel. 555-21-50, 55-56-30 y 555-15-66
			 
		</td>
		<td colspan="2" width="140" align="right" style="font-size: 24px; font-weight: bold;">
		Fecha de Emisión: '.$detalle->fecha.'<br><br>
		<strong style="font-size: 28px;">$'.$detalle->cantidad.'</strong></td> 
	</tr> 
        <tr>
		<td colspan="10" align="right">
			 
			
		</td>
	</tr>
	<tr>
		<td colspan="10" align="right" width="540"  >
			<strong style="font-size: 24px; padding:90px 90px 90px 90px;">SON: '.$this->numtoletras($detalle->cantidad).'</strong>
			
		</td>
	</tr>
	<tr>
		<td colspan="5" width="280" style="border: solid red 2px;border-radius: 10px;height: 80px;">
		
		<strong style="font-size: 25px;">Cliente:</strong><label style="font-size: 25px;"> '.$dataresult->nombre.' '.$dataresult->apellidop.' '.$dataresult->apellidom.'</label><br>
		<strong style="font-size: 25px;">Domincilio:</strong> <label style="font-size: 25px;">'.$dataresult->direccion.' '.$dataresult->nocasa.' '.$dataresult->colonia.' '.$dataresult->cp.' '.$dataresult->municipio.' '.$dataresult->estado.'</label><br>
		<strong style="font-size: 25px;">Tel.</strong><label style="font-size: 25px;"></label><br>
		<strong style="font-size: 25px;">Centro de Trabajo:</strong><label style="font-size: 25px;"> '.$dataresult->centrotrabajo.'</label>
		
		</td>
		   
		<td colspan="5"   style="border: solid red 2px;border-radius: 10px;height: 80px;" width="260">
			 
		</td> 
	</tr>
	<tr>
		<td colspan="10"><br></td>
	</tr>
	<tr>
		<td colspan="4"><strong style="font-size: 24px; ">No. de Pago:</strong><label style="font-size: 24px;">1ERO</label></td> 
		<td colspan="7"><strong style="font-size: 24px;">Periodo:</strong><label style="font-size: 24px;">'.$detalle->periodocobro.'</label></td>  
	</tr>
		<tr>
		<td colspan="4"><strong style="font-size: 24px;">Concepto:</strong> <label style="font-size: 24px;">'.$formapago.' '.$autorizacion.'</label></td> 
		<td colspan="7"><strong style="font-size: 24px;">Producto:</strong> <label style="font-size: 24px;">'.$producto.' - '.$compania.'</label></td>  
	</tr>
	
	<tr>
		<td colspan="3" width="166"><strong style="font-size: 24px;">Póliza: </strong><label style="font-size: 24px;">'.$detalle->poliza.'</label> </td> 
		<td colspan="3" width="166"><strong style="font-size: 24px;">Inicio Vigencia: </strong><label style="font-size: 24px;">'.$detalle->fechainicio.'</label></td>
		 
		<td colspan="4" width="166"><strong style="font-size: 24px;">Fin Vigencia: </strong><label style="font-size: 24px;">'.$detalle->fechafin.'</label></td> 
	</tr>
	<tr>
		<td colspan="10"><br></td>
	</tr>
        <tr>
		<td colspan="10"><br></td>
	</tr>
	<tr>
		<td colspan="5" width="250" align="center"><strong style="font-size: 25px;">Administrativo de PROTEGES </strong></td>
		<td colspan="5" width="250" align="center"><strong style="font-size: 25px;">Asegurado(a)</strong></td> 
	</tr>
	<tr>
		<td colspan="5" width="250" align="center">_________________________</td>
		<td colspan="5" width="250" align="center">_____________________</td> 
	</tr>
        <tr>
            <td colspan="10"></td>
        </tr>
	<tr>
		<td colspan="5" width="250" align="center " style="font-size: 25px;">'.$detalleusuario->name.'</td>
		<td colspan="5" width="250" align="center" style="font-size: 25px;">'.$dataresult->nombre.' '.$dataresult->apellidop.' '.$dataresult->apellidom.'</td> 
	</tr>
 
 
</table>

<br><br><br><br><br><br><br><br><br><br><br> <br> 
<table border="" width="560" cellpadding="0" cellspacing="0" >
	<tr>
		<td width="100" style=""><img  align="center" class="imgtitle" src="' . $linkimge . '"; /></td>
		<td colspan="8" width="300" style="font-size: 27px; font-weight: bold;"> 
		PROTECCIÓN GENERAL EN SEGUROS S.A. DE. C.V.<br>
		  Centro Comercial Plaza Fiesta Loc. 5 y 6b<br>
		  Centro Civico Mexicali B.C.<br>
		  Tel. 555-21-50, 55-56-30 y 555-15-66
			 
		</td>
		<td colspan="2" width="140" align="right" style="font-size: 24px; font-weight: bold;">
		Fecha de Emisión: '.$detalle->fecha.'<br><br>
		<strong style="font-size: 28px;">$'.$detalle->cantidad.'</strong></td> 
	</tr> 
        <tr>
		<td colspan="10" align="right">
			 
			
		</td>
	</tr>
	<tr>
		<td colspan="10" align="right" width="540"  >
			<strong style="font-size: 24px; padding:90px 90px 90px 90px;">SON: '.$this->numtoletras($detalle->cantidad).'</strong>
			
		</td>
	</tr>
	<tr>
		<td colspan="5" width="280" style="border: solid red 2px;border-radius: 10px;height: 80px;">
		
		<strong style="font-size: 25px;">Cliente:</strong><label style="font-size: 25px;"> '.$dataresult->nombre.' '.$dataresult->apellidop.' '.$dataresult->apellidom.'</label><br>
		<strong style="font-size: 25px;">Domincilio:</strong> <label style="font-size: 25px;">'.$dataresult->direccion.' '.$dataresult->nocasa.' '.$dataresult->colonia.' '.$dataresult->cp.' '.$dataresult->municipio.' '.$dataresult->estado.'</label><br>
		<strong style="font-size: 25px;">Tel.</strong><label style="font-size: 25px;"></label><br>
		<strong style="font-size: 25px;">Centro de Trabajo:</strong><label style="font-size: 25px;"> '.$dataresult->centrotrabajo.'</label>
		
		</td>
		   
		<td colspan="5"   style="border: solid red 2px;border-radius: 10px;height: 80px;" width="260">
			 
		</td> 
	</tr>
	<tr>
		<td colspan="10"><br></td>
	</tr>
	<tr>
		<td colspan="4"><strong style="font-size: 24px; ">No. de Pago:</strong></td> 
		<td colspan="7"><strong style="font-size: 24px;">Periodo:</strong><label style="font-size: 24px;">'.$detalle->periodocobro.'</label></td>  
	</tr>
		<tr>
		<td colspan="4"><strong style="font-size: 24px;">Concepto:</strong> <label style="font-size: 24px;">'.$formapago.' '.$autorizacion.'</label></td> 
		<td colspan="7"><strong style="font-size: 24px;">Producto:</strong> <label style="font-size: 24px;">'.$producto.' - '.$compania.'</label></td>  
	</tr>
	
	<tr>
		<td colspan="3" width="166"><strong style="font-size: 24px;">Póliza: </strong><label style="font-size: 24px;">'.$detalle->poliza.'</label> </td> 
		<td colspan="3" width="166"><strong style="font-size: 24px;">Inicio Vigencia: </strong><label style="font-size: 24px;">'.$detalle->fechainicio.'</label></td>
		 
		<td colspan="4" width="166"><strong style="font-size: 24px;">Fin Vigencia: </strong><label style="font-size: 24px;">'.$detalle->fechafin.'</label></td> 
	</tr>
	<tr>
		<td colspan="10"><br></td>
	</tr>
        <tr>
		<td colspan="10"><br></td>
	</tr>
	<tr>
		<td colspan="5" width="250" align="center"><strong style="font-size: 25px;">Administrativo de PROTEGES </strong></td>
		<td colspan="5" width="250" align="center"><strong style="font-size: 25px;">Asegurado(a)</strong></td> 
	</tr>
	<tr>
		<td colspan="5" width="250" align="center">_________________________</td>
		<td colspan="5" width="250" align="center">_____________________</td> 
	</tr>
        <tr>
            <td colspan="10"></td>
        </tr>
	<tr>
		<td colspan="5" width="250" align="center " style="font-size: 25px;">'.$detalleusuario->name.'</td>
		<td colspan="5" width="250" align="center" style="font-size: 25px;">'.$dataresult->nombre.' '.$dataresult->apellidop.' '.$dataresult->apellidom.'</td> 
	</tr>
 
 
</table>
';
        //$pdf->AddPage(false);

        $pdf->writeHTML($tbl, true, false, false, false, '');
        $pdf->Output('My-File-Name.pdf', 'I');
    }

//------    CONVERTIR NUMEROS A LETRAS         ---------------
//------    Máxima cifra soportada: 18 dígitos con 2 decimales
//------    999,999,999,999,999,999.99
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE BILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE MILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE PESOS 99/100 M.N.
//------    Creada por:                        ---------------
//------             ULTIMINIO RAMOS GALÁN     ---------------
//------            uramos@gmail.com           ---------------
//------    10 de junio de 2009. México, D.F.  ---------------
//------    PHP Version 4.3.1 o mayores (aunque podría funcionar en versiones anteriores, tendrías que probar)
   public function numtoletras($xcifra) {
        $xarray = array(0 => "Cero",
            1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
            "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
            "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
            100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
        );
//
        $xcifra = trim($xcifra);
        $xlength = strlen($xcifra);
        $xpos_punto = strpos($xcifra, ".");
        $xaux_int = $xcifra;
        $xdecimales = "00";
        if (!($xpos_punto === false)) {
            if ($xpos_punto == 0) {
                $xcifra = "0" . $xcifra;
                $xpos_punto = strpos($xcifra, ".");
            }
            $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
            $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
        }

        $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
        $xcadena = "";
        for ($xz = 0; $xz < 3; $xz++) {
            $xaux = substr($XAUX, $xz * 6, 6);
            $xi = 0;
            $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
            $xexit = true; // bandera para controlar el ciclo del While
            while ($xexit) {
                if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                    break; // termina el ciclo
                }

                $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
                $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
                for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                    switch ($xy) {
                        case 1: // checa las centenas
                            if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            } else {
                                $key = (int) substr($xaux, 0, 3);
                                if (TRUE === array_key_exists($key, $xarray)) {  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                    if (substr($xaux, 0, 3) == 100)
                                        $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                                }
                                else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                    $key = (int) substr($xaux, 0, 1) * 100;
                                    $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 0, 3) < 100)
                            break;
                        case 2: // checa las decenas (con la misma lógica que las centenas)
                            if (substr($xaux, 1, 2) < 10) {
                                
                            } else {
                                $key = (int) substr($xaux, 1, 2);
                                if (TRUE === array_key_exists($key, $xarray)) {
                                    $xseek = $xarray[$key];
                                    $xsub = $this->subfijo($xaux);
                                    if (substr($xaux, 1, 2) == 20)
                                        $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                    $xy = 3;
                                }
                                else {
                                    $key = (int) substr($xaux, 1, 1) * 10;
                                    $xseek = $xarray[$key];
                                    if (20 == substr($xaux, 1, 1) * 10)
                                        $xcadena = " " . $xcadena . " " . $xseek;
                                    else
                                        $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                                } // ENDIF ($xseek)
                            } // ENDIF (substr($xaux, 1, 2) < 10)
                            break;
                        case 3: // checa las unidades
                            if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            } else {
                                $key = (int) substr($xaux, 2, 1);
                                $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                                $xsub = $this->subfijo($xaux);
                                $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                            } // ENDIF (substr($xaux, 2, 1) < 1)
                            break;
                    } // END SWITCH
                } // END FOR
                $xi = $xi + 3;
            } // ENDDO

            if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
                $xcadena .= " DE";

            if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
                $xcadena .= " DE";

            // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
            if (trim($xaux) != "") {
                switch ($xz) {
                    case 0:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena .= "UN BILLON ";
                        else
                            $xcadena .= " BILLONES ";
                        break;
                    case 1:
                        if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                            $xcadena .= "UN MILLON ";
                        else
                            $xcadena .= " MILLONES ";
                        break;
                    case 2:
                        if ($xcifra < 1) {
                            $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                        }
                        if ($xcifra >= 1 && $xcifra < 2) {
                            $xcadena = "UN PESO $xdecimales/100 M.N. ";
                        }
                        if ($xcifra >= 2) {
                            $xcadena .= " PESOS $xdecimales/100 M.N. "; //
                        }
                        break;
                } // endswitch ($xz)
            } // ENDIF (trim($xaux) != "")
            // ------------------      en este caso, para México se usa esta leyenda     ----------------
            $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
            $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
            $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
            $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
        } // ENDFOR ($xz)
        return trim($xcadena);
    }

// END FUNCTION

    public function subfijo($xx) { // esta función regresa un subfijo para la cifra
        $xx = trim($xx);
        $xstrlen = strlen($xx);
        if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
            $xsub = "";
        //
        if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
            $xsub = "MIL";
        //
        return $xsub;
    }

// END FUNCTION
}
