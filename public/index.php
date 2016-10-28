<?php
/**
 * Zend Expressive Doctrine API (http://framework.zend.com/)
 *
 * @see       https://github.com/jguittard/zend-expressive-doctrine-api for the canonical source repository
 * @copyright Copyright (c) 2015-2016 Julien Guittard. (https://julienguittard.com)
 * @license   https://github.com/jguittard/zend-expressive-doctrine-api/blob/master/LICENSE.md New BSD License
 */

error_reporting(E_ALL);
ini_set('display_errors', 1);

use Zend\Expressive\Application;
use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zend\Expressive\Helper\UrlHelperMiddleware;
use App\Middleware;

// Delegate static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server'
    && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))
) {
    return false;
}

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

/** @var \Interop\Container\ContainerInterface $container */
$container = require 'config/container.php';

/** @var \Zend\Expressive\Application $app */
$app = $container->get(Application::class);

$app->pipe(BodyParamsMiddleware::class);
$app->pipeRoutingMiddleware();
$app->pipe(UrlHelperMiddleware::class);
$app->pipeDispatchMiddleware();

// Routes
$app->get('/api/posts[/{id:[A-Za-z0-9-]+}]', Middleware\Post::class, 'api.post.get');
$app->post('/api/posts', Middleware\Post::class, 'api.post.post');
$app->patch('/api/posts/{id:[A-Za-z0-9-]+}', Middleware\Post::class, 'api.post.patch');
$app->delete('/api/posts/{id:[A-Za-z0-9-]+}', Middleware\Post::class, 'api.post.delete');

$app->get('/api/authors[/{id:[A-Za-z0-9-]+}]', Middleware\Author::class, 'api.author.get');
$app->post('/api/authors', Middleware\Author::class, 'api.author.post');

$app->run();
