<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', 1);

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

    public function validate_contact(){
        $contact_type=$this->input->post('contact_type');
        $contact_value=$this->input->post('contact_value');

        $data= $this->db->get_where('user_contact', ['contact_type ' => $contact_type ,'contact_value ' => $contact_value ])->result_array();
        if(count($data)>0){
            $response = [
                'status' => 0,
                'message' => 'وسيلة الاتصال مدخلة مسبقاً لــ  ',
                'user_id' =>$data[0]['id'],
            ];

        }else{
            $response = [
                'status' => 1,
                'message' => 'بيانات صحيحة',
                'user_id' =>0,
            ];
        }
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }
    // data member info
    public function validate_identity()
    {
        $identity=$this->input->post('identity');
        $form=$this->input->post('form');
        $maretal_status_id=$this->input->post('type');
        $huspand_user_id=$this->input->post('parent_user_id');
        $parent_user_id=$this->input->post('parent_user_id');
        $data=[];
        switch ($form){
            case 'father':
                $data= $this->db->get_where('user', ['identity ' => $identity,])->result_array();
                break;
            case 'wife':

                $data= $this->db->get_where('user', ['identity ' => $identity,'huspand_user_id ' => $huspand_user_id,'maretal_status_id ' => $maretal_status_id])->result_array();
                break;
            case 'child':
                $data= $this->db->get_where('user', ['identity ' => $identity,'parent_user_id ' => $parent_user_id])->result_array();
                break;
        }

        if(count($data)>0){
            $response = [
                'status' => 0,
                'message' => 'رقم الهوية مدخل مسبقاً لــ  '.$data[0]['full_name'],
                'user_id' =>$data[0]['id'],
                'from' =>$form,
                'huspand_user_id' =>$huspand_user_id,
                'maretal_status_id' =>$maretal_status_id,
            ];

        }else{
            $response = [
                'status' => 1,
                'message' => 'رقم الهوية  صحيح',
                'user_id' =>0,
                'from' =>$form,
                'huspand_user_id' =>$huspand_user_id,
                'maretal_status_id' =>$maretal_status_id,
            ];
        }
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);exit();
    }

    public function add_member($huspand_id=null,$tab_id=1,$title='سطح المكتب')
    {
       $this->form_validation->set_rules('user_status', 'user_status', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('fname', 'Fname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('sname', 'sname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('tname', 'tname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('lname', 'lname', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('identity', 'identity', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('asylum_status', 'asylum_status', 'required', ['required' => 'حقل واجب الإدخال!' ]);
        $this->form_validation->set_rules('naturalwork', 'naturalwork', 'required', ['required' => 'حقل واجب الإدخال!' ]);

        // var_dump($_POST);die();
        if ($this->form_validation->run() == false) {
            $data['title'] = 'إضافة رب الأسرة';
            $data['viewName'] = 'member/add_member';
            $data['param']['DEATH_REASON'] = (array)$this->db->get_where('constants', ['parent_id' => DEATH_REASON])->result_array();
            $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
            $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
            $data['param']['MARETAL_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => MARETAL_STATUS])->result_array();

           // $data['param']['js_file'][0] ='\assets\custom\jquery.js';
            $data['param']['js_file'][0] ='\assets\custom\validate_identity.js';
            $data['param']['js_file'][1] ='\assets\custom\validate_name.js';
            $data['param']['js_file'][2] ='\assets\custom\add_member.js';
            $data['withParam'] = 'y';
            parent::index($data);
        }else{
            $mother_user_id=$this->input->post('mother_user_id');
            $mother_user_id = empty($mother_user_id) ? NULL : $mother_user_id;
            $fname=$this->input->post('fname');
            $sname=$this->input->post('sname');
            $tname=$this->input->post('tname');
            $lname=$this->input->post('lname');
            $dob=$this->input->post('dob');
            $parent_user_id=NULL;
            $relation_type=FAMILY_HEADER;
            $deathDate=NULL;
            if($tab_id==4){
                if($huspand_id!=null){
                    $relation_type=WIFE;
                    $deathDate='';
                    $parent_user_id=NULL;
                }else{
                    $parent_user_id=NULL;
                    $death_date=$this->input->post('death_date');
                    if($death_date)
                        $deathDate= date('d-m-Y', $death_date);
                    else
                        $deathDate=NULL;
                    $relation_type=FAMILY_HEADER;
                }
            }

            if($tab_id==5){
                if($huspand_id!=null){
                    $huspand_id=NULL;
                    $relation_type=$this->input->post('relation_type_id');
                    $parent_user_id=$this->input->post('parent_user_id');
                    $death_date=$this->input->post('child_death_date');
                    $dob=$this->input->post('dob_child');
                    if($death_date){
                        $timestamp = strtotime($death_date); // Convert to timestamp
                        $deathDate= date('Y-m-d', $timestamp);
                    }
                    else
                        $deathDate=NULL;
                    if($dob)
                    {
                        $timestamp = strtotime($dob); // Convert to timestamp
                        $dob = date('Y-m-d', $timestamp); // Format the date
                    }
                    else
                        $dob=NULL;
                }
            }


             $data = [
                 'parent_user_id' =>$parent_user_id ,
                 'fname' =>$fname ,
                 'sname' => $sname,
                 'tname' =>$tname,
                 'lname' => $lname,
                 'mother_user_id' => $mother_user_id,
                 'full_name' => $fname.' '.$sname.' '.$tname.' '.$lname,
                 'identity' => $this->input->post('identity'),
                 'death_date' =>$deathDate ,
                 'dob' => $dob,
                 'death_reason_id' => $this->input->post('death_reason'),
                 'user_status_id' => $this->input->post('user_status'),
                 'asylum_status_id' => $this->input->post('asylum_status'),
                 'naturalwork_id' => $this->input->post('naturalwork'),
                 'maretal_status_id' => $this->input->post('maretal_status'),
                 'incom' => $this->input->post('incom'),
                 'huspand_user_id' => $huspand_id,
                 'relation_type_id' => $relation_type,
                 'after_death_incom' => $this->input->post('after_death_incom'),
                 'created_by' => $this->session->userdata('id'),
                 'created_at' => date('Y-m-d')
             ];
         //  var_dump($_POST);
       //  var_dump($data); die();
            if($this->db->insert('user',$data)){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
                switch($tab_id){
                    case 4:
                        $huz_user_id=$huspand_id;//$this->input->post('huz_user_id');
                       /* var_dump($huz_user_id);
                        var_dump($tab_id);die();*/
                        redirect('member/edit_member/'.$huz_user_id.'/4');
                        break;
                    case 5:
                        $parent_user_id=$parent_user_id;//$this->input->post('parent_user_id');
                        redirect('member/edit_member/'.$parent_user_id.'/5');
                        break;
                    default:
                        redirect('member/edit_member/'.$this->db->insert_id());
                        break;
                }
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('member/datamember');
            }
        }
    }

    public function edit_member($id=null,$tab_id='1',$title='سطح المكتب')
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة ، اختر العضو لتتمكن من تعديله';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
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
            $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();

            $datap= $this->db->get_where('user', ['id' => $id])->row_array();
            $data['param']['user_row'] =$datap;
            $data['title'] = 'تعديل بيانات  '.$datap['full_name'];

            $data['param']['tab_id'] =$tab_id;
            $data['param']['id'] =$id;
            $data['param']['js_file'][0] ='\assets\custom\tab_manage.js';
            $data['param']['js_file'][1] ='\assets\custom\validate_identity.js';
            $data['param']['js_file'][2] ='\assets\custom\validate_name.js';
            $data['param']['js_file'][3] ='\assets\custom\contact.js';
            $data['param']['js_file'][4] ='\assets\custom\member.js';
            $data['withParam'] = 'y';
            parent::index($data);
        }else{
            //var_dump($this->input->post('fname'));die();
            $fname=$this->input->post('fname');
            $sname=$this->input->post('sname');
            $tname=$this->input->post('tname');
            $lname=$this->input->post('lname');
            $mother_user_id=$this->input->post('mother_user_id');
            $mother_user_id = empty($mother_user_id) ? NULL : $mother_user_id;
            $relation_type=$this->input->post('relation_type_id');
            switch ($tab_id){
                case '1' :
                    $dob=$this->input->post('dob_father');
                    $death_date=$this->input->post('father_death_date');
                    $death_date=date('Y-m-d', strtotime($death_date));
                    break;
                case '4' :
                    $dob=$this->input->post('dob_wife');
                    $death_date=$this->input->post('wife_death_date');
                    $death_date=date('Y-m-d', strtotime($death_date));
                break;
                case '5' :
                    $dobPost=$this->input->post('dob_child_detail');
                    $death_date=$this->input->post('child_death_date_detail');
                    $death_date=date('Y-m-d', strtotime($death_date));
                    $dob=date('Y-m-d', strtotime($dobPost));
                    break;
            }
            $data = [
                'fname' =>$fname ,
                'sname' => $sname,
                'tname' =>$tname,
                'lname' => $lname,
                'full_name' => $fname.' '.$sname.' '.$tname.' '.$lname,
                'identity' => $this->input->post('identity'),
                'dob' => $dob,
                'mother_user_id' => $mother_user_id,
                 'death_date' => $death_date ,
                'death_reason_id' => $this->input->post('death_reason'),
                'relation_type_id' => $relation_type,
                'user_status_id' => $this->input->post('user_status'),
                'asylum_status_id' => $this->input->post('asylum_status'),
                'naturalwork_id' => $this->input->post('naturalwork'),
                'maretal_status_id' => $this->input->post('maretal_status'),
                'gender_id' => $this->input->post('gender'),
                'incom' => $this->input->post('incom'),
                'after_death_incom' => $this->input->post('after_death_incom'),
                'updated_by' => $this->session->userdata('id'),
                'updated_at' => date('Y-m-d')
            ];
            // var_dump($data);die();
            if($this->db->update('user',$data, ['id' => $id])){
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل  بنجاح</div>');
                switch($tab_id){
                    case 4:
                        $huz_user_id=$this->input->post('huz_user_id');
                        redirect('member/edit_member/'.$huz_user_id.'/4');
                        break;
                    case 5:
                        $parent_user_id=$this->input->post('parent_user_id');
                        redirect('member/edit_member/'.$parent_user_id.'/5');
                        break;
                    default:
                        redirect('member/edit_member/'.$id);
                        break;
                }

            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('member/datamember');
            }
        }
    }

    public function emp_show()
    {
        $this->datamember('emp','إدارة الموظفين');
    }

    public function citizen_show()
    {
        $this->datamember('all','إدارة المواطنين');
    }

    public function child_show()
    {
        $this->datamember('child','إدارة الأطفال');
    }

    public function family_orphan_show()
    {
        $this->datamember('family_orphan','إدارة أسر الأيتام');
    }

    public function family_show()
    {
         $this->datamember('family','إدارة الأسرة');
    }

    public function datamember($condition=NULL,$title=null)
    {
        if ($condition === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد بيانات';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
        $user_members=array();
        $data['title'] = $title;
        $data['user'] = $this->db->get_where('user', ['user_name' => $this->session->userdata('user_name')])->row_array();
       // $data['user_member'] = $this->db->order_by('id', 'DESC');
        switch ($condition) {
            case 'emp':
                $user_members = $this->db->get_where('user', ['role_id' => 1,'deleted_by' => NULL])->result_array();
                break;
            case 'all':
                $user_members= $this->db->get_where('user', ['deleted_by' => NULL])->result_array();
                break;
            case 'family':
                $user_members= $this->db->get_where('user', ['deleted_by' => NULL,'relation_type_id' => FAMILY_HEADER])->result_array();
                break;

                case 'family_orphan':
                    $this->db->where('deleted_by', NULL); // Condition for 'deleted_by'
                    $this->db->where('relation_type_id', FAMILY_HEADER); // Condition for 'relation_type_id'

                    // Use 'where_in' for the 'IN' clause
                    $this->db->where_in('user_status_id', [5, 6, 18]);

                    // Execute the query
                    $user_members = $this->db->get('user')->result_array();
                    break;
            case 'child':
                 $user_members= $this->db->get_where('user', ['deleted_by' => NULL,'age < ' => CHILD_AGE])->result_array();
                 break;

            default:
                $data['title'] = 'خطأ';

                $data['message'] = 'لايوجد بيانات';
                $data['return'] = 'member';
                $this->load->view('error_custom', $data);
                return;
        }

        $data['param']['user_members'] =$user_members;
        $data['param']['condition'] =$condition;
        $data['viewName']='member/data_member';
        $data['withParam']='y';
        parent::index($data);

    }

    public function load_tab($tab_id,$id) {
        $data['param']['DEATH_REASON'] = (array)$this->db->get_where('constants', ['parent_id' => DEATH_REASON])->result_array();
        $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
        $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
        $data['param']['MARETAL_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => MARETAL_STATUS])->result_array();
        $data['param']['CONTACT_TYPE'] = (array)$this->db->get_where('constants', ['parent_id' => CONTACT_TYPE])->result_array();
        $data['param']['CURRENT_RESIDENCE'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENT_RESIDENCE])->result_array();
        $data['param']['GOVERNORATES'] = (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
        $data['param']['DWELLING_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_STATUS])->result_array();
        $data['param']['DWELLING_NATURE'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_NATURE])->result_array();
        $data['param']['VALLEY_SIDE'] = (array)$this->db->get_where('constants', ['parent_id' => VALLEY_SIDE])->result_array();
        $data['param']['RELATION'] = (array)$this->db->get_where('constants', ['parent_id' => RELATION])->result_array();
//,'user_status_id'=>LIVE
        $datap= $this->db->get_where('user', ['id' => $id])->row_array();
        $dataWife= $this->db->get_where('user', ['huspand_user_id' => $id])->result_array();
        $result= $this->db->get_where('user', ['huspand_user_id' => $id,'maretal_status_id !='=>DIVORCED])->result_array();
       if($result)
            $user_wife_row=$result[0];
       else
           $user_wife_row=[];

        $join_array = array(
            array(
                'table_name' => 'constants pms',
                'condition' => 'user.relation_type_id  = pms.id '
            ),
            array(
                'table_name' => 'user mum',
                'condition' => 'user.mother_user_id  = mum.id '
            ),
        );
        $dataChild= $this->Base_model->get_with_join('user.*,user.id as uid,pms.title as relation_type,mum.fname as mother',
            'user', $join_array, '  user.deleted_by  is  null and user.parent_user_id='.$id,
            'user.id asc');

        if($dataChild)
            $user_child_row=$dataChild[0];
        else{
            $user_child_row=$dataChild=[];
        }

        $data['param']['user_row'] =$datap;
        $data['title'] = 'تعديل بيانات  '.$datap['full_name'];
        $join_array = array(
            array(
                'table_name' => 'constants',
                'condition' => 'user_contact.contact_type = constants.id'
            ),
        );
        $dataContacts = $this->Base_model->get_with_join('user_contact.*,constants.title', 'user_contact', $join_array, ' user_contact.user_id='.$id.' and  user_contact.deleted_by  is  null ', 'user_contact.id asc');

        $data['param']['tab_id'] =$tab_id;
        $data['param']['contacts'] =$dataContacts;
        $data['param']['wife'] =$dataWife;
        $data['param']['child'] =$dataChild;
        $data['param']['user_wife_row'] =$user_wife_row;
        $data['param']['user_child_row'] =$user_child_row;
       // var_dump($data['param']);die();
        $this->load->view('member/tab'.$tab_id.'_view',$data);
    }
    /**
     * info detail member
     * */
    public function detailmember($id=null)
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة ، اختر العضو لتتمكن من تعديله';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
        $data['title'] = 'معلومات المستخدم';
        $data['param']['member'] =  $this->db->get_where('user', ['id' => $id])->row_array();
//var_dump($data['param']['member'] );
        $data['viewName']='member/detail_member';
        $data['withParam']='y';
        parent::index($data);
    }

    /**
     * get_details
     */
    public function get_details()
    {
        $id=$this->input->post('id');
       $data=  $this->db->get_where('user', ['id' => $id])->row_array();
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($data);
    }

    /**
     * delete member
     */
    public function deletemember($id,$tab_id=1,$parent_id=null)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if($this->db->update('user',$data, ['id' => $id])){
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
        switch($tab_id){
            case 5:
                redirect('member/edit_member/'.$parent_id.'/5');
                break;
            default:
                redirect('member/family_show/');
                break;
        }
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        فشل الحذف!</div>');
            redirect('member/family_show/');
        }

    }

  /**
   *edit member
   */
    public function editmember($id)
    {
        $this->form_validation->set_rules('user_name', 'user_name', 'required');
        
        if ($this->form_validation->run() == false) {
            $data['title'] = 'تعديل معلومات المستخدم';

            $data['param']['member'] =  $this->db->get_where('user', ['id' => $id])->row_array();
            $data['viewName']='member/edit_member_light';
            $data['withParam']='y';
            parent::index($data);
        } else {
            $data = [
                'id' => $this->input->post('id'),
                'user_name' => $this->input->post('user_name'),
                'email' => $this->input->post('email'),
                'role_id' => $this->input->post('role_id'),
                'is_active' => $this->input->post('is_active')
            ];
                
            $this->db->update('user', $data, ['id' => $data['id']]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تم التعديل بنجاح!</div>');
            redirect('member/datamember/all');
        }
    }

/**
 * contact
 */
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


                redirect('member/edit_member/'.$user_id.'/2');
            }else{
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
            فشل التعديل</div>');
                redirect('member/edit_member/'.$user_id.'/2');
            }
        }
    }

    /**
     *delete_member_contact
     */
    public function delete_member_contact($id=null,$user_id=null,$tab_id='2')
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة ، اختر العضو لتتمكن من تعديله';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
        $this->db->delete('user_contact', ['id' => $id]);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');

        redirect('member/edit_member/'.$user_id.'/2
        ');
    }
/**
 * dwelling
 */
    public function edit_dwelling($id=null,$tab_id='3',$title='سطح المكتب'){
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة ، اختر العضو لتتمكن من تعديله';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
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
$data['param']['js_file'][1] ='\assets\custom\member.js';
$data['withParam'] = 'y';
parent::index($data);
}else{
    $data = [
        'original_residence' =>$this->input->post('original_residence') ,
        'dwelling_nature_id' =>$this->input->post('dwelling_nature') ,
        'dwelling_damage_id' =>$this->input->post('dwelling_damage') ,
        'current_governorate_id' =>$this->input->post('current_governorate_id') ,
        'current_residence_status_id' =>$this->input->post('current_residence_status') ,
        'current_residence' =>$this->input->post('current_residence') ,
        'governorate_id' =>$this->input->post('governorate') ,
        'nearest_famous_place' =>$this->input->post('nearest_famous_place') ,
        'Local_area' =>$this->input->post('Local_area') ,
        'valley_side_id' =>$this->input->post('valley_side') ,
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

    /**
     * objectToArray
     */
    private function objectToArray($obj) {
    return json_decode(json_encode($obj), true);
}
}