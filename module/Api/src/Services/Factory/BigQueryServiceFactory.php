<?php

namespace Api\Services\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class BigQueryServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $bigQueryService = new BigQueryService();

        return $bigQueryService;
    }
}
