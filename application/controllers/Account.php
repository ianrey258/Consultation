<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Account extends CI_Controller {
	
	function __construct(){
		parent::__construct();
		$this->load->model('Useraccount');
	}

	public function index()
	{	
		$data['name'] = $this->Useraccount->getname();
		if($_SESSION['usertype']=='1'){
			$data['content']='staff/Dashboard';			
			$this->load->view('staff/Staff',$data);
		}
		else if($_SESSION['usertype']=='2'){
			$this->load->view('student/Student',$data);
		}
		else if($_SESSION['usertype']=='3'){
			$this->load->view('admin/Admin');
		}
		else{
			redirect(base_url('Signin'));
		}
	}
	public function inbox()
	{
		$data['name'] = $this->Useraccount->getname();
		$data['content']='staff/Inbox';			
		$this->load->view('staff/Staff',$data);
	}
	public function appointment()
	{
		$data['name'] = $this->Useraccount->getname();
		$data['content']='staff/Appointment';			
		$this->load->view('staff/Staff',$data);
	}
	public function schedule()
	{
		$data['name'] = $this->Useraccount->getname();
		$data['content']='staff/Schedule';			
		$this->load->view('staff/Staff',$data);
	}
	public function SDash()
	{
		$data['name'] = $this->Useraccount->getname();
					$data['content']='student/Dashboard';
		$this->load->view('student/Student',$data);
	}
	public function Sinbox()
	{
		$data['name'] = $this->Useraccount->getname();
					$data['content']='student/FacultySchedule';
		$this->load->view('student/Student',$data);
	}
	public function Sappointment()
	{
		$data['name'] = $this->Useraccount->getname();
					$data['content']='student/STAppointment';
		$this->load->view('student/Student',$data);
	}
	public function logout()
	{
		session_destroy();
		redirect('Signin');
	}
	public function createSched(){
		$this->Useraccount->createSched($_POST);
		redirect(base_url('Account/schedule'));
	}
	public function viewRequest(){
		echo json_encode($this->Useraccount->getRequest());
	}
	public function submitRequest(){
		$this->Useraccount->acceptRequest($_POST);
	}
	public function viewAppointment(){
		echo json_encode($this->Useraccount->viewAppointment($_POST));
	}
	public function decline_or_postpone(){
		$this->Useraccount->changeStatus($_POST);
	}
	public function getTime(){
		echo json_encode($this->Useraccount->getTime($_POST));
	}
	public function requesting(){
		$this->Useraccount->submitRequest($_POST);
		redirect(base_url('Account/Sappointment'));
	}
	public function loadNames()
	{
		echo json_encode($this->Useraccount->getNames($_POST['id']));
	}
	public function studentAppointment(){
		echo json_encode($this->Useraccount->getAppointment($_POST));
	}
	public function viewSched(){
		echo json_encode($this->Useraccount->viewSched($_POST));
	}
	public function studentInfo(){
		echo json_encode($this->Useraccount->studentInfo($_POST));
	}
	public function accountInfo(){
		echo json_encode($this->Useraccount->accountInfo());
	}
	public function updateAccStaff(){
		$this->Useraccount->updateAccStaff($_POST);
		redirect(base_url('Account'));
	}
}
?>