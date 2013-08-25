<?php

class Supporter extends CI_model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Adds a user to the database.
     *
     * Note: This assumes you've already checked whether the user exists, etc.
     */
    public function addSupporter($supporterInfo) {
        return $this->db->insert('supporters', $supporterInfo);
    }


    public function isUsernameTaken($username) {
        $query = $this->db->get_where('users', array('username' => $username), 1);
        if ($query->num_rows() == 0) {
            return false;
        }
        return true;
    }

    /**
     * Generates a random salt to use on passwords.
     */
    public function getRandomSalt($length = 64) {
        return strtr(base64_encode(mcrypt_create_iv($length)), '+', '.');
    }


    /**
     * Generates the password hash given the password and salt...
     */
    public function getPasswordHash($plaintextPassword, $salt) {
        return hash('sha256', $salt . $plaintextPassword);
    }
}

