<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

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
        'email',
        'password',
        'avatar',
        'google_id',
        'facebook_id',
        'created_at',
        'updated_at',
    ];

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
    /**
     * Relationship method followers
     */
    public function followers(){
        return $this->hasMany('\App\Models\Follow', 'user_id', 'id');
    }
    public function following(){
        return $this->hasMany('\App\Models\Follow', 'follow_id', 'id');
    }
    /**
     * Relation ship method list videos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function my_video(){
        return $this->hasMany('\App\Models\Video', 'author_id', 'id');
    }
}
