<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class BookController extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Book');
    }

    public function index() {
        if($this->session->userdata('logged') && $this->session->userdata('admin')) {
            $this->load->model('Genre');
            $this->load->model('Store');

            $genres = $this->Genre->listGenres();
            $stores = $this->Store->listStores();
            $books = $this->Book->listBooks();

            $this->load->view('templates/header', array('title' => 'Admin Panel - Könyvek'));
            $this->load->view('templates/navbar');
            $this->load->view('admin/books', array('books' => $books, 'genres' => $genres, 'stores' => $stores));
            $this->load->view('templates/footer');
        } else {
            redirect('/home', 'refresh');
        }
    }

    public function uploadBook() {
        $this->load->model('Book');
        $this->load->model('Author');
        
        if(!$this->Book->checkIfBookExists()) {
            $author = $this->input->post('author');
            $title = $this->input->post('title');
            $publishDate = $this->input->post('publishDate');
            $filename = strtolower(str_replace(' ', '_', $author)).'_'.strtolower(str_replace(' ', '_', $title)).'_'.$publishDate.date('Y-m-d-H-i-s');
            $filename = str_replace(',', '', $filename);
            $filename = str_replace('.', '', $filename);
            $filename = str_replace('?', '', $filename);

            $config['upload_path']          = realpath(APPPATH . '../assets/img/covers');
            $config['allowed_types']        = 'jpg|png|jpeg';
            $config['max_size']             = 100;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $config['file_name']            = $filename;
    
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
    
            if(!$this->upload->do_upload('customFile')) {
                echo $this->upload->display_errors();
            }
            else {   
                $authorIds = $this->Author->addAuthors();
                if($this->Book->upload($filename, $authorIds)) {
                   echo "A könyv bekerült az adatbázisba!";
                } else {
                    echo "A könyvet nem sikerült feltölteni az adatbázisba!";
                }
            }
        } else {
            echo "A könyv már létezik az adatbázisban!";
        }
    }

    public function listSubgenres() {
        if($this->input->is_ajax_request()) {
            $this->load->model('Genre');
            $subgenres = $this->Genre->listSubgenres();

            $response = "<option value=".(-1)." selected>Válassz alkategóriát</option>";

            foreach($subgenres as $subgenre) {
                $response = $response."<option value=".$subgenre->SUBGENREID.">".$subgenre->NAME."</option>";
            }

            echo $response;
        }
        else {
            redirect('/home', 'refresh');
        }
        
    }

    public function listBooksByStoreId() {
        if($this->input->is_ajax_request()) {
            $this->load->model('Book');

            $storeId = $this->input->post('storeId');
            $isbn = $this->input->post('isbn');
            
            $books = $this->Book->listBooksByStoreId($storeId);
            $filteredBooks = array();

            foreach($books as $book) {
                if($book->ISBN != $isbn) {
                    array_push($filteredBooks, $book);
                }
            }

            if(count($filteredBooks) == 0) {
                echo "<p class='text-center'>Nincsenek további könyvek a kiválasztott áruházban!</p>";
            }
            else {
                $this->respond($filteredBooks);
            } 
        }
        else {
            redirect('/home', 'refresh');
        }
          
    }

    public function filterBooks() {
        if($this->input->is_ajax_request()) {
            $this->load->model('Book');
            $books = $this->Book->filterBooks();
        
            $this->respond($books);
        }
        else {
            redirect('/home', 'refresh');
        }
        
    }

    private function respond($books) {
        $response = "";
        $response.='<div class="row d-flex justify-content-center">'; 
        $prev = null;        
        foreach($books as $book) { 
            if($book->ISBN == $prev) continue;
            $authors = $book->AUTHORS;
            $response.='<div class="col-lg-2 col-md-3 col-sm-4">';
            $response.='<div class="card text-center border-0" style="height: 400px">';
            $response.='<img class="mx-auto d-block" src="'.base_url('assets/img/covers/'.$book->COVERIMAGE.'.jpg').'" height="190" width="130">';
            $response.='<div class="card-body">';
            $response.='<p style="font-weight: bold; font-size: 14px; margin-bottom:5px;" class="card-title">'.$book->TITLE.'</p>';
            foreach($authors as $author) {
                if($author->AUTHORID != $authors[0]->AUTHORID) {
                    $response.='<span style="font-size: 12px;">, </span>';
                }
                $response.='<a href="'.base_url('author/'.$author->AUTHORID).'" class="card-text" style="display: inline-block; font-size: 14px;">'.$author->NAME.'</a>';
            }
            $response.='<br><a href="'.base_url('book/'.$book->ISBN).'" class="btn btn-primary" style="margin-top: 8px;">Részletek</a>';
            $response.='</div>';
            $response.='</div>';
            $response.='</div>';
            
            $prev = $book->ISBN;
        }
        $response.='</div>';

        echo $response;
    }

    public function removeBook() {
        if($this->input->is_ajax_request()) {
            if($this->Book->removeBook()) {
                $response_array['status'] = 'success';
            }
            else {
                $response_array['status'] = 'error';
            }

            echo json_encode($response_array);
            exit();
        }
        else {
            redirect('/home', 'refresh');
        }
    }

    public function updateBook() {
        if($this->Book->updateBook()) {
            echo "Siker";
        } else {
            echo "Hiba";
        }
    }
}