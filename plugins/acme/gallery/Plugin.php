<?php namespace Acme\gallery;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Acme\Gallery\Components\Galleries' => 'galleries'
        ];
    }

    public function registerSettings()
    {
    }
}
