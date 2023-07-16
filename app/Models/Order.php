<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
        'title',
        'total_amount',
        'description',
        'phone_number',
        'order_date',
    ];

    // Relacja do użytkownika (klienta), który złożył to zamówienie
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
