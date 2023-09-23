<?php

namespace App\Models\EquipmentedNetworkDevices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedSwitch extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_switches';
    protected $hidden=['created_at','updated_at','deleted_at'];
}
