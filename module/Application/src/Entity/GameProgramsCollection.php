<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="game_programs_collection")
 */
class GameProgramsCollection
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id", type="integer")
     */
    private $id;


    /**
     * @ORM\ManyToOne(targetEntity="Game", inversedBy="gameProgrames")
     * @ORM\JoinColumn(name="game_id", referencedColumnName="id")
     */
    private $games;

    /**
     * @ORM\ManyToOne(targetEntity="GamePrograms")
     * @ORM\JoinColumn(name="game_program_id", referencedColumnName="id")
     * @var GamePrograms
     */
    private $gamePrograms;

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getGames()
    {
        return $this->games;
    }

    public function setGames($game)
    {
        $this->games = $game;
    }

    public function getGamePrograms()
    {
        return $this->gamePrograms;
    }

    public function setGamePrograms($gamePrograms)
    {
        $this->gamePrograms = $gamePrograms;
    }
}
