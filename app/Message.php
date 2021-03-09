<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
	protected $fillable = ['autor','content', 'is_admin', 'post_id'];
}
