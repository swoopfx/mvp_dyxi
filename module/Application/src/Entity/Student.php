<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="students")
 */
class Student
{
    /**
     * @ORM\Id 
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(name="student_name", type="string", length=255, nullable=true)
     */
    private $studentName;

    /**
     * @ORM\Column(name="student_age", type="integer", nullable=true)
     */
    private $studentAge;

    /**
     * @ORM\Column(name="student_id", type="string", length=255, unique=true)
     * @return string
     */
    private $studentId;


    /**
     * Undocumented variable
     * @ORM\Column(name="is_dyslexic", type="boolean", options={"default": false})
     * @var bool
     */
    private $isDyslexic;

    /**
     * Undocumented variable
     * @ORM\Column(name="uuid", type="string", length=255, unique=true)
     * @var string
     */

    private $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(name="created_at", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var \Datetime 
     */
    private $createdAt;

    /**
     * Undocumented variable
     * @ORM\Column(name="updated_at", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var \Datetime 
     */
    private $updatedAt;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Teacher")
     * 
     * @var Teacher
     */
    private $teacherId;




    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of studentName
     */
    public function getStudentName()
    {
        return $this->studentName;
    }

    /**
     * Set the value of studentName
     *
     * @return  self
     */
    public function setStudentName($studentName)
    {
        $this->studentName = $studentName;

        return $this;
    }

    /**
     * Get the value of studentId
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Set the value of studentId
     *
     * @return  self
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  bool
     */
    public function getIsDyslexic()
    {
        return $this->isDyslexic;
    }

    /**
     * Set undocumented variable
     *
     * @param  bool  $isDyslexic  Undocumented variable
     *
     * @return  self
     */
    public function setIsDyslexic(bool $isDyslexic)
    {
        $this->isDyslexic = $isDyslexic;

        return $this;
    }

    /**
     * Get the value of uuid
     */
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set the value of uuid
     *
     * @return  self
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $createdAt  Undocumented variable
     *
     * @return  self
     */
    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  \Datetime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set undocumented variable
     *
     * @param  \Datetime  $updatedAt  Undocumented variable
     *
     * @return  self
     */
    public function setUpdatedAt(\Datetime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getTeacherId()
    {
        return $this->teacherId;
    }

    /**
     * Set undocumented variable
     *
     * @param  Teacher  $teacherId  Undocumented variable
     *
     * @return  self
     */
    public function setTeacherId($teacherId)
    {
        $this->teacherId = $teacherId;

        return $this;
    }

    /**
     * Get the value of studentAge
     */ 
    public function getStudentAge()
    {
        return $this->studentAge;
    }

    /**
     * Set the value of studentAge
     *
     * @return  self
     */ 
    public function setStudentAge($studentAge)
    {
        $this->studentAge = $studentAge;

        return $this;
    }
}
