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

    /**
     * @ORM\Column(name="uuid", type="string", length=255, nullable=true)
     */
    private $uuid;

    /**
     * Used to define the upper bound of the age bracket
     * @ORM\Column(name="age_upper_bound", type="integer", nullable=true)
     */
    private $ageUpperBound;

    /**
     * Used to define the lower bound of the age bracket
     * @ORM\Column(name="age_lower_bound", type="integer", nullable=true)
     */
    private $ageLowerBound;

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

    public function getUuid()
    {
        return $this->uuid;
    }

    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function getAgeUpperBound()
    {
        return $this->ageUpperBound;
    }

    public function setAgeUpperBound($ageUpperBound)
    {
        $this->ageUpperBound = $ageUpperBound;
        return $this;
    }

    public function getAgeLowerBound()
    {
        return $this->ageLowerBound;
    }

    public function setAgeLowerBound($ageLowerBound)
    {
        $this->ageLowerBound = $ageLowerBound;
        return $this;
    }
}