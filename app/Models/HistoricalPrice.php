<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class HistoricalPrice extends Model
{
    use HasDateTimeFormatter;
    protected $table = 'historical_prices';

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
