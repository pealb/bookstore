<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Author extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function addAuthors() {
        $input = $this->input->post('author');
        $authors = explode(',', $input);
        $ids = array();

        foreach($authors as $author){
            $sql = "SELECT * FROM authors WHERE name = ?";
            $query = $this->db->query($sql, array(trim($author)));

            if($query->num_rows() == 0) {
                $id = $this->getLastId();
                $sql = "INSERT INTO authors (authorId, name) VALUES (?, ?)";
                $query = $this->db->query($sql, array($id, trim($author)));

                if($this->db->affected_rows() == 1) {
                    array_push($ids, $id);
                }
            }
            else {
                $id = $query->row()->AUTHORID;
                array_push($ids, $id);
            }
        }

        return $ids;
    }

    public function getLastId() {
        $query = $this->db->query("SELECT * FROM authors ORDER BY authorId DESC");
        if($query->num_rows() > 0) {
            return $query->row()->AUTHORID + 1;
        } else {
            return 0;
        } 
    }

    public function getAuthorById($id) {
        $sql = "SELECT * FROM authors WHERE authorId = ?";

        $query = $this->db->query($sql, array($id));

        return $query->row();
    }


}