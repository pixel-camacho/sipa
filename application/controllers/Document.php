<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//Load libruary for API
class Document extends CI_Controller {

  function __construct()
  {
    parent::__construct();

    if(!isset($_SESSION['user_id'])) {
      $this->session->set_flashdata('flash_data', 'You don\'t have access! ss');
      return redirect('login');
    }
    $this->load->helper('url');
    $this->load->model('document_model'); 
    $this->load->library('permission'); 
  }
  /**
   * 
   *
  **/
  public function index()
  {
    Permission::grant(uri_string());
    $this->load->view('header');
    $this->load->view('document/index');
    $this->load->view('footer');
  }

  /**
   * Funcion para buscar clientes 
  **/
  public function searchUser()
  {      
    $value = $this->input->post('text');
    $query = $this->document_model->searchUser($value);
    if($query) {
      $result['users'] = $query;
    }
    echo json_encode($result);
  }

  /**
   *Funcion para crear un nuevo cliente
  **/
  public function createClient()
  {
    // Cargar el modelo
    $this->load->model('document_model');

    // Datos recibidos por POST
    //$idusuario = $this->input->post("idusuario");
    $nombre = $this->input->post("nombre");
    $ap_paterno = $this->input->post("ap_paterno");
    $ap_materno = $this->input->post("ap_materno");
    $genero = $this->input->post("genero");

    // var_dump($nombre." ".$ap_paterno." ".$ap_materno." ".$genero);
    // Array de informacion
    $arrayClient = array(
      'nombre' => strtoupper($nombre),
      'apellido1' => strtoupper($ap_paterno),
      'apellido2' => strtoupper($ap_materno),
      'genero' => $genero,
      'fechamod' => date('Y-m-d H:i:s'),
      'idusuario' =>$this->session->user_id,
      'status' => 'A'  
    );

    $result = $this->document_model->createClient($arrayClient);
    echo(json_encode(array('status'=>$result)));
  }

  /**
   * Funcion para la seccion cliente [Informacion]
  **/
  public function cliente($id)
  {
    // Buscar la informacion del cliente
    $data["Idcliente"] = $id;
    $this->load->model('document_model');

    $data["documentInfo"] = $this->document_model->infoDocumento($id);
    $data["clientInfo"] = $this->document_model->infoCliente($id);
    $data['tipos_documentos'] = $this->document_model->getTipoDocumento();
    $data['tipos_productos'] = $this->document_model->getTipoProducto();

    $this->load->view('header');
    $this->load->view('document/cliente', $data);
    $this->load->view('footer');

  }

  /**
   * Funcion para subir documentos del cliente
   *
  **/
  public function uploadDocument()
  {
    $this->load->model("document_model");
    
    // Obtener los datos de la tabla del documento
    $tipo_documento = $this->input->post('tipo_documento');
    $tipo_producto = $this->input->post('tipo_producto');
    $IdCliente = $this->input->post('IdCliente');

    // Numeros aleatorios
    $random = rand(1,100);

    // Extraccion de datos de la imagen
    $file = $_FILES['image']['name']; 
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    $nombre =pathinfo($file, PATHINFO_FILENAME);

    // Extensiones de imagenes permitidas
    $extensionesPermitidas = array("tif","tiff","TIF","TIFF","pdf","PDF");

    // Validar el tipo de imagen
    if(!in_array($extension, $extensionesPermitidas)) {
      echo(json_encode(array('status'=>'wrongFile'))); 
    }else{
      // Nuevo nombre
      $nuevo_nombre = $nombre.$random.".".$extension; 

      $config['upload_path'] = './assets/IMGS/';
      $config['allowed_types'] = 'tif|tiff|pdf';
      $config['max_size'] = 0;
      $config['file_name'] = $nuevo_nombre;

      $this->load->library('upload', $config);

      if (!$this->upload->do_upload('image')) {
        $error = array('error' => $this->upload->display_errors());
        echo json_encode($error);
      } else {
        $data = array("upload_data" => $this->upload->data());
        $extension = $data['upload_data']['file_ext'];
        $nombre = $data['upload_data']['raw_name'];

        $datos  = array(
          'Idcliente' => $IdCliente,
          'iddocumento' => $tipo_documento,
          'idproducto' => $tipo_producto,
          'pathImg' => $nombre.$extension,
          'numimgs' => '0',  
          'status' => 'A'
        );

        $result = $this->document_model->uploadDocument($datos);
        echo(json_encode(array('status'=>'ok'))); 
      }
    }
  }

  /**
   *Funcion para forzar la descarga de archivos
  **/
  public function download($nombre_doc)
  {
    // Cargar el modelo
    $this->load->model('document_model');

    // Cargar la libreria 
    $this->load->helper('download');

    // Obtener la informacion 
    $fileInfo = $this->document_model->download(array('nombre_doc' => $nombre_doc));

    // Recorrer la informacion
    foreach ($fileInfo as $value) {
      // var_dump($value->pathImg);
      $file = './assets/IMGS/'.$value->pathImg;
      if(file_exists($file)){
        // Descargar el archivo desde el directorio
        force_download($file, NULL);
      }
    }
  }
}