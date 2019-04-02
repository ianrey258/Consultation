<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Registration extends CI_Model {

	function __constructor(){
		parent::__constructor();

	}

	public function getCollege()
	{
		$query = $this->db->get('college');
		$output = '<option value=0>----Select College----';
		foreach ($query->result() as $row) {
			$output .='<option value='.$row->id.'>'.$row->Collagename.'';
		}
		return $output;
	}
	public function getDepartment($data)
	{
		$result = $this->db->query('call show_department('.$data.')');
		$output = '<option value=0>----Select Department----';
		foreach ($result->result() as $row) {
			$output .='<option value='.$row->id.'>'.$row->Department.'';
		}
		return $output;
	}
}
?>