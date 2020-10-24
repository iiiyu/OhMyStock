<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasDateTimeFormatter;

    public function series()
    {
        return $this->hasMany('App\Models\Series');
    }

    public function activeStock()
    {
        return $this->hasMany('App\Models\ActiveStock');
    }
}
