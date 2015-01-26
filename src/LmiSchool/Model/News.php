<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Model;

use DateTime;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
class News extends BaseModel
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
    private $content;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var integer
     */
    private $dateShowAfter;

    /**
     * @var integer
     */
    private $views;

    /**
     * @return int
     */
    public function getViews()
    {
        return $this->views;
    }

    /**
     * @param int $views
     * @return News
     */
    public function setViews($views)
    {
        $this->views = $views;

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
     * @return News
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     * @return News
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getDateShowAfter()
    {
        if ($this->dateShowAfter) {
            return DateTime::createFromFormat('Ymd', $this->dateShowAfter);
        }

        return null;
    }

    /**
     * @param DateTime $dateShowAfter
     * @return News
     */
    public function setDateShowAfter(DateTime $dateShowAfter = null)
    {
        if (!$dateShowAfter) {
            $dateShowAfter = new DateTime();
        }

        $this->dateShowAfter = $dateShowAfter->format('Ymd');

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return News
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    protected function dump()
    {
        return array(
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'news' => $this->getContent(),
            'img_url' => $this->getImageUrl(),
            'date_up' => $this->getDateShowAfter(),
            'views' => $this->getViews()
        );
    }

    protected function init($data)
    {
        if (!$data) {
            return $this;
        }
        $this->id = $data['id'];
        $this->setTitle($data['title'])
            ->setContent($data['news'])
            ->setImageUrl($data['img_url'])
            ->setDateShowAfter(DateTime::createFromFormat('Ymd', $data['date_up']))
            ->setViews($data['views']);

        return $this;
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'tnews';
    }
}
