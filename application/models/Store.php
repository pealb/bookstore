<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listStores() {
        $sql = "SELECT * FROM stores";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function getLastId() {
        $query = $this->db->query("SELECT * FROM stores ORDER BY storeId DESC");
        if($query->num_rows() > 0) {
            return $query->row()->STOREID + 1;
        } else {
            return 0;
        } 
    }

    public function addStore() {
        $name = $this->input->post('name');
        $address = $this->input->post('address');
        $country = $this->input->post('country');
        $city = $this->input->post('city');
        $postal = $this->input->post('postal');
        $id = $this->getLastId();

        $sql = "INSERT INTO stores (storeId, name, postal, country, city, address) VALUES (?, ?, ?, ?, ?, ?)";
        $this->db->query($sql, array($id, $name, $postal, $country, $city, $address));

        if($this->db->affected_rows() == 1) {
            return true;
        }

        return false;
    }

    public function listStoresByIsbn($isbn) {
        $sql = "SELECT stores.storeId, stores.name, stores.country, stores.city, stores.address, stores.postal, bookstore.price,
                    bookstore.db, bookstore.isbn
                        FROM stores, bookstore
                            WHERE bookstore.isbn = ? 
                                AND bookstore.storeId = stores.storeId";

        $query = $this->db->query($sql, $isbn);
        $result = $query->result();

        return $this->fetchData($result);
    }

    public function fetchData($books) {
        $ret = array();
        $stores = array();
        
        $isbn = null;
        $obj = new \stdClass();
        foreach($books as $book) {
            $store = new \stdClass();
            $store->STOREID = $book->STOREID;
            $store->NAME = $book->NAME;
            $store->POSTAL = $book->POSTAL;
            $store->COUNTRY = $book->COUNTRY;
            $store->CITY = $book->CITY;
            $store->ADDRESS = $book->ADDRESS;
            $store->DB = $book->DB;
            $store->PRICE = $book->PRICE;

            array_push($stores, $store);

            if($isbn == null) {
                $obj->ISBN = $book->ISBN;
                $isbn = $book->ISBN;
            }

            if($book->ISBN != $isbn && $isbn != null) {
                array_push($ret, $obj);
                $obj = new \stdClass();
                $obj->ISBN = $book->ISBN;
                $isbn = $book->ISBN;
                $stores = array();
            }

            $obj->STORES = $stores;

            if($book == end($books)) {
                array_push($ret, $obj);
            }   
        }   

        return $ret;
    }

    public function bookStoresByIsbn($isbn) {
        $sql = "select * from bookstore where isbn = ?";

        $query = $this->db->query($sql, array($isbn));

        return $query->result();
    }

    public function getPriceFromStoreByIsbn() {
        $isbn = $this->input->post('isbn');
        $storeId = $this->input->post('storeId');

        $sql = "SELECT * FROM bookstore WHERE storeId = ? AND isbn = ?";
        
        $query = $this->db->query($sql, array($storeId, $isbn));
        return $query->row();
    }

    public function updateBookStore($isbn) {
        $inputs = $this->input->post();
        $updateStores = array();
        $stores = array();
        $updatePrices = array();
        $prices = array();
        $updateDbs = array();
        $dbs = array();

        $prevUpStoreId = null;
        $prevStoreId = null;
        foreach($inputs as $key => $value) {
            if(stripos($key, "updatestore") !== false && $value == -1) {
                $prevUpStoreId = -1;
                continue;
            }
            else if(stripos($key, "store") !== false && $value == -1) {
                $prevStoreId = -1;
                continue;
            }

            if(stripos($key, "updatestore") !== false) {
                $prevUpStoreId = $value;
                array_push($updateStores, $value);
            }
            else if(stripos($key, "store") !== false){
                $prevStoreId = $value;
                array_push($stores, $value);
            }
            else if(stripos($key, "updateprice") !== false && $prevUpStoreId != -1) {
                array_push($updatePrices, $value);
            }
            else if(stripos($key, "price") !== false && $prevStoreId != -1){
                array_push($prices, $value);
            }
            else if(stripos($key, "updatedb") !== false && $prevUpStoreId != -1) {
                array_push($updateDbs, $value);
            }
            else if(stripos($key, "db") !== false && $prevStoreId != -1){
                array_push($dbs, $value);
            }
        }

        $counter = 0;

        foreach($updateStores as $updateStore) {
            $data = array(
                'PRICE' => $updatePrices[$counter],
                'DB' => $updateDbs[$counter]
            );

            $this->db->where(array('ISBN' => $isbn, 'STOREID' => $updateStore));
            $this->db->update('BOOKSTORE', $data);

            if($this->db->affected_rows() != 1) {
                return false;
            }

            $counter++;
        }

        $counter = 0;

        foreach($stores as $store) {
            $sql = "INSERT INTO bookstore (isbn, storeId, price, db) VALUES (?, ?, ?, ?)";
            $query = $this->db->query($sql, array($isbn, $store, $prices[$counter], $dbs[$counter]));

            if($this->db->affected_rows() != 1) {
                return false;
            }

            $counter++;
        }
    
        return true;
    }

    public function deleteStore() {
        $id = $this->input->post('id');

        $sql = "DELETE FROM stores WHERE storeId = ?";
        $query = $this->db->query($sql, $id);

        if($this->db->affected_rows() == 1) return true;

        return false;
    }
}