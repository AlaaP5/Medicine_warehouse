<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Manufacture extends Model
{
    use HasFactory;

    protected $fillable = ['nameEN', 'nameAR'];

    public function drugs()
    {
        return $this->hasMany(Drugs::class);
    }
}
