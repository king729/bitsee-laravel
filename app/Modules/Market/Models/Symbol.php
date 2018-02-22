<?php

namespace App\Modules\Market\Models;

use Illuminate\Database\Eloquent\Model;

class Symbol extends Model
{
    protected $connection = 'october';
    protected $table = 'symbols';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    ];

    public function market()
    {
       return $this->belongsTo('App\Modules\Market\Market', 'market_id','id');
    }
}
