<?php

class Routers
{
    private $routes = [];

    public function addRoute($method, $uriPattern, $handler)
    {
        $this->routes[] = [
            'method' => strtoupper($method),
            'uriPattern' => $uriPattern,
            'handler' => $handler,
        ];
    }

    public function handleRequest($method, $uri)
    {
        foreach ($this->routes as $route) {
            $pattern = $this->buildPattern($route['uriPattern']);
            if ($route['method'] == strtoupper($method) && preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Loại bỏ phần tử đầu tiên (toàn bộ dòng URL)
                if (isset($_GET['user'])) {
                    $matches['user'] = $_GET['user'];
                }
                 if (isset($_GET['token'])) {
                    $matches['token'] = $_GET['token'];
                }
                if (is_array($route['handler'])) {
                    list($className, $methodName) = $route['handler'];
                    $controller = new $className();
                    return call_user_func_array([$controller, $methodName], array_values($matches));
                } else {
                    return call_user_func_array($route['handler'], $matches);
                }
            }
        }

        // Handle 404 - Not Found
        return $this->handleNotFound();
    }

    private function buildPattern($uriPattern)
    {
        $pattern = str_replace('/', '\/', $uriPattern);
        $pattern = preg_replace('/\{(\w+)\}/', '(?<$1>[^\/]+)', $pattern);
        $pattern = '/^' . $pattern . '$/';
        return $pattern;
    }

    private function handleNotFound()
    {
        // Log lỗi 404
        error_log('Page not found: ' . $_SERVER['REQUEST_URI']);
        return view('page/404');
    }
}
