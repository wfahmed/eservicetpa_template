<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('session');
        $this->load->model('UserModel');
        $this->load->helper('security');
    }
    // login
    public function index()
    {

        if ($this->session->userdata('user_name')) {
           //  var_dump($this->session->userdata('role_id'));die();
            if($this->session->userdata('role_id')==1)
                redirect('admin');
            else
            redirect('User');
        }

        $this->form_validation->set_rules('user_name', 'user_name', 'required|trim', [
            'required' => 'حقل واجب الادخال',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);

       if ($this->form_validation->run() == false) {
            $data['csrf'] = array(
                'name' => $this->security->get_csrf_token_name(),
                'hash' => $this->security->get_csrf_hash()
            );
            $data['title'] = 'شاشة تسجيل الدخول';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login', $data);
            $this->load->view('templates/auth_footer');
        } else {
            //var_dump($this->form_validation->run());die();
            // validasi sukses
            $this->_login();
        }
    }

    private function _login()
    {
        $username = $this->input->post('user_name');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['user_name' => $username])->row_array();

        if ($user) {
            if (password_verify($password, $user['password'])) {
                $data = [
                    'email' => $user['email'],
                    'identity' => $user['identity'],
                    'user_name' => $user['user_name'],
                    'role_id' => $user['role_id'],
                    'id' => $user['id'],
                ];
                $this->session->set_userdata($data);
                switch ($user['role_id']) {
                    case 1:
                        redirect('admin');
                        break;
                    case 2:
                        redirect('profile');
                        break;
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
          كلمة مرور خاطئة!</div>');
               redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">
      اسم المستخدم غير موجود</div>');
           redirect('auth');
        }

        if ($user) {
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">خطأ في المستخدم وكلمة المرور!</div>');
           redirect('auth');
        }
    }

    // valid login sukses
    public function login_user()
    {
        $user_name = $this->input->post('user_name');
        $password = $this->input->post('password');

        $csrf_token_name = $this->security->get_csrf_token_name();
        $csrf_hash = $this->security->get_csrf_hash(); // Token stored in session

        // Get token from request headers
        $headers = $this->input->request_headers();
        $csrf_token_value = isset($headers[$csrf_token_name]) ? $headers[$csrf_token_name] : null;

        // Debug output
      /*  echo '<pre>';
        echo 'Token from POST data: ' . htmlspecialchars($csrf_token_value) . '<br>';
        echo 'Expected CSRF hash: ' . htmlspecialchars($csrf_hash) . '<br>';
        echo $password.'</pre>';*/

      if ($csrf_token_value !== $csrf_hash) {
            $this->session->set_flashdata('error', 'Invalid CSRF token');
          $response = [
              'status' => 'error',
              'message' => 'Invalid CSRF token'
          ];
          echo json_encode($response);
            return;
        }

        $userCheck = $this->UserModel->verify_user($user_name, $password);
      switch($userCheck){
          case 0;
              $response = [
                  'status' => 'auth',
                  'message' => 'الحساب او كلمة المرور خاطئة !'
              ];
              echo json_encode($response);
          break;
          case 1 :
              $response = [
                  'status' => 'auth',
                  'message' => 'كلمة المرور  خاطئة !'
              ];
              echo json_encode($response);
              break;
          case 2:
              $user = $this->db->get_where('user', ['user_name' => $user_name])->row_array();
              $data = [
                  'email' => $user['email'],
                  'identity' => $user['identity'],
                  'user_name' => $user['user_name'],
                  'role_id' => $user['role_id'],
                  'id' => $user['id'],
              ];
              $this->session->set_userdata($data);
              // cek role
              if ($user['is_emp'] == "1") {
                  $status='admin';
              } else {
                  $status='profile';
              }
              $response = [
                  'status' => $status,
                  'message' => ' '
              ];
              echo json_encode($response);
              break;
      }
    }

    // registrasi
    public function registration()
    {
        if ($this->session->userdata('user_name')) {
            redirect('user');
        }
        $this->form_validation->set_rules('fname', 'fname', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('sname', 'sname', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('tname', 'tname', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('lname', 'lname', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('user_name', 'user_name', 'required|trim|is_unique[user.user_name]', [
            'required' => 'حقل واجب الإدخال!',
            'valid_email' => 'حساب خاطىء!',
            'is_unique' => 'الحساب مسجل مسبقاً!'
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[5]|matches[password2]', [
            'required' => 'حقل واجب الإدخال!',
            'matches' => 'كلمات السر غير متوافقة!',
            'min_length' => 'كلمة المرور قصيرة للغاية!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|min_length[5]|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'إنشاء حساب جديد';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration', $data);
            $this->load->view('templates/auth_footer');
        }
        else
        {
            $user_name= $this->input->post('user_name', true);
            $password = $this->input->post('password');
            $fname=$this->input->post('fname', true);
            $sname=$this->input->post('sname', true);
            $tname=$this->input->post('tname', true);
            $lname=$this->input->post('lname', true);
            $full_name=$fname.' '.$sname.' '.$tname.' '.$lname;
            $data = [
                'fname' => htmlspecialchars($fname),
                'sname' => htmlspecialchars($sname),
                'tname' => htmlspecialchars($tname),
                'lname' => htmlspecialchars($lname),
                'full_name' => $full_name,
                'user_name' => htmlspecialchars($user_name),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,//0,
                'date_created' => date("d-m-Y"),//time()
            ];
           $result= $this->db->insert('user', $data);
          //  var_dump($result);die();
            $userCheck = $this->UserModel->verify_user($user_name, $password);
            if (isset($userCheck)) {
                $user = $this->db->get_where('user', ['user_name' => $user_name])->row_array();
                $data = [
                    'identity' => $user['identity'],
                    'user_name' => $user['user_name'],
                    'role_id' => $user['role_id'],
                    'id' => $user['id'],
                ];
                $this->session->set_userdata($data);
                // cek role
                if ($user['is_emp'] == "1") {
                    redirect('admin');
                } else {
                    redirect('user');
                }
            }

        }
    }

    // logout
    public function logout()
    {
        $this->session->sess_destroy();
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم تسجيل الخروج بنجاح!</div>');
        redirect('auth');
    }

    // blocked
    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    // reset password
    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            // jika ada email
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            
            if ($user_token) {
                // jika token valid
                $this->session->set_userdata('reset_email', $email);
                $this->changepassword();
            } else {
                // jika token tidak valid
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Reset password failed! Invalid token</div>');
                redirect('auth');
            }

        } else {
            // jika email tidak ada
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            Reset password failed! Email is not registered</div>');
            redirect('auth');
        }
    }

    // change password
    public function changepassword()
    {
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'New password', 'required|trim|min_length[5]|matches[password2]', [
            'required' => 'Enter a new password!',
            'min_length' => 'Password is too short!',
            'matches' => 'Passwords does not match at all!'
        ]);
        $this->form_validation->set_rules('password2', 'Confirm new password', 'required|trim|min_length[5]|matches[password1]', [
            'required' => 'Enter a new password!',
            'min_length' => 'Password is too short!',
            'matches' => 'Passwords does not match at all!' 
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change_password', $data);
            $this->load->view('templates/auth_footer');
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->unset_userdata('reset_email');
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Password changed successfully! Please login.</div>');
            redirect('auth');
        }
    }

}