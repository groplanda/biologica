<?php namespace Acme\Shop\Models;

use Model;

/**
 * Model
 */
class Product extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sluggable;
    use \October\Rain\Database\Traits\SoftDelete;
    use \October\Rain\Database\Traits\Sortable;


    protected $dates = ['deleted_at'];
    protected $slugs = ['slug' => 'title'];
    protected $jsonable = ['options'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'acme_shop_products';

    /**
     * @var array Validation rules
     */
    public $rules = [

    ];

    public $belongsToMany = [
        'categories' => [
            'Acme\Shop\Models\Category',
            'table' => 'acme_shop_products_categories',
        ],
    ];

    public $attachMany = [
        'gallery' => ['System\Models\File', 'delete' => true ]
    ];

    public $attachOne  = [
        'file' => ['System\Models\File', 'delete' => true ]
    ];

    public function afterDelete() {
        foreach ($this->gallery as $image) {
            $image->delete();
        }
    }

    public function scopeListFrontEnd($query, $options = [], $perPage)
    {

        extract(array_merge([
            'page'       => 1,
            'perPage'    => $perPage,
            //'start'      => 0,
            //'end'        => $maxPrice,
            'categories' => null,
            'sort' => 'sort_order asc'
        ], $options));

        // if($start || $end) {
        //     $query->whereBetween('price', [$start, $end])->get();
        // }
        if($categories !== null) {

            if(!is_array($categories)) {
                $categories = [$categories];
            }

            foreach($categories as $category) {
                $query->whereHas('categories', function($q) use ($category){
                    $q->where('id', '=', $category);
                });
            }

        }

        // if(!is_array($sort)) {
        //     $sort = [$sort];
        // }

        // foreach($sort as $_sort) {

        //     if(in_array($_sort, array_keys(self::$allowedSortingOptions))) {

        //         $parts = explode(' ', $_sort);

        //         if(count($parts) < 2) {
        //             array_push($parts, 'desc');
        //         }

        //         list($sortField, $sortDirecton) = $parts;

        //         $query->orderBy($sortField, $sortDirecton);

        //     }

        // }

        $lastPage = $query->paginate($perPage, $page)->lastPage();

        if($lastPage < $page){
            $page = 1;
        }

        return $query->paginate($perPage, $page);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '1');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', '1');
    }

}
