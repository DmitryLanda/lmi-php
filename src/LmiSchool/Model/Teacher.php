<?php
/*
* For a full copyright notice, see the COPYRIGHT file.
*/

namespace LmiSchool\Model;

/**
 * @author Dmitry Landa <dmitry.landa@opensoftdev.ru>
 */
class Teacher extends BaseModel
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
    private $imageUrl;

    /**
     * @var string
     */
    private $subjectName;

    /**
     * @var string
     */
    private $subjectAbbreviation;

    /**
     * @var string
     */
    private $birthDate;

    /**
     * @var string
     */
    private $education;

    /**
     * @var string
     */
    private $category;

    /**
     * @var integer
     */
    private $experience;

    /**
     * @var string
     */
    private $projects;

    /**
     * @var string
     */
    private $rewards;

    /**
     * @var string
     */
    private $contact;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $forumLink;

    /**
     * @var string
     */
    private $about;

    /**
     * @return string
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }

    /**
     * @param string $birthDate
     * @return Teacher
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return Teacher
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param string $contact
     * @return Teacher
     */
    public function setContact($contact)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return string
     */
    public function getEducation()
    {
        return $this->education;
    }

    /**
     * @param string $eduacation
     * @return Teacher
     */
    public function setEducation($eduacation)
    {
        $this->education = $eduacation;

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
     * @return Teacher
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @param int $expirience
     * @return Teacher
     */
    public function setExperience($expirience)
    {
        $this->experience = $expirience;

        return $this;
    }

    /**
     * @return string
     */
    public function getForumLink()
    {
        return $this->forumLink;
    }

    /**
     * @param string $forumLink
     * @return Teacher
     */
    public function setForumLink($forumLink)
    {
        $this->forumLink = $forumLink;

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
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @param string $imageUrl
     * @return Teacher
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

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
     * @return Teacher
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param string $projects
     * @return Teacher
     */
    public function setProjects($projects)
    {
        $this->projects = $projects;

        return $this;
    }

    /**
     * @return string
     */
    public function getRewards()
    {
        return $this->rewards;
    }

    /**
     * @param string $rewards
     * @return Teacher
     */
    public function setRewards($rewards)
    {
        $this->rewards = $rewards;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubjectAbbreviation()
    {
        return $this->subjectAbbreviation;
    }

    /**
     * @param string $subjectAbbreviation
     * @return Teacher
     */
    public function setSubjectAbbreviation($subjectAbbreviation)
    {
        $this->subjectAbbreviation = $subjectAbbreviation;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubjectName()
    {
        return $this->subjectName;
    }

    /**
     * @param string $subjectName
     * @return Teacher
     */
    public function setSubjectName($subjectName)
    {
        $this->subjectName = $subjectName;

        return $this;
    }

    /**
     * @return string
     */
    public function getAbout()
    {
        return $this->about;
    }

    /**
     * @param string $about
     * @return Teacher
     */
    public function setAbout($about)
    {
        $this->about = $about;

        return $this;
    }

    protected function dump()
    {
        return [
            'id' => $this->getId(),
            'teacher_id' => $this->getId(),
            'teacher_name' => $this->getName(),
            'teacher_foto' => $this->getImageUrl(),
            'teacher_predmet' => $this->getSubjectName(),
            'teacher_birthday' => $this->getBirthDate() ? $this->getBirthDate()->format('d M') : null,
            'teacher_univer' => $this->getEducation(),
            'teacher_cat' => $this->getCategory(),
            'teacher_stag' => $this->getExperience(),
            'teacher_info' => $this->getAbout(),
            'teacher_subject' => $this->getSubjectAbbreviation(),
            'teacher_projects' => $this->getProjects(),
            'teacher_rewards' => $this->getRewards(),
            'teacher_contact' => $this->getContact(),
            'teacher_email' => $this->getEmail(),
            'teacher_forum' => $this->getForumLink()
        ];
    }

    protected function init($data)
    {
        if (!$data) {
            return $this;
        }
        $this->id = $data['id'];
        $this->setName($data['teacher_name'])
            ->setImageUrl($data['teacher_foto'])
            ->setSubjectName($data['teacher_predmet'])
            ->setBirthDate($data['teacher_birthday'])
            ->setEducation($data['teacher_univer'])
            ->setCategory($data['teacher_cat'])
            ->setExperience($data['teacher_stag'])
            ->setAbout($data['teacher_info'])
            ->setSubjectAbbreviation($data['teacher_subject'])
            ->setProjects($data['teacher_projects'])
            ->setRewards($data['teacher_rewards'])
            ->setContact($data['teacher_contact'])
            ->setEmail($data['teacher_email'])
            ->setForumLink($data['teacher_forum']);

        return $this;
    }

    /**
     * @return string
     */
    protected function getTableName()
    {
        return 'teachers';
    }
}
