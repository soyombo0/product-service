<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'game',
        'price',
        'games_in_total',
        'efriend_id',
        'customer_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
