<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cart extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function addBookToCart() {
        $isbn = $this->input->post('isbn');
        $store = $this->input->post('store');
        $price = $this->input->post('price');

        if(!$this->session->has_userdata('cartSize')) {
            $this->session->set_userdata('cartSize', 1);
            $books = array();

            $book = new \stdClass();
            $book->id = 0;
            $book->isbn = $isbn;
            $book->storeId = $store;
            $book->price = $price;
            
            array_push($books, $book);

            $this->session->set_userdata('cartBooks', $books);

            return 1;
        } 
        else {
            $size = $this->session->userdata('cartSize');
            $this->session->set_userdata('cartSize', $size + 1);

            $book = new \stdClass();
            $book->id = $size + 1;
            $book->isbn = $isbn;
            $book->storeId = $store;
            $book->price = $price;

            $books = $this->session->userdata('cartBooks');
            
            array_push($books, $book);
            $this->session->set_userdata('cartBooks', $books);
        
            return $size + 1;
        }
    }

    public function listCartItems() {
        $books = $this->session->userdata('cartBooks');
        $ret = array();

        if($this->session->userdata('cartSize') > 0) {
            foreach($books as $book) {
                $sql = "SELECT books.title, books.binding, books.isbn, books.pages, books.publishdate, books.publisher, 
                            books.coverimage, genres.name AS genrename, genres.genreid AS genreid, subgenres.name AS subgenrename,
                                bookstore.price, subgenres.subgenreid AS subgenreid, stores.name AS storename, stores.storeid
                                    FROM books, genres, subgenres, bookstore, stores
                                        WHERE books.genreId = genres.genreId 
                                            AND books.subgenreId = subgenres.subgenreId 
                                                AND books.isbn = ? 
                                                    AND bookstore.isbn = books.isbn 
                                                        AND bookstore.storeId = ? 
                                                            AND stores.storeId = bookstore.storeId";
    
                $query = $this->db->query($sql, array($book->isbn, $book->storeId));
                $result = $query->row();

                $result->CARTID = $book->id;
                array_push($ret, $result);
            }
        }

        $ret = $this->fetchAuthors($ret);

        return $ret;
    }

    private function getLastId() {
        $query = $this->db->query("SELECT * FROM orders ORDER BY orderId DESC");
        if($query->num_rows() > 0) {
            return $query->row()->ORDERID + 1;
        } else {
            return 0;
        } 
    }

    private function insertOrderDetails($orderId) {
        $books = $this->session->userdata('cartBooks');

        foreach($books as $book) {
            $sql = "INSERT INTO bookorder (orderId, storeId, isbn) VALUES (?, ?, ?)";
            $query = $this->db->query($sql, array($orderId, $book->storeId, $book->isbn));

            if($this->db->affected_rows() != 1) {
                return false;
            }

            $this->db->set('DB', 'DB-1', false);
            $this->db->where(array('ISBN' => $book->isbn, 'STOREID' => $book->storeId));
            $this->db->update('BOOKSTORE'); 
        }

        return true;
    }

    private function getPriceSum() {
        $books = $this->session->userdata('cartBooks');
        $price = 0;

        foreach($books as $book) {
            $price += $book->price;
        }

        return $price;
    }

    public function order() {
        $orderId = $this->getLastId();
        $userId = $this->session->userdata('id');
        $price = $this->getPriceSum();

        $sql = "INSERT INTO orders (orderId, userId, dateCreated, price) 
                    VALUES (?, ?, to_date('".date('Y-m-d H-i-s')."', 'yyyy-mm-dd hh24-mi-ss'), ?)";
        $query = $this->db->query($sql, array($orderId, $userId, $price));
        
        if($this->db->affected_rows() == 1) {
            if($this->insertOrderDetails($orderId)) return true;
        }

        return false;
    }  

    public function removeItem() {
        $books = $this->session->userdata('cartBooks');
        $size = $this->session->userdata('cartSize');
        $id = $this->input->post('id');

        $ret = array();

        foreach($books as $book) {
            if($book->id != $id) {
                array_push($ret, $book);
                continue;
            }

            $size--;
        }

        $this->session->set_userdata('cartBooks', $ret);
        $this->session->set_userdata('cartSize', $size);

        return $id;
    }

    private function fetchAuthors($books) {
        foreach($books as $book) {
            $sql = "SELECT authors.authorId, authors.name  
                        FROM authors, bookauthor 
                            WHERE authors.authorId = bookauthor.authorId
                                AND bookauthor.isbn = ?";
            
            $query = $this->db->query($sql, $book->ISBN);
            $authors = array();

            foreach($query->result() as $row) {
                $author = new \stdClass();
                $author->AUTHORID = $row->AUTHORID;
                $author->NAME = $row->NAME;

                array_push($authors, $author);
            }

            $book->AUTHORS = $authors;
        }

        return $books;
    }
}

