<?php declare(strict_types=1);

namespace Core;

/**
 * Router
 */
class Router
{
    /**
     * Associative array of routes (routing table)
     * @var array
     */
    protected $routes = [];

    /**
     * Add a route to the routing table
     * 
     * @param string $route The route URL
     * @param array $params Parameters (controller, action, etc.)
     * 
     * @return void
     */
    public function add(string $route, array $params = []) : void
    {
        // Convert the route to a regular expression
        $route = preg_replace('/\//', '\\/', $route);

        // Convert variables e.g. {controller}
        $route = preg_replace('/\{([a-z]+)\}/', '(?P<\1>[a-z-]+)', $route);

        // Convert variables with custom regular expressions e.g. {id:\d+}
        $route = preg_replace('/\{([a-z]+):([^\}]+)\}/', '(?P<\1>\2)', $route);

        // Add start and end delimiters, and case insensitive flag
        $route = '/^' . $route . '$/i';

        $this->routes[$route] = $params;
    }

    /**
     * Get all routes from the routing table
     * 
     * @return array
     */
    public function getRoutes() : array
    {
        return $this->routes;
    }

    /**
     * Match the route to the ones in the routing table.
     * Sets the $params property if a route is found.
     * 
     * @param string $url The route URL
     * 
     * @return boolean true if a match was found, false otherwise
     */
    public function match(string $url) : bool
    {
        $output = false;

        $url = trim($url, '/');

        foreach ($this->routes as $route => $params) 
        {
            if (preg_match($route, $url, $matches))
            {
                foreach ($matches as $key => $match)
                {
                    if (is_string($key))
                    {
                        $params[$key] = $match;
                    }
                }

                $this->params = $params;
                $output = true;

                break;
            }
        }

        return $output;
    }

    /**
     * Get the currently matched parameters
     * 
     * @return array
     */
    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * Dispatch the route, creating the controller object and running the
     * action method
     *
     * @param string $url The route URL
     *
     * @return void
     */
    public function dispatch(string $url) : void
    {
        $url = $this->removeQueryStringVariables($url);
        if ($this->match($url)) 
        {
            $controller = $this->params['controller'];
            $controller = $this->convertToPascalCase($controller);
            $controller = $this->getNamespace() . $controller;

            if (class_exists($controller)) 
            {
                $controller_object = new $controller($this->params);

                $action = $this->params['action'];
                $action = $this->convertToCamelCase($action);

                if (preg_match('/action$/i', $action) == 0) 
                {
                    $controller_object->$action();
                } 
                else 
                {
                    throw new \Exception("Method '$action' in controller '$controller' cannot be called directly - remove the Action suffix to call this method");
                }
            } 
            else 
            {
                throw new \Exception("Controller class '$controller' not found");
            }
        } 
        else 
        {
            throw new \Exception('No route matched.', 404);
        }
    }

    /**
     * Convert a string with hyphens to PascalCase,
     * e.g. post-authors => PostAuthors
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToPascalCase($string)
    {
        return str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));
    }

    /**
     * Convert a string with hyphens to camelCase,
     * e.g. add-new => addNew
     *
     * @param string $string The string to convert
     *
     * @return string
     */
    protected function convertToCamelCase($string)
    {
        return lcfirst($this->convertToPascalCase($string));
    }

    /**
     * Remove any query string variables from the URL.
     *
     * @param string $url The full URL
     *
     * @return string The URL with the query string variables removed
     */
    protected function removeQueryStringVariables(string $url) : string
    {
        if ($url != '') 
        {
            $parts = explode('&', $url, 2);

            if (strpos($parts[0], '=') === false) 
            {
                $url = $parts[0];
            } else 
            {
                $url = '';
            }
        }

        return $url;
    }

    /**
     * Get the namespace for the controller class. The namespace defined in the
     * route parameters is added if present.
     *
     * @return string The request URL
     */
    protected function getNamespace() : string
    {
        $namespace = 'App\Controllers\\';

        if (array_key_exists('namespace', $this->params)) 
        {
            $namespace .= $this->params['namespace'] . '\\';
        }

        return $namespace;
    }
}