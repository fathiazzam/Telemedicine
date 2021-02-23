<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_videocall extends CI_Controller {
	public function index()
	{
		if ($this->session->id == '') {
        	redirect(base_url());
        }
        $id = $this->session->id;
        $username = $this->session->username;
        $this->session->set_userdata(array(
			'id' => $id,
			'username' => $username,
			'status' => 1
		));
		$this->load->view('templ/header');
		$this->load->view('video_call');
		$this->load->view('templ/footer');		
	}
	function voice()
	{
		if ($this->session->id == '') {
        	redirect(base_url());
        }
		$this->load->view('templ/header');
		$this->load->view('voice_call');
		$this->load->view('templ/footer');		
	}
}
