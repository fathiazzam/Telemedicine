	<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Login extends CI_Controller {

		function __construct(){
			parent::__construct();
			$this->load->model('M_user');
		}
		function phpAlert($msg) {
			echo '<script type="text/javascript">alert("' . $msg . '")</script>';
		}
		public function login(){
			$username = $this->input->post('username');
	        $pass = $this->input->post('password');
			$cek = $this->M_user->login($username, $pass);
			if ($cek == 1) {
				$id = $this->M_user->id($username);
				$this->session->set_userdata(array(
				'id' => $id,
				'username' => $username
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
			$username = $this->input->post('username','required');
	      	$email = $this->input->post('email','required','valid_email');
	      	$pass = $this->input->post('password','required');
	      	$password = md5($pass);
	      	$fullName = $this->input->post('name','required');
	      	$gender = $this->input->post('gender','required');
	      	$phone = $this->input->post('phone','required');
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
	      	print_r('data');
	      	$check=$this->M_user->check($data['email'], $data['username']);
	      	if($check){
	      		$this->M_user->register($data);
	      		$this->session->set_flashdata('success_msg', 'Registered successfully.Now login to your account.');
	      		redirect('login');
	      	}else{
	      		// $message = "Username/email telah terdaftar";
	      		// echo "<script type='text/javascript'>alert('$message');</script>";
	      		$this->session->set_flashdata('error_msg', 'Error occured,Try again.');
	      		redirect('register');
	      	}
		}
		function logout()
		{
			$this->M_user->logout($this->session->id);
			session_destroy();
	 		redirect(base_url());
		}
	}