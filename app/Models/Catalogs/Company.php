<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='companies';
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $fillable=['name','products', 'active',];
}
