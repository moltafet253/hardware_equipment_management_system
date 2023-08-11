<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Harddisk extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='harddisks';
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $fillable = [
        'company_id',
        'model',
        'capacity',
        'type',
        'connectivity_type',
    ];
}
