<?php

namespace app\core;



use app\controllers\SiteController;

class Router
{
    protected array $routes = [];
    public Request $request;
    public Response $response;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callBack)
    {
        $this->routes['get'][$path] = [$callBack];
    }

    public function post($path, $callBack)
    {
        $this->routes['post'][$path] = [$callBack];
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->method();
        $callback = $this->routes[$method][$path] ?? false;

        if($callback === false)
        {
            $this->response->changeStatusCode(404);
            echo 'CallBack not found';
            exit;
        }

        $shit_array_from_callback = array_shift($callback);

        if(is_string($shit_array_from_callback))
        {
           $this->renderView($shit_array_from_callback);
        }

        if(is_array($shit_array_from_callback))
        {
            $shit_array_from_callback[0] = new $shit_array_from_callback[0];
            Controller::$action = $shit_array_from_callback[1];

            foreach (Controller::$middlewares as $middleware) {
                $middleware->execute();
            }
        }

        call_user_func($shit_array_from_callback, $this->request, $this->response);

    }

    public function renderView($view, $params)
    {
        $layout = $this->renderLayout();
        $view = $this->renderOnlyView($view, $params);
        echo str_replace("{{content}}", $view, $layout);
    }

    protected function renderLayout()
    {
        ob_start();
        include_once "../views/layout/main.php";
        return ob_get_clean();
    }

    protected function renderOnlyView($view , $params)
    {
        extract($params);

        ob_start();
        include_once "../views/$view.php";
        return ob_get_clean();
    }
}