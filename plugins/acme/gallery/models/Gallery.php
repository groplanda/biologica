<?php namespace Acme\gallery\Models;

use Model;

/**
 * Model
 */
class Gallery extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\SimpleTree;
    
    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;
    
    const SORT_ORDER = 'title';


    /**
     * @var string The database table used by the model.
     */
    public $table = 'acme_gallery_gallery';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'gallery'   => 'required',
        'gallery.*' => 'image|max:1000|dimensions:min_width=100,min_height=100'
    ];
    public $attachMany = [
        'gallery' => ['System\Models\File', 'delete' => true ]
    ];

    public function afterDelete() {
        foreach ($this->gallery as $image) {
            $image->delete();
        }
    }
}