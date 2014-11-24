<?php

namespace LmiSchool\Model;
/**
 *
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class Document extends BaseModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $urlToDownload;

    /**
     * @var string
     */
    private $urlToView;

    /**
     * @var boolean
     */
    private $isKPMO;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return boolean
     */
    public function isKPMO()
    {
        return $this->isKPMO;
    }

    /**
     * @param boolean $isKPMO
     * @return Document
     */
    public function setIsKPMO($isKPMO)
    {
        $this->isKPMO = $isKPMO;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Document
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrlToDownload()
    {
        return $this->urlToDownload;
    }

    /**
     * @param string $urlToDownload
     * @return Document
     */
    public function setUrlToDownload($urlToDownload)
    {
        $this->urlToDownload = $urlToDownload;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrlToView()
    {
        return $this->urlToView;
    }

    /**
     * @param string $urlToView
     * @return Document
     */
    public function setUrlToView($urlToView)
    {
        $this->urlToView = $urlToView;

        return $this;
    }

    /**
     * @return array
     */
    protected function dump()
    {
        return [
            'doc_id' => $this->getId(),
            'doc_name' => $this->getName(),
            'doc_url' => $this->getUrlToDownload(),
            'doc_url_show' => $this->getUrlToView(),
            'doc_kpmo' => $this->isKPMO()
        ];
    }

    /**
     * @param array $data
     * @return Document
     */
    protected function init($data)
    {
        if (!$data) {
            return $this;
        }
        $this->id = $data['doc_id'];
        $this->setName($data['doc_name'])
            ->setUrlToDownload($data['doc_url'])
            ->setUrlToView($data['doc_url_show'])
            ->setIsKPMO($data['doc_kpmo']);

        return $this;
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'documents';
    }

}
