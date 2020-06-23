<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('login_model');
        $this->load->model('calendar_model');  

    }

	public function index()
	{
     if($this->session->user_id) {
            $this->load->view('header');
            $this->load->view('sitio/index');
            $this->load->view('footer');
            //return redirect('sitio/index');
        }else if($_POST) { 

            $data = [
                'usuario' => $this->input->post('usuario'),
                'password' => md5($this->input->post('password')),
            ];
            $result = $this->login_model->login($data);
           
            if(!empty($result)) {
                $this->session->set_userdata([
                    'user_id' => $result->id,
                    'idusuario' => $result->idusuario,
                    'usuario' => $result->usuario,
                    'name' => $result->name,
                    'rol' => $result->rol,
                    'imagen' => $result->imagen
                ]);

                $this->load->view('header');
                $this->load->view('sitio/index');
                $this->load->view('footer');
            } else {
				 
                $this->session->set_flashdata('err', 'Usuario o Contraseña Incorrecto.');
                $this->load->view('usuario/login');
            }
        
       
    }
    else{
      $this->load->view('usuario/login');
    }
      
  
	}
	
 
	public function logout() {  
      // creamos un array con las variables de sesión en blanco
    $datasession = array('usuario_id' => '', 'logged_in' => '');
    // y eliminamos la sesión
    $this->session->unset_userdata($datasession);
    // redirigimos al controlador principal 
    $logout=$this->session->sess_destroy();
    
      redirect('login');
       
       
    }

    public function get_events()
 {
     // Our Start and End Dates
     $start = $this->input->get("start");
     $end = $this->input->get("end");
     $iduser= $this->session->user_id;
     $startdt = new DateTime('now'); // setup a local datetime
     $startdt->setTimestamp($start); // Set the date based on timestamp
     $start_format = $startdt->format('Y-m-d H:i:s');

     $enddt = new DateTime('now'); // setup a local datetime
     $enddt->setTimestamp($end); // Set the date based on timestamp
     $end_format = $enddt->format('Y-m-d H:i:s');

     $events = $this->calendar_model->get_events($start_format, $end_format,$iduser); 
     echo json_encode(array("events" => $events));
     exit();
 }

public function add_event() 
{
    /* Our calendar data */
    $name = $this->input->post("name");
    $desc = $this->input->post("description");
    $start_date = $this->input->post("start_date");
    $end_date = $this->input->post("end_date"); 
    $iduser= $this->session->user_id;
    if(!empty($start_date)) {
       $sd = DateTime::createFromFormat("Y-m-d", $start_date);
       $start_date = $sd->format('Y-m-d H:i:s');
       $start_date_timestamp = $sd->getTimestamp();
    } else {
       $start_date = date("Y-m-d H:i:s", time());
       $start_date_timestamp = time();
    }

    if(!empty($end_date)) {
       $ed = DateTime::createFromFormat("Y-m-d", $end_date);
       $end_date = $ed->format('Y-m-d H:i:s');
       $end_date_timestamp = $ed->getTimestamp();
    } else {
       $end_date = date("Y-m-d H:i:s", time());
       $end_date_timestamp = time();
    }

    $this->calendar_model->add_event(array(
       "iduser" => $iduser,
       "title" => $name,
       "description" => $desc,
       "start" => $start_date,
       "end" => $end_date
       )
    );

    redirect(site_url("login"));
}
public function edit_event()
     {
          $eventid = intval($this->input->post("eventid"));
          $event = $this->calendar_model->get_event($eventid);
          if($event->num_rows() == 0) {
               echo"Invalid Event";
               exit();
          }

          $event->row();

          /* Our calendar data */
          $name = $this->input->post("name");
          $desc = $this->input->post("description");
          $start_date = $this->input->post("start_date");
          $end_date = $this->input->post("end_date");
          $delete = intval($this->input->post("delete"));
          $iduser= $this->session->user_id;
          
          if(!$delete) {

               if(!empty($start_date)) {
                    $sd = DateTime::createFromFormat("Y-m-d", $start_date);
                    $start_date = $sd->format('Y-m-d H:i:s');
                    $start_date_timestamp = $sd->getTimestamp();
               } else {
                    $start_date = date("Y-m-d H:i:s", time());
                    $start_date_timestamp = time();
               }

               if(!empty($end_date)) {
                    $ed = DateTime::createFromFormat("Y-m-d", $end_date);
                    $end_date = $ed->format('Y-m-d H:i:s');
                    $end_date_timestamp = $ed->getTimestamp();
               } else {
                    $end_date = date("Y-m-d H:i:s", time());
                    $end_date_timestamp = time();
               }

               $this->calendar_model->update_event($eventid, array(
                   "iduser" => $iduser,
                    "title" => $name,
                    "description" => $desc,
                    "start" => $start_date,
                    "end" => $end_date,
                    )
               );

          } else {
               $this->calendar_model->delete_event($eventid);
          }

          redirect(site_url("login"));
     }
}
