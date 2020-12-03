<?php namespace Acme\Settings\Models;

use Model;

/**
 * Model
 */
class Learn extends Model
{
    use \October\Rain\Database\Traits\Validation;

    use \October\Rain\Database\Traits\SoftDelete;

    protected $dates = ['deleted_at'];


    /**
     * @var string The database table used by the model.
     */
    public $table = 'acme_settings_learning';

    /**
     * @var array Validation rules
     */
    public $rules = [
        'title' => 'required',
        'file' => 'max:4000',
    ];
    public $attachOne = [
        'file' => ['System\Models\File', 'delete' => true ]
    ];
}
