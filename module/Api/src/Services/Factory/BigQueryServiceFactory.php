<?php

namespace Api\Services\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Api\Services\BigQueryService;

class BigQueryServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
       $config = $container->get('config');

        return new BigQueryService(
            $config['bigquery']
        );
    }
}
