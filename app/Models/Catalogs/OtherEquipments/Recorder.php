<?php

namespace App\Models\Catalogs\OtherEquipments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recorder extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='recorders';
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $fillable=[
        'company_id',
        'model',
        'active',
    ];
}
