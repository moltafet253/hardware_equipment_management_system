<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstablishmentPlace extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='establishment_places';
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $fillable = [
        'title'
    ];
}
