<?php namespace Acme\Settings\Components;

use Acme\Settings\Models\Advantages;

class Advantage extends \Cms\Classes\ComponentBase
{
    public $advantages;

    public function componentDetails()
    {
        return [
            'name' => 'Преимущества',
            'description' => 'Отобразить преимущества на сайте'
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
      return Advantages::all()->lists('title', 'id');
    }

    function getAdvantageByID()
    {
      return Advantages::where( 'id', '=', $this->property('advantageName') )->first();
    }

    public function onRun()
    {
      $this->advantages =  $this->getAdvantageByID();
    }
}