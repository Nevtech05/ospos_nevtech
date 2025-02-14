<?php
class Repair_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fetch all repair orders
    public function get_all_repairs() {
        $this->db->select('repair_id, customer_id, item_name, serial_number, issue_description, status, estimated_cost, actual_cost, technician_id, created_at, updated_at');
        $query = $this->db->get('ospos_repair_orders');
        return $query->result_array();
    }

    // Get repair by ID
    public function get_repair($repair_id) {
        $this->db->select('*');
        $this->db->where('repair_id', $repair_id);
        $query = $this->db->get('ospos_repair_orders');
        return ($query->num_rows() > 0) ? $query->row_array() : false;
    }

    // Insert a new repair order
    public function insert_repair($data) {
        $this->db->trans_start();
        $this->db->insert('ospos_repair_orders', $data);
        $insert_id = $this->db->insert_id();
        $this->db->trans_complete();

        return ($this->db->trans_status() === false) ? false : $insert_id;
    }

    // Update an existing repair order
    public function update_repair($repair_id, $data) {
        $this->db->trans_start();
        $this->db->where('repair_id', $repair_id);
        $this->db->update('ospos_repair_orders', $data);
        $this->db->trans_complete();

        return $this->db->trans_status();
    }

    // Delete a repair order
    public function delete_repair($repair_id) {
        $this->db->where('repair_id', $repair_id);
        return $this->db->delete('ospos_repair_orders');
    }
}
