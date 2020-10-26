<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\Series;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class SeriesController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Series(['company']), function (Grid $grid) {

            // 禁用不需要的东西
            $grid->disableCreateButton();
            $grid->disableRowSelector();
            $grid->disableActions();

            $grid->column('company.name');
            $grid->column('company.symbol');
            $grid->column('interval');
            $grid->column('closed_at')->sortable();
            $grid->column('open');
            $grid->column('high');
            $grid->column('low');
            $grid->column('close');
            $grid->column('adjusted_close');
            $grid->column('volume');
            $grid->column('dividend_amount');
            $grid->column('split_coefficient');



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
        return Show::make($id, new Series(), function (Show $show) {
            $show->field('id');
            $show->field('company_id');
            $show->field('closed_at');
            $show->field('interval');
            $show->field('open');
            $show->field('high');
            $show->field('low');
            $show->field('close');
            $show->field('adjusted_close');
            $show->field('volume');
            $show->field('dividend_amount');
            $show->field('split_coefficient');
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
        return Form::make(new Series(), function (Form $form) {
            $form->display('id');
            $form->text('company_id');
            $form->text('closed_at');
            $form->text('interval');
            $form->text('open');
            $form->text('high');
            $form->text('low');
            $form->text('close');
            $form->text('adjusted_close');
            $form->text('volume');
            $form->text('dividend_amount');
            $form->text('split_coefficient');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
