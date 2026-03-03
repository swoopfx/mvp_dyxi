<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GameType
 *
 * @ORM\Table(name="game_type")
 * @ORM\Entity
 */
class GameType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(name="type", type="string", length=255, nullable=true)
     */
    private $type; // defines the type of game (e.g. speeaking test, wrtining test,  phonological test)


    public function getId()
    {
        return $this->id;
    }

    public function getType()
    {
        return $this->type;
    }
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }
}
