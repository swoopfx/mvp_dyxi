<?php
namespace Api\Controller\Factory;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Api\Controller\IndexController;
use Doctrine\ORM\EntityManager;
use Api\Controller\PostController;
use Api\Services\BigQueryService;

class PostControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);
        $bigQuery = $container->get(BigQueryService::class);
        $ctr = new PostController();
        $ctr->setEntityManager($entityManager)->setBigQueryService($bigQuery);
        return $ctr;
    }
}
