<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\GameType;
use Application\Entity\GameBracket;

/**
 * GameBracketDefinition
 *
 * @ORM\Table(name="game")
 * @ORM\Entity
 */
class Game
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
     * Defines if ADHD or dyslexia
     *
     * @var GameCategory
     * @ORM\ManyToOne(targetEntity="GameCategory")
     */
    private $gameCategory; // ADHD or Dyslexia

    /**
     * Undocumented variable
     * @ORM\Column(name="game_definition", type="text", columnDefinition="LONGTEXT", nullable=true)
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

    /**
     * Undocumented variable
     * 
     * @var GameBracket
     * @ORM\ManyToOne(targetEntity="GameBracket")
     */
    private $gameBracket;

    /**
     * Undocumented variable
     * @ORM\ManyToOne(targetEntity="GameLanguage")
     * @var GameLanguage
     */
    private $language;

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

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get defines if ADHD or dyslexia
     *
     * @return  GameCategory
     */
    public function getGameCategory()
    {
        return $this->gameCategory;
    }

    /**
     * Set defines if ADHD or dyslexia
     *
     * @param  GameCategory  $gameCategory  Defines if ADHD or dyslexia
     *
     * @return  self
     */
    public function setGameCategory(GameCategory $gameCategory)
    {
        $this->gameCategory = $gameCategory;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  GameBracket
     */ 
    public function getGameBracket()
    {
        return $this->gameBracket;
    }

    /**
     * Set undocumented variable
     *
     * @param  GameBracket  $gameBracket  Undocumented variable
     *
     * @return  self
     */ 
    public function setGameBracket(GameBracket $gameBracket)
    {
        $this->gameBracket = $gameBracket;

        return $this;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language)
    {
        $this->language = $language;

        return $this;
    }
}
