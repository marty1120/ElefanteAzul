<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class TipoLavado extends Model
{
    use HasFactory;

    protected $table = 'tipo_lavado';
    public $incrementing = false;  
    protected $keyType = 'string';
    public $timestamps = false;   
    protected $fillable = ['id', 'descripcion', 'precio', 'tiempo']; 

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }
}
