<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    protected $fillable = ['data', 'name', 'count_likes', 'isComments', 'category_id', 'image', 'seo_url'];
}
