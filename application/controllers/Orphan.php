<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ALL);
ini_set('display_errors', 1);

class Orphan extends MY_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    public function index($title='إدارة الأيتام')
    {
        /***constant************/
        $data['param']['DISABILITY_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DISABILITY_STATUS])->result_array();
        $data['param']['PARENT_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => PARENT_STATUS])->result_array();
        $data['param']['NATURAL_WORK'] = (array)$this->db->get_where('constants', ['parent_id' => NATURAL_WORK])->result_array();
        $data['param']['MARETAL_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => MARETAL_STATUS])->result_array();
        $data['param']['HEALTH'] = (array)$this->db->get_where('constants', ['parent_id' => HEALTH])->result_array();
        $data['param']['CURRENT_RESIDENCE'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENT_RESIDENCE])->result_array();
        $data['param']['GOVERNORATES'] = (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
        $data['param']['DWELLING_STATUS'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_STATUS])->result_array();
        $data['param']['DWELLING_NATURE'] = (array)$this->db->get_where('constants', ['parent_id' => DWELLING_NATURE])->result_array();
        $data['param']['VALLEY_SIDE'] = (array)$this->db->get_where('constants', ['parent_id' => VALLEY_SIDE])->result_array();
        $data['param']['RELATION'] = (array)$this->db->get_where('constants', ['parent_id' => RELATION])->result_array();
        $data['param']['GOVERNORATES'] = (array)$this->db->get_where('constants', ['parent_id' => GOVERNORATES])->result_array();
        $data['param']['EDUCATION'] = (array)$this->db->get_where('constants', ['parent_id' => EDUCATION])->result_array();
        $data['param']['RELIEF'] = (array)$this->db->get_where('constants', ['parent_id' => RELIEF])->result_array();
        $data['param']['GUARANTEE_SUB'] = (array)$this->db->get_where('constants', ['parent_id' => GUARANTEE_SUB])->result_array();
        $data['param']['CURRENCY'] = (array)$this->db->get_where('constants', ['parent_id' => CURRENCY])->result_array();
        $data['param']['BENEFIT'] = (array)$this->db->get_where('constants', ['parent_id' => BENEFIT])->result_array();
        $data['param']['SUPPORTING_BODIES'] = (array)$this->db->get_where('constants', ['parent_id' => SUPPORTING_BODIES])->result_array();

        $data['title'] = $title;
        $data['viewName']='orphan/index';
        $data['param']['js_file'][0] ='\assets\custom\orphan.js';
        $data['withParam']='y';
        parent::index($data);

    }

    public function view()
    {
        // Get DataTables parameters
        $draw = $this->input->post('draw');
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $search = $this->input->post('search')['value'];

        // Initialize filter
        $filter = '';

        // Add search filter if provided
        if (!empty($search)) {
            $filter .= " AND (user.full_name LIKE '%$search%' OR father.full_name LIKE '%$search%' OR mother.full_name LIKE '%$search%' OR agent.full_name LIKE '%$search%')";
        }

        // Add other filters (you can expand this based on your needs)
        $death_date_from = $this->input->post('death_date_from');
        $death_date_to = $this->input->post('death_date_to');
        if (!empty($death_date_from) && !empty($death_date_to)) {
            $filter .= " AND (father.death_date BETWEEN '$death_date_from' AND '$death_date_to')";
        }

        // ... add other filters here ...

        $join_array = array(
            array(
                'table_name' => 'constants pms',
                'condition' => 'user.relation_type_id  = pms.id '
            ),
            array(
                'table_name' => 'user father',
                'condition' => 'user.parent_user_id  = father.id '
            ),
            array(
                'table_name' => 'user mother',
                'condition' => 'user.mother_user_id  = mother.id '
            ),
            array(
                'table_name' => 'user agent',
                'condition' => 'user.last_user_agent_id  = agent.id '
            ),
            array(
                'table_name' => 'constants agRelation',
                'condition' => 'user.last_user_agent_relation_id  = agRelation.id '
            ),
        );

        // Count total records
        $totalRecords = $this->Base_model->count_with_join(
            'user',
            $join_array,
            'user.deleted_by IS NULL AND father.deleted_by IS NULL AND user.age < 19 AND father.user_status_id IN (5,6,18) AND father.relation_type_id = ' . FAMILY_HEADER . $filter
        );

        // Fetch paginated data
        $orphans = $this->Base_model->get_with_joins(
            'user.*, user.id as uid, pms.title as relation_type, 
        father.full_name as father_name, user.parent_user_id as father_id, 
        mother.full_name as mother_name, agent.full_name as agent_name, 
        agRelation.title as agent_relation_type',
            'user',
            $join_array,
            'user.deleted_by IS NULL AND father.deleted_by IS NULL AND user.age < 19 AND father.user_status_id IN (5,6,18) AND father.relation_type_id = ' . FAMILY_HEADER . $filter,
            'user.id asc',
            $length,
            $start
        );

        // Apply pagination if required
        if ($length != -1) {
            $orphans = array_slice($orphans, $start, $length);
        }

        // Prepare the response
        $response = array(
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalRecords,
            "data" => $orphans
        );
        // Output the response as JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    /**
     * objectToArray
     */
    private function objectToArray($obj) {
        return json_decode(json_encode($obj), true);
    }
}