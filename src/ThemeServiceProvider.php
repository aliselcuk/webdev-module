<?php

namespace SuperV\Modules\Webdev;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\ServiceProvider;
use SuperV\Platform\Domains\Port\PortDetectedEvent;

class ThemeServiceProvider extends ServiceProvider
{
    use DispatchesJobs;

    public function register()
    {
        $this->app['events']->listen(PortDetectedEvent::class,
            function (PortDetectedEvent $event) {
//                $config = Platform::config('ports.'.$event->port);

                if (! $themeSlug = $event->port->theme()) {
                    return;
                }

                $this->dispatch(new ActivateThemeJob($themeSlug));
            }
        );
    }
}