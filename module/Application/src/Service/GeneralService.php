<?php
namespace Application\Service;


class GeneralService
{
    // This service can be used for general application logic
    // For example, you could add methods to handle common tasks across controllers

    private $entityManager;
    

    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }
}