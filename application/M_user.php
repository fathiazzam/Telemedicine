<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class M_user extends CI_Model {
  function __construct()
  {
    parent::__construct();
  }
    function login($username, $pass) {
       $password = md5($pass);
       $where=array(
       	'username' => $username,
       	'password' => $password 
       );

       $cek=$this->db->get_where('users',$where)->num_rows();
       if ($cek == 1) {
        $data = array('status' => 1 );
        $this->db->update('users', $data, array('username' => $username));
       }
       return $cek;
       
    }
    function id($username){
      $where = array(
        'username' => $username
      );
      $id = $this->db->get_where('users',$where)->row_array();
      return $id['user_id'];
    }
    function register($data){      
      $this->db->insert('users', $data);
      redirect('login/login');
    }
    public function check($email, $username){
      $emailc = $this->db->query('select * from users where email=?', $email);
      $user = $this->db->query('select * from users where username=?', $username);
      $rowEmail = $emailc->row();
      $rowUser = $user->row();
      if($rowEmail == null){
        if ($rowUser == null) {
          return true;
        }else {
          return false;
        }
      }else {
        return false;
      }
    }
    function logout($user){
      $data = array('status' => 0 );
      $this->db->update('users', $data, array('user_id' => $user));
    }
}