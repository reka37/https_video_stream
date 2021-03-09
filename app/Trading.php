<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trading extends Model
{
    protected $fillable = ['ticker','order_type', 'buy_price', 'take_profit', 'stop_loss', 'percent', 'market_price', 'closed', 'close_price', 'percent_for_close'];
}
