<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Verify user credentials
    public function verify_user($username, $password_input) {
        // Fetch the user record based on the username
        $this->db->where('user_name', $username);
        $query = $this->db->get('user');

        if ($query->num_rows() == 1) {
            $user = $query->row(); // Fetch the user row

            // Stored hashed password from the database
            $user_psw = $user->password;

            // Compare the input password with the stored hashed password
            if (password_verify($password_input, $user_psw)) {
                return 2; // Password is correct
            }
            return 1;
        }

        return 0; // User not found or password is incorrect
    }
}
