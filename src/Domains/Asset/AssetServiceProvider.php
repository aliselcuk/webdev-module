<?php

namespace SuperV\Modules\Webdev\Domains\Asset;

use SuperV\Modules\Webdev\Events\ThemeActivatedEvent;
use SuperV\Platform\Providers\BaseServiceProvider;

class AssetServiceProvider extends BaseServiceProvider
{
    protected $_singletons = [
        Asset::class => Asset::class,
    ];

    public function register()
    {
        $this->registerSingletons($this->_singletons);

        $this->registerListeners([
            ThemeActivatedEvent::class => function (ThemeActivatedEvent $event) {
                app(Asset::class)->addPath('theme', $event->theme->path.'/public');
            },
        ]);
    }
}