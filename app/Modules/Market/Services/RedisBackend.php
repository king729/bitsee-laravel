<?php

namespace App\Modules\Market\Services;

use Cache;

class RedisBackend
{
     public function getTickers($market)
     {
         return Cache::get('ticker_'.$market);
     }

     public function getTicker($market, $symbol)
     {
         return Cache::get('ticker_'.$market.'_'.$symbol);
     } 
    
}
