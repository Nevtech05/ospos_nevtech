<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpesa extends CI_Controller {

    public function register_urls() {
        $this->load->library('Mpesa');
        $response = $this->mpesa->registerUrls();

        echo json_encode($response);
    }
}
