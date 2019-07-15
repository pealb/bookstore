<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PageController extends CI_Controller {

    public function index() {
        $this->load->model('Genre');

        $genres = $this->Genre->listGenres();

        $this->load->view('templates/header', array('title' => 'Kezdőlap'));
        $this->load->view('templates/navbar', array('home' => true));
        $this->load->view('pages/home', array('genres' => $genres));
        $this->load->view('templates/footer');
    }

    public function profile() {
        if($this->session->userdata('logged')) {
            $this->load->view('templates/header', array('title' => 'Profilom'));
            $this->load->view('templates/navbar');
            $this->load->view('pages/profile');
            $this->load->view('templates/footer');
        } else {
            redirect('/home', 'refresh');
        } 
    }

    public function history() {
        if($this->session->userdata('logged')) {
            $this->load->model('Order');

            $orders = $this->Order->getOrderHistory();

            $this->load->view('templates/header', array('title' => 'Vásárlásaim'));
            $this->load->view('templates/navbar');
            $this->load->view('pages/history', array('orders' => $orders));
            $this->load->view('templates/footer');
        } else {
            redirect('/home', 'refresh');
        } 
    }

    public function listBooksByAuthor($id) {
        $this->load->model('Book');
        $this->load->model('Author');

        $books = $this->Book->listBooksByAuthorId($id);
        $author = $this->Author->getAuthorById($id);

        $this->load->view('templates/header', array('title' => 'Szerző - '.$author->NAME));
        $this->load->view('templates/navbar');
        $this->load->view('pages/listbooks', array("books" => $books));
        $this->load->view('templates/footer');
    }

    public function bookDetails($isbn) {
        $this->load->model('Book');
        $this->load->model('Store');
        
        $book = $this->Book->getBookByISBN($isbn)[0];
        $stores = $this->Store->listStoresByIsbn($isbn);

        $this->load->view('templates/header', array('title' => $book->TITLE));
        $this->load->view('templates/navbar');
        $this->load->view('pages/bookdetails', array("book" => $book, "stores" => (count($stores) > 0 ? $stores[0]->STORES : array())));
        $this->load->view('templates/footer');
    }

    public function listBooksByGenre($genreId) {
        $this->load->model('Book');

        $books = $this->Book->listBooksByGenreId($genreId);

        $this->load->view('templates/header', array('title' => 'Kategória - '.$books[0]->GENRENAME));
        $this->load->view('templates/navbar');
        $this->load->view('pages/listbooks', array("books" => $books));
        $this->load->view('templates/footer');
    }

    public function listBooksBySubgenre($subgenreId) {
        $this->load->model('Book');

        $books = $this->Book->listBooksBySubgenreId($subgenreId);

        $this->load->view('templates/header', array('title' => 'Alkategória - '.$books[0]->SUBGENRENAME));
        $this->load->view('templates/navbar');
        $this->load->view('pages/listbooks', array("books" => $books));
        $this->load->view('templates/footer');
    }

    public function listBooksByStoreId($storeId) {
        $this->load->model('Book');

        $books = $this->Book->listBooksByStoreId($storeId);

        $this->load->view('templates/header', array('title' => 'Áruház - '.$books[0]->STORENAME));
        $this->load->view('templates/navbar');
        $this->load->view('pages/listbooks', array("books" => $books));
        $this->load->view('templates/footer');
    }

    public function cart() {
        if($this->session->userdata('logged')) {
            $this->load->model('Cart');

            $items = $this->Cart->listCartItems();

            $this->load->view('templates/header', array('title' => 'Kosár'));
            $this->load->view('templates/navbar');
            $this->load->view('pages/cart', array('items' => $items));
            $this->load->view('templates/footer');
        } else {
            redirect('/home', 'refresh');
        }
    }

    public function updateBook($isbn) {
        if($this->session->userdata('logged') && $this->session->userdata('admin')) {
            $this->load->model('Book'); 
            $this->load->model('Genre');
            $this->load->model('Store');

            $genres = $this->Genre->listGenres();
            $stores = $this->Store->listStores();
            $bookstores = $this->Store->bookStoresByIsbn($isbn);
            $book = $this->Book->getBookByISBN($isbn);

            $this->load->view('templates/header', array('title' => 'Könyv frissítése - '.$isbn));
            $this->load->view('templates/navbar');
            $this->load->view('admin/updatebook', array('book' => $book[0], 'genres' => $genres, 'stores' => $stores, 'bookstores' => $bookstores));
            $this->load->view('templates/footer');
        } else {
            redirect('/home', 'refresh');
        }
    }
}