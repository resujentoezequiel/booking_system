<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationInformationModel extends Model
{
    use HasFactory;
    protected $table = 'reservation_information';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'reservationist',
        'room_id',
        'date_reservation',
        'start_time',
        'end_time',
        'minutes_count',
        'reservation_status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
