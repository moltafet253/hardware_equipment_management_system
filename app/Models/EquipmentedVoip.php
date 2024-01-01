<?php

namespace App\Models;

use App\Models\Catalogs\Voip;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedVoip extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_voips';
    protected $hidden=['created_at','updated_at','deleted_at'];
    public function personInfo()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }
    public function equipmentInfo()
    {
        return $this->belongsTo(Voip::class,'voip_id','id');
    }
}
