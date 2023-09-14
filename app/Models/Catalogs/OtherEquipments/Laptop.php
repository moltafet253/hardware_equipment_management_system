<?php

namespace App\Models\Catalogs\OtherEquipments;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laptop extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='laptops';
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $fillable=[
        'company_id',
        'model',
        'screen_size',
        'cpu',
        'ram1',
        'ram2',
        'ram3',
        'ram4',
        'hdd1',
        'hdd2',
        'graphic_card',
        'active',
    ];
}
