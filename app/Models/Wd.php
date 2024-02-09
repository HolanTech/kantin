<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wd extends Model
{
    use HasFactory;
    protected $table = 'wds';
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class, 'rfid', 'rfid');
    }
}
