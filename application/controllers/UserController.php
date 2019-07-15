<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserController extends CI_Controller {

    public function login() {
        if($this->User->login()) {
            $this->User->build();
            redirect('/home', 'refresh');
        } else {
            echo "Hiba!";
        }
    }

    public function register() {
        $password = $this->input->post('password');
        $repassword = $this->input->post('re-password');
    
        if($password === $repassword) {
            if($this->User->register()) {
                $this->User->build();
                redirect('/home', 'refresh');
            }       
        }
        echo "Hiba!";
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('/home', 'refresh');
    }

    public function updateProfile() {
        $this->User->updateProfile();
        $this->User->build();
        redirect('/profile', 'refresh');
    }
}