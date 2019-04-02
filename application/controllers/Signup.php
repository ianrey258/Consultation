<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signup extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('Useraccount');
		$this->load->model('Registration');
	}
	function index()
	{
		$this->load->view('Registration/Registration');
	}

	public function login()
	{
		redirect(base_url('Signin'));
	}
	//inserting new data with rules validation with session
	public function register()
	{
		if ($this->form_validation->run('signup')){
			if($this->Useraccount->create($_POST)){
				$user = array(
					'name' => $_POST['username'],
					'usertype' => $_POST['usertype']
				);
				$this->session->set_userdata($user);
				redirect('Signin');
			}
		}
		else{
			$this->load->view('Registration/Registration');
		}
	}
	public function loadCollege()
	{
		echo json_encode($this->Registration->getCollege());
	}
	public function loadDepartment()
	{
		echo json_encode($this->Registration->getDepartment($_POST['id']));
	}
}
