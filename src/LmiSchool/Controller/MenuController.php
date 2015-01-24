<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Controller;

use LmiSchool\Model\Exception\ModelException;
use LmiSchool\Model\Menu;

/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class MenuController extends AbstractController
{
    public function editAction()
    {
        $this->checkCredentials();
        $error = null;

        $id = $this->request->get('id');
        $menuItem = Menu::findOneBy(['id' => $id]);

        if (!$menuItem) {
            $this->redirectTo('error.not_found');
        }

        if ($this->request->isPost()) {
            $this->fillPageFromRequest($menuItem);

            try {
                $menuItem->save();
                $this->redirectTo('admin.menu.list');
            } catch (ModelException $e) {
                $error = $e->getMessage();
            }
        }

        $this->render('Menu/edit.html.twig', ['item' => $menuItem, 'error' => $error]);
    }

    public function addAction()
    {
        $this->checkCredentials();
        $error = null;

        $menuItem = new Menu();
        if ($this->request->isPost()) {
            $this->fillPageFromRequest($menuItem);
            try {
                $menuItem->save();
                $this->redirectTo('admin.menu.list');
            } catch (ModelException $e) {
                $error = $e->getMessage();
                print $error; die;
            }
        }

        $this->render('Menu/add.html.twig', ['item' => $menuItem, 'error' => $error]);
    }

    public function listAction()
    {
        $this->checkCredentials();

        $menu = [];
        foreach (Menu::findBy([], ['parent_id' => 'DESC', 'position' => 'ASC']) as $menuItem) {
            if ($menuItem->getParentId()) {
                $menu['children'][$menuItem->getParentId()][] = $menuItem;
            } else {
                $menu['parents'][$menuItem->getId()] = $menuItem;
            }
        }

        $this->render('Menu/list.html.twig', [
            'menu' => $menu
        ]);
    }

    /**
     * @param Menu $menuItem
     */
    private function fillPageFromRequest(Menu $menuItem)
    {
        $menuItem->setParentId($this->request->get('parent_id'))
            ->setPosition($this->request->get('position'))
            ->setTitle($this->request->get('title'))
            ->setRouteName($this->request->get('route_name'))
            ->setRouteOptions(json_decode($this->request->get('route_options'), true));
    }
}
