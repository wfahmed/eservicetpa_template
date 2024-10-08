<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    public function verify_user($username, $password_input) {
        $this->db->where('user_name', $username);
        $query = $this->db->get('user');

        if ($query->num_rows() == 1) {
            $user = $query->row();
            if (password_verify($password_input, $user->password)) {
                return true;
            }
        }
        return false;
    }
}
