<?php

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="teacher", indexes={
 *     @ORM\Index(name="teacher_id_index", columns={"teacher_id"})
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
     * @ORM\Column(name="created_at", type="datetime", options={"default": "CURRENT_TIMESTAMP"}, unique=true)
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(name="created_at", type="datetime", options={"default": "CURRENT_TIMESTAMP"})
     * @var \Datetime 
     */
    private $createdAt;

    private $updatedAt;

    private $deletedAt;
}