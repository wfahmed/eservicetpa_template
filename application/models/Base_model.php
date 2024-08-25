<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_Model extends CI_Model
{
    var $numrows;

    function __construct()
    {
        parent::__construct();
    }


    //General database operations
    function run_query($query)
    {
        $rs = $this->db->query($query);
        return $rs or die ('Error:' . mysql_error());
    }


    //General database operations
    function get_query_result($query)
    {
        return $this->db->query($query)->result();
    }

    function get_query_row($query)
    {
        return $this->db->query($query)->row();
    }


    function fetch_row($table, $condition = "")
    {
        if (!(empty($condition)))
            $this->db->where($condition);
        // echo $this->db->last_query();
        return $this->db->get($table)->row();
    }


    function count_records($table, $condition = '')
    {
        if (!(empty($condition)))
            $this->db->where($condition);
        $this->db->from($table);
        $reocrds = $this->db->count_all_results();
        //echo $this->db->last_query();
        return $reocrds;
    }


    function fetch_records_from($table, $condition = '', $select = '*', $order_by = '', $like = '', $offset = '', $perpage = '')
    {
        $this->db->start_cache();
        $this->db->select($select, FALSE);
        $this->db->from($table);
        if (!empty($condition))
            $this->db->where($condition);
        if (!empty($like))
            $this->db->like($like);
        if (!empty($order_by))
            $this->db->order_by($order_by);
        $this->db->stop_cache();
        $result = $this->db->get();
        $this->numrows = $this->db->affected_rows();
        //echo $this->numrows.'<br>';
        if ($perpage != '')
            $this->db->limit($perpage, $offset);
        $result = $this->db->get();
        //    var_dump($this->db->error());
        //echo $this->db->last_query();

        // print_r($result);die();
        $this->db->flush_cache();
        return $result->result();


    }

    function fetch_records_from_in($table, $column, $value, $select = '*', $order_by = '', $like = '')
    {
        $this->db->start_cache();
        $this->db->select($select, FALSE);
        $this->db->from($table);
        $this->db->where_in($column, $value);
        if (!empty($like))
            $this->db->like($like);
        if (!empty($order_by))
            $this->db->order_by($order_by);
        $this->db->stop_cache();
        $this->numrows = $this->db->count_all_results();

        $result = $this->db->get();
        $this->db->flush_cache();
        return $result->result();
    }

    function fetch_value($table, $column, $where)
    {
        $this->db->select($column, FALSE);
        $this->db->from($table);
        $this->db->where($where);
        $this->db->limit(0, 1);
        $result = $this->db->get()->result();
        $str = '-';
        if (count($result)) {
            foreach ($result as $row) {
                $str = $row->$column;
            }
        }
        return $str;
    }

    function changestatus($table, $inputdata, $where)
    {
        $result = $this->db->update($table, $inputdata, $where);
        return $result;
    }

    function delete_record($table, $column, $ids)
    {
        $this->db->where_in($column, $ids);
        $result = $this->db->delete($table);
        return $result;
    }

    function delete_record_new($table, $condition)
    {
        $this->db->where($condition);
        $this->db->delete($table);
        return TRUE;
    }

    function delete($table, $id_name, $id)
    {
        $data["is_delete"] = 1;
        $this->db->where($id_name, $id);
        if ($this->db->update($table, $data)) {
            return true;
        } else {
            return false;
        }
    }

    public function get_with_join($selectColumns, $table_name, $joins, $where = '', $order_by = '', $offset = '', $perpage = '',
                                  $group_by = null)
    {
        $this->db->select($selectColumns);
        $this->db->from($table_name);
        if (count($joins) > 0) {
            foreach ($joins as $join) {
                $this->db->join($join['table_name'], $join['condition'], 'left');
            }
        }
        if (!empty($where))
            $this->db->where($where);
        if (!empty($order_by))
            $this->db->order_by($order_by);
        if ($perpage != '') {
            $this->db->offset($offset);
            $this->db->limit($perpage);
        }
        if (!empty($group_by))
            $this->db->group_by($group_by);

        $results = $this->db->get();
//    var_dump($this->db->error());
//     echo ($this->db->last_query());
// echo $this->db->last_query();
        if ($results !== FALSE && $results->num_rows() > 0) {

            return $results->result_array();
        } else {
            return null;
        }
    }


    ////////////////////////////tree//////////////////////////
    function get_hierarchical_paths()
    {
        $sql = "WITH RECURSIVE ConstantTree AS (
SELECT
id,deleted_by,
title,
parent_id,
title AS path,         
        0 AS level           
    FROM Constants
    WHERE parent_id IS NULL 
    
    UNION ALL
    
    SELECT 
        c.id, c.deleted_by,
        c.title,  
        c.parent_id, 
        CONCAT(ct.path, ' > ', c.title) AS path, 
ct.level + 1 AS level                 
FROM Constants c
INNER JOIN ConstantTree ct ON c.parent_id = ct.id
)
SELECT
id,deleted_by,
title,
parent_id,
path,   
level     
FROM ConstantTree where deleted_by is null 
ORDER BY path

";
      //  var_dump($sql);
        $query = $this->db->query($sql);

        if (!$query) {
            $error = $this->db->error(); // Returns an array with 'code' and 'message'
            echo "Error Code: " . $error['code'] . "<br>";
            echo "Error Message: " . $error['message'] . "<br>";
        } else {
            return $query->result();
        }
    }


}
?>