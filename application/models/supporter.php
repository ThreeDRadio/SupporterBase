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


    public function findSupporterByLastName($partialName) {
        //$this->db->like('last_name', $partialName, 'after');
        //$query = $this->db->get('supporters');
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone, m.email,
            mh.expiration_date, mh.type
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL
            AND m.last_name LIKE '$partialName%'");

        $results = array();
        foreach ($query->result_array() as $result) {
            array_push($results, $result);
        }
        return $results;
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

