<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Application\Entity\GameAgeBracket;
use Application\Entity\GameLanguage;

/**
 * GameBracket
 * This class defines the bracket of age and language for each game deifinition 
 *
 * @ORM\Table(name="game_bracket")
 * @ORM\Entity
 */
class GameBracket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="GameAgeBracket")
     * @var GameAgeBracket
     */
    private $age; // defines the age the game is for
    /**
     * Reference language Entity
     * @ORM\ManyToOne(targetEntity="GameLanguage")
     * @var GameLanguage
     */
    private $language;

    /**
     * Unique Identifyer for game bracket
     * @ORM\Column(name="bracket_id", type="string", length=255, unique=true)
     * @var string
     */
    private $bracketId;
    /**
     * Undocumented variable
     * @ORM\Column(name="uuid", type="string", length=255, unique=true)
     * @var string
     */
    private $uuid;

    /**
     * Bbackround Id for referening  background to use 
     * This is dependent on the age too
     * 
     * @ORM\Column(name="bg_id", type="string", length=255, nullable=true)
     * @var string
     */
    private $bgId;

    /**
     * Undocumented variable
     * @ORM\Column(name="description", type="text", columnDefinition="LONGTEXT", nullable=true)
     * @var string
     */
    private $description;

    /**
     * Undocumented variable
     * @ORM\Column(name="bracket_name", type="string", length=255, nullable=true)
     * @var string
     */
    private $bracketName;



    /**
     * Undocumented variable
     * @ORM\Column(name="created_at", type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * @var \DateTime
     */
    private $createdAt;

    /**
     * Undocumented variable
     * @ORM\Column(name="updated_at", type="datetime", nullable=true, options={"default": "CURRENT_TIMESTAMP"})
     * @var \DateTime
     */
    private $updatedAt;

    public function getId()
    {
        return $this->id;
    }

   

    public function getBracketName()
    {
        return $this->bracketName;
    }

    public function setBracketName($bracketName)
    {
        $this->bracketName = $bracketName;
        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * Get the value of age
     * 
     * @return GameAgeBracket
     */ 
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @return  self
     */ 
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get reference language Entity
     *
     * @return  GameLanguage
     */ 
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * Set reference language Entity
     *
     * @param  GameLanguage  $language  Reference language Entity
     *
     * @return  self
     */ 
    public function setLanguage(GameLanguage $language)
    {
        $this->language = $language;

        return $this;
    }

    /**
     * Get unique Identifyer for game bracket
     *
     * @return  string
     */ 
    public function getBracketId()
    {
        return $this->bracketId;
    }

    /**
     * Set unique Identifyer for game bracket
     *
     * @param  string  $bracketId  Unique Identifyer for game bracket
     *
     * @return  self
     */ 
    public function setBracketId(string $bracketId)
    {
        $this->bracketId = $bracketId;

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
     * Get this is dependent on the age too
     *
     * @return  string
     */ 
    public function getBgId()
    {
        return $this->bgId;
    }

    /**
     * Set this is dependent on the age too
     *
     * @param  string  $bgId  This is dependent on the age too
     *
     * @return  self
     */ 
    public function setBgId(string $bgId)
    {
        $this->bgId = $bgId;

        return $this;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $description  Undocumented variable
     *
     * @return  self
     */ 
    public function setDescription(string $description)
    {
        $this->description = $description;

        return $this;
    }
}
