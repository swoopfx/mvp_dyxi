<?php

declare(strict_types=1);

namespace Api\Controller\Factory;

use Interop\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Api\Controller\IndexController;
use Doctrine\ORM\EntityManager;

class IndexControllerFactory implements FactoryInterface
{
    /**
     * @param ContainerInterface $container
     * @param string $requestedName
     * @param null|array $options
     * @return IndexController
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null): IndexController
    {
        $entityManager = $container->get(EntityManager::class);
        return new IndexController($entityManager);
    }
}
