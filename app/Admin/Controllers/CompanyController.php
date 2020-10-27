<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Company;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class CompanyController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Company(), function (Grid $grid) {

            // 禁用不需要的东西
            $grid->disableCreateButton();
            $grid->disableRowSelector();
            $grid->disableActions();
            $grid->fixColumns(1, 0);
            $grid->paginate(100);

            $grid->column('symbol')->sortable();
            $grid->column('name');
            $grid->column('market_cap_basic')->sortable();
            $grid->column('price_earnings_ttm')->sortable();
            $grid->column('earnings_per_share_basic_ttm')->sortable();
            $grid->column('number_of_employees')->sortable();
            $grid->column('sector');
            $grid->column('is_spx')->bool();

            $grid->filter(function (Grid\Filter $filter) {
                $filter->equal('id');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        return Show::make($id, new Company(), function (Show $show) {
            $show->field('id');
            $show->field('symbol');
            $show->field('name');
            $show->field('created_at');
            $show->field('updated_at');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Form::make(new Company(), function (Form $form) {
            $form->display('id');
            $form->text('symbol');
            $form->text('name');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
