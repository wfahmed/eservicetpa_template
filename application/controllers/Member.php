<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    // function index view
    public function index($title='سطح المكتب')
    {
        $data['title']=$title;
        $data['viewName']='admin/index';
        $data['withParam']='n';
        parent::index($data);
    }

    // data member info
    public function add_member($title='سطح المكتب')
    {
       $this->form_validation->set_rules('user_status', 'user_status', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('fname', 'Fname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('sname', 'sname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('tname', 'tname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('lname', 'lname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('identity', 'identity', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('incom', 'incom', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('after_death_incom', 'after_death_incom', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('asylum_status', 'asylum_status', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('naturalwork', 'naturalwork', 'required', ['required' => 'حقل واجب الإدخال!' ]);

        // var_dump($_POST);die();
        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة مستخدم';
            $data['viewName'] = 'member/add_member';
            $data['param']['DEATH_REASON'] = (array)$this->db->get_where('constants', ['parent_id' => DEATH_REASON])->result_array();
            $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
            $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();

//var_dump($data['param']['DEATH_REASON']);die();
            $data['withParam'] = 'y';
            parent::index($data);
        }else{
            //var_dump($this->input->post('fname'));die();
            $fname=$this->input->post('fname');
            $sname=$this->input->post('sname');
            $tname=$this->input->post('tname');
            $lname=$this->input->post('lname');
            $death_date=$this->input->post('death_date');
             $data = [
                 'fname' =>$fname ,
                 'sname' => $sname,
                 'tname' =>$tname,
                 'lname' => $lname,
                 'name' => $fname.' '.$sname.' '.$tname.' '.$lname,
                 'identity' => $this->input->post('identity'),
                 'death_date' => date('d-m-Y', $death_date) ,
                 'death_reason' => $this->input->post('death_reason'),
                 'user_status' => $this->input->post('user_status'),
                 'asylum_status' => $this->input->post('asylum_status'),
                 'naturalwork' => $this->input->post('naturalwork'),
                 'incom' => $this->input->post('incom'),
                 'after_death_incom' => $this->input->post('after_death_incom'),
                 'created_by' => $this->session->userdata('id'),
                 'created_at' => date('Y-m-d')
             ];
            // var_dump($data);die();
            if($this->db->insert('user',$data)){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                redirect('member/edit_member/'.$this->db->insert_id());
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('member/datamember');
            }
        }
    }

    public function edit_member($id,$tab_id='father',$title='سطح المكتب')
    {
        $this->form_validation->set_rules('user_status', 'user_status', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('fname', 'Fname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('sname', 'sname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('tname', 'tname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('lname', 'lname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('identity', 'identity', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('incom', 'incom', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('after_death_incom', 'after_death_incom', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('asylum_status', 'asylum_status', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('naturalwork', 'naturalwork', 'required', ['required' => 'حقل واجب الإدخال!' ]);

        // var_dump($_POST);die();
        if ($this->form_validation->run() == false) {
            $data['viewName'] = 'member/edit_member';
            $data['param']['DEATH_REASON'] = (array)$this->db->get_where('constants', ['parent_id' => DEATH_REASON])->result_array();
            $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
            $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
            $data['param']['CONTACT_TYPE'] = (array)$this->db->get_where('constants', ['parent_id' => CONTACT_TYPE])->result_array();
            $data['param']['CURRENT_RESIDENCE'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENT_RESIDENCE])->result_array();
            $data['param']['GOVERNORATES'] = (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
            $data['param']['DWELLING_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_STATUS])->result_array();
            $data['param']['DWELLING_NATURE'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_NATURE])->result_array();
            $data['param']['VALLEY_SIDE'] = (array)$this->db->get_where('constants', ['parent_id' => VALLEY_SIDE])->result_array();

            $datap= $this->db->get_where('user', ['id' => $id])->row_array();
            $data['param']['user_row'] =$datap;
            $data['title'] = 'تعديل بيانات  '.$datap['name'];
            $join_array = array(
                array(
                    'table_name' => 'constants',
                    'condition' => 'user_contact.contact_type = constants.id'
                ),
            );
            $dataContacts = $this->Base_model->get_with_join('user_contact.*,constants.title', 'user_contact', $join_array, '  user_contact.deleted_by  is  null ', 'user_contact.id asc');

            $data['param']['tab_id'] =$tab_id;
            $data['param']['contacts'] =$dataContacts;
            $data['param']['js_file'][0] ='\assets\custom\tab_manage.js';
            $data['withParam'] = 'y';
            parent::index($data);
        }else{
            //var_dump($this->input->post('fname'));die();
            $fname=$this->input->post('fname');
            $sname=$this->input->post('sname');
            $tname=$this->input->post('tname');
            $lname=$this->input->post('lname');
            $death_date=$this->input->post('death_date');
            $death_date=date('d-m-Y', strtotime($death_date));
            $data = [
                'fname' =>$fname ,
                'sname' => $sname,
                'tname' =>$tname,
                'lname' => $lname,
                'name' => $fname.' '.$sname.' '.$tname.' '.$lname,
                'identity' => $this->input->post('identity'),
                 'death_date' => $death_date ,
                'death_reason' => $this->input->post('death_reason'),
                'user_status' => $this->input->post('user_status'),
                'asylum_status' => $this->input->post('asylum_status'),
                'naturalwork' => $this->input->post('naturalwork'),
                'incom' => $this->input->post('incom'),
                'after_death_incom' => $this->input->post('after_death_incom'),
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];
            // var_dump($data);die();
            if($this->db->update('user',$data, ['id' => $id])){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
               redirect('member/edit_member/'.$id);
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('member/datamember');
            }
        }
    }

    public function datamember()
    {
        $data['title'] = 'بيانات المستخدم';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['user_member'] = $this->db->order_by('id', 'DESC');
        $data['user_member'] = $this->db->get_where('user', ['role_id' => 2])->result_array();

        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/data_member', $data);
        $this->load->view('templates/admin_footer');
    }

    // info detail member
    public function detailmember($id)
    {
        $data['title'] = 'معلومات المستخدم';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['member'] = $this->db->get_where('user', ['id' => $id])->row_array();

        $this->load->view('templates/admin_header', $data);
        $this->load->view('templates/admin_sidebar');
        $this->load->view('templates/admin_topbar', $data);
        $this->load->view('admin/detail_member', $data);
        $this->load->view('templates/admin_footer');
    }

    // delete member
    public function deletemember($id)
    {
        $this->db->delete('user', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
        redirect('member/datamember');
    }

    // edit member
    public function editmember($id)
    {
        $this->form_validation->set_rules('name', 'Name', 'required');
        
        if ($this->form_validation->run() == false) {
            $data['title'] = 'تعديل معلومات المستخدم';
            $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['member'] = $this->db->get_where('user', ['id' => $id])->row_array();
            $this->load->view('templates/admin_header', $data);
            $this->load->view('templates/admin_sidebar');
            $this->load->view('templates/admin_topbar', $data);
            $this->load->view('member/edit_member', $data);
            $this->load->view('templates/admin_footer');
        } else {
            $data = [
                'id' => $this->input->post('id'),
                'name' => $this->input->post('name'),
                'email' => $this->input->post('email'),
                'role_id' => $this->input->post('role_id'),
                'is_active' => $this->input->post('is_active')
            ];
                
            $this->db->update('user', $data, ['id' => $data['id']]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل بنجاح!</div>');
            redirect('member/datamember');
        }
    }

/**contact*/
    public function add_contact($title='سطح المكتب')
    {
        $this->form_validation->set_rules('contact_type', 'contact_type', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('contact_value', 'contact_type', 'required', ['required' => 'حقل واجب الإدخال!' ]);

        // var_dump($_POST);die();
        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة وسيلة اتصال';
            $data['viewName'] = 'member/edit_member';
            $data['param']['DEATH_REASON'] = (array)$this->db->get_where('constants', ['parent_id' => DEATH_REASON])->result_array();
            $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
            $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
            $data['param']['CONTACT_TYPE'] = (array)$this->db->get_where('constants', ['parent_id' => CONTACT_TYPE])->result_array();
//var_dump($data['param']['DEATH_REASON']);die();
            $data['withParam'] = 'y';
            parent::index($data);
        }else{
            //var_dump($_POST);die();
            $contact_type=$this->input->post('contact_type');
            $contact_value=$this->input->post('contact_value');
            $user_id=$this->input->post('user_id');
            $data = [
                'user_id'=>$user_id ,
                'contact_type' =>$contact_type ,
                'contact_value' => $contact_value,
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d')
            ];
            // var_dump($data);die();
            if($this->db->insert('user_contact',$data)){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');


                redirect('member/edit_member/'.$user_id);
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('member/edit_member/'.$user_id);
            }
        }
    }

    public function delete_member_contact($id,$user_id,$tab_id='contact')
    {
        $this->db->delete('user_contact', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');

        redirect('member/edit_member/'.$user_id.'/contact');
    }
/**dwelling**********/
    public function edit_dwelling($id,$tab_id='dwelling',$title='سطح المكتب'){
$this->form_validation->set_rules('original_residence', 'original_residence', 'required', ['required' => 'حقل واجب الإدخال!' ]);
$this->form_validation->set_rules('dwelling_nature', 'dwelling_nature', 'required', ['required' => 'حقل واجب الإدخال!' ]);
$this->form_validation->set_rules('dwelling_damage', 'dwelling_damage', 'required', ['required' => 'حقل واجب الإدخال!' ]);
$this->form_validation->set_rules('current_residence_status', 'current_residence_status', 'required', ['required' => 'حقل واجب الإدخال!' ]);
$this->form_validation->set_rules('current_residence', 'current_residence', 'required', ['required' => 'حقل واجب الإدخال!' ]);
$this->form_validation->set_rules('governorate', 'governorate', 'required', ['required' => 'حقل واجب الإدخال!' ]);
$this->form_validation->set_rules('nearest_famous_place', 'nearest_famous_place', 'required', ['required' => 'حقل واجب الإدخال!' ]);
$this->form_validation->set_rules('Local_area', 'Local_area', 'required', ['required' => 'حقل واجب الإدخال!' ]);
$this->form_validation->set_rules('valley_side', 'valley_side', 'required', ['required' => 'حقل واجب الإدخال!' ]);

    // var_dump($_POST);die();
if ($this->form_validation->run() == false) {

$data['viewName'] = 'member/edit_member';
$data['param']['DEATH_REASON'] = (array)$this->db->get_where('constants', ['parent_id' => DEATH_REASON])->result_array();
$data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
$data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
$data['param']['CONTACT_TYPE'] = (array)$this->db->get_where('constants', ['parent_id' => CONTACT_TYPE])->result_array();
$data['param']['CURRENT_RESIDENCE'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENT_RESIDENCE])->result_array();
$data['param']['GOVERNORATES'] = (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
$data['param']['DWELLING_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_STATUS])->result_array();
$data['param']['DWELLING_NATURE'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_NATURE])->result_array();
$data['param']['VALLEY_SIDE'] = (array)$this->db->get_where('constants', ['parent_id' => VALLEY_SIDE])->result_array();

$datap= $this->db->get_where('user', ['id' => $id])->row_array();
$data['title'] = 'تعديل بيانات  '.$datap['name'];
$data['param']['user_row'] =$datap;

$join_array = array(
array(
'table_name' => 'constants',
'condition' => 'user_contact.contact_type = constants.id'
),
);
$dataContacts = $this->Base_model->get_with_join('user_contact.*,constants.title', 'user_contact', $join_array, '  user_contact.deleted_by  is  null ', 'user_contact.id asc');

$data['param']['tab_id'] =$tab_id;
$data['param']['contacts'] =$dataContacts;
$data['param']['js_file'][0] ='\assets\custom\tab_manage.js';
$data['withParam'] = 'y';
parent::index($data);
}else{
    $data = [
        'original_residence' =>$this->input->post('original_residence') ,
        'dwelling_nature' =>$this->input->post('dwelling_nature') ,
        'dwelling_damage' =>$this->input->post('dwelling_damage') ,

        'current_residence_status' =>$this->input->post('current_residence_status') ,
        'current_residence' =>$this->input->post('current_residence') ,
        'governorate' =>$this->input->post('governorate') ,

        'nearest_famous_place' =>$this->input->post('nearest_famous_place') ,
        'Local_area' =>$this->input->post('Local_area') ,
        'valley_side' =>$this->input->post('valley_side') ,

        'updated_by' => $this->session->userdata('id'),
        'updated_at' => date('Y-m-d')
    ];
    // var_dump($data);die();
    if($this->db->update('user',$data, ['id' => $id])){
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
        redirect('member/edit_member/'.$id.'/'.$tab_id);
    }else{
        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
        redirect('member/datamember');

    }
}
}

    private function objectToArray($obj) {
    return json_decode(json_encode($obj), true);
}
}