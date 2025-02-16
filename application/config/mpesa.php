<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config['mpesa'] = [
    'consumer_key'    => 's4cb8sPQKCG48PsmHzXZdMo50rE39J1exDDwaaHnUgEhHYfj',
    'consumer_secret' => 'AVT27tCCeI4Y6IzDNRAvmcqi4ceo0hk9QnkwIsXNGMwGX3zV4zJXSgsFGf8zSZGC',
    'shortcode'       => '5870625',
    // 'passkey'         => 'YOUR_MPESA_PASSKEY',
    'confirmation_url'=> 'https://yourdomain.com/mpesa/confirmation',
    'validation_url'  => 'https://yourdomain.com/mpesa/validation',
    'environment'     => 'sandbox', // Change to 'live' when going live
];
