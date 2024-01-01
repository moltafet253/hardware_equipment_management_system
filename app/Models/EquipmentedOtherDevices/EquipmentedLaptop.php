<?php

namespace App\Models\EquipmentedOtherDevices;

use App\Models\Catalogs\OtherEquipments\Laptop;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedLaptop extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_laptops';
    protected $hidden=['created_at','updated_at','deleted_at'];
    public function personInfo()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }
    public function equipmentInfo()
    {
        return $this->belongsTo(Laptop::class,'laptop_id','id');
    }
}
