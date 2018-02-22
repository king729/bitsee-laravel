<?php

namespace App\Modules\Market\Models;

use Illuminate\Database\Eloquent\Model;

class Ticker extends Model
{
    protected $table = 'tickers';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];
}
