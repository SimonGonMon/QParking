<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Service;

class ServiceController extends Controller
{
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

        // Resto del código de la función
    }
}
