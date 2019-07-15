<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function build() {
        if($this->session->userdata('logged')) {
            $query = $this->db->query("SELECT * FROM users WHERE userId = ?", array($this->session->userdata('id')));

            $row = $query->row();

            $this->isAdmin();
            $this->session->set_userdata('name', $row->NAME);
            $this->session->set_userdata('email', $row->EMAIL);
            $this->session->set_userdata('zip', $row->POSTAL);
            $this->session->set_userdata('country', $row->COUNTRY);
            $this->session->set_userdata('city', $row->CITY);
            $this->session->set_userdata('address', $row->ADDRESS);
            $this->session->set_userdata('password', $row->PASSWORD);   
        }
    } 

    public function isAdmin() {
        $query = $this->db->query("SELECT * FROM admins WHERE userId = ?", array($this->session->userdata('id')));

        if($query->num_rows() == 1) {
            $this->session->set_userdata('admin', true);
        } else {
            $this->session->set_userdata('admin', false);
        }
    }

    public function getLastId() {
        $query = $this->db->query("SELECT * FROM users ORDER BY userId DESC");
        if($query->num_rows() > 0) {
            return $query->row()->USERID + 1;
        } else {
            return 0;
        } 
    }

    public function register() {
        $id = $this->getLastId();
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $sql = "INSERT INTO users (userId, name, email, password) VALUES (?, ?, ?, ?)";
        $query = $this->db->query($sql, array($id, $name, $email, $password));

        if($this->db->affected_rows() == 1) {
            $this->session->set_userdata('logged', true);
            $this->session->set_userdata('id', $id);
            
            return true;
        } 
        
        return false;
    }

    public function login() {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $sql = "SELECT * FROM users WHERE email = ? AND password = ?";
        $query = $this->db->query($sql, array($email, $password));

        if($query->num_rows() == 1) {
            $this->session->set_userdata('logged', true);
            $this->session->set_userdata('id', $query->row()->USERID);

            return true;
        }

        return false;
    }

    public function updateProfile() {
        $address = $this->input->post('address');
        $country = $this->input->post('country');
        $city = $this->input->post('city');
        $zip = $this->input->post('zip');

        $data = array(
            'ADDRESS' => $address,
            'COUNTRY' => $country,
            'CITY' => $city,
            'POSTAL' => $zip
        );
    
        $this->db->where('USERID', $this->session->userdata('id'));
        $this->db->update('USERS', $data);
    }
}