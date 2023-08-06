<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Printer extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='printers';
    protected $hidden=['created_at','updated_at','deleted_at'];
}
