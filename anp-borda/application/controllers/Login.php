<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends MY_Controller
{

  	public function __construct()
	{
	    parent::__construct();	
	    $id_pengguna	= $this->session->userdata('id_pengguna');
	    $username 		= $this->session->userdata('username');
	    $id_role		= $this->session->userdata('id_role');
		if (isset($id_pengguna, $username, $id_role))
		{
			switch ($id_role) 
			{
				case 1:
					redirect('admin');
					break;

				case 2:
				case 3:
					redirect('decision-maker');
					break;
			}

		}
  	}


  	public function index()
  	{
  		if ($this->POST('submit'))
		{
			$this->load->model('Pengguna_m');
			$pengguna = Pengguna_m::has('role')
							->where('username', $this->POST('username'))
							->where('password', md5($this->POST('password')))
							->first();
			if (!isset($pengguna)) 
			{
				$this->flashmsg('Email atau password salah','danger');
			}
			else
			{
				$_SESSION['id_pengguna']	= $pengguna->id;
				$_SESSION['username']		= $pengguna->username;
				$_SESSION['id_role']		= $pengguna->id_role;
				$_SESSION['role']			= $pengguna->role->role;
			}
			redirect('login');
		}
		$this->data['title']  = 'Login';
		$this->load->view('login', $this->data);
	}
}
