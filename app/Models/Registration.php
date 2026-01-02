<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'name',
        'email',
        'phone_number',
        'gender',
        'age',
        'status_peserta',
        'previous_participation',
        'special_needs',
        'status',
        'payment_proof',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
