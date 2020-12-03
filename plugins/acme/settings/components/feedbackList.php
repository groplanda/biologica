<?php namespace Acme\Settings\Components;

use Acme\Settings\Models\Feedback;
use System\Models\File;

class feedbackList extends \Cms\Classes\ComponentBase
{
    public $feedbacks;

    public function componentDetails()
    {
        return [
            'name' => 'Список отзывов',
            'description' => 'Отобразить отзывы'
        ];
    }

    public function defineProperties()
    {
        return [
            'maxFeeds' => [
                'title'             => 'Кол-во отзывов',
                'default'           => 0,
                'type'              => 'string',
                'validationPattern' => '^[0-9]+$',
                'validationMessage' => 'Значение может быть только числом'
            ],
            'feedType' => [
                'title'             => 'Внешний вид',
                'type'              => 'dropdown',
                'default'           => 'list',
                'placeholder'       => 'Выберите тип',
                'options'           => ['list' => 'Список', 'grid' => 'Колонки']

            ],
            'sortOrder' => [
              'title'             => 'Сортировка',
              'type'              => 'dropdown',
              'default'           => 'desc',
              'placeholder'       => 'Выберите тип',
              'options'           => ['desc' => 'Вначале новые', 'asc' => 'Вначале старые']
            ]
        ];
    }

    protected function getFeedbacks()
    {
      $prop = $this->property('maxFeeds');
      $sort = $this->property('sortOrder');

      $query = Feedback::where('status', '=', 1)->orderBy('id', $sort)->get();

      if($prop != 0) {

        $query = Feedback::where('status', '=', 1)->orderBy('id', $sort)->take($prop)->get();

      }

      return $query;

    }

    public function onRun()
    {
        $this->feedbacks = $this->getFeedbacks();
    }

    public function onRender()
    {
        $view = $this->property('feedType');
        if($view != 'list') {
            return $this->renderPartial('@_grid.htm');
        }
    }
}