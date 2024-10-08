<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
        //var_dump($this->session->userdata());die();
    }

    // index view user info
    public function index($title='الملف الشخصي')
    {
        $data['title'] =$title ;//My Profile
        $data['viewName']='user/index';
        $data['withParam']='y';

        parent::index($data);
    }

    // edit profile
    public function edit($id=NULL)
    {
        if($id==NULL)
            $id=$this->session->userdata('id');
        $data['title'] = 'تعديل الملف الشخصي';
        $data['user'] = $this->db->get_where('user', ['id' => $id])->row_array();

        $this->form_validation->set_rules('name', 'Full name', 'required', [
            'required' => 'Full name is required!'
        ]);

        if ($this->form_validation->run() == false) {
            $data['viewName']='user/edit';
            $data['withParam']='y';

            parent::index($data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            // upload image
            $upload_image = $_FILES['image']['name'];
            
            if ($upload_image) {
                $config['allowed_types']    = 'jpg|jpeg|png';
                $config['max_size']         = '6000';
                $config['upload_path']      = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH.'/assets/img/profile/'.$old_image);
                    }

                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {
                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('full_name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم تعديل الملف الشخصي بنجاح!</div>');
            redirect('user');
        }
        
    }

    // change password user
    public function changepassword()
    {
        $data['title'] = 'تغيير كلمة المرور';
        $data['user'] = $this->db->get_where('user', ['user_name' => $this->session->userdata('user_name')])->row_array();

        $this->form_validation->set_rules('current_password', 'Old password', 'required|trim', [
            'required' => 'حقل واجب الإدخال!'
        ]);
        $this->form_validation->set_rules('new_password1', 'New password', 'required|trim|min_length[5]|matches[new_password2]', [
            'required' => 'حقل واجب الإدخال!',
            'min_length' => 'كلمة مرور قصيرة!',
            'matches' => 'كلمة المرور غير متطابقة!'
        ]);
        $this->form_validation->set_rules('new_password2', 'Confirm new password', 'required|trim|min_length[5]|matches[new_password1]', [
            'required' => 'حقل واجب الإدخال!',
            'min_length' => 'كلمة مرور قصيرة!',
            'matches' => 'كلمة المرور غير متطابقة!'
        ]);
        
        if ($this->form_validation->run() == false) {
            $this->load->view('templates/admin_header', $data);
            $this->load->view('templates/admin_sidebar');
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
               كلمة مرور خاطئة!</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    كلمة المرور الجديدة يجب الا تكون هي نفسها القديمة!</div>');
                    redirect('user/changepassword');
                } else {
                    // password ok!
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');
                    
                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                   تم تعديل كلمة المرور بنجاح!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

    // delete acc
    public function deleteuser($id)
    {
        $this->db->delete('user', ['id' => $id]);
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Account deleted successfully!</div>');
        redirect('auth');
    }

    // Calculate age function
    function calculate_age($dob) {
        $dob = new DateTime($dob);
        $today = new DateTime(date("Y-m-d"));
        $age = $today->diff($dob)->y;
        return $age;
    }
}