<?php namespace Acme\Settings\Components;

use Cms\Classes\ComponentBase;
use Acme\Settings\Models\Learn;

class Learning extends ComponentBase
{
    public $programs;

    public function componentDetails()
    {
        return [
            'name'          => 'Блок обучения',
            'description'   => 'Выбрать тип'
        ];
    }

    public function defineProperties()
    {
        return [
            'learnType' => [
                'title'             => 'Выберите тип',
                'type'              => 'dropdown',
                'default'           => 'online'
            ],
        ];
    }

    public function onRender()
    {
        $view = $this->property('learnType');
        if($view == 'offline') {
            return $this->renderPartial('@_offline.htm');
        }
    }

    public function getLearnTypeOptions()
    {
      return Learn::orderBy('type', 'asc')->lists('type', 'type');
    }

    public function onRun()
    {
        $query = new Learn;
        $this->programs = $query->where( 'type', '=', $this->property('learnType'))->orderBy('created_at', 'asc')->get();
    }

    public function onLoadIframe() {

      $learn_id = post('id');
      $this->page['result'] = Learn::find($learn_id)->iframe;
    }
}