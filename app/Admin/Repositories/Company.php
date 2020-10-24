<?php

namespace App\Admin\Repositories;

use App\Models\Company as Model;
use Dcat\Admin\Repositories\EloquentRepository;

class Company extends EloquentRepository
{
    /**
     * Model.
     *
     * @var string
     */
    protected $eloquentClass = Model::class;
}
