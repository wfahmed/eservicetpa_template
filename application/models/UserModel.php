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

    public function get_disabled_user($start = 0, $length = 10, $search_value = null, $order_column = null, $order_dir = 'asc')
    {
        $this->db->start_cache();
        $this->db->from('disability_view');

        if (!empty($search_value['identity_number'])) {
            $this->db->group_start();
            $this->db->where('orphan_identity', $search_value['identity_number']);
            $this->db->or_where('father_identity', $search_value['identity_number']);
            $this->db->or_where('mother_identity', $search_value['identity_number']);
            $this->db->group_end();
        }

        if (!empty($search_value['full_name'])) {
            $this->db->like('full_name', $search_value['full_name']);
        }

        if (!empty($search_value['disability_status_id']) && is_array($search_value['disability_status_id'])) {
            $this->db->where_in('last_disability_status', $search_value['disability_status_id']);
        } else {
            $this->db->where('last_disability_status >', 100);
        }

        // Sorting
        $columns = [
            'orphan_id',
            'orphan_identity',
            'father_name',
            'mother_name',
            'agent_name'
        ];

        if ($order_column !== null && isset($columns[$order_column])) {
            $this->db->order_by($columns[$order_column], $order_dir);
        }

        $this->db->stop_cache();

        $total = $this->db->count_all_results();

        $this->db->limit($length, $start);

        $query = $this->db->get();

        $this->db->flush_cache();

        return [
            'total_count' => $total,
            'data' => $query->result_array()
        ];
    }
}
