<?php namespace Acme\Contactform;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Acme\ContactForm\Components\FormWidget' => 'formwidget',
            'Acme\ContactForm\Components\SubscribeForm' => 'subscribeform'
        ];
    }

    public function registerSettings()
    {
        
    }
}
