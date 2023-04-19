<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

use App\Models\Service;

class ServiceController extends Controller
{

    public $data = [];

    public function registerVehicle(Request $request)
    {
        // Obtener la placa ingresada por el usuario desde la solicitud HTTP
        $plate = $request->input('plate');

        // Verificar si existe una entrada en la tabla services con la misma placa
        $service = Service::where('plate', $plate)->first();

        // Si la consulta anterior retorna una entrada, significa que el vehículo ya está estacionado. En ese caso, retornar un error.
        if ($service) {

            return back()->with('error', 'Este vehículo ya se encuentra estacionado.');
        }


        // Si no se encuentra ninguna entrada en la tabla services con la misma placa, se puede insertar una nueva entrada en la tabla.
        $service = new Service;
        $service->user_id = $request->input('user_id');
        $service->plate = $plate;
        $service->status = "active";
        $service->time_start = now();
        $service->save();

        return back()->with('success', 'Vehículo registrado exitosamente.');


        // Resto del código de la función
    }

    public function generatePayment(Request $request)
    {
        // Obtener la placa ingresada por el usuario desde la solicitud HTTP
        $plate = $request->input('plate');

        // Verificar si existe una entrada en la tabla services con la misma placa
        $service = Service::where('plate', $plate)->first();

        // Si la consulta anterior no retorna una entrada, significa que el vehículo no está estacionado. En ese caso, retornar un error.
        if (!$service) {
            return back()->with('error', 'No se encontró un servicio para la placa ingresada.');
        }

//        check in table transactions if theres an entry with a pending status with the same plate
        $transaction = Transaction::where('license_plate', $plate)->where('status', 'pending')->first();

//        save the info into another data array with the transaction info if $transaction is not null

        if ($transaction) {
            $data = [
                'plate' => $transaction->license_plate,
                'start_time' => $transaction->time_start,
                'end_time' => $transaction->time_end,
                'cost' => $transaction->amount,
                'elapsed_time' => $transaction->elapsed_time,
                'reference' => $transaction->reference,
                'qr_code' => $transaction->qr_code
            ];

            $this->data = $data;

//        guarda el arreglo en una variable de sesion para ser usada en la vista
            $request->session()->put('data', $data);

            return redirect()->route('dashboard.index');
        }

        // Obtener la fecha de inicio y calcular el tiempo transcurrido hasta ahora
        $start_time = $service->created_at;
        $now = now();
        $diff = $start_time->diffInSeconds($now);

        // Calcular el costo
        $hours = floor($diff / 3600);
        $minutes = floor(($diff % 3600) / 60);
        $fraction = ($minutes > 0) ? 1 : 0;
        $cost = ($hours * 5000) + ($fraction * 3000);

        // Devolver la información requerida
        $data = [
            'plate' => $service->plate,
            'start_time' => $start_time,
            'elapsed_time' => $hours . ' horas ' . $minutes . ' minutos',
            'end_time' => $now,
            'cost' => $cost
        ];

//        set the same values for the class data variable
        $this->data = $data;

//        guarda el arreglo en una variable de sesion para ser usada en la vista
        $request->session()->put('data', $data);

        return redirect()->route('dashboard.index');
    }

    public function generateQR(Request $request)
    {
        $licensePlate = $request->input('plate');
        $startTime = $request->input('start_time');
        $elapsedTime = $request->input('elapsed_time');
        $endTime = $request->input('end_time');
        $price = $request->input('cost');

        $data = [
            'plate' => $licensePlate,
            'start_time' => $startTime,
            'elapsed_time' => $elapsedTime,
            'end_time' => $endTime,
            'cost' => $price,
        ];

//        check in the table transactions if theres a transaction with the same license plate and status 'pending'
        $transaction = Transaction::where('license_plate', $licensePlate)->where('status', 'pending')->first();

//        if theres a transactions found then get the value of qr_code and save it to session
        if ($transaction) {
            $request->session()->put('routeQr', $transaction->qr_code);
            $request->session()->put('data', $data);
            return redirect()->route('dashboard.index');
        }

        $title = "QParking | $licensePlate | $endTime";

        $description = "Pago de parqueadero para la placa $licensePlate\n$elapsedTime";

        $payResponse = $this->newPayLink($title, $description, $price);

        dump($payResponse);

//        if key titleResponse == Error return with error with string key textResponse

//        if title_response exists then, if doesnt exist do nothing (make this not to trigger an exception)




        if (json_decode($payResponse, true)['title_response'] == 'Error') {
            return back()->with('error', "API Error");
        }

        $invoiceNumber = json_decode($payResponse, true)['data']['invoceNumber'];
        $routeQr = json_decode($payResponse, true)['data']['routeQr'];

//        save transaction to database
        $transaction = new Transaction;
        $transaction->license_plate = $licensePlate;
        $transaction->reference = $invoiceNumber;
        $transaction->amount = $price;
        $transaction->status = 'pending';
        $transaction->time_start = $startTime;
        $transaction->time_end = $endTime;
        $transaction->qr_code = $routeQr;
        $transaction->elapsed_time = $elapsedTime;
        $transaction->save();


        //        save routeQr to session
        $request->session()->put('routeQr', $routeQr);
        //        save data to session
        $request->session()->put('data', $data);

        return redirect()->route('dashboard.index');

    }

    function getApiToken()
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

    function newPayLink($title, $description, $amount)
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
                'Authorization: Bearer ' . $this->getApiToken()

            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        //echo $response;


        // alert response
        //echo "<script>alert('$response');</script>";

        return $response;

    }

}
