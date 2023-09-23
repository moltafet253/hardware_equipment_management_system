<?php

namespace App\Models\EquipmentedOtherDevices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedMobile extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_mobiles';
    protected $hidden=['created_at','updated_at','deleted_at'];
}
