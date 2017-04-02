<?php

namespace Tests;

use Illuminate\Contracts\Console\Kernel;

trait CreatesApplication
{
    protected $app;
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $this->app = require __DIR__.'/../../../../bootstrap/app.php';

        $this->app->make(Kernel::class)->bootstrap();

        return $this->app;
    }
}
