<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OracleController extends CI_Controller // Use CI_Controller instead of Controller in CI3
{
    public function __construct()
    {
        parent::__construct();
        // Load Oracle database configuration
      $oracle_db = $this->load->database('oracle', TRUE); // TRUE returns the database object for Oracle

// Load MySQL database configuration
    $mosaaid_db = $this->load->database('mosaaid', TRUE); // TRUE returns the database object for MySQL
    }
    public function callProcedure($id )
    {
        $oracle_db = $this->load->database('oracle', TRUE);
        $conn = $oracle_db->conn_id; // Get the native OCI8 resource

            $sql = "
        DECLARE
            ID NUMBER;
            DATA_REC sys_refcursor;
        BEGIN
            ID := :id;

            gov_admin.EMMOSA_PKG.CITZN_INFO(
                ID => ID,
                DATA_REC => DATA_REC
            );

            :cursor := DATA_REC;
        END;";
            // Prepare the statement
            $stmt = oci_parse($conn, $sql);

            // Bind input parameter
            oci_bind_by_name($stmt, ":id", $id);

            // Bind the output cursor
            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

            // Execute the statement
            if (!oci_execute($stmt)) {
                $error = oci_error($stmt);
                echo "Error: " . $error['message'];
                return;
            }

            // Execute the cursor
            oci_execute($cursor);

            // Fetch data from the cursor
            $results = [];
            while (($row = oci_fetch_assoc($cursor)) != false) {
                $results[] = $row;
                echo $row['FULL_NAME_AR'];
            }

        // Free resources
        oci_free_statement($stmt);
        oci_free_statement($cursor);
var_dump($results);
    }

    public function callProcedure2( )
    {
        $oracle_db = $this->load->database('oracle', TRUE);
        $conn = $oracle_db->conn_id; // Get the native OCI8 resource
        $mosaaid_db = $this->load->database('mosaaid', TRUE);
        $connM = $mosaaid_db->conn_id; // Get the native OCI8 resource
        $sqlWives="SELECT * FROM person_wives where wife_dob ='1981-04-22' limit 10";
        $wives = $mosaaid_db->query($sqlWives)->result_array();
        foreach ($wives as $wife) {
            $pw_id=$wife['pw_id'];
            $id= $wife['wife_identity'];
            $sql = "
        DECLARE
            ID NUMBER;
            DATA_REC sys_refcursor;
        BEGIN
            ID := :id;

            gov_admin.EMMOSA_PKG.CITZN_INFO(
                ID => ID,
                DATA_REC => DATA_REC
            );

            :cursor := DATA_REC;
        END;";
            // Prepare the statement
            $stmt = oci_parse($conn, $sql);

            // Bind input parameter
            oci_bind_by_name($stmt, ":id", $id);

            // Bind the output cursor
            $cursor = oci_new_cursor($conn);
            oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

            // Execute the statement
            if (!oci_execute($stmt)) {
                $error = oci_error($stmt);
                echo "Error: " . $error['message'];
                return;
            }

            // Execute the cursor
            oci_execute($cursor);

            // Fetch data from the cursor
            $results = [];
            while (($row = oci_fetch_assoc($cursor)) != false) {
                if (isset($row['FULL_NAME_AR'])) {
                    $data = [
                        'wife_fname' => $row['CI_FIRST_ARB'],
                        'wife_sname' => $row['CI_FATHER_ARB'],
                        'wife_tname' => $row['CI_GRAND_FATHER_ARB'],
                        'wife_lname' => $row['CI_FAMILY_ARB'],
                        'wife_full_name' => $row['FULL_NAME_AR'],
                        'wife_dob' => $row['CI_BIRTH_DT'],
                        'wife_death_date' => $row['CI_DEAD_DT'],
                    ];
                    $mosaaid_db->update('person_wives', $data, ['pw_id ' => $pw_id]);
                    echo $pw_id;
                }else{
                    echo 'no';
                }
            }
        }
        // Define the PL/SQL block with the stored procedure call

        // Free resources
        oci_free_statement($stmt);
        oci_free_statement($cursor);

    }

    public function rel_ctzn_info($id)
    {
        // Load the Oracle database connection using CodeIgniter's default connection
        $oracle_db = $this->load->database('oracle', TRUE);
        $conn = $oracle_db->conn_id; // Get the native OCI8 resource

        // Check if the connection is established
        if (!$conn) {
            echo "Error: Unable to connect to the Oracle database.";
            return;
        }

        // Define the PL/SQL block with the stored procedure call
        $sql = "
    DECLARE
        ID NUMBER;
        DATA_REC SYS_REFCURSOR;
    BEGIN
        ID := :id;

        gov_admin.EMMOSA_PKG.REL_CTZN_INFO(
            ID => ID,
            DATA_REC => DATA_REC
        );

        :cursor := DATA_REC;
    END;";

        // Prepare the statement
        $stmt = oci_parse($conn, $sql);

        // Check if the statement was successfully parsed
        if (!$stmt) {
            $error = oci_error($conn);
            echo "Error: " . $error['message'];
            return;
        }

        // Bind input parameter
        oci_bind_by_name($stmt, ":id", $id);

        // Create and bind the output cursor
        $cursor = oci_new_cursor($conn);
        oci_bind_by_name($stmt, ":cursor", $cursor, -1, OCI_B_CURSOR);

        // Execute the statement
        if (!oci_execute($stmt)) {
            $error = oci_error($stmt);
            echo "Error executing statement: " . $error['message'];
            return;
        }

        // Execute the cursor
        if (!oci_execute($cursor)) {
            $error = oci_error($cursor);
            echo "Error executing cursor: " . $error['message'];
            return;
        }

        // Fetch data from the cursor into an array
        $results = [];
        while (($row = oci_fetch_assoc($cursor)) !== false) {
            $results[] = $row;
        }

        // Free cursor and statement resources
        oci_free_statement($stmt);
        oci_free_statement($cursor);

        // Optionally close the database connection
        $oracle_db->close();

        // Display or return the results
        var_dump($results);
        // Alternatively, you can return the results to use elsewhere
    }

    public function update_wives() {
        // Step 1: Get data from Oracle
        $mysql_db = $this->load->database('default', TRUE);
        echo "<pre>";
        print_r($this->db);
        echo "</pre>";

        $wives_query="SELECT `wife_identity` from  person_wives; ";
        $wives_result = $this->mysql_db->query($wives_query)->result_array();

        foreach ($wives_result as $row) {
            $res=$this->callProcedure($row['wife_identity']);
            // Process CI_SEX_CD and CI_PERSONAL_CD
            $marital_status = ($row['CI_PERSONAL_CD'] == '526') ? 1 : $row['CI_PERSONAL_CD'];

            // Step 2: Update MySQL
            $update_data = array(
                'wife_fname' => $row['CI_FIRST_ARB'],
                'wife_sname' => $row['CI_FATHER_ARB'],
                'wife_tname' => $row['CI_GRAND_FATHER_ARB'],
                'wife_lname' => $row['CI_FAMILY_ARB'],
                'wife_dob' => $row['CI_BIRTH_DT'],
                'wife_death_date' => $row['CI_DEAD_DT'],
                'wife_maretal_status_id' => $marital_status
            );

            $this->db->where('wife_identity', $row['wife_identity']);
            $this->db->update('person_wives', $update_data);
        }

        echo "Update completed.";
    }
}
