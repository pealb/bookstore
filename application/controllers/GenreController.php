<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class GenreController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Genre');
    }

    public function index() {
        if($this->session->userdata('logged') && $this->session->userdata('admin')) {
            $genres = $this->Genre->listGenres();
            $subgenres = $this->Genre->listSubgenres();

            $this->load->view('templates/header', array('title' => 'Admin Panel - Kategóriák & Alkategóriák'));
            $this->load->view('templates/navbar');
            $this->load->view('admin/genres', array('genres' => $genres, 'subgenres' => $subgenres));
            $this->load->view('templates/footer');
        } else {
            redirect('/home', 'refresh');
        }
    }

    public function addGenre() {
        if($this->Genre->addGenre()){
            redirect('admin/genres', 'refresh');
        }

        echo "Hiba!";
    }

    public function addSubgenre() {
        if($this->Genre->addSubgenre()){
            redirect('admin/genres', 'refresh');
        }

        echo "Hiba!";
    }

    public function listSubgenresByGenreId() {
        if($this->input->is_ajax_request()) {
            $subgenres = $this->Genre->listSubgenresByGenreId();

            $subgenreid = $this->input->post('subgenreid');

            $response = "<option value=".(-1)." selected>Válassz alkategóriát</option>";

            foreach($subgenres as $subgenre) {
                if($subgenre->SUBGENREID == $subgenreid) {
                    $response = $response."<option value=".$subgenre->SUBGENREID." selected>".$subgenre->NAME."</option>";
                }
                else {
                    $response = $response."<option value=".$subgenre->SUBGENREID.">".$subgenre->NAME."</option>";
                }
                
            }

            echo $response;
        }
        else {
            redirect('/home', 'refresh');
        }
        
    }

    public function deleteSubgenre() {
        if ($this->input->is_ajax_request()) {
            if($this->Genre->deleteSubgenre()) {
                $response_array['status'] = 'success';
            } else {
                $response_array['status'] = 'error';
            }
    
            echo json_encode($response_array);
            exit();
        }

        redirect('/admin/books', 'refresh');     
    }

    public function deleteGenre() {
        if ($this->input->is_ajax_request()) {
            if($this->Genre->deleteGenre()){
                $response_array['status'] = 'success';
            } else {
                $response_array['status'] = 'error';
            }
    
            echo json_encode($response_array);
            exit();
        }

        redirect('/admin/books', 'refresh'); 
    }
}