<?php namespace Acme\Settings\Models;

use Model;

/**
 * Model
 */
class Advantages extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\SimpleTree;
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    const SORT_ORDER = 'title';

    protected $jsonable = ['advantages'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'acme_settings_advantages';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
