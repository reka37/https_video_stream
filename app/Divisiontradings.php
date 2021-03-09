<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Divisiontradings extends Model
{
	protected $fillable = ['percent_for_close', 'parent_trading_id', 'children_trading_id'];
}
 