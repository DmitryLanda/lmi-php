<?php

namespace LmiSchool\Core;

use Aura\Router\RouteCollection;
use Aura\Router\Router;
use Aura\Router\RouterFactory;
use Doctrine\DBAL\Connection;
use LmiSchool\Core\Authentication\AuthService;
use Twig_Environment;
use Twig_Extensions_Extension_Text;
use Twig_Loader_Filesystem;

/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class Application
{
    public static function run()
    {
        $app = new self();

        $app->initAuthorization();
        $app->initConfig();
        $app->initLocale();
        $app->initDatabaseConnection();
        $router = $app->initRouter();
        $twig = $app->initTemplateEngine();
        $app->handleRequest($router, $twig);
    }

    /**
     * @return Config
     */
    private function initConfig()
    {
        return Config::getInstance();
    }

    private function initLocale()
    {
        setlocale(LC_ALL, Config::getInstance()->get('locale'));
    }

    /**
     * @return Connection
     */
    private function initDatabaseConnection()
    {
        return DatabaseConnection::getConnection();
    }

    /**
     * @return Twig_Environment
     */
    private function initTemplateEngine()
    {
        $config = Config::getInstance();
        $loader = new Twig_Loader_Filesystem(
            $config->get('app_path') . DIRECTORY_SEPARATOR . $config->get('template.base')
        );
        $twig = new Twig_Environment($loader, array(
//            'cache' => $config->get('app_path') . DIRECTORY_SEPARATOR .$config->get('template.cache'),
        ));

        $twig->addExtension(new Twig_Extensions_Extension_Text());

        return $twig;
    }

    /**
     * @return Router
     */
    private function initRouter()
    {
        $routerFactory = new RouterFactory;
        /** @var Router|RouteCollection $router */
        $router = $routerFactory->newInstance();
        $config = Config::getInstance();
        include $config->get('app_path') . DIRECTORY_SEPARATOR . $config->get('routes');

        return $router;
    }

    /**
     * @param Router $router
     * @param Twig_Environment $twig
     * @return mixed
     */
    private function handleRequest(Router $router, Twig_Environment $twig)
    {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $route = $router->match($path, $_SERVER);
        if (!$route) {
            header('Location: ' . $router->generate('error.not_found'));
            exit;
        }


        $request = new Request($_GET, $_POST, $route);
        $controller = 'LmiSchool\\Controller\\' . $request->getControllerName();
        $controller = new $controller($request, $router, $twig);
        $action = $request->getActionName();

        return $controller->$action();
    }

    private function initAuthorization()
    {
        AuthService::getInstance();
    }
}
