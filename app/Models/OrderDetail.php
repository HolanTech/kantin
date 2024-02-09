<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function users()
    {
        return $this->belongsTo(User::class, 'rfid', 'rfid');
    }
    public function orders()
    {
        // Asumsi bahwa model OrderDetail memiliki foreign key 'order_id' yang merujuk ke 'id' pada tabel orders
        return $this->hasMany(Order::class, 'order_id');
    }
}
