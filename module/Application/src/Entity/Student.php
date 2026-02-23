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
     * @ORM\Column(name="student_name", type="string", length=255)
     */
    private $studentName;

    /**
     * @ORM\Column(name="student_id", type="string", length=255, unique=true)
     * @return string
     */
    private $studentId;


    /**
     * Undocumented variable
     * @ORM\Column(name="is_dyslaxic", type="boolean", options={"default": false})
     * @var bool
     */
    private $isDyslaxic;

    private $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(name="created_at", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var \Datetime 
     */
    private $createdAt;

    private $updatedAt;

    private $deletedAt;

    private $teacherId;



}