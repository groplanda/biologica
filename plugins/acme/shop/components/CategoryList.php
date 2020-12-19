<?php namespace Acme\Shop\Components;

use Acme\Shop\Models\Category;

class CategoryList extends \Cms\Classes\ComponentBase
{
    public function componentDetails()
    {
      return [
          'name' => 'Список категорий',
          'description' => 'Показать категории'
      ];
    }

    public function defineProperties()
    {
        return [
            'onlySpecial' => [
              'title'       => 'Выбор',
              'type'        => 'dropdown',
              'default'     => 'cub',
              'placeholder' => 'Выберите...',
              'options'     => ['cub'=>'Только куб', 'standart'=>'Все остальные']
            ]
        ];
    }

    public function onRun()
    {
      if($this->property('onlySpecial') === 'cub') {
        $this->page['categories'] = Category::special()->orderBy('sort_order', 'asc')->where('parent_id', '=', NULL)->get();
      } else {
        $this->page['categories'] = Category::orderBy('sort_order', 'asc')->where('is_cub', '0')->where('parent_id', '=', NULL)->get();
      }
    }
}
