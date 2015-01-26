<?php

namespace LmiSchool\Model;
/**
 *
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
class Document extends BaseModel
{
    const KPMO_TYPE = 1;
    const EDUCATION_TYPE = 2;
    const OTHER_TYPE = 0;

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
     * @var boolean
     */
    private $isKPMO;

    /**
     * @var string
     */
    private $type;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Document
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return array
     */
    protected function dump()
    {
        return [
            'id' => $this->getId(),
            'doc_name' => $this->getName(),
            'doc_url' => $this->getUrlToDownload(),
            'doc_kpmo' => $this->isKPMO(),
            'doc_type' => $this->getType()
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
        $this->id = $data['id'];
        $this->setName($data['doc_name'])
            ->setUrlToDownload($data['doc_url'])
            ->setIsKPMO($data['doc_kpmo'])
            ->setType($data['doc_type']);

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
