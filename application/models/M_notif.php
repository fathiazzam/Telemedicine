<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_notif extends CI_Model {    
  function __construct()
  {
    parent::__construct();
  }
  function check() {
    $data = $this->db->query('select user_id,fullName,status from users where autho=1');
    return $data->result_array();
  }

//caller
  function call($data){  	
  	$check = $this->db->query('select id_call from list_call where id_receiver = ? and status != 0', $data['receiver'])->num_rows();
  	if ($check != 0) {
  		return null;
  	}
  	$status = array('status' => 2);
  	$this->db->update('users', $status, array('user_id' => $data['receiver']));
  	$now = date("Y-m-d h:i:sa");
  	$data = array('id_caller' => $data['caller'], 'id_receiver' => $data['receiver'], 'time' => $now, 'status' => 1, 'video' => $data['video']);
  	$this->db->insert('list_call', $data);
  	$this->db->update('users', $status, array('user_id' => $this->session->id));
  	$replay = array(
  		'id_call' => $this->get_Idcall($data['id_caller']),
  		'fullName' => $this->check_FullName($data['id_receiver'])  		
  	);
  	return $replay;
  }

  function get_Idcall($id_caller){
  	$data = $this->db->query('select id_call from list_call where id_caller=? and status = 1',$id_caller)->row_array();
  	return $data;
  }

//check receive -> caller
  function check_receive($id){
  	$data = $this->db->query('select status,video from list_call where id_call=?', $id)->row_array();
  	return $data;
  }

  
//receiver

//check call in
  function check_call($id){
  	$data = $this->db->query('select id_call, id_caller from list_call where id_receiver=? and status = 1', $id);
  	if ($data->num_rows() == 1) {
  		$data = $data->row_array();
  		$replay = array(
  			'id_call' => $data['id_call'],
  			'fullName' => $this->check_FullName($data['id_caller'])
  		);
  		return $replay;
  	}return null;
  }

  function receive($id_call){
  	$data = array('status' => 2 );
  	$this->db->update('list_call', $data, array('id_call' => $id_call));
    $data = $this->db->query('select video from list_call where id_call=?', $id_call)->row_array();
    return $data;
  }

  

//cancel

  function cancel($id_call){
  	$data = array('status' => 0 );
  	$this->db->update('list_call', $data, array('id_call' => $id_call));
  	$call = $this->db->query('select id_caller,id_receiver from list_call where id_call=?', $id_call)->row_array();
  	$data = array('status' => 1 );
  	$this->db->update('users', $data, array('user_id' => $call['id_caller']));
  	$this->db->update('users', $data, array('user_id' => $call['id_receiver']));
  }

  function check_FullName($id){
  	$call = $this->db->query('select fullName from users where user_id=?', $id)->row_array();
  	return $call;
  }

  function chat($id){
    $phone = $this->db->query('select phone from users where user_id=?', $id)->row_array();
    return $phone;
  }

}