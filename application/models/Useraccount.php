<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Useraccount extends CI_Model {

	function __constructor(){
		parent::__constructor();
		$this->load->model('Useraccount');
	}

	//inserting new data for registration
	public function create($data){
		$accountdata = array(
			'username' => $data['username'],'password' => $data['password'],
			'usertype' => $data['usertype'],'status' => '1'
		);
		$this->db->insert('accounts',$accountdata);
		if ($data['usertype']=='1') {
			$accountid = $this->db->select('Accountid')->from('tblstaff')->where('department',Null)->get()->row()->Accountid;
			$staffdata = array(
				'Firstname' => $data['firstname'],'Middlename' => $data['middlename'],
				'Lastname' => $data['lastname'],'Gender' => $data['gender'],
				'Email' => $data['email'],'Department' => $data['department']	
			);
			return $this->db->where('Accountid',$accountid)->update('tblstaff',$staffdata);	
		}
		else if ($data['usertype']=='2') {
			$accountid = $this->db->select('Accountid')->from('tblstudent')->where('department',Null)->get()->row()->Accountid;
			$studentdata = array(
				'Firstname' => $data['firstname'],'Middlename' => $data['middlename'],
				'Lastname' => $data['lastname'],'Gender' => $data['gender'],
				'Email' => $data['email'],'Department' => $data['department'],
				'DoB' => $data['dob'],'PhoneNumber' => $data['phonenumber']	
			);
			return $this->db->where('Accountid',$accountid)->update('tblstudent',$studentdata);	
		}
	}
	public function read($data){
		
	}
	//checking account for login with session
	public function checkaccount($data){
		$user = array(
			'name' =>$data['username'],
			'usertype' => null
		);
		$query = $this->db->query($this->db->select('Usertype')->from('accounts')->where('username',$data['username'])->where('password',$data['password'])->get_compiled_select());
		if ($query->row()!=null) {
			$user['usertype'] = $query->row()->Usertype;
			$this->session->set_userdata($user);
			return ($user['usertype']);
		}
		else{
			return 0;
		}
	}
	//id for account setup data
	public function get_account_id(){
		return $this->db->select('id')->from('accounts')->where('username',$_SESSION['name'])->where('usertype',$_SESSION['usertype'])->get()->row()->id;
	}
	public function get_student_id(){
		$account_id = $this->Useraccount->get_account_id();
		return $this->db->select('*')->from('tblstudent')->where('Accountid',$account_id)->get()->row()->id;
	}
	public function get_staff_id(){
		$account_id = $this->Useraccount->get_account_id();
		return $this->db->select('*')->from('tblstaff')->where('Accountid',$account_id)->get()->row()->id;
	}
	//return name for every login
	public function getname(){
		$id = $this->Useraccount->get_account_id();
		if($_SESSION['usertype']=='1'){
			return $this->db->select('*')->from('tblstaff')->where('Accountid',$id)->get()->row()->Firstname;
		}
		else if($_SESSION['usertype']=='2'){
			return $this->db->select('*')->from('tblstudent')->where('Accountid',$id)->get()->row()->Firstname;
		}
		else{
			return "Admin";
		}
	}
	public function update($data){
			
	}
	private function delete(){

	}
	public function createSched($data){
		$staff_id=$this->Useraccount->get_staff_id();
		$this->db->query('insert into staff_schedule(Staff_id)values('.$staff_id.')');
		$date_id=$this->db->select('id')->from('date')->where('Sched_date',Null)->get()->row()->id;
		$this->db->set('Sched_date',$data['Date'])->set('Time_start',$data['Time_Start'])->set('Time_end',$data['Time_End'])->where('id',$date_id)->update('date');
	}
	public function getRequest(){
		$staff_id=$this->Useraccount->get_staff_id();
		$query = $this->db->query('call view_request_by_id_and_status('.$staff_id.',4)');
		return $query->result();
	}
	public function acceptRequest($id){
		$data = array();
		$hour = 0;$min =0;$hour1 = 0;$min1 =0;
		$query = $this->db->query('SELECT (SELECT Sched_date FROM date WHERE Sched_id=r.Sched_id) as Date,(SELECT Time_start FROM date WHERE Sched_id=r.Sched_id) as Time_start,(SELECT Student_Limit FROM staff_schedule WHERE id=r.Sched_id) as Student_limit,(select count(id) FROM request where Sched_id=r.Sched_id and Status_id=1) as numres FROM request r WHERE r.id='.$id['id'].'');
		$id1=$id['id'];
		$addtime = (15)*(1+$query->row()->numres);
		$addtime1 = (15)*($query->row()->numres);
		$date = $query->row()->Date;
		$timestart = $query->row()->Time_start;
		if($addtime>59){
			$hour = intval($addtime/60);
			$min = ($hour-($addtime/60))*100;
			$hour1 = intval($addtime1/60);
			$min1 = ($hour-($addtime1/60))*100;
		}
		else{
			$min=$addtime;$min1=$addtime1;
		}
		$addstart = ''.$hour1.':'.$min1.'';
		$addend = ''.$hour.':'.$min.'';
		$this->db->query('update request set Status_id=1 where id='.$id['id'].'');
		$this->db->query('call create_appointments(\''.$id1.'\',\''.$date.'\',\''.$timestart.'\',\''.$addstart.'\',\''.$addend.'\')');
	}
	public function viewAppointment($data){
		$id =$this->Useraccount->get_staff_id();
		return $this->db->query('call view_apointments_by_id_and_date('.$id.',\''.$data['date'].'\')')->result();
	}
	public function changeStatus($data){
		$this->db->set('Status_id',$data['status'])->where('id',$data['id'])->update('request');
	}
	public function getNames($data)
	{
		$query = $this->db->query('call view_staff_by_department('.$data.')');
		$output = '<option value=0>----Select Staff----';
		foreach ($query->result() as $row) {
			$output .='<option value='.$row->id.'>'.$row->Lastname.' , '.$row->Firstname.'';
		}
		return $output;
	}
	public function getTime($data){
		return $this->db->query('call view_time_by_dateandstaffid('.$data['id'].',\''.$data['date'].'\')')->result();
	}
	public function submitRequest($data){
		$datas = array(
				'Student_id'=>$this->Useraccount->get_student_id(),'Reason'=>$data['Reason'],'Sched_id'=>$data['reqtime'],'Status_id'=>'4'
				);
		$this->db->insert('request',$datas);
	}
	public function getAppointment($data){
		$id = $this->Useraccount->get_student_id();
		return $this->db->query('call show_appointment_by_stud_idate('.$id.',\''.$data['date'].'\')')->result();
	}
	public function viewSched($data){
		$id = $this->Useraccount->get_staff_id();
		return $this->db->query('call view_sched_by_staff_id_and_date('.$id.',\''.$data['date'].'\')')->result();
	}
	public function studentInfo($data){
		return $this->db->query('call view_status_by_stud_id('.$data['id'].')')->result();
	}
	public function accountInfo(){
		$id =$this->Useraccount->get_staff_id();
		return $this->db->query('call view_status_by_staff_id('.$id.')')->result();
	}
	public function updateAccStaff($data){
		$id = $this->Useraccount->get_staff_id();
		$this->db->set('Firstname',$data['firstname'])->set('middlename',$data['Time_Start'])->set('Lastname',$data['lastname'])->set('Email',$data['email'])->where('id',$id)->update('tblstaff');
	}
}
