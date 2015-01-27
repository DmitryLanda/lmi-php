<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Model;
use DateTime;

/**
 * @author Dmitry Landa <dmitry.landa@yandex.ru>
 */
class Comment extends BaseModel
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $author;

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $message;

    /**
     * @var string
     */
    private $city;

    /**
     * @return integer
     */
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
            'author' => $this->getAuthor(),
            'date' => date('Y-m-d H:i:s'),
            'email' => $this->getEmail(),
            'city' => $this->getCity(),
            'message' => $this->getMessage()
        ];
    }

    /**
     * @param array|null $data
     * @return Comment
     */
    protected function init($data)
    {
        if (!$data) {
            return $this;
        }

        $this->id = $data['id'];
        $this->setAuthor($data['author'])
            ->setDate(DateTime::createFromFormat('Y-m-d H:i:s', $data['date']))
            ->setEmail($data['email'])
            ->setCity($data['city'])
            ->setMessage($data['message']);

        return $this;
    }

    /**
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param string $author
     * @return Comment
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return Comment
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return Comment
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Comment
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     * @return Comment
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'comments';
    }
}
