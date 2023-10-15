<?php

namespace App\Models\Catalogs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class cpu extends Model
{
    use HasFactory,SoftDeletes;
    protected $table='cpus';
    protected $hidden=['created_at','updated_at','deleted_at'];
    protected $fillable = [
        'company_id',
        'model',
        'generation',
        'active',
    ];
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
