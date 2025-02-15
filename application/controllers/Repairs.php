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
        $data['table_headers'] = json_encode($this->Repair_model->get_table_headers());
        $data['filters'] = $this->Repair_model->get_filters();

        $this->load->view('repairs/manage', $data);
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
