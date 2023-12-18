<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public $timestamps = false;

    protected $fillable = ['login', 'password', 'first_name', 'last_name', 'birthday', 'created_at'];


    public function event(): hasMany
    {
        return $this->hasMany(Event::class, 'owner_id', 'id');
    }

    public function events(): belongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
