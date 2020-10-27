<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\HistoricalPrice;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class HistoricalPriceController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new HistoricalPrice(), function (Grid $grid) {
            $grid->column('id')->sortable();
            $grid->column('company_id');
            $grid->column('closed_at');
            $grid->column('open');
            $grid->column('high');
            $grid->column('low');
            $grid->column('close');
            $grid->column('volume');
            $grid->column('u_open');
            $grid->column('u_high');
            $grid->column('u_low');
            $grid->column('u_close');
            $grid->column('u_volume');
            $grid->column('change_over_time');
            $grid->column('change');
            $grid->column('change_percent');
            $grid->column('created_at');
            $grid->column('updated_at')->sortable();
        
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
        return Show::make($id, new HistoricalPrice(), function (Show $show) {
            $show->field('id');
            $show->field('company_id');
            $show->field('closed_at');
            $show->field('open');
            $show->field('high');
            $show->field('low');
            $show->field('close');
            $show->field('volume');
            $show->field('u_open');
            $show->field('u_high');
            $show->field('u_low');
            $show->field('u_close');
            $show->field('u_volume');
            $show->field('change_over_time');
            $show->field('change');
            $show->field('change_percent');
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
        return Form::make(new HistoricalPrice(), function (Form $form) {
            $form->display('id');
            $form->text('company_id');
            $form->text('closed_at');
            $form->text('open');
            $form->text('high');
            $form->text('low');
            $form->text('close');
            $form->text('volume');
            $form->text('u_open');
            $form->text('u_high');
            $form->text('u_low');
            $form->text('u_close');
            $form->text('u_volume');
            $form->text('change_over_time');
            $form->text('change');
            $form->text('change_percent');
        
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
