<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_type',
        'post_data',
        'valid_till'
    ];

    public function postMapping()
    {
        return $this->hasMany('App\Models\PostsUserMapping', 'post_id', 'id');
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
}
