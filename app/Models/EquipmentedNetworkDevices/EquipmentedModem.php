<?php

namespace App\Models\EquipmentedNetworkDevices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedModem extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_modems';
    protected $hidden=['created_at','updated_at','deleted_at'];
}
