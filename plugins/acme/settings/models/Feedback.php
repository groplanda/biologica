<?php namespace Acme\Settings\Models;

use Model;

/**
 * Model
 */
class Feedback extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\SimpleTree;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    const SORT_ORDER = 'name';

    /**
     * @var string The database table used by the model.
     */
    public $table = 'acme_settings_feedback';

    public $attachOne = [
        'avatar' => ['System\Models\File', 'delete' => true]
    ];

    /**
     * @var array Validation rules
     */
    public $rules = [
        'avatar' => 'image|max:512|dimensions:min_width=100,min_height=100'
    ];

    public function afterDelete()
    {
        $this->avatar->delete();
    }
}
