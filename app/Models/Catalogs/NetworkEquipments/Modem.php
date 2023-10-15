<?php

namespace App\Models\Catalogs\NetworkEquipments;

use App\Models\Catalogs\Company;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Modem extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='modems';
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $fillable=[
        'company_id',
        'model',
        'ports_number',
        'type',
        'connectivity_type',
        'active',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
