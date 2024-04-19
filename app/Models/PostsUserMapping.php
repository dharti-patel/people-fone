<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostsUserMapping extends Model
{
    use HasFactory;

    protected $table = 'posts_user_mapping';
    
    protected $fillable = [
        'post_id',
        'user_id',
    ];

    public function postMapping()
    {
        return $this->belongsTo('App\Models\Posts', 'post_id', 'id');
    }
}
