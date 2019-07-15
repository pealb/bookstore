<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Book extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function upload($filename, $authorIds) {
        $title = $this->input->post('title');
        $isbn = $this->input->post('isbn');
        $price = $this->input->post('price');
        $pages = $this->input->post('pagenumber');
        $category = $this->input->post('genre');
        $subcategory = $this->input->post('subgenre');
        $publishDate = $this->input->post('publishdate');
        $binding = $this->input->post('binding');
        $desc = $this->input->post('description');
        $publisher = $this->input->post('publisher');

        $stores = array();
        $prices = array();
        $db = array();

        $prevStoreId = null;
        foreach($this->input->post() as $key => $value) {
            if(stripos($key, "store") !== false && $value == -1) {
                $prevStoreId = -1;
                continue;
            }
            if(stripos($key, "store") !== false) {
                $prevStoreId = $key;
                array_push($stores, $value);
            }
            else if(stripos($key, "price") !== false && $prevStoreId != -1) {
                array_push($prices, $value);
            }
            else if(stripos($key, "db") !== false && $prevStoreId != -1) {
                array_push($db, $value);
            }
        }
   
        $sql = "INSERT INTO books (isbn, genreId, subgenreId, title, publishDate, binding, 
                    description, pages, coverImage, dateCreated, publisher) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, to_date(?, 'yyyy-mm-dd'), ?)";
        $query = $this->db->query($sql, array($isbn, $category, $subcategory, $title, $publishDate, 
                                                $binding, $desc, $pages, $filename, date('Y-m-d'), $publisher));
       
        if($this->db->affected_rows() == 1) {
            foreach($authorIds as $authorId) {
                $sql = "insert into bookauthor (isbn, authorId) values (?, ?)";
                $this->db->query($sql, array($isbn, $authorId));
            }
            $counter = 0;
            foreach($stores as $store) {
                $sql = "insert into bookstore (isbn, storeId, price, db) values (?, ?, ?, ?)";
                $this->db->query($sql, array($isbn, $store, $prices[$counter], $db[$counter])); 
                $counter++;
            }

            return true;
        } 
        return false;
    } 

    public function getLastId() {
        $query = $this->db->query("SELECT * FROM books ORDER BY bookId DESC");
        if($query->num_rows() > 0) {
            return $query->row()->BOOKID + 1;
        } else {
            return 1;
        }        
    }

    public function checkIfBookExists() {
        $isbn = $this->input->post('isbn');

        $sql = "SELECT * FROM books WHERE isbn = ?";
        $query = $this->db->query($sql, $isbn);

        if($query->num_rows() > 0) {
            return true;
        } 
        return false;    
    }

    public function listBooksByAuthorId($id) {
        $sql = "SELECT books.title, books.binding, books.isbn, books.pages, books.publishdate, books.publisher, 
                    books.description, books.coverimage, genres.name AS genrename, genres.genreid AS genreid, 
                        subgenres.name AS subgenrename, subgenres.subgenreid AS subgenreid
                            FROM books, authors, bookauthor, genres, subgenres
                                WHERE bookauthor.authorId = ? 
                                    AND books.isbn = bookauthor.isbn 
                                        AND bookauthor.authorId = authors.authorId 
                                            AND books.genreId = genres.genreId 
                                                AND books.subgenreId = subgenres.subgenreId";

        $query = $this->db->query($sql, $id);
        $result = $query->result();
        $result = $this->fetchAuthors($result);

        return $result;
    }

    public function listBooksByGenreId($genreId) {
        $sql = "SELECT books.title, books.binding, books.isbn, books.pages, books.publishdate, books.publisher, 
                    books.description, books.coverimage, genres.name AS genrename, genres.genreid AS genreid, 
                        subgenres.name AS subgenrename, subgenres.subgenreid AS subgenreid
                            FROM books, authors, bookauthor, genres, subgenres
                                WHERE books.isbn = bookauthor.isbn 
                                    AND bookauthor.authorId = authors.authorId 
                                        AND books.genreId = genres.genreId 
                                            AND books.subgenreId = subgenres.subgenreId 
                                                AND books.genreId = ?";

        $query = $this->db->query($sql, $genreId);
        $result = $query->result();
        $result = $this->fetchAuthors($result);

        return $result;
    }

    public function listBooksBySubgenreId($subgenreId) {
        $sql = "SELECT books.title, books.binding, books.isbn, books.pages, books.publishdate, books.publisher, 
                    books.description, books.coverimage, genres.name AS genrename, genres.genreid AS genreid, 
                        subgenres.name AS subgenrename, subgenres.subgenreid AS subgenreid
                            FROM books, authors, bookauthor, genres, subgenres
                                WHERE books.isbn = bookauthor.isbn 
                                    AND bookauthor.authorId = authors.authorId 
                                        AND books.genreId = genres.genreId 
                                            AND books.subgenreId = subgenres.subgenreId 
                                                AND books.subgenreId = ?";

        $query = $this->db->query($sql, $subgenreId);
        $result = $query->result();
        $result = $this->fetchAuthors($result);

        return $result;
    }

    public function listBooksByStoreId($storeId) {
        $sql = "SELECT books.title, books.binding, books.isbn, books.pages, books.publishdate, books.publisher, 
                    books.description, books.coverimage, genres.name AS genrename, genres.genreid AS genreid, 
                        subgenres.name AS subgenrename, subgenres.subgenreid AS subgenreid, stores.name 
                            AS storename, stores.storeId
                                FROM books, authors, bookauthor, genres, subgenres, stores, bookstore
                                    WHERE books.isbn = bookauthor.isbn 
                                        AND bookauthor.authorId = authors.authorId 
                                            AND books.genreId = genres.genreId 
                                                AND books.subgenreId = subgenres.subgenreId 
                                                    AND stores.storeId = ? 
                                                        AND bookstore.storeId = stores.storeId 
                                                            AND books.isbn = bookstore.isbn";

        $query = $this->db->query($sql, $storeId);
        $result = $query->result();
        $result = $this->fetchAuthors($result);

        return $result;
    }

    public function getBookByISBN($isbn) {
        $sql = "SELECT books.title, books.binding, books.isbn, books.pages, books.publishdate, books.publisher, 
                    books.description, books.coverimage, genres.name AS genrename, genres.genreid AS genreid, 
                        subgenres.name AS subgenrename, subgenres.subgenreid AS subgenreid
                            FROM books, authors, bookauthor, genres, subgenres    
                                WHERE books.genreId = genres.genreId 
                                    AND books.subgenreId = subgenres.subgenreId 
                                        AND authors.authorId = bookauthor.authorId 
                                            AND books.isbn = bookauthor.isbn 
                                                AND books.isbn = ?";

        $query = $this->db->query($sql, $isbn);
        $result = $query->result();
        $result = $this->fetchAuthors($result);

        return $result;
    }

    public function filterBooks() {
        $name = $this->input->post('name');
        $genre = $this->input->post('genre');
        $subgenre = $this->input->post('subgenre');
        $order = $this->input->post('order');

        $sql = "SELECT books.isbn, books.title, books.coverImage 
                    FROM books, genres, subgenres, authors, bookauthor
                        WHERE books.genreId = genres.genreId 
                            AND books.subgenreId = subgenres.subgenreId 
                                AND authors.authorId = bookauthor.authorId 
                                    AND books.isbn = bookauthor.isbn";
        
        if(isset($name) && !empty($name)) {
            $sql .= " AND (books.title LIKE '%".$name."%' OR authors.name LIKE '%".$name."%')";
        } 
        if(isset($genre) && $genre != -1) {
            $sql .= " AND books.genreId =".$genre;
        }
        if(isset($subgenre) && $subgenre != -1) {
            $sql .= " AND books.subgenreId =".$subgenre;
        }
        if(isset($order) && $order != -1) {
            $sql .= " ORDER BY books.dateCreated DESC";
        }
                        
        $query = $this->db->query($sql);
        $result = $query->result();
        
        $result = $this->fetchAuthors($result);

        return $result;
    }

    public function listBooks() {
        $sql = "SELECT * FROM books";
    
        $query = $this->db->query($sql);
        $result = $query->result();
        $result = $this->fetchAuthors($result);
        
        return $result;
    }

    public function removeBook() {
        $isbn = $this->input->post('isbn');

        $sql = "DELETE FROM books WHERE isbn = ?";
        $query = $this->db->query($sql, $isbn);

        if($this->db->affected_rows() == 1) {
            return true;
        }

        return false;
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

    public function updateBook() {
        $title = $this->input->post('title');
        $genre = $this->input->post('genre');
        $subgenre = $this->input->post('subgenre');
        $publishDate = $this->input->post('publishdate');
        $publisher = $this->input->post('publisher');
        $pages = $this->input->post('pagenumber');
        $binding = $this->input->post('binding');
        $desc = $this->input->post('description');

        $isbn = $this->input->post('isbn');

        $this->db->set('TITLE', $title);
        $this->db->set('GENREID', $genre);
        $this->db->set('SUBGENREID', $subgenre);
        $this->db->set('PUBLISHDATE', $publishDate);
        $this->db->set('PUBLISHER', $publisher);
        $this->db->set('PAGES', $pages);
        $this->db->set('BINDING', $binding);
        $this->db->set('DESCRIPTION', $desc);

        $this->db->where(array('ISBN' => $isbn));
        $this->db->update('BOOKS');

        if($this->db->affected_rows() > 0) return true;

        return false;
    }
    
}

