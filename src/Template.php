<?php

namespace SuperV\Modules\Webdev;

use Illuminate\Contracts\View\Factory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Foundation\Application;

class Template
{
    /**
     * The view factory.
     *
     * @var Factory
     */
    protected $view;

    /**
     * The file system.
     *
     * @var Filesystem
     */
    protected $files;

    /**
     * The application instance.
     *
     * @var Application
     */
    protected $application;

    /**
     * Create a new Template instance.
     *
     * @param Factory     $view
     * @param Filesystem  $files
     * @param Application $application
     */
    public function __construct(Factory $view, Filesystem $files)
    {
        $this->view = $view;
        $this->files = $files;
    }

    /**
     * Render a string template.
     *
     * @param             $template
     * @param  array      $payload
     * @return string
     * @throws \Exception
     */
    public function render($template, array $payload = [])
    {
        $view = 'support/parsed/'.md5($template);
        $path = storage_path($view);

        if (! $this->files->isDirectory($directory = dirname($path))) {
            $this->files->makeDirectory($directory, 0777, true);
        }

        if (! $this->files->exists($path.'.twig')) {
            $this->files->put($path.'.twig', $template);
        }

        $this->view->addNamespace('storage', storage_path());

        return $this->view->make('storage::'.$view, $payload);
    }
}
