<?php
class User_model extends CI_Model {

    public function get_users_with_dob() {
        $this->db->select('id, dob');
        $query = $this->db->get('user');
        return $query->result();
    }

    public function update_age($id, $age) {
        $this->db->where('id', $id);
        $this->db->update('user', ['age' => $age]);
    }
}
