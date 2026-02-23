<?php

namespace Application\Controller\Factory;

use Application\Controller\IndexController;
use Application\Service\GeneralService;

class IndexControllerFactory implements \Laminas\ServiceManager\Factory\FactoryInterface
{
    public function __invoke(\Psr\Container\ContainerInterface $container, $requestedName, array $options = null)
    {
        $ctr = new IndexController();
        $em = $container->get(GeneralService::class)->getEntityManager();
        $ctr->setEm($em);
        return $ctr;
    }
}
