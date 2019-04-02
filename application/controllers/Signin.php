<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Signin extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('Useraccount');
	}

	function index()
	{	
		$data['errormsg'] = '';
		$data['numarr'] = count($_SESSION);
		if ($data['numarr']!='1') {
			redirect('account');
		}
		else{
			$this->load->view('Login',$data);
		}
	}

	public function register()
	{
		redirect('Signup');	
	}
	public function login(){		
		if($_POST!=null){
			if ($this->Useraccount->checkaccount($_POST)!=0){
				redirect(base_url('Signin'));
			}
			else{
				$data['errormsg'] = 'Wrong Input Fields!';
				$this->load->view('Login',$data);
			}
		}
		else{
			redirect(base_url('Signin'));
		}	
	}
	
}	
