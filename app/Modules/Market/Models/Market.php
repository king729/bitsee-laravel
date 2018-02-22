<?php

namespace App\Modules\Market\Models;

use Illuminate\Database\Eloquent\Model;

class Market extends Model
{
    protected $connection = 'october';
    protected $table = 'markets';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    public function symbols()
    {
       return $this->hasMany('App\Modules\Market\Models\Symbol', 'market_id', 'id');
    }
}
