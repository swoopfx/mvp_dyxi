<?php
namespace Api\Controller\Factory;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Api\Controller\IndexController;
use Doctrine\ORM\EntityManager;

class PostControllerFactroy implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);
        
    }
}
