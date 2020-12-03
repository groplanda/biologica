<?php namespace Acme\Settings\Components;

use Cms\Classes\ComponentBase;
use Acme\Settings\Models\Content;
use Response;

class Contents extends ComponentBase
{
    public $content;
    public $type;

    public function componentDetails()
    {
        return [
            'name'          => 'Блок о компании',
            'description'   => 'Добавить блок'
        ];
    }

    public function defineProperties()
    {
        return [
            'contentType' => [
                'title'             => 'С какой стороны изображение',
                'type'              => 'dropdown',
                'default'           => 'left',
                'placeholder'       => 'Выберите',
                'options'           => ['left'=>'Слева', 'right'=>'Справа', 'none'=>'Не показывать']
            ],
            'contentId' => [
                'title'             => 'Выберите блок',
                'type'              => 'dropdown',
                'default'           => '1',
                'placeholder'       => 'Выберите'
            ]
        ];
    }

    public function getContentIdOptions()
    {
        return Content::all()->lists('title', 'id');
    }

    public function onRun() 
    {
        $this->type = $this->property('contentType');
        $this->content = Content::where( 'id', '=', $this->property('contentId') )->first();
    }
    
}