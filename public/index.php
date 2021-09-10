<?php

use App\CacheKernel;
use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    $kernel = new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
    if ('prod' === $kernel->getEnvironment()) {
        $kernel = new CacheKernel($kernel);
    }
    return $kernel;
};
