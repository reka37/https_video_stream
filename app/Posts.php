<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = ['data', 'count_likes', 'isComments', 'category_id'];
}
