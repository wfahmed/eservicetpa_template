<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

    }
    // login
    public function index()
    {

        if ($this->session->userdata('user_name')) {
           // var_dump('in auth new '.$this->session->userdata('id'));die();
            redirect('User');
        }

        $this->form_validation->set_rules('user_name', 'user_name', 'required|trim', [
            'required' => 'حقل واجب الادخال',
        ]);
        $this->form_validation->set_rules('password', 'Password', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);

        if ($this->form_validation->run() == false) {
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

    // valid login sukses
    private function _login()
    {
        $user_name = $this->input->post('user_name');
        $password = $this->input->post('password');

        $user = $this->db->get_where('user', ['user_name' => $user_name])->row_array();

        // jika user ada
        if ($user) {
           // var_dump($user);die();
            // jika user nya aktif
            if ($user['is_active'] == '1') {

                // cek passwordnya
                if (password_verify($password, $user['password'])) {

                    $data = [
                        'email' => $user['email'],
                        'identity' => $user['identity'],
                        'user_name' => $user['user_name'],
                        'role_id' => $user['role_id'],
                        'id' => $user['id'],
                    ];

                    $this->session->set_userdata($data);
                    // cek role

                    if ($user['role_id'] == "1") {
                       // var_dump($user['role_id']);die();
                        redirect('admin');
                    } else {
                        var_dump($user['role_id']);die();
                        redirect('user');
                    }
                }else{
                    // jika gagal
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    كلمة سر خاطئة!</div>');
                    redirect('auth');
                }
            } else {
                // tidak aktif
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                لم يتم التحديث!</div>');
                redirect('auth');
            }   
        } else {
            // tidak ada user dengan email itu
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            الحساب موجود مسبقا!</div>');
            redirect('auth');
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
        } else {
            $user_name= $this->input->post('user_name', true);
            $email= $this->input->post('email', true);
            $fname=$this->input->post('fname', true);
            $sname=$this->input->post('sname', true);
            $tname=$this->input->post('tname', true);
            $lname=$this->input->post('lname', true);
            $name=$fname.' '.$sname.' '.$tname.' '.$lname;
            $data = [
                'fname' => htmlspecialchars($fname),
                'sname' => htmlspecialchars($sname),
                'tname' => htmlspecialchars($tname),
                'lname' => htmlspecialchars($lname),
                'name' => $name,
                'email' => htmlspecialchars($email),
                'user_name' => htmlspecialchars($user_name),
                'image' => 'default.jpg',
                'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'role_id' => 2,
                'is_active' => 1,//0,
                'date_created' => date("d-m-Y"),//time()
            ];

            // token
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date_created' => time()
            ];

            $this->db->insert('user', $data);
            $this->db->insert('user_token', $user_token);

        /*    $this->_sendemail($token, 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            برجاء فحص الاميل لتنشيط الحساب!</div>');*/
            redirect('auth');
        }
    }

    // _sendemail
    private function _sendemail($token, $type)
    {
        $config = array();
        $config['protocol']  = 'smtp';
        $config['smtp_host'] = 'ssl://smtp.gmail.com';
        $config['smtp_user'] = 'wafa3ahmed@gmail.com';
        $config['smtp_pass'] = 'java&oracle81';
        $config['smtp_port'] = 465;
        $config['mailtype']  = 'html';
        $config['charset']   = 'utf-8';

        $this->load->library('email');
        $this->load->initialize($config);
        $this->email->initialize($config);
        $this->email->set_newline("\r\n");

        $this->email->from('wafa3ahmed@gmail.com', 'المنظومة الإلكترونية');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Dear User, Please click the URL for your account verification : <a href="' . base_url() .'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) .'">Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset password');
            $this->email->message('Click this address to reset your password: <a href="' . base_url() .'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) .'">Reset password</a>');
        }

        if ($this->email->send()) {
            return true; 
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    // verify
    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            // jika email benar
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                // jika token benar

                if (time() - $user_token['date_created'] < (60*60*24)) {
                    // token belum expired
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    '. $email .' Activated! Please login.</div>');
                    redirect('auth');
                } else {
                    // token expired
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    فشل تنشيط الحساب لانتهاء كود التحقق</div>');
                    redirect('auth');
                }

            } else {
                // token salah
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                فشل تنشيط الحساب</div>');
                redirect('auth');
            }

        } else {
            // email salah
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل تنشيط الحساب الايميل غير متوفر</div>');
            redirect('auth');
        }
    }

    // logout
    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('identity');
        $this->session->unset_userdata('user_name');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم تسجيل الخروج بنجاح!</div>');
        redirect('auth');
    }

    // blocked
    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    // forgot password
    public function forgotpassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email', [
            'required' => 'Email must be filled!',
            'valid_email' => 'Invalid email!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot_password', $data);
            $this->load->view('templates/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                // jika ada user buat token
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendemail($token, 'forgot');
                
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Please check your email to reset your password!</div>');
                redirect('auth/forgotpassword');
            } else {
                // email tidak terdaftar
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Email is not registered or not yet activated!</div>');
                redirect('auth/forgotpassword');
            }
        }
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