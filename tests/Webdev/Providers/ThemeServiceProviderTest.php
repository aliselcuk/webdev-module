<?php

namespace Tests\Webdev\Providers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use SuperV\Modules\Webdev\Events\ThemeActivatedEvent;
use SuperV\Platform\Domains\Addon\Installer;
use SuperV\Platform\Domains\Port\PortDetectedEvent;
use SuperV\Platform\Exceptions\AddonNotFoundException;
use Tests\Platform\ComposerLoader;
use Tests\Webdev\TestCase;

class ThemeServiceProviderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function get_registered_with_platform()
    {
        $this->assertProviderRegistered(\SuperV\Modules\Webdev\ThemeServiceProvider::class);
    }

    /** @test */
    function adds_theme_view_hint_for_the_active_theme_when_port_is_detected()
    {
        ComposerLoader::load(base_path('tests/Platform/__fixtures__/starter-theme'));
        app(Installer::class)
            ->setPath('tests/Platform/__fixtures__/starter-theme')
            ->setSlug('superv.themes.starter')
            ->install();

        $this->setUpPort('web', 'superv.io', 'superv.themes.starter');

        PortDetectedEvent::dispatch(\Hub::get('web'));

        $hints = $this->app['view']->getFinder()->getHints();
        $this->assertContains(base_path('tests/Platform/__fixtures__/starter-theme/resources/views'), $hints['theme']);
        $this->assertDirectoryExists(reset($hints['theme']));
    }

    /** @test */
    function does_not_add_any_hint_if_port_has_no_theme()
    {
        $this->setUpPort('web', 'superv.io', $theme = null);

        PortDetectedEvent::dispatch(\Hub::get('web'));

        $hints = $this->app['view']->getFinder()->getHints();
        $this->assertFalse(array_key_exists('theme', $hints));
    }

    /** @test */
    function dispatches_event_when_a_theme_is_activated()
    {
        ComposerLoader::load(base_path('tests/Platform/__fixtures__/starter-theme'));
        app(Installer::class)
            ->setPath('tests/Platform/__fixtures__/starter-theme')
            ->setSlug('superv.themes.starter')
            ->install();

        $this->setUpPort('web', 'superv.io', 'superv.themes.starter');

        Event::fake([ThemeActivatedEvent::class]);
        PortDetectedEvent::dispatch(\Hub::get('web'));

        Event::assertDispatched(ThemeActivatedEvent::class, function ($event) {
            return $event->theme->slug === 'superv.themes.starter';
        });
    }

    /** @test */
    function throws_exception_if_ports_theme_is_not_found()
    {
        $this->expectException(AddonNotFoundException::class);

        $this->setUpPort('web', 'superv.io', $theme = 'non.existant.theme');

        PortDetectedEvent::dispatch(\Hub::get('web'));
    }
}