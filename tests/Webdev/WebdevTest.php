<?php

namespace Tests\Webdev;

class WebdevTest extends TestCase
{
    /** @test */
    function module_is_installed()
    {
        $this->assertNotNull(superv('addons')->get('superv.modules.webdev'));
    }
}