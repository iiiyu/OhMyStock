<?php

namespace App\Admin\Renderable;

use Dcat\Admin\Grid;
use Dcat\Admin\Grid\LazyRenderable;
use App\Models\Company;

class CompanyTable extends LazyRenderable
{
    public function grid(): Grid
    {
        // 获取外部传递的参数
        $id = $this->id;

        return Grid::make(new Company(), function (Grid $grid) {


            // quick search
            $grid->quickSearch(['symbol', 'name'])->placeholder('Search Symbol...')->auto(false);

            // 禁用不需要的东西
            $grid->paginate(5);
            $grid->column('id');
            $grid->column('symbol')->sortable();
            $grid->column('name');

            $grid->column('sector');
            $grid->column('is_spx')->bool();
            $grid->column('is_ndx')->bool();

            $grid->rowSelector()->titleColumn('symbol');

            $grid->paginate(10);
            $grid->disableActions();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->like('symbol')->width(4);
                $filter->like('name')->width(4);
            });
        });
    }
}
