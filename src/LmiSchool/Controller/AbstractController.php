<?php

namespace LmiSchool\Controller;

use Aura\Auth\Auth;
use Aura\Router\Exception\RouteNotFound;
use Aura\Router\Router;
use LmiSchool\Core\Authentication\AuthService;
use LmiSchool\Core\Request;
use LmiSchool\Model\Menu;
use Twig_Environment;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
abstract class AbstractController
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Auth|null
     */
    protected $authData;

    /**
     * @var Twig_Environment
     */
    private $twig;

    /**
     * @param Request $request
     * @param Router $router
     * @param Twig_Environment $twig
     */
    public function __construct(Request $request, Router $router, Twig_Environment $twig)
    {
        $this->request = $request;
        $this->router = $router;
        $this->twig = $twig;
        $this->authData = AuthService::getInstance()->resume();
    }

    /**
     * @param string $routeName
     * @param array $options
     * @return string
     */
    protected function generateUrl($routeName, array $options = [])
    {
        try {
            if (array_key_exists('options', $options) && is_array($options['options'])) {
                $options['options'] = http_build_query($options['options']);

                return $this->router->generateRaw($routeName, $options);
            }
            return $this->router->generate($routeName, $options);
        } catch (RouteNotFound $e) {
            return $this->router->generate('error.not_found');
        }
    }

    /**
     * @param string $routeName
     * @param array $options
     */
    protected function redirectTo($routeName, array $options = [])
    {
        $url = $this->generateUrl($routeName, $options);

        header(sprintf('Location: %s', $url));
        exit;
    }

    /**
     * @param string $viewName
     * @param array $options
     */
    protected function render($viewName, array $options = [])
    {
        $menu = [];
        foreach (Menu::findBy([], ['parent_id' => 'DESC', 'position' => 'ASC']) as $menuItem) {
            if ($menuItem->getParentId()) {
                $menu['children'][$menuItem->getParentId()][] = $menuItem;
            } else {
                $menu['parents'][$menuItem->getId()] = $menuItem;
            }
        }

        $options = array_merge(array(
            'isAdmin' => ($this->authData && $this->authData->isValid()),
            'user' => $this->authData->getUserData(),
            'menu' => $menu
        ), $options);
        $template = $this->twig->loadTemplate($viewName);
        echo $template->render($options);
        exit;
    }

    /**
     * @return integer
     */
    protected function getPage()
    {
        return $this->request->get('page', 1);
    }

    protected function checkCredentials()
    {
        if (!$this->authData || !$this->authData->isValid()) {
            $this->renderNotAuthorized();
        }
    }

    protected function renderNotFound()
    {
        $this->render('Error/404.html.twig');
    }

    protected function renderNotAuthorized()
    {
        $this->render('Error/403.html.twig');
    }
}
