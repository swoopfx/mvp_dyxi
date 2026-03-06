<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Used to capture eye tracking data for each game session. 
 * This will be used to analyze the user's eye movement patterns during gameplay, 
 * which can provide insights into their attention and focus levels.
 * 
 * @ORM\Entity
 * @ORM\Table(name="eye_tracking_data")
 */
class EyeTrackingData
{
    /**
     * @ORM\Id 
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\Column(name="eye_tracking_data", type="text", columnDefinition="LONGTEXT", nullable=true)
     * @var string
     */
    private $eyeTrackingData;


    /**
     * Undocumented variable
     * @ORM\Column(name="session_id", type="string", length=255, nullable=false)
     * @var string
     */
    private $sessionId;

    /**
     * Undocumented variable
     *
     * @ORM\Column(name="uuid", type="string", length=255, unique=true, nullable=false)
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Game")
     * @var Game 
     */
    private $gameId;

    /**
     * Undocumented variable
     * @ORM\Column(name="created_at", type="datetime", nullable=false, options={"default": "CURRENT_TIMESTAMP"})
     * @var \Datetime
     */
    private $createdAt;

    /**
     * Undocumented variable
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * @var \Datetime
     */
    private $updatedAt;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Student")
     * @var Student
     */
    private $studentId;

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
    public function getEyeTrackingData()
    {
        return $this->eyeTrackingData;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $eyeTrackingData  Undocumented variable
     *
     * @return  self
     */ 
    public function setEyeTrackingData(string $eyeTrackingData)
    {
        $this->eyeTrackingData = $eyeTrackingData;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */ 
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $sessionId  Undocumented variable
     *
     * @return  self
     */ 
    public function setSessionId(string $sessionId)
    {
        $this->sessionId = $sessionId;

        return $this;
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
     * @return  Game
     */ 
    public function getGameId()
    {
        return $this->gameId;
    }

    /**
     * Set undocumented variable
     *
     * @param  Game  $gameId  Undocumented variable
     *
     * @return  self
     */ 
    public function setGameId(Game $gameId)
    {
        $this->gameId = $gameId;

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
     * @return  Student
     */ 
    public function getStudentId()
    {
        return $this->studentId;
    }

    /**
     * Set undocumented variable
     *
     * @param  Student  $studentId  Undocumented variable
     *
     * @return  self
     */ 
    public function setStudentId(Student $studentId)
    {
        $this->studentId = $studentId;

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
