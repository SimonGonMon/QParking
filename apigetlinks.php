<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://apify.epayco.co/collection/link',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_POSTFIELDS =>'{
	"filter":{
		
	}
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhcGlmeWVQYXljb0pXVCIsInN1YiI6NzAwOTgyLCJpYXQiOjE2NjcxODQ5MzksImV4cCI6MTY2NzE4ODUzOSwicmFuZCI6IjBhYTU0MjEzNjA1YjRjMTliODA3ODZlODYxNmNjZjQ1MTg4OCIsInJlcyI6ZmFsc2UsImluYSI6ZmFsc2UsImd1aSI6MzA5MzIzfQ.2DVFxy90vu9otwudcxhorytkeCEap9CuPYT_-IEScl8',
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

