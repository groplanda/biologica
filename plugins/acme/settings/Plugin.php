<?php namespace Acme\Settings;

use System\Classes\PluginBase;

class Plugin extends PluginBase
{
    public function registerComponents()
    {
        return [
            'Acme\Settings\Components\Services' => 'services',
            'Acme\Settings\Components\Contents' => 'contents',
            'Acme\Settings\Components\Advantage' => 'advantage',
            'Acme\Settings\Components\feedbackForm' => 'feedbackform',
            'Acme\Settings\Components\feedbackList' => 'feedbacklist',
            'Acme\Settings\Components\Learning' => 'learning',
        ];
    }

    public function registerSettings()
    {

    }

}
