<?php

namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * GameLanguage
 * English
 * french
 * Spanish
 *
 * @ORM\Table(name="game_language")
 * @ORM\Entity
 */
class GameLanguage
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;

    /**
     * @ORM\Column(name="language", type="string", length=255, nullable=true)
     */
    private $language;

    public function getId()
    {
        return $this->id;
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