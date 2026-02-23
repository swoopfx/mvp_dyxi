<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="teacher", indexes={
 *     @ORM\Index(name="teacher_id_index", columns={"teacher_id, uuid"})
 * }, uniqueConstraints={
 * @ORM\UniqueConstraint(name="teacher_id_unique", columns={"teacher_id"})})
 * 
 * 
 */


class Teacher{

    /**
     * @ORM\Id 
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;    

    /**
     * @ORM\Column(name="teacher_name", type="string", length=255)
     */
    private $teacherName;

    /**
     * @ORM\Column(name="teacher_id", type="string", length=255, unique=true)
     * @return string
     */
    private $teacherId;

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
     * Get the value of teacherName
     */ 
    public function getTeacherName()
    {
        return $this->teacherName;
    }

    /**
     * Set the value of teacherName
     *
     * @return  self
     */ 
    public function setTeacherName($teacherName)
    {
        $this->teacherName = $teacherName;

        return $this;
    }

    /**
     * Get the value of teacherId
     */ 
    public function getTeacherId()
    {
        return $this->teacherId;
    }

    /**
     * Set the value of teacherId
     *
     * @return  self
     */ 
    public function setTeacherId($teacherId)
    {
        $this->teacherId = $teacherId;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */ 
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $uuid  Undocumented variable
     *
     * @return  self
     */ 
    public function setUuid(string $uuid)
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
}