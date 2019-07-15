<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Genre extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function listGenres() {
        $sql = "SELECT * FROM genres";
        $query = $this->db->query($sql);

        return $query->result();
    }

    public function listSubgenresByGenreId() {
        $id = $this->input->post('id');

        $sql = "SELECT subgenres.subgenreId, subgenres.name 
                    FROM subgenres, genresubgenre 
                        WHERE genresubgenre.subgenreId = subgenres.subgenreId 
                            AND genresubgenre.genreId = ?";
        $query = $this->db->query($sql, $id);

        return $query->result();
    }

    public function listSubgenres() {
        $sql = "SELECT subgenres.subgenreid, subgenres.name, genres.name AS genrename 
                    FROM subgenres, genres, genresubgenre 
                        WHERE subgenres.subgenreid = genresubgenre.subgenreid 
                            AND genresubgenre.genreid = genres.genreid";

        $query = $this->db->query($sql);

        return $query->result();
    }

    public function addGenre() {
        $id = $this->getLastGenreId();
        $name = $this->input->post('name');

        $sql = "INSERT INTO genres (genreId, name) VALUES (?, ?)";
        $this->db->query($sql, array($id, $name));

        if($this->db->affected_rows() == 1) {
            return true;
        }

        return false;
    }

    public function addSubgenre() {
        $id = $this->getLastSubgenreId();
        $name = $this->input->post('name');
        $genre = $this->input->post('genre');

        $sql = "INSERT INTO subgenres (subgenreId, name) VALUES (?, ?)";
        $this->db->query($sql, array($id, $name));

        if($this->db->affected_rows() == 1) {
            $sql = "INSERT INTO genresubgenre (genreId, subgenreId) VALUES (?, ?)";
            $this->db->query($sql, array($genre, $id));
            
            if($this->db->affected_rows() == 1) {
                return true;
            }
        }

        return false;
    }

    public function getLastGenreId(){
        $query = $this->db->query("SELECT * FROM genres ORDER BY genreId DESC");
        if($query->num_rows() > 0) {
            return $query->row()->GENREID + 1;
        } else {
            return 0;
        } 
    }

    public function getLastSubGenreId(){
        $query = $this->db->query("SELECT * FROM subgenres ORDER BY subgenreId DESC");
        if($query->num_rows() > 0) {
            return $query->row()->SUBGENREID + 1;
        } else {
            return 0;
        } 
    }

    public function deleteGenre() {
        $id = $this->input->post('id');

        $sql = "DELETE FROM genres WHERE genreId = ?";
        $query = $this->db->query($sql, $id);

        if($this->db->affected_rows() == 1) {
            return true;
        }

        return false;
    }

    public function deleteSubgenre() {
        $id = $this->input->post('id');

        $sql = "DELETE FROM subgenres WHERE subgenreId = ?";
        $query = $this->db->query($sql, $id);

        if($this->db->affected_rows() == 1) {
            return true;
        }

        return false;
    }
}