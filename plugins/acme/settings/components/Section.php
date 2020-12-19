<?php namespace Acme\Settings\Components;

use Acme\Settings\Models\Taxonomy;

class Section extends \Cms\Classes\ComponentBase
{
    public $taxonomy;

    public function componentDetails()
    {
        return [
            'name' => 'Рубрика',
            'description' => 'Отобразить рубрику'
        ];
    }

    public function defineProperties()
    {
        return [
            'advantageName' => [
                'title'             => 'Выбор блока',
                'default'           => 1,
                'type'              => 'dropdown',
                'placeholder'       => 'Выберите',
            ]
        ];
    }

    public function getAdvantageNameOptions()
    {
      return Taxonomy::all()->lists('title', 'id');
    }

    function getAdvantageByID()
    {
      return Taxonomy::where( 'id', '=', $this->property('advantageName') )->first();
    }

    public function onRun()
    {
      $this->taxonomy =  $this->getAdvantageByID();
    }
}