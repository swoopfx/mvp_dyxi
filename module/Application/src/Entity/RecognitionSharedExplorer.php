<?php
namespace Application\Entity;

use Doctrine\ORM\mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recognition_shared_explorer")
 */
class RecognitionSharedExplorer {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(type="string", name="pageName", nullable=true)
     */
    private  $pageName;

    /**
     * @ORM\Column(type="string", name="stuentId", nullable=true)
     */
    private $stuentId;

    /**
     * @ORM\Column(type="string", name="userId", nullable=true)
     */
    private $userId;

    /**
     * @ORM\Column(type="string", name="userAge", nullable=true)
     */
    private $userAge;

    /**
     * @ORM\Column(type="string", name="gameId", nullable=true)
     */
    private $gameId;

    /**
     * @ORM\ManyToOne(targetEntity="GameType")
     */
    private $gameType;

    /**
     * @ORM\ManyToOne(targetEntity="GameCategory")
     */
    private $gameCategory;

    /**
     * @ORM\Column(name="activity", nullable=false, type="json")
     */
    private $activity;

    /**
     * @ORM\Column(type="string", name="session_id", nullable=false)
     */
    private $sessionId;

    /**
     * @ORM\Column(type="float", name="problemSolvingindex", nullable=true)
     */
    private $problemSolvingindex;

    /**
     * @ORM\Column(type="float", name="creativeIdex", nullable=true)
     */
    private $creativeIdex;


    /**
     * @ORM\Column(type="float", name="averageTimeCorrect", nullable=true)
     */
    private $averageTimeCorrect;

    /**
     * @ORM\Column(type="float", name="averageTimeFailed", nullable=true)
     */
    private $averageTimeFailed;

    /**
     * @ORM\Column(name="created_at", type="datetime", nullable=false)
     */
    private $createdAt;

    /**
     * @ORM\Column(name="updated_at", type="datetime", nullable=false)
     */
    private $updatedAt;

    public function __construct() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    
}