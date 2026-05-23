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

    private  $pageName;

    private $stuentId;

    private $gameId;

    private $gameType;

    private $gameCategory;

    private $activity;

    private $userId;

    private $sessionId;

    private $problemSolvingindex;

    private $creativeIdex;

    private $averageTimeCorrect;

    private $averageTimeFailed;

    private $createdAt;

    private $updatedAt;

    public function __construct() {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    
}