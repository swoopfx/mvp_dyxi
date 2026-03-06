<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CurriculumStudent
 *
 * @ORM\Table(name="curriculum_student")
 * @ORM\Entity
 */
class CurriculumStudent
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(name="student_id", type="integer", nullable=false)
     * @var int
     */
    private $studentId;

    /**
     * Reference to curriculum data
     * @ORM\Column(name="curriculum_data", type="text", columnDefinition="LONGTEXT", nullable=true)
     * @var string
     */
    private $curriculumData;

    /**
     * @ORM\Column(name="curriculum_id", type="integer", nullable=false)
     * @var int
     */
    private $curriculumId;

    /**
     * Unique Identifyer for curriculum student
     * @ORM\Column(name="uuid", type="string", length=255, unique=true)
     * @var string
     */
    private $uuid;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set studentId
     *
     * @param int $studentId
     * @return CurriculumStudent
     */
    public function setStudentId($studentId)
    {
        $this->studentId = $studentId;
        return $this;
    }

    /**
     * Get studentId
     *
     * @return int
     */
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Set curriculumId
     *
     * @param int $curriculumId
     * @return CurriculumStudent
     */
    public function setCurriculumId($curriculumId)
    {
        $this->curriculumId = $curriculumId;
        return $this;
    }

    /**
     * Get curriculumId
     *
     * @return int
     */
    public function getCurriculumId()
    {
        return $this->curriculumId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return CurriculumStudent
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return CurriculumStudent
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getCurriculumData()
    {
        return $this->curriculumData;
    }

    public function setCurriculumData($curriculumData)
    {
        $this->curriculumData = $curriculumData;
        return $this;
    }

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }
}