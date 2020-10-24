<?php

namespace App\Admin\Repositories;

use App\Models\ActiveStock as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class ActiveStock extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
