<?php
#create a variable with the UTC time of now + 1 hour
$expiration = time() + 3600;
#time in utc numeric format
$utc = time();
#time in utc string format

$reference = "1000900454654309"+"$utc";

$curl = curl_init();



curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apify.epayco.co/collection/link/create',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "quantity": 1,
  "onePayment":true,
  "amount": "5000",
  "currency": "COP",
  "id": 0,
  "description": "Link de test",
  "title": "QParking - '.$reference.'",
  "typeSell": "2"

}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhcGlmeWVQYXljb0pXVCIsInN1YiI6NzAwOTgyLCJpYXQiOjE2NjczMjAxMjksImV4cCI6MTY2NzMyMzcyOSwicmFuZCI6ImYzZGU5ZjY5MzA1ODcwNDQ5YjYxZmFjNjA3NzM5MDY5OTY3NyIsInJlcyI6ZmFsc2UsImluYSI6ZmFsc2UsImd1aSI6MzA5MzIzfQ.kOhs4XZAJPDnu8BMOCq2SO2CzHycG-dvsSlyB-2e-xk',

  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;


