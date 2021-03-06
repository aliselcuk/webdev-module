<?php namespace SuperV\Modules\Webdev;

use SuperV\Platform\Domains\Addon\AddonServiceProvider;

class WebdevModuleServiceProvider extends AddonServiceProvider
{
    protected $providers = [
        ThemeServiceProvider::class
    ];
    public function register()
    {
        parent::register();

        $this->enableTwig();
    }

    protected function enableTwig(): void
    {
        if (sv_config('twig.enabled')) {
           $this->registerProviders([TwigServiceProvider::class]);
        }
    }
}