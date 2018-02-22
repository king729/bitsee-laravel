<?php
namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\Auth;

use Cache;

use Illuminate\Support\Facades\Response;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;

use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Modules\Market\Components\Market;

use Illuminate\Http\Request;

class MarketController extends Controller
{

    /*获取所有市场*/
    public function index()
    {
        $markets =  Market::getAllMarkets();
       
        return Response::json($markets);
    }

    public function getTicker(Request $request)
    {
        $market = $request->input('market');

        $symbol = $request->input('symbol');

        if (!$symbol) {
            
            return app('Ticker')->getTickers($market);

        } else {

            return app('Ticker')->getTicker($market, $symbol);

        }

    }


}