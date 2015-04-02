<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Model;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
class Menu extends BaseModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $parentId;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $routeName;

    /**
     * @var array|null
     */
    private $routeOptions = array();

    /**
     * @var integer
     */
    private $position;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return integer
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * @param integer $parentId
     * @return Menu
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * @param string $routeName
     * @return Menu
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRouteOptions()
    {
        return $this->routeOptions;
    }

    /**
     * @param array|null $routeOptions
     * @return Menu
     */
    public function setRouteOptions($routeOptions)
    {
        $this->routeOptions = $routeOptions;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Menu
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * @param integer $position
     * @return Menu
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdentifierName()
    {
        return 'id';
    }

    /**
     * @return array
     */
    protected function dump()
    {
        return array(
            'id' => $this->id,
            'parent_id' => $this->parentId,
            'title' => $this->title,
            'route_name' => $this->routeName,
            'position' => $this->position,
            'route_options' => serialize($this->routeOptions)
        );
    }

    /**
     * @param array|null $data
     * @return Menu
     */
    protected function init($data)
    {
        $this->id = $data['id'];
        $this->parentId = $data['parent_id'];
        $this->title = $data['title'];
        $this->routeName = $data['route_name'];
        $this->position = $data['position'];
        $this->routeOptions = unserialize($data['route_options']);

        return $this;
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'menu_items';
    }
}
