<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cases extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='cases';
    protected $hidden=['created_at','updated_at','deleted_at'];
}
