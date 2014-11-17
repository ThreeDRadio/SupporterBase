<?php

class Supporter extends CI_model {

    public function __construct($includeExcluded = false) {
        parent::__construct();
        $this->load->database();
        $this->excluded = !$includeExcluded;
    }

    /**
     * Adds a user to the database.
     *
     * Note: This assumes you've already checked whether the user exists, etc.
     */
    public function addSupporter($supporterInfo) {
        $this->db->insert('supporters', $supporterInfo);
	return $this->db->insert_id();
    }

    public function updateSupporter($id, $supporterInfo) {
        $this->db->where('supporter_id', $id);
        $this->db->update('supporters', $supporterInfo);
    }

    public function getSupporter($id) {
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email, m.excluded,
            mh.expiration_date, mh.type
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL
            AND m.supporter_id  = '$id' " . (($this->excluded) ? " AND m.excluded = '0' " : "") . " 
            LIMIT 1");

        return $query->result_array();
    }

    public function getSupporterNotes($supporterID) {
        $query = $this->db->query("SELECT *
            FROM supporter_notes 
            WHERE supporter_id = '$supporterID' ORDER BY time DESC");

        return $query->result_array();
    }

    public function getSubscriptions($supporterID) {
        $query = $this->db->query("SELECT *
            FROM transactions 
            WHERE supporter_id = '$supporterID' ORDER BY expiration_date DESC");

        return $query->result_array();

    }

    public function addNote($data) {
        $this->db->insert('supporter_notes', $data);
	return $this->db->insert_id();
    }

    public function getSupporters() {
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
            mh.expiration_date, mh.type
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
            ORDERBY m.last_name DESC
            ");

        return $query->result_array();
    }

    public function getMysterySupporters() {
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email
            FROM supporters m
            WHERE m.supporter_id NOT IN (SELECT supporter_id FROM transactions)
            ORDER BY m.last_name ASC"
        );
        return $query->result_array();
    }
    public function getMysterySupporterCount() {
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email
            FROM supporters m
            WHERE m.supporter_id NOT IN (SELECT supporter_id FROM transactions)
            ORDER BY m.last_name ASC"
        );
        return $query->num_rows();
    }
    public function getCurrentSubscribers() {
        $time = time();
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
            mh.expiration_date, mh.type, mh.payment_processed, mh.pack_sent, mh.transaction_id, mh.note, mh.transaction_id
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL
            AND mh.expiration_date >= '$time'
            AND (mh.type='sub' OR mh.type='sub_concession' OR mh.type='band' OR mh.type='life') " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
            ORDER BY m.last_name ASC
            ");
        return $query->result_array();
    }
    
    public function getCurrentSupporters() {
        $time = time();
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
            mh.expiration_date, mh.type, mh.payment_processed, mh.pack_sent, mh.transaction_id, mh.note, mh.transaction_id
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL
            AND mh.expiration_date >= '$time'
            " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
            ORDER BY m.last_name ASC
            ");
        return $query->result_array();
    }


    public function setSubscriberPackSent($transactionID) {
        $data = array(
            'pack_sent' => '1'
        );
        $this->db->where('transaction_id', $transactionID);
        $this->db->update('transactions', $data);

        return true;
    }


    public function getCurrentMembers() {
        $time = time();
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
            mh.expiration_date, mh.type, mh.payment_processed, mh.pack_sent, mh.transaction_id
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL
            AND mh.expiration_date >= '$time'
            AND (mh.type='member' OR mh.type='member_concession' OR mh.type='probationary' OR mh.type='honourary' OR mh.type='life') " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
            ORDER BY m.last_name ASC
            ");
        return $query->result_array();
    }
    public function getExpiredMembers() {
        $time = time();
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
            mh.expiration_date, mh.type, mh.payment_processed, mh.pack_sent
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL
            AND mh.expiration_date < '$time'
            AND (mh.type='member' OR mh.type='member_concession' OR mh.type='probationary' OR mh.type='honourary' OR mh.type='life') " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
            ORDER BY m.last_name ASC
            ");
        return $query->result_array();
    }


    public function getCurrentMemberCount() {
        $time = time();
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
            mh.expiration_date, mh.type
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL
            AND mh.expiration_date >= '$time'
            AND (mh.type='member' OR mh.type='member_concession' OR mh.type='probationary' OR mh.type='honourary' OR mh.type='life') " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
            ORDER BY m.last_name ASC
            ");
        return $query->num_rows();
    }
    public function getExpiredMemberCount() {
        $time = time();
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
            mh.expiration_date, mh.type
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL
            AND mh.expiration_date < '$time' " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
            AND (mh.type='member' OR mh.type='member_concession')");
        return $query->num_rows();
    }

    public function getCurrentSubscriberCount() {
        $time = time();
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
            mh.expiration_date, mh.type
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL
            AND mh.expiration_date >= '$time' " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
            AND (mh.type='sub' OR mh.type='sub_concession' OR mh.type='band')");
        return $query->num_rows();
    }
    public function getExpiredSubscriberCount() {
        $time = time();
        $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
            m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
            mh.expiration_date, mh.type
            FROM supporters m
            LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
            LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
            AND mh.expiration_date < mh2.expiration_date
            WHERE mh2.expiration_date IS NULL
            AND mh.expiration_date < '$time' " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
            AND (mh.type='sub' OR mh.type='sub_concession')");
        return $query->num_rows();
    }

    public function addTransaction($user_id, $supporter_id, $expiration_date, $type, $note, $payment) {
        $data = array(
            'user_id' => $user_id,
            'supporter_id' => $supporter_id,
            'expiration_date' => $expiration_date,
            'type' => $type,
            'timestamp' => time(),
            'note' => $note,
	    'payment_processed' => $payment
        );
        return $this->db->insert('transactions', $data);
    }

    public function findSupporterByLastName($partialName) {
        if (!is_numeric($partialName)) {
            $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
                m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
                mh.expiration_date, mh.type
                FROM supporters m
                LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
                LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
                AND mh.expiration_date < mh2.expiration_date
                WHERE mh2.expiration_date IS NULL " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
                AND m.last_name ILIKE " . $this->db->escape($partialName . '%'));
        }
        else {
            $query = $this->db->query("SELECT m.supporter_id, m.first_name, m.last_name, 
                m.address1, m.address2, m.town, m.state, m.postcode, m.phone_mobile, m.email,
                mh.expiration_date, mh.type
                FROM supporters m
                LEFT OUTER JOIN transactions mh ON m.supporter_id = mh.supporter_id
                LEFT OUTER JOIN transactions mh2 ON m.supporter_id = mh2.supporter_id
                AND mh.expiration_date < mh2.expiration_date
                WHERE mh2.expiration_date IS NULL " . (($this->excluded) ? " AND m.excluded = '0' " : "") . "
                AND (m.last_name ILIKE " . $this->db->escape($partialName . '%') . " OR m.supporter_id = " . $this->db->escape($partialName) . ")" );
        }

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

