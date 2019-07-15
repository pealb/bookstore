<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getOrderHistory() {
        $userId = $this->session->userdata('id');

        $sql = "SELECT * FROM orders WHERE userId = ? ORDER BY orderId DESC";
        $query = $this->db->query($sql, $userId);
        $result = $query->result();
        $result = $this->fetchDetails($result);

        return $result;
    }

    public function fetchDetails($orders) {
        foreach($orders as $order) {
            $sql = "SELECT books.title, books.isbn, books.coverimage, books.publishdate, books.publisher,
                        books.pages, books.binding, genres.name AS genrename, genres.genreid, subgenres.name AS subgenrename,
                            subgenres.subgenreid, bookorder.storeId, stores.name AS storename    
                                FROM bookorder, books, genres, subgenres, stores 
                                    WHERE bookorder.orderId = ? 
                                        AND bookorder.isbn = books.isbn
                                            AND books.genreId = genres.genreId 
                                                AND books.subgenreid = subgenres.subgenreId 
                                                    AND bookorder.storeId = stores.storeId";
            $query = $this->db->query($sql, array($order->ORDERID));
            $result = $query->result();

            $books = array();

            foreach($result as $row) {
                $book = new \stdClass();
                $book->TITLE = $row->TITLE;
                $book->STOREID = $row->STOREID;
                $book->COVERIMAGE = $row->COVERIMAGE;
                $book->PUBLISHDATE = $row->PUBLISHDATE;
                $book->PUBLISHER = $row->PUBLISHER;
                $book->PAGES = $row->PAGES;
                $book->BINDING = $row->BINDING;
                $book->GENRENAME = $row->GENRENAME;
                $book->GENREID = $row->GENREID;
                $book->SUBGENRENAME = $row->SUBGENRENAME;
                $book->SUBGENREID = $row->SUBGENREID;
                $book->STORENAME = $row->STORENAME;
                $book->ISBN = $row->ISBN;

                array_push($books, $book);
            }

            $order->BOOKS = $books;
        }

        return $orders;
    }
    
}