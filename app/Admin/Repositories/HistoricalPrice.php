<?php

namespace App\Admin\Repositories;

use App\Models\HistoricalPrice as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class HistoricalPrice extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
