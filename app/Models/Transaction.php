<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'license_plate',
        'reference',
        'amount',
        'status',
        'time_start',
        'time_end',
        'elapsed_time',
        'qr_code'
    ];


}
