<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class Exels extends Model
{
    protected $fillable = ['ticker','fair_value', 'market_price', 'name', 'safety_margin'];
}
