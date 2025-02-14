<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Repairs extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Repair_model');
        $this->load->model('Module'); // Load Module model
        $this->load->model('Employee'); // Load Employee model
        $this->load->library('session');
    }

    public function index() {
        $person_id = $this->session->userdata('person_id'); // Get user ID from session

        // Ensure user is logged in
        if (!$person_id) {
            redirect('login'); // Redirect to login if not authenticated
        }

        // Fetch user information
        $user_info = $this->Employee->get_info($person_id);

        // Fetch allowed modules and ensure it's an array
        $allowed_modules = $this->Module->get_allowed_home_modules($person_id);
        if (!is_array($allowed_modules)) {
            $allowed_modules = []; // Prevents invalid argument error in foreach
        }

        // Fetch repairs
        $data['repairs'] = $this->Repair_model->get_all_repairs();
        $data['allowed_modules'] = $allowed_modules; // ✅ Renamed for consistency
        $data['user_info'] = $user_info;

        // Load views
        $this->load->view("partial/header", $data);
        $this->load->view("repairs/index", $data);
        $this->load->view("partial/footer");
    }

    public function view($repair_id) {
        $data['repair'] = $this->Repair_model->get_repair($repair_id);
        if (empty($data['repair'])) {
            show_404();
        }

        $this->load->view('repairs/view', $data);
    }

    public function create() {
        if ($this->input->post()) {
            $repair_data = array(
                'customer_name' => $this->input->post('customer_name'),
                'device_type' => $this->input->post('device_type'),
                'problem_description' => $this->input->post('problem_description'),
                'status' => $this->input->post('status')
            );

            $this->Repair_model->insert_repair($repair_data);
            redirect('repairs');
        } else {
            $this->load->view('repairs/create');
        }
    }

    public function edit($repair_id) {
        $data['repair'] = $this->Repair_model->get_repair($repair_id);
        if (empty($data['repair'])) {
            show_404();
        }

        if ($this->input->post()) {
            $repair_data = array(
                'customer_name' => $this->input->post('customer_name'),
                'device_type' => $this->input->post('device_type'),
                'problem_description' => $this->input->post('problem_description'),
                'status' => $this->input->post('status')
            );

            $this->Repair_model->update_repair($repair_id, $repair_data);
            redirect('repairs');
        } else {
            $this->load->view('repairs/edit', $data);
        }
    }

    public function delete($repair_id) {
        $this->Repair_model->delete_repair($repair_id);
        redirect('repairs');
    }
}
?>
