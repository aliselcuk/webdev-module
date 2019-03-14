<?php

namespace SuperV\Modules\Webdev;

use SuperV\Platform\Providers\BaseServiceProvider;
use TwigBridge\Facade\Twig;
use TwigBridge\ServiceProvider as TwigBridgeServiceProvider;

class TwigServiceProvider extends BaseServiceProvider
{
    protected $providers = [TwigBridgeServiceProvider::class];

    protected $aliases = ['Twig' => Twig::class];


}