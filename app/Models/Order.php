<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $dates = ['tanggal'];
    // Mendefinisikan relasi ke OrderDetail
    public function details()
    {
        // Asumsi bahwa model OrderDetail memiliki foreign key 'order_id' yang merujuk ke 'id' pada tabel orders
        return $this->hasMany(OrderDetail::class, 'order_id');
    }
    public function user()
    {
        // Asumsi bahwa model OrderDetail memiliki foreign key 'order_id' yang merujuk ke 'id' pada tabel orders
        return $this->belongsTo(User::class, 'kantin_id', 'id');
    }

    public function saldos()
    {
        return $this->hasMany(Saldo::class, 'rfid', 'rfid');
    }
}
