<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Load extends Model
{
    use HasFactory;

    protected $fillable = [
        "date", 
    ];

    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }
}
