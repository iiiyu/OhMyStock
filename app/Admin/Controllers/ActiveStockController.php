<?php

namespace App\Admin\Controllers;

use App\Admin\Repositories\ActiveStock;
use Dcat\Admin\Form;
use Dcat\Admin\Grid;
use Dcat\Admin\Show;
use Dcat\Admin\Controllers\AdminController;

class ActiveStockController extends AdminController
{
    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Grid::make(new ActiveStock(['company']), function (Grid $grid) {
            // data
            $grid->model()->orderBy('one_day_change', 'desc');

            // 禁用不需要的东西
            $grid->disableCreateButton();
            $grid->disableRowSelector();
            $grid->disableActions();
            $grid->fixColumns(2, 0);
            $grid->paginate(100);

            // Column
            $grid->column('company.symbol')->label();
            $grid->column('last_price')->sortable()->if(function ($column) {
                return $this->before_last_price <= $this->last_price;
            })
                ->then(function (Grid\Column $column) {

                    $column->label('green');
                })
                ->else(function (Grid\Column $column) {
                    $column->label('red');
                });;
            $grid->column('one_day_change')->sortable()->display(function ($one_day_change) {
                return round($one_day_change, 4) * 100 . '%';
            })->if(function ($column) {
                return $this->before_last_price <= $this->last_price;
            })
                ->then(function (Grid\Column $column) {
                    // $column->display($view)->copyable();
                    $column->label('green');
                })
                ->else(function (Grid\Column $column) {
                    $column->label('red');
                });

            $grid->column('vti_one_day_rel')
                ->sortable()
                ->if(function ($column) {
                    return $column->getValue() >= 0;
                })->then(function (Grid\Column $column) {
                    $column->display(function ($vti_one_day_rel) {
                        $vti_one_day_rel = round($vti_one_day_rel, 2);
                        return "<span style='color:green'>$vti_one_day_rel</span>";
                    });
                })->else(function (Grid\Column $column) {
                    $column->display(function ($vti_one_day_rel) {
                        $vti_one_day_rel = round($vti_one_day_rel, 2);
                        return "<span style='color:red'>$vti_one_day_rel</span>";
                    });
                });
            $grid->column('vti_five_day_rel')->sortable()
                ->if(function ($column) {
                    return $column->getValue() >= 0;
                })->then(function (Grid\Column $column) {
                    $column->display(function ($vti_five_day_rel) {
                        $vti_five_day_rel = round($vti_five_day_rel, 2);
                        return "<span style='color:green'>$vti_five_day_rel</span>";
                    });
                })->else(function (Grid\Column $column) {
                    $column->display(function ($vti_five_day_rel) {
                        $vti_five_day_rel = round($vti_five_day_rel, 2);
                        return "<span style='color:red'>$vti_five_day_rel</span>";
                    });
                });
            $grid->column('vti_one_month_rel')->sortable()
                ->if(function ($column) {
                    return $column->getValue() >= 0;
                })->then(function (Grid\Column $column) {
                    $column->display(function ($vti_one_month_rel) {
                        $vti_one_month_rel = round($vti_one_month_rel, 2);
                        return "<span style='color:green'>$vti_one_month_rel</span>";
                    });
                })->else(function (Grid\Column $column) {
                    $column->display(function ($vti_one_month_rel) {
                        $vti_one_month_rel = round($vti_one_month_rel, 2);
                        return "<span style='color:red'>$vti_one_month_rel</span>";
                    });
                });
            $grid->column('price_divergence_cs')->sortable()
                ->if(function ($column) {
                    return $column->getValue() >= 0;
                })->then(function (Grid\Column $column) {
                    $column->display(function ($price_divergence_cs) {
                        $price_divergence_cs = round($price_divergence_cs, 2);
                        return "<span style='color:green'>$price_divergence_cs</span>";
                    });
                })->else(function (Grid\Column $column) {
                    $column->display(function ($price_divergence_cs) {
                        $price_divergence_cs = round($price_divergence_cs, 2);
                        return "<span style='color:red'>$price_divergence_cs</span>";
                    });
                });
            $grid->column('price_divergence_sm')->sortable()
                ->if(function ($column) {
                    return $column->getValue() >= 0;
                })->then(function (Grid\Column $column) {
                    $column->display(function ($price_divergence_sm) {
                        $price_divergence_sm = round($price_divergence_sm, 2);
                        return "<span style='color:green'>$price_divergence_sm</span>";
                    });
                })->else(function (Grid\Column $column) {
                    $column->display(function ($price_divergence_sm) {
                        $price_divergence_sm = round($price_divergence_sm, 2);
                        return "<span style='color:red'>$price_divergence_sm</span>";
                    });
                });
            $grid->column('price_divergence_ml')->sortable()
                ->if(function ($column) {
                    return $column->getValue() >= 0;
                })->then(function (Grid\Column $column) {
                    $column->display(function ($price_divergence_ml) {
                        $price_divergence_ml = round($price_divergence_ml, 2);
                        return "<span style='color:green'>$price_divergence_ml</span>";
                    });
                })->else(function (Grid\Column $column) {
                    $column->display(function ($price_divergence_ml) {
                        $price_divergence_ml = round($price_divergence_ml, 2);
                        return "<span style='color:red'>$price_divergence_ml</span>";
                    });
                });
            $grid->column('last_tradvol')->sortable()
                ->if(function ($column) {
                    return $column->getValue() >= 0;
                })->then(function (Grid\Column $column) {
                    $column->display(function ($last_tradvol) {
                        return "<span style='color:green'>$last_tradvol</span>";
                    });
                })->else(function (Grid\Column $column) {
                    $column->display(function ($last_tradvol) {
                        return "<span style='color:red'>$last_tradvol</span>";
                    });
                });

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
        return Show::make($id, new ActiveStock(), function (Show $show) {
            $show->field('id');
            $show->field('company_id');
            $show->field('calculated_at');
            $show->field('last_price');
            $show->field('before_last_price');
            $show->field('one_day_change');
            $show->field('vti_one_day_rel');
            $show->field('vti_five_day_rel');
            $show->field('vti_one_month_rel');
            $show->field('price_divergence_cs');
            $show->field('price_divergence_sm');
            $show->field('price_divergence_ml');
            $show->field('last_tradvol');
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
        return Form::make(new ActiveStock(), function (Form $form) {
            $form->display('id');
            $form->text('company_id');
            $form->text('calculated_at');
            $form->text('last_price');
            $form->text('before_last_price');
            $form->text('one_day_change');
            $form->text('vti_one_day_rel');
            $form->text('vti_five_day_rel');
            $form->text('vti_one_month_rel');
            $form->text('price_divergence_cs');
            $form->text('price_divergence_sm');
            $form->text('price_divergence_ml');
            $form->text('last_tradvol');

            $form->display('created_at');
            $form->display('updated_at');
        });
    }
}
