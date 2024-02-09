<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Wd;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'password',
        'rfid',
        'no_hp',
        'role',
    ];

    public function saldos()
    {
        return $this->hasMany(Saldo::class, 'rfid', 'rfid');
    }
    public function topup()
    {
        return $this->belongsTo(Topup::class, 'rfid', 'rfid');
    }
    public function wd()
    {
        return $this->belongsTo(Wd::class, 'rfid', 'rfid');
    }
    public function details()
    {
        return $this->belongsTo(OrderDetail::class, 'rfid', 'rfid');
    }
    public function orders()
    {
        // Asumsi bahwa model OrderDetail memiliki foreign key 'order_id' yang merujuk ke 'id' pada tabel orders
        return $this->hasMany(Order::class, 'rfid');
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
