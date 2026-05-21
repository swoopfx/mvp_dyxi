<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use DoctrineModule\Paginator\Adapter\Collection;

/**
 * GameCategoryCollection
 *
 * @ORM\Table(name="game_category_collection")
 * @ORM\Entity
 */
class GameCategoryCollection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="gameCategory")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     * @var Game
     */
    private $game;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="GameCategory")
     * @ORM\JoinColumn(name="game_category_id", referencedColumnName="id")
     * @var GameCategory
     */
    private $gameCategory;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function getGame()
    {
        return $this->game;
    }

    

    public function setGame($game)
    {
        $this->game = $game;
        return $this;
    }

    public function getGameCategory()
    {
        return $this->gameCategory;
    }

    public function setGameCategory($gameCategory)
    {
        $this->gameCategory = $gameCategory;
        return $this;
    }
}
