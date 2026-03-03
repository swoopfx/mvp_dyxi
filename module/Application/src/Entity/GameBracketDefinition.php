<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\GameType;

/**
 * GameBracketDefinition
 *
 * @ORM\Table(name="game_bracket_definition")
 * @ORM\Entity
 */
class GameBracketDefinition
{
    /**
     * @ORM\Id 
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * Name of game for proper admin Tracking
     * @ORM\Column(name="game_name", type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $gameName; // 

    /**
     * Mactches the name of the game Page
     * @ORM\Column(name="game_page", type="string", length=255, nullable=true)
     * @var string
     */
    private $gamePage; // mactes the qml pages

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="GameType")
     * @var GameType
     */
    private $gamesType; // phonological, Speaking Test, writing Test

    /**
     * Undocumented variable
     * @ORM\Column(name="game_definition", type="longtext", nullable=true)
     * @var string
     */
    private $gameDefinition;

    /**
     * Undocumented variable
     * @ORM\Column(name="uuid", type="string", length=255, unique=true)
     * @var string
     */
    private $uuid;

    /**
     * Undocumented variable
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * @var \Datetime
     */
    private $createdAt;

    /**
     * Undocumented variable
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * @var \Datetime
     */

    private $updatedAt;

    public function getId()
    {
        return $this->id;
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


    /**
     * Get name of game for proper admin Tracking
     *
     * @return  string
     */
    public function getGameName()
    {
        return $this->gameName;
    }

    /**
     * Set name of game for proper admin Tracking
     *
     * @param  string  $gameName  Name of game for proper admin Tracking
     *
     * @return  self
     */
    public function setGameName(string $gameName)
    {
        $this->gameName = $gameName;

        return $this;
    }

    /**
     * Get mactches the name of the game Page
     *
     * @return  string
     */
    public function getGamePage()
    {
        return $this->gamePage;
    }

    /**
     * Set mactches the name of the game Page
     *
     * @param  string  $gamePage  Mactches the name of the game Page
     *
     * @return  self
     */
    public function setGamePage(string $gamePage)
    {
        $this->gamePage = $gamePage;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  GameType
     */
    public function getGamesType()
    {
        return $this->gamesType;
    }

    /**
     * Set undocumented variable
     *
     * @param  GameType  $gamesType  Undocumented variable
     *
     * @return  self
     */
    public function setGamesType(GameType $gamesType)
    {
        $this->gamesType = $gamesType;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */
    public function getGameDefinition()
    {
        return $this->gameDefinition;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $gameDefinition  Undocumented variable
     *
     * @return  self
     */
    public function setGameDefinition(string $gameDefinition)
    {
        $this->gameDefinition = $gameDefinition;

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
}
