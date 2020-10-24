<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class ActiveStock extends Model
{
    use HasDateTimeFormatter;

    protected $table = 'active_stocks';

    protected $guarded = [];

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
