<?php

namespace App\Models;

use Database\Factories\CurrencyFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        "num_code", 
        "char_code", 
        "nominal", 
        "name", 
        "value", 
        "visibility", 
        "load_id", 
    ];

    public function loaded()
    {
        return $this->belongsTo(Load::class);
    }

    public function scopeVisible($query)
    {
        return $query->whereVisibility(true);
    }

    protected static function newFactory()
    {
        return CurrencyFactory::new();
    }
}
