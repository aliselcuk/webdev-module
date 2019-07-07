<?php

namespace Tests\Webdev\Providers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Webdev\TestCase;
use TwigBridge\ServiceProvider as TwigBridgeServiceProvider;

class TwigServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    function test__is_registered_if_enabled_by_config()
    {
        config()->set('superv.twig.enabled', true);

        $this->assertProviderRegistered(\SuperV\Modules\Webdev\TwigServiceProvider::class);
        $this->assertProviderRegistered(TwigBridgeServiceProvider::class);
    }
}