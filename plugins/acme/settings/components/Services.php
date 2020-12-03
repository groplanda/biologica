<?php namespace Acme\Settings\Components;

use Cms\Classes\ComponentBase;
use Acme\Settings\Models\Service;
use Response;

class Services extends ComponentBase
{
    public $service;

    public function componentDetails()
    {
        return [
            'name'          => 'Блок услуги',
            'description'   => 'Добавить блок с услугами'
        ];
    }

    public function defineProperties()
    {
        return [
            'serviceName' => [
                'title'             => 'Выберите раздел',
                'type'              => 'dropdown',
                'default'           => 'us'
            ],
        ];
    }

    public function getServiceNameOptions()
    {
        return Service::all()->lists('title', 'id');
    }

    public function onRun() 
    {
        $service = new Service;
        $this->service = $service -> where( 'id', '=', $this->property('serviceName') )->first();
    }

    
}