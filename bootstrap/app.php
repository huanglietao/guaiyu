<?php

require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv\Dotenv(dirname(__DIR__)))->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    //
}

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withFacades();

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

if (env('APP_ENV') != 'production' || env('APP_ENV') == 'local') {
    $app->register(MichaelB\LumenMake\LumenMakeServiceProvider::class);
    $app->register(\Thedevsaddam\LumenRouteList\LumenRouteListServiceProvider::class);
}

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

// $app->middleware([
//     App\Http\Middleware\ExampleMiddleware::class
// ]);

$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
    'checkSign' => App\Http\Middleware\CheckSign::class,
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/

$app->register(App\Providers\AppServiceProvider::class);
$app->register(App\Providers\AuthServiceProvider::class);
// $app->register(App\Providers\EventServiceProvider::class);
$app->register(App\Providers\ModelProvider::class);

// 新增Passport的注册
$app->register(Laravel\Passport\PassportServiceProvider::class);
$app->register(Dusterio\LumenPassport\PassportServiceProvider::class);

/***** 自定义服务 ******/
$app->register(App\Providers\LogProvider::class);
//$app->register(App\Providers\ApiRequestServiceProvider::class);
/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/
//自动加载config目录的配置
foreach (\Symfony\Component\Finder\Finder::create()->files()->name('*.php')->in($app->basePath('config')) as $file) {
    $filename = $file->getFileName();
    $place = strpos($filename, '.php');
    if ($place > 0) {
        $filename = mb_substr($filename, 0, $place);
        $app->configure($filename);
    }
}

$app->router->group([
    'namespace' => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});

$app->router->group(['namespace' => 'App\Http\Controllers\Api\V1', 'prefix' => 'api'], function ($router) {
    require __DIR__ . '/../routes/api.php';
});

//后台api
$app->router->group(['namespace' => 'App\Http\Controllers\Admin', 'prefix' => 'admin'], function ($router) {
   require __DIR__ . '/../routes/admin.php';
});

return $app;
