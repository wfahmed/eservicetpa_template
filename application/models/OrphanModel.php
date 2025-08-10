<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class OrphanModel extends CI_Model
{
    private $numrows;
    private $error_message; // Explicitly define the error_message property

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function search_orphans($search_params, $length = null, $start = null)
    {
        try {
            $this->db->reset_query();

            $this->db->select('main_user.*, main_user.id as uid, pms.title as relation_type, main_user.identity as orphan_identity,
                           father.full_name as father_name, main_user.parent_user_id as father_id, 
                           mother.full_name as mother_name, agent.full_name as agent_name, 
                           agRelation.title as agent_relation_type');
            $this->db->from('user as main_user');

            $this->join_tables();
            $this->apply_base_conditions();
            $this->apply_search_conditions($search_params);
            $this->apply_orphan_conditions($search_params);

            $this->db->order_by('main_user.id', 'asc');

            // Get total count before applying limit
            $this->numrows = $this->db->count_all_results('', false);

            if ($length !== null && $start !== null) {
                $this->db->limit($length, $start);
            }

            $query = $this->db->get();
            //echo $this->db->last_query();
            return $query->result();
        } catch (Exception $e) {
            $this->error_message = 'Error in OrphanModel::search_orphans: ' . $e->getMessage() . '   /' . $this->db->last_query();
            log_message('error', 'Error in OrphanModel::search_orphans: ' . $e->getMessage());
            log_message('error', 'Last SQL query: ' . $this->db->last_query());
            return false;
        }
    }

    private function join_tables()
    {
        $this->db->join('user as father', 'main_user.parent_user_id = father.id', 'left');
        $this->db->join('user as mother', 'main_user.mother_user_id = mother.id', 'left');
        $this->db->join('user as agent', 'main_user.last_user_agent_id = agent.id', 'left');
        $this->db->join('constants as pms', 'main_user.relation_type_id = pms.id', 'left');
        $this->db->join('constants as agRelation', 'main_user.last_user_agent_relation_id = agRelation.id', 'left');
        // Add new joins for orphan-related lookups
        $this->db->join('constants as ed', 'main_user.last_edu_status  = ed.id', 'left');
        $this->db->join('constants as ds', 'main_user.last_disability_status  = ds.id', 'left');
        $this->db->join('constants as hs', 'main_user.last_health_status  = hs.id', 'left');
    }

    private function apply_orphan_conditions($search_params)
    {
        if (!empty($search_params['orphan'])) {
            $orphan_params = $search_params['orphan'];

            // Handle birth date range
            if (!empty($orphan_params['birth_date_from']) && !empty($orphan_params['birth_date_to'])) {
                $this->db->group_start();
                $this->db->where('main_user.dob >=', $orphan_params['birth_date_from']);
                $this->db->where('main_user.dob <=', $orphan_params['birth_date_to']);
                $this->db->group_end();
            }

            // Handle gender
            if (!empty($orphan_params['gender_id'])) {
                if (is_array($orphan_params['gender_id'])) {
                    $this->db->where_in('main_user.gender_id', $orphan_params['gender_id']);
                } else {
                    $this->db->where('main_user.gender_id', $orphan_params['gender_id']);
                }
            }

            // Handle age range
            if (!empty($orphan_params['age_from']) || !empty($orphan_params['age_to'])) {
                $this->db->group_start();
                if (!empty($orphan_params['age_from'])) {
                    $this->db->where('main_user.age >=', $orphan_params['age_from']);
                }
                if (!empty($orphan_params['age_to'])) {
                    $this->db->where('main_user.age <=', $orphan_params['age_to']);
                }
                $this->db->group_end();
            }

            // Handle education level
            if (!empty($orphan_params['edu_id'])) {
                if (is_array($orphan_params['edu_id'])) {
                    $this->db->where_in('main_user.education_level_id', $orphan_params['edu_id']);
                } else {
                    $this->db->where('main_user.education_level_id', $orphan_params['edu_id']);
                }
            }

            // Handle disability status
            if (!empty($orphan_params['disability_status_id'])) {
                if (is_array($orphan_params['disability_status_id'])) {
                    $this->db->where_in('main_user.disability_status_id', $orphan_params['disability_status_id']);
                } else {
                    $this->db->where('main_user.disability_status_id', $orphan_params['disability_status_id']);
                }
            }

            // Handle health status
            if (!empty($orphan_params['health_status_id'])) {
                if (is_array($orphan_params['health_status_id'])) {
                    $this->db->where_in('main_user.health_status_id', $orphan_params['health_status_id']);
                } else {
                    $this->db->where('main_user.health_status_id', $orphan_params['health_status_id']);
                }
            }

            // Handle orphan identity
            if (!empty($orphan_params['identity'])) {
                $this->db->where('main_user.identity', $orphan_params['identity']);
            }
        }
    }

    private function apply_base_conditions()
    {
        $this->db->where('main_user.deleted_by IS NULL');
        $this->db->where('father.deleted_by IS NULL');
        $this->db->where('main_user.age <', 19);
        $this->db->where('father.relation_type_id', FAMILY_HEADER);
    }

    private function apply_search_conditions($search_params)
    {
        $hasConditions = false;
        $dFatherAdded = false;
        $dMotherAdded = false;
        $parent_types = ['father', 'mother'];

        foreach ($parent_types as $parent) {
            if (!empty($search_params[$parent])) {
                $parent_params = $search_params[$parent];
                if ($parent_types == 'father') {
                    $dFatherAdded = false;
                }
                if ($parent_types == 'mother') {
                    $dMotherAdded = false;
                }
                // Handle date range
                if (!empty($parent_params['death_date_from']) && !empty($parent_params['death_date_to'] && !$dFatherAdded && !$dMotherAdded)) {
                    $dFatherAdded = true;
                    $dMotherAdded = true;
                    $this->db->group_start();
                    $this->db->where("{$parent}.death_date >=", $parent_params['death_date_from']);
                    $this->db->where("{$parent}.death_date <=", $parent_params['death_date_to']);
                    $this->db->group_end();
                    $hasConditions = true;
                }
//print_r($parent_params);
                // Handle other fields
                $fields = [
                    'asylum_status_id',
                    'user_status_id',
                    'naturalwork_id',
                    'maretal_status_id',
                    'disability_status_id',
                    'health_status_id',
                    'identity',
                ];

                foreach ($fields as $field) {
                    if (!empty($parent_params[$field])) {
                        if (is_array($parent_params[$field])) {
                            $this->db->where_in("{$parent}.{$field}", $parent_params[$field]);
                        } else {
                            $this->db->where("{$parent}.{$field}", $parent_params[$field]);
                        }
                        $hasConditions = true;
                    }
                }
            }
        }

        // Handle any non-parent specific conditions
        $general_fields = [
            'main_user.age' => 'age',
            'pms.title' => 'relation_type',
            'agRelation.title' => 'agent_relation_type'
        ];

        foreach ($general_fields as $field => $param) {
            if (!empty($search_params[$param])) {
                $this->db->where($field, $search_params[$param]);
                $hasConditions = true;
            }
        }

        // Wrap all conditions in a group if any conditions were added
        if ($hasConditions) {
            $this->db->group_start();
            // Re-apply all conditions inside the group
            foreach ($parent_types as $parent) {
                if (!empty($search_params[$parent])) {
                    $parent_params = $search_params[$parent];

                    if (!empty($parent_params['death_date_from']) && !empty($parent_params['death_date_to'])) {
                        $this->db->group_start();
                        $this->db->where("{$parent}.death_date >=", $parent_params['death_date_from']);
                        $this->db->where("{$parent}.death_date <=", $parent_params['death_date_to']);
                        $this->db->group_end();
                    }

                    foreach ($fields as $field) {
                        if (!empty($parent_params[$field])) {
                            if (is_array($parent_params[$field])) {
                                $this->db->where_in("{$parent}.{$field}", $parent_params[$field]);
                            } else {
                                $this->db->where("{$parent}.{$field}", $parent_params[$field]);
                            }
                        }
                    }
                }
            }

            foreach ($general_fields as $field => $param) {
                if (!empty($search_params[$param])) {
                    $this->db->where($field, $search_params[$param]);
                }
            }

            $this->db->group_end();
        }
    }

    public function get_total_orphans($search_params)
    {
        $result = $this->search_orphans($search_params);
        if ($result === false) {
            return 0; // Return 0 if there was an error
        }
        return $this->numrows;
    }

    public function get_orphan_by_id($id)
    {
        try {
            $this->db->select('user.*, user.id as uid, pms.title as relation_type, 
                           father.full_name as father_name, user.parent_user_id as father_id, 
                           mother.full_name as mother_name, agent.full_name as agent_name, 
                           agRelation.title as agent_relation_type');
            $this->db->from('user');
            $this->join_tables();
            $this->apply_base_conditions();
            $this->db->where('user.id', $id);
            $query = $this->db->get();
            return $query->row();
        } catch (Exception $e) {
            log_message('error', 'Error in OrphanModel::get_orphan_by_id: ' . $e->getMessage());
            log_message('error', 'Last SQL query: ' . $this->db->last_query());
            return false;
        }
    }

    public function get_orphans($start = 0, $length = 10, $search_value = null, $order_column = null, $order_dir = 'asc')
    {
        // var_dump($search_value);
        // Start with the base query
        $this->db->start_cache();
        $this->db->from('orphans_view');

        // Search across multiple columns
        if (!empty($search_value['child_identity'])) {
            $this->db->group_start();
            $this->db->where('orphan_identity', $search_value['child_identity']);
            $this->db->or_where('father_identity', $search_value['child_identity']);
            $this->db->or_where('mother_identity', $search_value['child_identity']);
            $this->db->group_end();
        }
        if (!empty($search_value['child_age'])) {
            $this->db->group_start();

            // Handle different comparison operators
            switch ($search_value['child_age_operand']) {
                case '=':
                    $this->db->where('age', $search_value['child_age']);
                    break;
                case '>':
                    $this->db->where('age >', $search_value['child_age']);
                    break;
                case '<':
                    $this->db->where('age <', $search_value['child_age']);
                    break;
                case '>=':
                    $this->db->where('age >=', $search_value['child_age']);
                    break;
                case '<=':
                    $this->db->where('age <=', $search_value['child_age']);
                    break;
                case '!=':
                    $this->db->where('age !=', $search_value['child_age']);
                    break;
                default:
                    // If no valid operand is provided, you might want to handle this case
                    $this->db->where('age', $search_value['child_age']);
            }

            $this->db->group_end();
        }

        if (!empty($search_value['is_updated'])) {
            $this->db->where('orphan_is_refresh', $search_value['is_updated'] == 1 ? 1 : 0);
        }

        if (!empty($search_value['has_priority'])) {
            $this->db->where('orphan_has_prior', $search_value['has_priority'] == 1 ? 1 : 0);
        }

        // Sorting
        $columns = [
            'orphan_id',
            'orphan_identity',
            'father_name',
            'mother_name',
            'agent_name'
        ];

        if ($order_column !== null && isset($columns[$order_column])) {
            $this->db->order_by($columns[$order_column], $order_dir);
        }

        $this->db->stop_cache();

        // Get total filtered count
        $total = $this->db->count_all_results();

        // Pagination
        $this->db->limit($length, $start);

        // Execute and return results
        $query = $this->db->get();

        // Clear the cache
        $this->db->flush_cache();

        return [
            'total_count' => $total,
            'data' => $query->result_array()
        ];
    }

//    public function count_orphans($search_value = null)
//    {
//        $this->db->from('orphans_view');
//
//        // Search across multiple columns
//        if (!empty($search_value['child_identity'])) {
//            $this->db->group_start();
//            $this->db->where('orphan_identity', $search_value['child_identity']);
//            $this->db->or_where('father_identity', $search_value['child_identity']);
//            $this->db->or_where('mother_identity', $search_value['child_identity']);
//            $this->db->group_end();
//        }
//        if (!empty($search_value['child_age'])) {
//            $this->db->group_start();
//
//            // Handle different comparison operators
//            switch ($search_value['child_age_operand']) {
//                case '=':
//                    $this->db->where('age', $search_value['child_age']);
//                    break;
//                case '>':
//                    $this->db->where('age >', $search_value['child_age']);
//                    break;
//                case '<':
//                    $this->db->where('age <', $search_value['child_age']);
//                    break;
//                case '>=':
//                    $this->db->where('age >=', $search_value['child_age']);
//                    break;
//                case '<=':
//                    $this->db->where('age <=', $search_value['child_age']);
//                    break;
//                case '!=':
//                    $this->db->where('age !=', $search_value['child_age']);
//                    break;
//                default:
//                    // If no valid operand is provided, you might want to handle this case
//                    $this->db->where('age', $search_value['child_age']);
//            }
//
//            $this->db->group_end();
//        }
//
//        if (!empty($search_value['is_updated']) && $search_value['is_updated'] == 1) {
//            $this->db->where('orphan_is_refresh', 1);
//        }
//        if (!empty($search_value['has_priority']) && $search_value['has_priority'] == 1) {
//            $this->db->where('orphan_has_prior', 1);
//        }
//
//        return $this->db->count_all_results();
//    }

    public function get_last_error()
    {
        return $this->error_message;
    }

}
