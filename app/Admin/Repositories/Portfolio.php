<?php

namespace App\Admin\Repositories;

use App\Models\Portfolio as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Portfolio extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
