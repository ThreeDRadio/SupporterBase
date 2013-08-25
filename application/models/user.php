<?php

class User extends CI_model {

    public function __construct() {
        $this->load->database();
    }

    /**
     * Adds a user to the database.
     *
     * Note: This assumes you've already checked whether the user exists, etc.
     */
    public function addUser($username, $plaintextPassword) {
        $salt = $this->getRandomSalt();
        $passwordHash = $this->getPasswordHash($plaintextPassword, $salt);

        $data = array(
            'username' => $username,
            'password' => $passwordHash,
            'salt'     => $salt
        );

        return $this->db->insert('users', $data);
    }


    public function isUsernameTaken($username) {
        $query = $this->db->get_where('users', array('username' => $username), 1);
        if ($query->num_rows() === 0) {
            return false;
        }
        return true;
    }

    /**
     * Generates a random salt to use on passwords.
     */
    public function getRandomSalt($length = 64) {
        return mcrypt_create_iv($length);
    }


    public function getPasswordHash($plaintextPassword, $salt) {
        return hash('sha256', $salt . $plaintextPassword);
    }
}
