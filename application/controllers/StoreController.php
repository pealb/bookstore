<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class StoreController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Store');
    }

    public function index() {
        if($this->session->userdata('logged') && $this->session->userdata('admin')) {
            $stores = $this->Store->listStores();

            $this->load->view('templates/header', array('title' => 'Admin Panel - Áruházak'));
            $this->load->view('templates/navbar');
            $this->load->view('admin/stores', array('stores' => $stores));
            $this->load->view('templates/footer');
        } else {
            redirect('/home', 'refresh');
        }
    }

    public function addStore() {
        if($this->Store->addStore()) {
            redirect('/admin/stores', 'refresh');
        } else {
            echo "Hiba!";
        }
    }

    public function getPriceFromStoreByIsbn() {
        echo json_encode($this->Store->getPriceFromStoreByIsbn());
    }

    public function updateBookStore($isbn) {
        if($this->Store->updateBookStore($isbn)) {
            redirect('/home', 'refresh');
        }
        else {
            echo "Hiba!";
        }
    }

    public function deleteStore() {
        if($this->input->is_ajax_request()) {
            if($this->Store->deleteStore()) {
                $response_array['status'] = 'success';
            }
            else {
                $response_array['status'] = 'error';
            }

            echo json_encode($response_array);
            exit();
        }

        redirect('/home', 'refresh');
    }
}