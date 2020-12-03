<?php namespace Acme\Shop\Components;

use Acme\Shop\Models\Product;

class Featured extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
        return [
            'name' => 'Список популярных товаров',
            'description' => 'Показать популярные товары'
        ];
    }
    public function defineProperties()
    {
        return [
            'featuredTitle' => [
                'title'             => 'Заголовок',
                'description'       => 'Заголовок блока',
                'default'           => 'Популярные товары',
                'type'              => 'string',
            ]
        ];
    }
    

    function prepareVars()
    {

        $this->page['featuredTitle'] = $this->property('featuredTitle');
        $this->page['featured'] = Product::active()->featured()->get();

    }

    public function onRun()
    { 
        $this->prepareVars();
    }

}