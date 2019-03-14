<?php

namespace SuperV\Modules\Webdev;

use Illuminate\View\Factory;
use SuperV\Modules\Webdev\Events\ThemeActivatedEvent;
use SuperV\Platform\Domains\Addon\AddonModel;
use SuperV\Platform\Exceptions\AddonNotFoundException;

class ActivateThemeJob
{
    protected $themeSlug;

    public function __construct($themeSlug)
    {
        $this->themeSlug = $themeSlug;
    }

    public function handle(Factory $view)
    {
        if (! $theme = AddonModel::bySlug($this->themeSlug)) {
            throw new AddonNotFoundException($this->themeSlug);
        }

        $view->addNamespace('theme', base_path($theme->path.'/resources/views'));

        ThemeActivatedEvent::dispatch($theme);
    }
}