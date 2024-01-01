<?php

namespace App\Models\EquipmentedOtherDevices;

use App\Models\Catalogs\OtherEquipments\Webcam;
use App\Models\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedWebcam extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_webcams';
    protected $hidden=['created_at','updated_at','deleted_at'];
    public function personInfo()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }
    public function equipmentInfo()
    {
        return $this->belongsTo(Webcam::class,'webcam_id','id');
    }
}
