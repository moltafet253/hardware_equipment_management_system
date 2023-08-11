<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='persons';
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $fillable=[
        'name',
        'family',
        'national_code',
        'personnel_code',
        'phone',
        'mobile',
        'net_username',
        'room_number',
        'assistance',
    ];
}
