<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='jobs';
    protected $hidden=['created_at','updated_at','deleted_at'];
}
