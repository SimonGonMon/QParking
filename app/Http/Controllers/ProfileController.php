<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $gravatar = $this->getGravatar($user->email);

        return view('profile.index', compact('user', 'gravatar'));
    }

    private function getGravatar($email, $size = 120)
    {
        $hash = md5(strtolower(trim($email)));
        return "https://www.gravatar.com/avatar/$hash?s=$size";
    }

    public function getQR(Request $request)
    {
        // Generate QR code using $request data
        $user = auth()->user();
        $pdo = DB::connection()->getPdo();

        $amount = $request->input('amount');

        $title = "QParking | Recarga de Saldo";

        $description = "Referencia: " . strval($user->username);

        $payResponse = $this->API_ePaycoGenerateLink($title, $description, $amount);

        error_log($payResponse, 0);

        // if (json_decode($payResponse, true)['title_response'] == 'Error') {
        //     return response()->json(['success' => false, 'qrCode' => 'null']);
        // }

        $invoiceNumber = json_decode($payResponse, true)['data']['invoceNumber'];
        $routeQr = json_decode($payResponse, true)['data']['routeQr'];
        $routeLink = json_decode($payResponse, true)['data']['routeLink'];

        $user->balance += $amount;

        $stmt = $pdo->prepare('UPDATE users SET balance = :balance WHERE id = :id');
        $stmt->execute(['balance' => $user->balance, 'id' => $user->id]);

        return response()->json(['success' => true, 'qrCode' => $routeQr, 'link' => $routeLink, 'invoiceNumber' => $invoiceNumber]);
    }

    public function API_ePaycoGetApiToken()
    {
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

        #get the entry "token" and return it
        $response = json_decode($response, true);
        $token = $response['token'];
        return $token;
    }

    public function API_ePaycoGenerateLink($title, $description, $amount)
    {
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
            CURLOPT_POSTFIELDS => '{
        "quantity": 1,
        "onePayment":true,
        "amount": ' . $amount . ',
        "currency": "COP",
        "id": 0,
        "description": "' . $description . '",
        "title": "' . $title . '",
        "typeSell": "2"

        }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $this->API_ePaycoGetApiToken()

            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;
    }
}
