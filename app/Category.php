<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
		'name', 
		'isVisiable',
		'seo_url',
		'seo_description'
	];
}
