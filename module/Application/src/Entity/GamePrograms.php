<?php


namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Used to register framework like WIAT4 COPP3 etc
 * @ORM\Entity
 * @ORM\Table(name="game_programs")
 */
class GamePrograms
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="program_name", type="string")
     */
   private $programName;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getProgramName()
    {
        return $this->programName;
    }

    public function setProgramName($programName)
    {
        $this->programName = $programName;
        return $this;
    }

    public function getGameId()
    {
        return $this->gameId;
    }

    public function setGameId($gameId)
    {
        $this->gameId = $gameId;
    }

    public function getProgramId()
    {
        return $this->programId;
    }

    public function setProgramId($programId)
    {
        $this->programId = $programId;
    }
}