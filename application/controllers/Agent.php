<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Agent extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    // function index view
    public function index($id = null)
    {
        if ($id === null) {
            $data['title'] = 'خطأ';
            $data['message'] = 'لايوجد قيمة ، اختر العضو لتتمكن من تعديله';
            $data['return'] = 'member/index';
            $this->load->view('error_custom', $data);
            return;
        }
        $data['param']['RELATION'] = (array)$this->db->get_where('constants', ['parent_id' => RELATION])->result_array();
        $data['viewName'] = 'agent/index';
        $datap = $this->db->get_where('user', ['id' => $id])->row_array();
        $data['param']['user_row'] = $datap;
        $data['title'] = 'الوكيل لـ ' . $datap['full_name'];
        $join_array = array(
            array(
                'table_name' => 'constants pms',
                'condition' => 'user_agent.relation_type_id  = pms.id '
            ),
            array(
                'table_name' => 'user ',
                'condition' => 'user.id  = user_agent.agent_user_id '
            ),
        );
        $childAgent= $this->Base_model->get_with_join('user.*,user_agent.*,user.id as uid,pms.title as relation_type',
            'user_agent', $join_array, '  user.deleted_by  is  null and  user_agent.deleted_by  is  null  and user_agent.child_user_id='.$id,
            'user.id asc');
        //var_dump($childAgent);die();
        $data['param']['childAgent'] = $childAgent;
        $data['param']['id'] = $id;
        $data['param']['js_file'][0] = '\assets\custom\agent.js';
        $data['withParam'] = 'y';
        parent::index($data);
    }

    /**
     *  search_query
     */
    public function search_query()
{
    // Retrieve search input
    $search_query = $this->input->post('search_query');
    $child_user_id = $this->input->post('child_user_id');

    // Build the query
    $this->db->select('*'); // Adjust fields as needed
    $this->db->from('user');

    if (!empty($search_query)) {
        $this->db->group_start();
      //  $this->db->like('full_name', $search_query);
        $this->db->or_like('identity', $search_query);
        $this->db->group_end();
    }

    $query = $this->db->get();
    $results = $query->row_array(); // Get results as an associative array
    if(!empty($results)) {
        $agent_id = $results['id'];
        /* $res= $this->db->get_where('user', ['id ' => $agent_id])->result_array();
         $agent= $this->db->get_where('user_agent', ['agent_user_id ' => $agent_id])->result_array();
         $childAgent= $this->db->get_where('user_agent', ['child_user_id ' => $child_user_id])->result_array();*/
        $response = [
            'status' => 1,
            'response' => $results,
        ];
    }else{
        $response = [
            'status' => 0,
            'response' => $results,
        ];
    }
    // Return results as JSON
    echo json_encode($response);

}

    /**
     *  add
     */
    public function add()
    {
        // Retrieve  input
        $user_id= $this->input->post('user_id');
        $child_id= $this->input->post('child_id');
        $relation_type_id= $this->input->post('relation_type_id');
        $agent_approve_id= $this->input->post('agent_approve_id');
        $fname= $this->input->post('fname');
        $sname= $this->input->post('sname');
        $tname= $this->input->post('tname');
        $lname= $this->input->post('lname');
        $identity= $this->input->post('search_query');
        $details= $this->input->post('details');

        if (empty($user_id)) {
            $data = [
                'fname' =>$fname ,
                'sname' => $sname,
                'tname' => $tname,
                'lname' => $lname,
                'full_name' => $fname.' '.$sname.' '.$tname.' '.$lname,
                'identity' => $identity,
                'created_by' => $this->session->userdata('id'),
                'created_at' => date('Y-m-d'),
            ];
            $this->db->insert('user',$data);
            $user_id=$this->db->insert_id();

        }
                $data = [
                    'last_user_agent_id'=>$user_id,
                    'last_user_agent_relation_id'=>$relation_type_id,
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d')
                ];
                // var_dump($data);die();
               $this->db->update('user',$data, ['id' => $child_id]);
                  $data = [
                      'child_user_id'=>$child_id ,
                      'agent_user_id' =>$user_id ,
                      'relation_type_id' => $relation_type_id,
                      'agent_approve_id' => $agent_approve_id,
                      'details' => $details,
                      'created_by' => $this->session->userdata('id'),
                      'created_at' => date('Y-m-d'),
                  ];
           if($this->db->insert('user_agent',$data)){
               $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            تمت الإضافة  بنجاح</div>');
               redirect('agent/index/'.$child_id);
           }

    }
    /**
     * delete
     */
    public function del($id,$child)
    {
        $data = [
            'deleted_by' => $this->session->userdata('id'),
            'deleted_at' => date('Y-m-d')
        ];
        if($this->db->update('user_agent',$data, ['agent_id' => $id])){
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        تم الحذف بنجاح!</div>');
        }else{
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
        فشل الحذف!</div>');

        }
        redirect('agent/index/'.$child);
    }
    /**
     * @return add_agent_mother
     */
    public function add_agent_mother()
    {
        $id=$this->input->post('id');
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
            'user', $join_array, '  user.deleted_by  is  null and user.mother_user_id='.$id,
            'user.id asc');

        if($dataChild) {
            $user_child_row = $dataChild;
            foreach ($user_child_row as &$row){
               // var_dump($row);
                $data = [
                   'last_user_agent_id'=>$id,
                   'last_user_agent_relation_id'=>MOTHER,
                    'updated_by' => $this->session->userdata('id'),
                    'updated_at' => date('Y-m-d')
                ];
                // var_dump($data);die();
               $this->db->update('user',$data, ['id' => $row['id']]);
                $data = [
                    'child_user_id'=>$row['id'] ,
                    'agent_user_id' =>$id ,
                    'relation_type_id' => MOTHER,
                    'agent_approve_id' => MOTHER,
                    'details' => '',
                    'created_by' => $this->session->userdata('id'),
                    'created_at' => date('Y-m-d'),
                ];
                $this->db->insert('user_agent',$data);
            }
            $response = [
                'status' => 1,
                'message' => 'تمت العملية بنجاح  ',
            ];
        }
        else{
            $response = [
                'status' => 0,
                'message' => 'لا يوجد أبناء ',
            ];
        }

        echo json_encode($response);exit();
    }

}