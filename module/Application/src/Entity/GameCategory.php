<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="game_category")
 * ADHD or Dyslexia, DysCalulus, Dysgraphia, Dysorthography, Dysphasia, Dyslexia
 */
class GameCategory
{
    /**
     * @ORM\Id 
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * Undocumented variable
     * @ORM\Column(name="game_category", type="string", length=255, nullable=true)
     * @var string
     */
    private $gameCategory; // ADHD or Dyslexia

    public function getId()
    {
        return $this->id;
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