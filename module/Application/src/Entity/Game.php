<?php

namespace Application\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Application\Entity\GameType;
// use Application\Entity\GameBracket;
use Application\Entity\GameAgeBracket;
use Application\Entity\GameLanguage;
use DoctrineModule\Paginator\Adapter\Collection;

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
     * @ORM\OneToMany(targetEntity="GameTypeCollection", mappedBy="games" , orphanRemoval=true,  cascade={"persist", "remove"})
     * @var \Doctrine\Common\Collections\Collection
     */
    private $gamesType; // phonological, Speaking Test, writing Test


    /**
     * Defines if ADHD or dyslexia
     *
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\OneToMany(targetEntity="GameCategoryCollection", mappedBy="game", orphanRemoval=true,  cascade={"persist", "remove"})
     */
    private $gameCategory; // ADHD or Dyslexia

    /**
     * @ORM\OneToMany(targetEntity="GameProgramsCollection", mappedBy="games", orphanRemoval=true,  cascade={"persist", "remove"})
     * @var \Doctrine\Common\Collections\Collection
     */
    private $gamePrograms;

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
     * @var GameAgeBracket
     * @ORM\ManyToOne(targetEntity="GameAgeBracket")
     */
    private $gameAgeBracket;

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
     * Get undocumented variabless
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
     * @return  GameAgeBracket
     */ 
    public function getGameAgeBracket()
    {
        return $this->gameAgeBracket;
    }

    /**
     * Set undocumented variable
     *
     * @param  GameAgeBracket  $gameAgeBracket  Undocumented variable
     *
     * @return  self
     */ 
    public function setGameAgeBracket(GameAgeBracket $gameAgeBracket)
    {
        $this->gameAgeBracket = $gameAgeBracket;

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

    public function addGameType($gameType)
    {
        if(!$this->gamesType->contains($gameType)){
            $this->gamesType->add($gameType);
        }
        return $this;
    }

    public function removeGameType($gameType)
    {
        $this->gamesType->removeElement($gameType);
        // $gameType->setGames(null);
        return $this;
    }

    public function getGameTypes()
    {
        return $this->gamesType;
    }

    public function addGameCategory($gameCategory)
    {
        if(!$this->gameCategory->contains($gameCategory)){
            $this->gameCategory->add($gameCategory);
        }
        return $this;
    }
    public function removeGameCategory($gameCategory)
    {
        $this->gameCategory->removeElement($gameCategory);
        // $gameCategory->setGame(null);
        return $this;
    }

    public function getGameCategories()
    {
        return $this->gameCategory;
    }

    public function getGamePrograms()
    {
        return $this->gamePrograms;
    }

    public function setGamePrograms($gamePrograms)
    {
        $this->gamePrograms = $gamePrograms;
        return $this;
    }

    public function __construct(){
        $this->gamesType = new ArrayCollection();
        $this->gameCategory = new ArrayCollection();
        $this->gamePrograms = new ArrayCollection();
    }
}
    


