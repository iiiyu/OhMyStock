<?php

namespace App\Admin\Controllers;

use App\Admin\Renderable\CompanyTable;
use App\Admin\Repositories\Portfolio;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;
use App\Utils\Log\Facades\FileLog as FileLog;
use App\Models\Company;

class PortfolioController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new Portfolio(), function (Grid $grid) {
            // $grid->disableCreateButton();
            // $grid->disableRowSelector();

            // $grid->column('id')->sortable();
            $grid->column('name');

            // $grid->tags('symbols');
            $grid->column('symbols')->display(function ($symbols) {
                $message = '';
                $companies = Company::whereIn('id', $symbols)->pluck('symbol')->sort();

                foreach ($companies as $symbol) {
                    # code...
                    $message = $message . $symbol . ' ';
                }
                return "<span>$message</span>";
            });
            // $grid->column('created_at');
            // $grid->column('updated_at')->sortable();


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
        return Show::make($id, new Portfolio(), function (Show $show) {
            $show->field('id');
            $show->field('name');
            // $show->field('symbols');
            $show->symbols()->as(function ($symbols) {
                $message = '';
                $companies = Company::whereIn('id', $symbols)->pluck('symbol')->sort();

                foreach ($companies as $symbol) {
                    # code...
                    $message = $message . $symbol . ' ';
                }

                return $message;
            });


            // $show->multipleSelectTable('symbols')
            //     ->max(10)
            //     ->title('Companies')
            //     ->dialogWidth('50%')
            //     ->from(CompanyTable::make(['id' => $show->getKey()]))
            //     ->model(Company::class, 'id', 'symbol')
            //     ->saving(function ($v) {
            //         return  $v;
            //     });
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
        return Form::make(new Portfolio(), function (Form $form) {
            $form->display('id');
            $form->text('name');
            // $form->text('symbols')->saveAsJson();

            // $form->multipleSelect('symbols')
            //     ->options(Company::all()->pluck('symbol', 'id'));

            $form->multipleSelectTable('symbols')
                ->max(10)
                ->title('Companies')
                ->dialogWidth('50%')
                ->from(CompanyTable::make(['id' => $form->getKey()]))
                ->model(Company::class, 'id', 'symbol')
                ->saving(function ($v) {
                    return  $v;
                });

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
