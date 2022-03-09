<?php

namespace Xthk\Logger;

use Illuminate\Support\ServiceProvider;

class LogServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->registerMiddleware(LogMiddleware::class);
        $this->registerMiddleware(RequestHandledListener::class);
    }

    public function register()
    {
        if ($this->isLumen() && is_null(config('logging'))) {
            $this->app->configure('logging');
        }
        $configPath = __DIR__ . '/../config/logging.php';
        $this->mergeConfigFrom($configPath, 'logging.channels');
    }

    private function isLumen(): bool
    {
        $class = '\\Laravel\\Lumen\\Application';
        return class_exists($class) && $this->app instanceof $class;
    }

    /**
     * 注册中间件
     *
     * @param string $middleware
     */
    private function registerMiddleware($middleware)
    {
        if ($this->isLumen()) {
            $this->app->middleware([$middleware]);
        } else {
            $kernel = $this->app[\Illuminate\Contracts\Http\Kernel::class];
            $kernel->pushMiddleware($middleware);
        }
    }
}
