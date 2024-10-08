<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// Add logging to verify cron job execution
file_put_contents(APPPATH . 'logs/cron_log.txt', date('Y-m-d H:i:s') . " - Cron job ran\n", FILE_APPEND);

class Croncontroller extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('User_model'); // Load your User model
    }

    public function update_age() {
        $users = $this->User_model->get_users_with_dob(); // Fetch users with DOB

        foreach ($users as $user) {
            if (!empty($user->dob)) { // Check if DOB is not empty
                $age = $this->calculate_age($user->dob); // Calculate age based on DOB
                $this->User_model->update_age($user->id, $age); // Update the age column
            } else {
                // Handle cases where DOB is missing (optional)
                $this->User_model->update_age($user->id, null); // Set age to null or handle accordingly
            }
        }
        log_message('info', 'CronController - update_age method triggered');
        log_message('debug', 'User data retrieved: ' . json_encode($users));
        echo "Age updated successfully for all users.";
    }

    private function calculate_age($dob) {
        $dob = new DateTime($dob);
        $today = new DateTime(date("Y-m-d"));
        $age = $today->diff($dob)->y;
        return $age;
    }
}
