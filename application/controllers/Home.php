<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	function __construct()
	{
		parent::__construct();

		if(!isset($_SESSION['user_id'])) {
            $this->session->set_flashdata('flash_data', 'You don\'t have access!');
            return redirect('login');
        }
        $this->load->helper('url');
		$this->load->model('data_model');
		$this->load->library('permission');
		
	}

	public function index()
	{
		//$data['page'] = 'sitio/home';
		//$this->load->view('usuario/layout', $data);
		 $this->load->view('header');
           $this->load->view('sitio/index');
           $this->load->view('footer');
	}
	public function error404()
	{
		 
		$this->load->view('sitio/error404');
	}
/*
	public function users()
	{
		   Permission::grant(uri_string());
		   var_dump(uri_string());
		   $data['users'] = $this->data_model->users();
		   $this->load->view('header');
           $this->load->view('usuario/index', $data);
           $this->load->view('footer');
	}
		public function roles()
	{
		   Permission::grant(uri_string());
		   var_dump(uri_string());
		   $data['users'] = $this->data_model->users();
		   $this->load->view('header');
           $this->load->view('usuario/rol', $data);
           $this->load->view('footer');
	}

	public function user_crud($id = 0)
	{
		Permission::grant(uri_string());
		  var_dump(uri_string());
		if ($_POST) {
			$data = [
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'password' => md5($this->input->post('password')),
				'id' => $this->input->post('id'),
			];
			$this->data_model->user_crud($data);
			return redirect('home/users');
		}
		$data['page'] = 'user_form';
		if($id) {
			$data['user'] = $this->data_model->users($id);
		}
		$this->load->view('usuario/layout', $data);
	}

	public function user_delete($id)
	{
		Permission::grant(uri_string());
		$this->data_model->user_delete($id);
		return redirect('home/users');
	}

	public function permissions()
	{
		Permission::grant(uri_string());
		$data['permissions'] = $this->data_model->permissions();
		$data['page'] = 'permission';
		$this->load->view('/usuario/permission', $data);
	}

	public function permission_crud($id = 0)
	{
		Permission::grant(uri_string());
		var_dump(uri_string());
		if ($_POST) {
			$data = [
				'uri' => $this->input->post('uri'),
				'pu_id' => $this->input->post('pu_id'),
				'permission_id' => $this->input->post('permission_id'),
				'user_id' => $this->input->post('user_id'),
			];
			$this->data_model->permission_crud($data);
			return redirect('home/permissions');
		}
		$data['page'] = '/usuario/permission_form';
		if($id) {
			$data['permission'] = $this->data_model->permissions($id);
		}
		$data['users'] = $this->data_model->users();
		$this->load->view('/usuario/layout', $data);
	}

	public function permission_delete($id)
	{
		Permission::grant(uri_string());
		$this->data_model->permission_delete($id);
		return redirect('home/permissions');
	}
	*/
}
