<?php
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apify.epayco.co/login',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Basic YTlhODMzNzAzZDVjNjJkNTkzYzI5ZTFlMGUxMzdiZWE6Nzk1NWU3YzQ5ZWQ4N2IzM2QzM2MzZGJiNGYxMzkzYzU='
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;