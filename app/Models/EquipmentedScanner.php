<?php

namespace App\Models;

use App\Models\Catalogs\Scanner;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedScanner extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_scanners';
    protected $hidden=['created_at','updated_at','deleted_at'];
    public function personInfo()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }
    public function equipmentInfo()
    {
        return $this->belongsTo(Scanner::class,'scanner_id','id');
    }
}
