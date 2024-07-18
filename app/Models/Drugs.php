<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drugs extends Model
{
    use HasFactory;
    protected $fillable = [
        'scientific_name',
        'commercial_name',
        'manufacture_id',
        'company_id',
        'quantity_available',
        'expiry_date',
        'price'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function manufacture()
    {
        return $this->belongsTo(Manufacture::class, 'manufacture_id', 'id');
    }
}
