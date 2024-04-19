<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    ];

    public function userPosts()
    {
        return $this->hasMany('App\Models\PostsUserMapping', 'user_id', 'id');
    }

    public function postUserData(){
        return $this->hasManyThrough (
            User::class,
            PostsUserMapping::class,
            'post_id',
            'id',
            'id',
            'user_id'
        );
    }

    public function userPostData(){
        return $this->hasManyThrough (
            Posts::class,
            PostsUserMapping::class,
            'post_id',
            'id',
            'id',
            'post_id'
        );
    }
}
