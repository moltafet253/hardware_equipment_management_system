<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedCase extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_cases';
    protected $hidden=['created_at','updated_at','deleted_at'];
}
