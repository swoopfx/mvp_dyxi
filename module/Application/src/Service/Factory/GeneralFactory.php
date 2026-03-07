<?php

namespace Application\Service\Factory;

use Doctrine\ORM\EntityManager;
use Application\Service\GeneralService;
use Laminas\Cache\Storage\Adapter\Redis;


class GeneralFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{
    public function __invoke(\Psr\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        $xservice = new GeneralService();
        // You can retrieve other services from the container if needed
        // For example:
        // $someService = $container->get(SomeService::class);  
        $xservice->setEntityManager($container->get(EntityManager::class));
        $xservice->setRedisManager($container->get("dyxiredis"));
        return $xservice;
    }
}
