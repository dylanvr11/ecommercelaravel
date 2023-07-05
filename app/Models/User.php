<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasRoles;

    protected $table = 'users';

    protected $fillable = [
        'number_id',
        'name',
        'last_name',
        'email',
        'password',
    ];

    //esto para se ejecute siempre con el
    protected $appends = ['full_name'];

    protected $hidden = [
        'password',
    ];

    //casteo
    protected $casts = [
        'created_at' => 'datetime:Y-m-d',
        'updated_at' => 'datetime:Y-m-d'
    ];

    // accesor (get)
    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->last_name}";
    }

    // mutador (create - update) set
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // Relations
    public function AdministratorOrders()
    {
        return $this->hasMany(Order::class, 'administrator_user_id', 'id');
    }

    public function CustomerOrders()
    {
        return $this->hasMany(Order::class, 'customer_user_id', 'id');
    }
}
