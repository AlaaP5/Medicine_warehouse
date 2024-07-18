<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'payment_status',
        'case_id',
        'total'
    ];


    public function drugs()
    {
        return $this->belongsToMany(Drugs::class,'order_content','order_id','drug_id')->withPivot('quantity_require');
    }

    public function cases()
    {
        return $this->belongsTo(Status::class,'case_id','id'); ;
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id'); ;
    }
}
