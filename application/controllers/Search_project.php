<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class search_project extends MY_Controller {

    public function __construct(){
        parent::__construct();
        }

        // function index view
    public function index($title='سطح المكتب'){
        $data['title']='إدارة بحث المشاريع';
        $data['viewName']='search_project/index';
        $this->refresh_debts();
        $data['param']['supporting_bodies'] = (array)$this->db->get_where('constants', ['parent_id' => SUPPORTING_BODIES])->result_array();
        $data['param']['suppliers'] =$this->db->get_where('supplier', ['deleted_by' =>NULL])->result_array();
        $data['param']['supporting_type'] =$this->db->get_where('constants', ['parent_id' => RELIEF,'deleted_by' =>NULL])->result_array();
            $data['withParam']='y';

        $data['param']['js_file'][0] ='\assets\custom\search_project.js';

            parent::index($data);
        }

    public function view(){

        $support_id = isset($_POST['support_id'])&& $_POST['support_id']!=0 ? $_POST['support_id'] : null;
        $support_type_id = isset($_POST['support_type_id'])&& $_POST['support_type_id']!=0  ? $_POST['support_type_id'] : null;
        $supplier_id = isset($_POST['supplier_id'])&& $_POST['supplier_id']!=0  ? $_POST['supplier_id'] : null;
        $draw = intval($this->input->post("draw"));
        $start = intval($this->input->post("start"));
        $length = intval($this->input->post("length"));
      //  $support_id=108;
        $where = ' project_supply.deleted_by IS NULL   ';
        if (!empty($support_id)) {
            $where .= '  AND project_master.support_id = ' . $this->db->escape($support_id);
        }

        if (!empty($support_type_id)) {
            $where .= '  AND project_support.support_fk = ' . $this->db->escape($support_type_id);
        }

        if (!empty($supplier_id)) {
            $where .= '  AND project_supply.supplier_fk = ' . $this->db->escape($supplier_id);
        }

        // Convert array to string for WHERE clause
        //$where_clause = implode(' AND ', $where);
      //echo ($where);exit();
    $join_array = array(
        array(
            'table_name' => 'supplier',
            'condition' => 'supplier.supplier_id = project_supply.supplier_fk'
        ),
        array(
            'table_name' => 'project_master',
            'condition' => 'project_master.project_id  = project_supply.proj_fk '
        ),
        array(
            'table_name' => 'constants pms',
            'condition' => 'project_master.support_id  = pms.id '
        ),
        array(
            'table_name' => 'project_support',
            'condition' => 'project_supply.ps_fk  = project_support.ps_id '
        ),
        array(
            'table_name' => 'constants psk',
            'condition' => 'project_support.support_fk  = psk.id '
        ),
    );
    $resArray= $this->Base_model->get_with_join('project_support.*,project_supply.*,project_master.*,supplier.*,psk.title as support_type_name,pms.title as support_name,pms.title as associaton_name',
        'project_supply', $join_array, '  '.$where,
        'supplier.supplier_id asc');
        $results=$resArray;//$project_supply=$this->objectToArray($resArray);
        if (empty($results)) {
            $recordsTotal=$recordsFiltered=0;
            $response = [
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => []
            ];
            echo json_encode($response);
        } else {
            $recordsTotal=$recordsFiltered=count($results);
            $response = [
                "draw" => $draw,
                "recordsTotal" => $recordsTotal,
                "recordsFiltered" => $recordsFiltered,
                "data" => $results
            ];
            echo json_encode($response);
        }
   // echo json_encode($project_supply);//exit();
}

     public function refresh_debts(){
         $response = [
             'status' => 0,
             'message' => ' no'
         ];
         $project_supply =$this->db->get_where('project_supply', ['deleted_by' =>NULL])->result_array();
             $i=0;
             foreach ($project_supply as $r_sup) {
                 $rowPays=$this->db->get_where('supplier_payments', ['deleted_by' =>NULL,'supplier_fk' =>$r_sup['supplier_fk'],'ps_fk' =>$r_sup['ps_fk']])->result_array();

                 if (is_array($rowPays)) {
                     $sum_paid_amount = 0;
                     foreach ($rowPays as $r) {
                         if (is_array($r)) {
                             $sum_paid_amount += $r['invoice_value'];
                         }
                     }
                 }
                 $data = [
                     'supplier_recieved_mony' => $sum_paid_amount,
                     'supplier_remain_mony' => $r_sup['supplier_paid_amount']-$sum_paid_amount,
                     'updated_by' => $this->session->userdata('id'),
                     'updated_at' => date('Y-m-d')
                 ];
                 // var_dump($data);die();
                 if($this->db->update('project_supply', $data,['proj_supply_id'=>$r_sup['proj_supply_id']]))
                 {
                     $response = [
                         'status' => 1,
                         'message' => ' yes'
                     ];

                 }
             }
        // echo json_encode($response);
         }

    private function objectToArray($obj) {
        return json_decode(json_encode($obj), true);
    }
        }