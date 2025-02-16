<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpesa {
    private $config;
    private $access_token;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->config->load('mpesa');
        $this->config = $this->CI->config->item('mpesa');
        $this->access_token = $this->getAccessToken();
    }

    // Generate Access Token
    private function getAccessToken() {
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
        $credentials = base64_encode($this->config['consumer_key'] . ":" . $this->config['consumer_secret']);

        $response = $this->makeRequest($url, [], [
            "Authorization: Basic $credentials"
        ]);

        return $response ? $response->access_token : null;
    }

    // Register Mpesa C2B URLs
    public function registerUrls() {
        $url = "https://sandbox.safaricom.co.ke/mpesa/c2b/v1/registerurl";

        $data = [
            "ShortCode" => $this->config['shortcode'],
            "ResponseType" => "Completed",
            "ConfirmationURL" => $this->config['confirmation_url'],
            "ValidationURL" => $this->config['validation_url']
        ];

        return $this->makeRequest($url, $data, [
            "Authorization: Bearer " . $this->access_token
        ]);
    }

    // Simulate C2B Transaction (For Testing Only)
    public function simulateC2B($phone, $amount, $account_reference) {
        $url = "https://sandbox.safaricom.co.ke/mpesa/c2b/v1/simulate";

        $data = [
            "ShortCode" => $this->config['shortcode'],
            "CommandID" => "CustomerPayBillOnline",
            "Amount" => $amount,
            "Msisdn" => $phone,
            "BillRefNumber" => $account_reference
        ];

        return $this->makeRequest($url, $data, [
            "Authorization: Bearer " . $this->access_token
        ]);
    }

    // Make HTTP Requests
    private function makeRequest($url, $data, $headers = []) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array_merge([
            "Content-Type: application/json"
        ], $headers));

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        curl_close($ch);

        return json_decode($response);
    }
}
