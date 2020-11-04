<?php

namespace App\Models;

use Dcat\Admin\Traits\HasDateTimeFormatter;

use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasDateTimeFormatter;

    protected $casts = [
        'symbols' => 'array',
    ];
}
