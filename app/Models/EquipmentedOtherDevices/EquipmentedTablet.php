<?php

namespace App\Models\EquipmentedOtherDevices;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedTablet extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_tablets';
    protected $hidden=['created_at','updated_at','deleted_at'];
}
