<?php

namespace App\Models\EquipmentedOtherDevices;

use App\Models\Catalogs\OtherEquipments\Headphone;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedHeadphone extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_headphones';
    protected $hidden=['created_at','updated_at','deleted_at'];
    public function personInfo()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }
    public function equipmentInfo()
    {
        return $this->belongsTo(Headphone::class,'headphone_id','id');
    }
}
