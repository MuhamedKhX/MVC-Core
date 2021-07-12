<?php


namespace muhamex\phpmvc;


class Controller
{
    public static array $middlewares = [];
    public static string $action = '';

    public function render($view, $params = [])
    {
        Application::$app->router->renderView($view, $params);
    }

    public function registerMiddleware(\BaseMiddleware $middleware)
    {
        self::$middlewares[] = $middleware;
    }
}