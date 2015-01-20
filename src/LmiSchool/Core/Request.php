<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Core;

use Aura\Router\Route;

/**
 * Class Request
 *
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class Request
{
    /**
     * @var array
     */
    private $parameterBag = array();

    /**
     * @var null|string
     */
    private $controllerName;

    /**
     * @var null|string
     */
    private $actionName;

    /**
     * @param array $query
     * @param array $data
     * @param Route $route
     */
    public function __construct(array $query, array $data, Route $route = null)
    {
        $this->controllerName = $route->values['controller']
            ? $route->params['controller']
            : $route->values['controller'];
        $this->actionName = $route->values['action']
            ? $route->params['action']
            : $route->values['action'];
        $params = $route->params;
        if ($params) {
            unset($params['controller']);
            unset($params['action']);
        }
        $this->parameterBag = array_merge($query, $data, $params);
    }

    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        if (array_key_exists($key, $this->parameterBag)) {
            $default = $this->parameterBag[$key];
        }

        return $default;
    }

    /**
     * @return mixed
     */
    public function getActionName()
    {
        return $this->actionName;
    }

    /**
     * @return mixed
     */
    public function getControllerName()
    {
        return $this->controllerName;
    }

    public function getMethod()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
    }

    public function isPost()
    {
        return $this->getMethod() == 'POST';
    }
}
