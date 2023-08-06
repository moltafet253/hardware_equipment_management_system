<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Motherboard extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='motherboards';
    protected $hidden=['created_at','updated_at','deleted_at'];
}
