<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineModule\Paginator\Adapter\Collection;

/**
 * GameTypeCollection
 *
 * @ORM\Table(name="game_type_collection")
 * @ORM\Entity
 */
class GameTypeCollection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="gamesType")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     * @var Game
     */
    private $games;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="GameType")
     * @ORM\JoinColumn(name="game_type_id", referencedColumnName="id")
     * @var GameType
     */
    private $gameTypes;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getGames()
    {
        return $this->games;
    }

    public function setGames($games)
    {
        $this->games = $games;
        return $this;
    }

    public function getGameTypes()
    {
        return $this->gameTypes;
    }

    public function setGameTypes($gameTypes)
    {
        $this->gameTypes = $gameTypes;
        return $this;
    }

    
}