<?php
	$config = array(
	'signup' => array(
		array(
			'field' => 'username',
            'label' => 'Username',
            'rules' => 'required|is_unique[accounts.Username]',
            'message' => 'is_unique',"%s already exist."
            
		),
		array(
			'field' => 'firstname',
            'label' => 'First Name',
            'rules' => 'required'
		),
		array(
			'field' => 'middlename',
            'label' => 'Middle Name',
            'rules' => 'required'
		),
		array(
			'field' => 'lastname',
            'label' => 'Last Name',
            'rules' => 'required'
		),
		array(
			'field' => 'password',
            'label' => 'Password',
            'rules' => 'required|min_length[6]|alpha_dash'
		),
		array(
			'field' => 'conpassword',
            'label' => 'Confirm Password',
            'rules' => 'required|matches[password]'
		),
		array(
			'field' => 'email',
            'label' => 'Email',
            'rules' => 'required'
		)
	)
);
?>
