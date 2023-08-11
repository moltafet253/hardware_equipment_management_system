<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voip extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='voips';
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $fillable=[
        'company_id',
        'model'
    ];
}
