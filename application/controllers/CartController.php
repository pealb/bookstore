<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CartController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->Model('Cart');
    }

    public function addBookToCart() {         
        echo $this->Cart->addBookToCart(); 
    }
/*
    public function listCartItems() {
        $this->load->model('Book');

        $items = $this->Cart->listCartItems();
        
        $items = $this->Book->fetchAuthors($items);
    
        return $items;
    }*/

    public function order() {
        if($this->Cart->order()){
            $this->session->unset_userdata('cartSize');
            $this->session->unset_userdata('cartBooks');
            redirect('/home', 'refresh');
        }

        echo "Hiba!";
    }

    public function removeItem() {
        echo $this->Cart->removeItem();
    }
}