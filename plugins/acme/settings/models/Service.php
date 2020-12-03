<?php namespace Acme\Settings\Models;

use Model;

/**
 * Model
 */
class Service extends Model
{
    use \October\Rain\Database\Traits\Validation;
    use \October\Rain\Database\Traits\Sortable;
    use \October\Rain\Database\Traits\SimpleTree;
    
    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];

    const SORT_ORDER = 'title';

    /*
     * Disable timestamps by default.
     * Remove this line if timestamps are defined in the database table.
     */
    public $timestamps = false;

    protected $jsonable = ['services'];

    /**
     * @var string The database table used by the model.
     */
    public $table = 'acme_settings_service';

    /**
     * @var array Validation rules
     */
    public $rules = [
    ];
}
