<?php

namespace Tests\Webdev;

class WebdevTest extends TestCase
{
    function test__module_is_installed()
    {
        $this->assertNotNull(superv('addons')->get('superv.modules.webdev'));
    }
}