<?php

namespace LmiSchool\Model;
/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class Page extends BaseModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $content;

    /**
     * @var array
     */
    private $tags = array();

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Page
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Page
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * @param array $tags
     * @return Page
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

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
     * @return Page
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    protected function dump()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'slug' => $this->getSlug(),
            'content' => $this->getContent(),
            'tags' => implode(',', $this->getTags())
        ];
    }

    /**
     * @param array $data
     * @return Page
     */
    protected function init($data)
    {
        if (!$data) {
            return $this;
        }
        $this->id = $data['id'];
        $this->setSlug($data['slug'])
            ->setTitle($data['title'])
            ->setContent($data['content'])
            ->setTags(explode(',', $data['tags']));

        return $this;
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'pages';
    }
}
