<?php

/**
 * A helper file for Dcat Admin, to provide autocomplete information to your IDE
 *
 * This file should not be included in your code, only analyzed by your IDE!
 *
 * @author jqh <841324345@qq.com>
 */
namespace Dcat\Admin {
    use Illuminate\Support\Collection;

    /**
     * @property Grid\Column|Collection name
     * @property Grid\Column|Collection version
     * @property Grid\Column|Collection alias
     * @property Grid\Column|Collection authors
     * @property Grid\Column|Collection enable
     * @property Grid\Column|Collection imported
     * @property Grid\Column|Collection config
     * @property Grid\Column|Collection require
     * @property Grid\Column|Collection require_dev
     * @property Grid\Column|Collection id
     * @property Grid\Column|Collection created_at
     * @property Grid\Column|Collection updated_at
     * @property Grid\Column|Collection company_id
     * @property Grid\Column|Collection calculated_at
     * @property Grid\Column|Collection last_price
     * @property Grid\Column|Collection before_last_price
     * @property Grid\Column|Collection one_day_change
     * @property Grid\Column|Collection vti_one_day_rel
     * @property Grid\Column|Collection vti_five_day_rel
     * @property Grid\Column|Collection vti_one_month_rel
     * @property Grid\Column|Collection price_divergence_cs
     * @property Grid\Column|Collection price_divergence_sm
     * @property Grid\Column|Collection price_divergence_ml
     * @property Grid\Column|Collection last_tradvol
     * @property Grid\Column|Collection parent_id
     * @property Grid\Column|Collection order
     * @property Grid\Column|Collection icon
     * @property Grid\Column|Collection uri
     * @property Grid\Column|Collection user_id
     * @property Grid\Column|Collection path
     * @property Grid\Column|Collection method
     * @property Grid\Column|Collection ip
     * @property Grid\Column|Collection input
     * @property Grid\Column|Collection permission_id
     * @property Grid\Column|Collection menu_id
     * @property Grid\Column|Collection slug
     * @property Grid\Column|Collection http_method
     * @property Grid\Column|Collection http_path
     * @property Grid\Column|Collection role_id
     * @property Grid\Column|Collection username
     * @property Grid\Column|Collection password
     * @property Grid\Column|Collection avatar
     * @property Grid\Column|Collection remember_token
     * @property Grid\Column|Collection symbol
     * @property Grid\Column|Collection stock_market
     * @property Grid\Column|Collection logo_id
     * @property Grid\Column|Collection volume
     * @property Grid\Column|Collection market_cap_basic
     * @property Grid\Column|Collection price_earnings_ttm
     * @property Grid\Column|Collection earnings_per_share_basic_ttm
     * @property Grid\Column|Collection number_of_employees
     * @property Grid\Column|Collection sector
     * @property Grid\Column|Collection is_spx
     * @property Grid\Column|Collection is_ndx
     * @property Grid\Column|Collection uuid
     * @property Grid\Column|Collection connection
     * @property Grid\Column|Collection queue
     * @property Grid\Column|Collection payload
     * @property Grid\Column|Collection exception
     * @property Grid\Column|Collection failed_at
     * @property Grid\Column|Collection closed_at
     * @property Grid\Column|Collection open
     * @property Grid\Column|Collection high
     * @property Grid\Column|Collection low
     * @property Grid\Column|Collection close
     * @property Grid\Column|Collection u_open
     * @property Grid\Column|Collection u_high
     * @property Grid\Column|Collection u_low
     * @property Grid\Column|Collection u_close
     * @property Grid\Column|Collection u_volume
     * @property Grid\Column|Collection change_over_time
     * @property Grid\Column|Collection change
     * @property Grid\Column|Collection change_percent
     * @property Grid\Column|Collection email
     * @property Grid\Column|Collection token
     * @property Grid\Column|Collection symbols
     * @property Grid\Column|Collection interval
     * @property Grid\Column|Collection adjusted_close
     * @property Grid\Column|Collection dividend_amount
     * @property Grid\Column|Collection split_coefficient
     * @property Grid\Column|Collection email_verified_at
     *
     * @method Grid\Column|Collection name(string $label = null)
     * @method Grid\Column|Collection version(string $label = null)
     * @method Grid\Column|Collection alias(string $label = null)
     * @method Grid\Column|Collection authors(string $label = null)
     * @method Grid\Column|Collection enable(string $label = null)
     * @method Grid\Column|Collection imported(string $label = null)
     * @method Grid\Column|Collection config(string $label = null)
     * @method Grid\Column|Collection require(string $label = null)
     * @method Grid\Column|Collection require_dev(string $label = null)
     * @method Grid\Column|Collection id(string $label = null)
     * @method Grid\Column|Collection created_at(string $label = null)
     * @method Grid\Column|Collection updated_at(string $label = null)
     * @method Grid\Column|Collection company_id(string $label = null)
     * @method Grid\Column|Collection calculated_at(string $label = null)
     * @method Grid\Column|Collection last_price(string $label = null)
     * @method Grid\Column|Collection before_last_price(string $label = null)
     * @method Grid\Column|Collection one_day_change(string $label = null)
     * @method Grid\Column|Collection vti_one_day_rel(string $label = null)
     * @method Grid\Column|Collection vti_five_day_rel(string $label = null)
     * @method Grid\Column|Collection vti_one_month_rel(string $label = null)
     * @method Grid\Column|Collection price_divergence_cs(string $label = null)
     * @method Grid\Column|Collection price_divergence_sm(string $label = null)
     * @method Grid\Column|Collection price_divergence_ml(string $label = null)
     * @method Grid\Column|Collection last_tradvol(string $label = null)
     * @method Grid\Column|Collection parent_id(string $label = null)
     * @method Grid\Column|Collection order(string $label = null)
     * @method Grid\Column|Collection icon(string $label = null)
     * @method Grid\Column|Collection uri(string $label = null)
     * @method Grid\Column|Collection user_id(string $label = null)
     * @method Grid\Column|Collection path(string $label = null)
     * @method Grid\Column|Collection method(string $label = null)
     * @method Grid\Column|Collection ip(string $label = null)
     * @method Grid\Column|Collection input(string $label = null)
     * @method Grid\Column|Collection permission_id(string $label = null)
     * @method Grid\Column|Collection menu_id(string $label = null)
     * @method Grid\Column|Collection slug(string $label = null)
     * @method Grid\Column|Collection http_method(string $label = null)
     * @method Grid\Column|Collection http_path(string $label = null)
     * @method Grid\Column|Collection role_id(string $label = null)
     * @method Grid\Column|Collection username(string $label = null)
     * @method Grid\Column|Collection password(string $label = null)
     * @method Grid\Column|Collection avatar(string $label = null)
     * @method Grid\Column|Collection remember_token(string $label = null)
     * @method Grid\Column|Collection symbol(string $label = null)
     * @method Grid\Column|Collection stock_market(string $label = null)
     * @method Grid\Column|Collection logo_id(string $label = null)
     * @method Grid\Column|Collection volume(string $label = null)
     * @method Grid\Column|Collection market_cap_basic(string $label = null)
     * @method Grid\Column|Collection price_earnings_ttm(string $label = null)
     * @method Grid\Column|Collection earnings_per_share_basic_ttm(string $label = null)
     * @method Grid\Column|Collection number_of_employees(string $label = null)
     * @method Grid\Column|Collection sector(string $label = null)
     * @method Grid\Column|Collection is_spx(string $label = null)
     * @method Grid\Column|Collection is_ndx(string $label = null)
     * @method Grid\Column|Collection uuid(string $label = null)
     * @method Grid\Column|Collection connection(string $label = null)
     * @method Grid\Column|Collection queue(string $label = null)
     * @method Grid\Column|Collection payload(string $label = null)
     * @method Grid\Column|Collection exception(string $label = null)
     * @method Grid\Column|Collection failed_at(string $label = null)
     * @method Grid\Column|Collection closed_at(string $label = null)
     * @method Grid\Column|Collection open(string $label = null)
     * @method Grid\Column|Collection high(string $label = null)
     * @method Grid\Column|Collection low(string $label = null)
     * @method Grid\Column|Collection close(string $label = null)
     * @method Grid\Column|Collection u_open(string $label = null)
     * @method Grid\Column|Collection u_high(string $label = null)
     * @method Grid\Column|Collection u_low(string $label = null)
     * @method Grid\Column|Collection u_close(string $label = null)
     * @method Grid\Column|Collection u_volume(string $label = null)
     * @method Grid\Column|Collection change_over_time(string $label = null)
     * @method Grid\Column|Collection change(string $label = null)
     * @method Grid\Column|Collection change_percent(string $label = null)
     * @method Grid\Column|Collection email(string $label = null)
     * @method Grid\Column|Collection token(string $label = null)
     * @method Grid\Column|Collection symbols(string $label = null)
     * @method Grid\Column|Collection interval(string $label = null)
     * @method Grid\Column|Collection adjusted_close(string $label = null)
     * @method Grid\Column|Collection dividend_amount(string $label = null)
     * @method Grid\Column|Collection split_coefficient(string $label = null)
     * @method Grid\Column|Collection email_verified_at(string $label = null)
     */
    class Grid {}

    class MiniGrid extends Grid {}

    /**
     * @property Show\Field|Collection name
     * @property Show\Field|Collection version
     * @property Show\Field|Collection alias
     * @property Show\Field|Collection authors
     * @property Show\Field|Collection enable
     * @property Show\Field|Collection imported
     * @property Show\Field|Collection config
     * @property Show\Field|Collection require
     * @property Show\Field|Collection require_dev
     * @property Show\Field|Collection id
     * @property Show\Field|Collection created_at
     * @property Show\Field|Collection updated_at
     * @property Show\Field|Collection company_id
     * @property Show\Field|Collection calculated_at
     * @property Show\Field|Collection last_price
     * @property Show\Field|Collection before_last_price
     * @property Show\Field|Collection one_day_change
     * @property Show\Field|Collection vti_one_day_rel
     * @property Show\Field|Collection vti_five_day_rel
     * @property Show\Field|Collection vti_one_month_rel
     * @property Show\Field|Collection price_divergence_cs
     * @property Show\Field|Collection price_divergence_sm
     * @property Show\Field|Collection price_divergence_ml
     * @property Show\Field|Collection last_tradvol
     * @property Show\Field|Collection parent_id
     * @property Show\Field|Collection order
     * @property Show\Field|Collection icon
     * @property Show\Field|Collection uri
     * @property Show\Field|Collection user_id
     * @property Show\Field|Collection path
     * @property Show\Field|Collection method
     * @property Show\Field|Collection ip
     * @property Show\Field|Collection input
     * @property Show\Field|Collection permission_id
     * @property Show\Field|Collection menu_id
     * @property Show\Field|Collection slug
     * @property Show\Field|Collection http_method
     * @property Show\Field|Collection http_path
     * @property Show\Field|Collection role_id
     * @property Show\Field|Collection username
     * @property Show\Field|Collection password
     * @property Show\Field|Collection avatar
     * @property Show\Field|Collection remember_token
     * @property Show\Field|Collection symbol
     * @property Show\Field|Collection stock_market
     * @property Show\Field|Collection logo_id
     * @property Show\Field|Collection volume
     * @property Show\Field|Collection market_cap_basic
     * @property Show\Field|Collection price_earnings_ttm
     * @property Show\Field|Collection earnings_per_share_basic_ttm
     * @property Show\Field|Collection number_of_employees
     * @property Show\Field|Collection sector
     * @property Show\Field|Collection is_spx
     * @property Show\Field|Collection is_ndx
     * @property Show\Field|Collection uuid
     * @property Show\Field|Collection connection
     * @property Show\Field|Collection queue
     * @property Show\Field|Collection payload
     * @property Show\Field|Collection exception
     * @property Show\Field|Collection failed_at
     * @property Show\Field|Collection closed_at
     * @property Show\Field|Collection open
     * @property Show\Field|Collection high
     * @property Show\Field|Collection low
     * @property Show\Field|Collection close
     * @property Show\Field|Collection u_open
     * @property Show\Field|Collection u_high
     * @property Show\Field|Collection u_low
     * @property Show\Field|Collection u_close
     * @property Show\Field|Collection u_volume
     * @property Show\Field|Collection change_over_time
     * @property Show\Field|Collection change
     * @property Show\Field|Collection change_percent
     * @property Show\Field|Collection email
     * @property Show\Field|Collection token
     * @property Show\Field|Collection symbols
     * @property Show\Field|Collection interval
     * @property Show\Field|Collection adjusted_close
     * @property Show\Field|Collection dividend_amount
     * @property Show\Field|Collection split_coefficient
     * @property Show\Field|Collection email_verified_at
     *
     * @method Show\Field|Collection name(string $label = null)
     * @method Show\Field|Collection version(string $label = null)
     * @method Show\Field|Collection alias(string $label = null)
     * @method Show\Field|Collection authors(string $label = null)
     * @method Show\Field|Collection enable(string $label = null)
     * @method Show\Field|Collection imported(string $label = null)
     * @method Show\Field|Collection config(string $label = null)
     * @method Show\Field|Collection require(string $label = null)
     * @method Show\Field|Collection require_dev(string $label = null)
     * @method Show\Field|Collection id(string $label = null)
     * @method Show\Field|Collection created_at(string $label = null)
     * @method Show\Field|Collection updated_at(string $label = null)
     * @method Show\Field|Collection company_id(string $label = null)
     * @method Show\Field|Collection calculated_at(string $label = null)
     * @method Show\Field|Collection last_price(string $label = null)
     * @method Show\Field|Collection before_last_price(string $label = null)
     * @method Show\Field|Collection one_day_change(string $label = null)
     * @method Show\Field|Collection vti_one_day_rel(string $label = null)
     * @method Show\Field|Collection vti_five_day_rel(string $label = null)
     * @method Show\Field|Collection vti_one_month_rel(string $label = null)
     * @method Show\Field|Collection price_divergence_cs(string $label = null)
     * @method Show\Field|Collection price_divergence_sm(string $label = null)
     * @method Show\Field|Collection price_divergence_ml(string $label = null)
     * @method Show\Field|Collection last_tradvol(string $label = null)
     * @method Show\Field|Collection parent_id(string $label = null)
     * @method Show\Field|Collection order(string $label = null)
     * @method Show\Field|Collection icon(string $label = null)
     * @method Show\Field|Collection uri(string $label = null)
     * @method Show\Field|Collection user_id(string $label = null)
     * @method Show\Field|Collection path(string $label = null)
     * @method Show\Field|Collection method(string $label = null)
     * @method Show\Field|Collection ip(string $label = null)
     * @method Show\Field|Collection input(string $label = null)
     * @method Show\Field|Collection permission_id(string $label = null)
     * @method Show\Field|Collection menu_id(string $label = null)
     * @method Show\Field|Collection slug(string $label = null)
     * @method Show\Field|Collection http_method(string $label = null)
     * @method Show\Field|Collection http_path(string $label = null)
     * @method Show\Field|Collection role_id(string $label = null)
     * @method Show\Field|Collection username(string $label = null)
     * @method Show\Field|Collection password(string $label = null)
     * @method Show\Field|Collection avatar(string $label = null)
     * @method Show\Field|Collection remember_token(string $label = null)
     * @method Show\Field|Collection symbol(string $label = null)
     * @method Show\Field|Collection stock_market(string $label = null)
     * @method Show\Field|Collection logo_id(string $label = null)
     * @method Show\Field|Collection volume(string $label = null)
     * @method Show\Field|Collection market_cap_basic(string $label = null)
     * @method Show\Field|Collection price_earnings_ttm(string $label = null)
     * @method Show\Field|Collection earnings_per_share_basic_ttm(string $label = null)
     * @method Show\Field|Collection number_of_employees(string $label = null)
     * @method Show\Field|Collection sector(string $label = null)
     * @method Show\Field|Collection is_spx(string $label = null)
     * @method Show\Field|Collection is_ndx(string $label = null)
     * @method Show\Field|Collection uuid(string $label = null)
     * @method Show\Field|Collection connection(string $label = null)
     * @method Show\Field|Collection queue(string $label = null)
     * @method Show\Field|Collection payload(string $label = null)
     * @method Show\Field|Collection exception(string $label = null)
     * @method Show\Field|Collection failed_at(string $label = null)
     * @method Show\Field|Collection closed_at(string $label = null)
     * @method Show\Field|Collection open(string $label = null)
     * @method Show\Field|Collection high(string $label = null)
     * @method Show\Field|Collection low(string $label = null)
     * @method Show\Field|Collection close(string $label = null)
     * @method Show\Field|Collection u_open(string $label = null)
     * @method Show\Field|Collection u_high(string $label = null)
     * @method Show\Field|Collection u_low(string $label = null)
     * @method Show\Field|Collection u_close(string $label = null)
     * @method Show\Field|Collection u_volume(string $label = null)
     * @method Show\Field|Collection change_over_time(string $label = null)
     * @method Show\Field|Collection change(string $label = null)
     * @method Show\Field|Collection change_percent(string $label = null)
     * @method Show\Field|Collection email(string $label = null)
     * @method Show\Field|Collection token(string $label = null)
     * @method Show\Field|Collection symbols(string $label = null)
     * @method Show\Field|Collection interval(string $label = null)
     * @method Show\Field|Collection adjusted_close(string $label = null)
     * @method Show\Field|Collection dividend_amount(string $label = null)
     * @method Show\Field|Collection split_coefficient(string $label = null)
     * @method Show\Field|Collection email_verified_at(string $label = null)
     */
    class Show {}

    /**
     
     */
    class Form {}

}

namespace Dcat\Admin\Grid {
    /**
     
     */
    class Column {}

    /**
     
     */
    class Filter {}
}

namespace Dcat\Admin\Show {
    /**
     
     */
    class Field {}
}
