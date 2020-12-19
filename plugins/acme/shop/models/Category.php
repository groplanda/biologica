<?php namespace Acme\Shop\Models;

use Model;

/**
 * Model
 */
class Category extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\SimpleTree;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'acme_shop_categories';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];

    public $belongsToMany = [
        'products' => [
            'Acme\Shop\Models\Product',
            'table' => 'acme_shop_products_categories'
        ]
    ];

    public $attachOne  = [
        'image' => ['System\Models\File', 'delete' => true ]
    ];

    public function scopeSpecial($query)
    {
        return $query->where('is_cub', '1');
    }
}
