<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_user extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('M_user');
	}
	public function login(){
		$username = $this->input->post('username');
        $pass = $this->input->post('password');
		$cek = $this->M_user->login($username, $pass);
		if ($cek == 1) {
			$id = $this->M_user->id($username);
			$this->session->set_userdata(array(
			'id' => $id,
			'username' => $username,
			'status' => 0
		));
       	redirect('home');
       	}else{       	
       	redirect('login');
       }
	}
	public function index() {
		if($this->session->userdata()==null){
            $this->session->set_userdata(array(
                  'id' => '',
        	));
        	
        }elseif ($this->session->id != '') {
        	redirect('home');
        }
        $this->load->view('templ/header');
		$this->load->view('login_page');
		$this->load->view('templ/footer');
		
	}
	function onClickRegister(){
		if ($this->session->id != '') {
        	redirect('home');
        }
		$this->load->view('templ/header');
		$this->load->view('register');
		$this->load->view('templ/footer');		
	}
	function register(){
		$username = $this->input->post('username');
      	$email = $this->input->post('email');
      	$pass = $this->input->post('password');
      	$password = md5($pass);
      	$fullName = $this->input->post('name');
      	$gender = $this->input->post('gender');
      	$phone = $this->input->post('phone');
      	$data = array(
        	'username' => $username,
        	'email' => $email,
        	'password' => $password,
        	'fullName' => $fullName,
        	'gender' => $gender,
        	'phone' => $phone,
        	'autho' => 2,
        	'status' => 0
      	);
		$this->M_user->register($data);
	}
	function logout()
	{
		$this->M_user->logout($this->session->id);
		session_destroy();
 		redirect(base_url());
	}
}