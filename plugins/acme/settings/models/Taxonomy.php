<?php namespace Acme\Settings\Models;

use Model;

/**
 * Model
 */
class Taxonomy extends Model
{
    use \October\Rain\Database\Traits\Validation;

    protected $jsonable = ['category'];
    /**
     * @var string The database table used by the model.
     */
    public $table = 'acme_settings_taxonomy';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required'
    ];
}
