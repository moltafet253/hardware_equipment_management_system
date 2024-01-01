<?php

namespace App\Models;

use App\Models\Catalogs\Cases;
use App\Models\Catalogs\cpu;
use App\Models\Catalogs\GraphicCard;
use App\Models\Catalogs\Harddisk;
use App\Models\Catalogs\Motherboard;
use App\Models\Catalogs\NetworkCard;
use App\Models\Catalogs\Odd;
use App\Models\Catalogs\Power;
use App\Models\Catalogs\Ram;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipmentedCase extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='equipmented_cases';
    protected $hidden=['created_at','updated_at','deleted_at'];
    public function personInfo()
    {
        return $this->belongsTo(Person::class,'person_id','id');
    }
    public function caseInfo()
    {
        return $this->belongsTo(Cases::class,'case','id');
    }
    public function powerInfo()
    {
        return $this->belongsTo(Power::class,'power','id');
    }
    public function motherboardInfo()
    {
        return $this->belongsTo(Motherboard::class,'motherboard','id');
    }
    public function cpuInfo()
    {
        return $this->belongsTo(cpu::class,'cpu','id');
    }
    public function ram1Info()
    {
        return $this->belongsTo(Ram::class,'ram1','id');
    }
    public function ram2Info()
    {
        return $this->belongsTo(Ram::class,'ram2','id');
    }
    public function ram3Info()
    {
        return $this->belongsTo(Ram::class,'ram3','id');
    }
    public function ram4Info()
    {
        return $this->belongsTo(Ram::class,'ram4','id');
    }
    public function hdd1Info()
    {
        return $this->belongsTo(Harddisk::class,'hdd1','id');
    }
    public function hdd2Info()
    {
        return $this->belongsTo(Harddisk::class,'hdd2','id');
    }
    public function hdd3Info()
    {
        return $this->belongsTo(Harddisk::class,'hdd3','id');
    }
    public function hdd4Info()
    {
        return $this->belongsTo(Harddisk::class,'hdd4','id');
    }
    public function graphiccardInfo()
    {
        return $this->belongsTo(GraphicCard::class,'graphic_card','id');
    }
    public function oddInfo()
    {
        return $this->belongsTo(Odd::class,'odd','id');
    }
    public function networkcardInfo()
    {
        return $this->belongsTo(NetworkCard::class,'network_card','id');
    }
}
