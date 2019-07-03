<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\AmqpHandler;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Channel\AMQPChannel;

class LogProvider extends ServiceProvider
{
    // 延迟加载
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('Logger', function ($app) {
            //延迟加载
            $logger = new Logger($app['request']->getHttpHost());

            $logger->pushProcessor(new \Monolog\Processor\WebProcessor);
            $logger->pushProcessor(new \Monolog\Processor\PsrLogMessageProcessor);

            $type = array_map('trim', explode(',', config('logs.type', 'file')));

            // 文件
            if (in_array('file', $type)) {
                $logger->pushHandler(new StreamHandler(storage_path('logs/logger.log'), Logger::DEBUG));
            }

            return $logger;
        });
    }
    
    /**
     * author hxc
     * @return array
     */
    public function provides()
    {
        return [
            'Logger'
        ];
    }
}
