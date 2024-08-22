<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'professional_id',
        'client_id',
        'start_time',
        'end_time',
        'status',
        'descreption',
    ];

    public function professional()
    {
        return $this->belongsTo(Professional::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}
