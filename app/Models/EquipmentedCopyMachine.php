<?php

namespace App\Models;

use App\Models\Catalogs\CopyMachine;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedCopyMachine extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_copy_machines';
    protected $hidden=['created_at','updated_at','deleted_at'];
    public function personInfo()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }
    public function equipmentInfo()
    {
        return $this->belongsTo(CopyMachine::class,'copy_machine_id','id');
    }
}
