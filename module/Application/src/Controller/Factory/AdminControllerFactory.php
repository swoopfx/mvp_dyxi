<?php

namespace Application\Controller\Factory;

use Application\Controller\AdminController;
use Application\Service\GeneralService;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class AdminControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $ctr = new AdminController();
        $em = $container->get(GeneralService::class)->getEntityManager();
        $ctr->setEm($em);
        return $ctr;
    }
}
