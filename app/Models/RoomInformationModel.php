<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomInformationModel extends Model
{
    use HasFactory;
    protected $table = 'room_information';
    public $timestamps = false;
    protected $fillable = [
        'id',
        'name',
        'description',
        'status',
        'created_at',
    ];
}
