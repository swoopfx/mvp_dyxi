<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="dyscalculia_clumsy_thief")
 */
class DyscalculiaClumsyThief {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", name="userId", nullable=false)
     */
    private $userId;

    /**
     * @ORM\Column(type="string", name="userAge", nullable=false)
     */
    private $userAge;

    /**
     * @ORM\Column(type="string", name="gameId", nullable=false)
     */
    private $gameId;

    /**
     * @ORM\Column(type="string", name="gameType", nullable=false)
     */
    private $gameType;

    /**
     * @ORM\Column(type="string", name="gameCategory", nullable=false)
     */
    private $gameCategory;

    /**
     * @ORM\Column(type="string", name="activity", nullable=false)
     */

    private $sessionId;

    private $createdAt;

    private $updatedAt;

    
}