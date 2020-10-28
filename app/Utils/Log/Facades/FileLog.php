<?php

namespace App\Utils\Log\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see App\Utils\Log\FileDailyWriter
 */
class FileLog extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fileLog';
    }
}