<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentLog extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_logs';
    protected $hidden=['updated_at','deleted_at'];
}