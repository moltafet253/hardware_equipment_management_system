<?php

namespace App\Models\EquipmentedNetworkDevices;

use App\Models\Catalogs\NetworkEquipments\Switches;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedSwitch extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_switches';
    protected $hidden=['created_at','updated_at','deleted_at'];
    public function personInfo()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }
    public function equipmentInfo()
    {
        return $this->belongsTo(Switches::class,'switch_id','id');
    }
}
