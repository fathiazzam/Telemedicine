 <?php
defined('BASEPATH') OR exit('No direct script access allowed');

class C_notif extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('M_notif');
	}
	public function index(){
		$cek = $this->M_notif->check();
		echo json_encode($cek);
	}

	function call($id = null){
		$input = $this->input->post();
		$data = array('caller' => $this->session->id, 'receiver' => $id, 'video' => $input['video']);
		$replay = $this->M_notif->call($data);
		echo json_encode($replay);
	}
	function check_call(){
		$check = $this->M_notif->check_call($this->session->id);
		if ($check != null) {
			echo json_encode($check);
		}else echo json_encode(null);
	}

	function check_receive(){
		$id_call = $this->input->post();
		$replay = $this->M_notif->check_receive($id_call['id_call']);
		if ($replay['status'] == 2){
			echo json_encode($replay);
		}elseif ($replay['status'] == 0) {
			$id = $this->session->id;
        	$username = $this->session->username;
        	$this->session->set_userdata(array(
			'id' => $id,
			'username' => $username,
			'status' => 0
		));
			echo json_encode($replay['status']);
		}else echo json_encode(null);
	}

	function receive(){
		$id_call = $this->input->post();
		$replay = $this->M_notif->receive($id_call['id_call']);
		echo json_encode($replay);
	}
	function cancel(){
		$id = $this->session->id;
        $username = $this->session->username;
        $this->session->set_userdata(array(
			'id' => $id,
			'username' => $username,
			'status' => 0
		));
		$id_call = $this->input->post();
		$replay = $this->M_notif->cancel($id_call['id_call']);
		echo json_encode(0);
	}
	function chat(){
		$id = $this->input->post();
		$phone = $this->M_notif->chat($id['id']);
		echo json_encode($phone);
	}
}