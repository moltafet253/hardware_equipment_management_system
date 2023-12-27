<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentLog extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipment_logs';
    protected $hidden=['updated_at','updated_at','deleted_at'];
    protected $fillable = [
        'equipment_id',
        'equipment_type',
        'personal_code',
        'property_number',
        'title',
        'operator',
    ];
    public function personInfo()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }
}
