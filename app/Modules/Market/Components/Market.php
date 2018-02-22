<?php

namespace App\Modules\Market\Components;

use App\Modules\Market\Models\Market as MarketModel;

class Market
{
    static function getAllMarkets()
    {
        return MarketModel::with('symbols')->get()->toArray();
    }

}
