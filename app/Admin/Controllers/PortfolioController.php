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
use App\Admin\Renderable\ActiveStockTable;

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

            $grid->column('company_ids')->display(function ($company_ids) {
                $message = '';
                $companies = Company::whereIn('id', $company_ids)->pluck('symbol')->sort();

                foreach ($companies as $company_id) {
                    # code...
                    $message = $message . $company_id . ' ';
                }
                return "<span>$message</span>";
            });

            $grid->column('content')
                ->display('Detail')->modal(function ($modal) {
                    $modal->title('Screener');
                    // 允许在比包内返回异步加载类的实例
                    return ActiveStockTable::make(['company_ids' => $this->company_ids]);
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
            $show->company_ids()->as(function ($company_ids) {
                $message = '';
                $companies = Company::whereIn('id', $company_ids)->pluck('symbol')->sort();

                foreach ($companies as $company_id) {
                    # code...
                    $message = $message . $company_id . ' ';
                }

                return $message;
            });
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
            $form->multipleSelect('company_ids')
                ->options(Company::all()->pluck('symbol', 'id'));
            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
