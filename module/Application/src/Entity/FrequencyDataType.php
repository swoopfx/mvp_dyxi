<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FrequencyDataType
 *  Touch, Writing, Speaking Memory
 *
 * @ORM\Table(name="frequency_data_type")
 * @ORM\Entity
 */
class FrequencyDataType
{
    /**
     * @ORM\Id 
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer", name="id", nullable=false)
     */
    private $id;    

    /**
     * Undocumented variable
     * @ORM\Column(name="frequency_data_type", type="string", length=255, nullable=true)
     * @var string
     */
    private $frequencyDataType;


    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get undocumented variable
     *
     * @return  string
     */ 
    public function getFrequencyDataType()
    {
        return $this->frequencyDataType;
    }

    /**
     * Set undocumented variable
     *
     * @param  string  $frequencyDataType  Undocumented variable
     *
     * @return  self
     */ 
    public function setFrequencyDataType(string $frequencyDataType)
    {
        $this->frequencyDataType = $frequencyDataType;

        return $this;
    }
}