<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Odd extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='odds';
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $fillable = [
        'company_id',
        'model',
        'connectivity_type',
    ];
}
