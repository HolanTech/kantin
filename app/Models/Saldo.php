<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saldo extends Model
{
    use HasFactory;
    protected $table = 'saldos';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'rfid', 'rfid');
    }
}
