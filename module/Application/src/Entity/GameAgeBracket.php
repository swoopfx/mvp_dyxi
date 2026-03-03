<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameAgeBracket
 *
 * @ORM\Table(name="game_age_bracket")
 * @ORM\Entity
 */
class GameAgeBracket
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(name="age", type="string", length=255, nullable=true)
     */
    private $ageBracket; // defines the age the game is for

    public function getId()
    {
        return $this->id;
    }

    public function getAgeBracket()
    {
        return $this->ageBracket;
    }

    public function setAgeBracket($ageBracket)
    {
        $this->ageBracket = $ageBracket;
        return $this;
    }
}