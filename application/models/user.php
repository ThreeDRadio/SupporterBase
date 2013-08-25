<?php

class User extends CI_model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }



    public function login($username, $password) {
        // get the username
        $query = $this->db->get_where('users', array('username' => $username), 1);
        if ($query->num_rows() === 0) {
            print "User not found!";
            return false;
        }
        $row = $query->first_row();
        $salt = $row->salt;


        $passwordHash = $this->getPasswordHash($password, $salt);

        print "Generated Hash: $passwordHash<br>";
        print "Database  Hash: $row->password<br>";


        if ($passwordHash == $row->password) {
            $newData = array(
                'user_id' => $row->user_id,
                'logged_in' => TRUE
            );
            $this->session->set_userdata($newData);
            print "Logged In!";
            return true;
        }
        print "Incorrect Password!";
        return false;
    }

    public function isLoggedIn() {
        return $this->session->userdata('logged_in');
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
