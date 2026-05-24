<?php

declare(strict_types=1);

namespace Api;

use Api\Controller\IndexController;
use Api\Controller\Factory\IndexControllerFactory;
use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'api' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api[/:action]',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],

            'api_post' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/api-post[/:action]',
                    'defaults' => [
                        'controller' => PostController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            IndexController::class => IndexControllerFactory::class,
            PostController::class => PostControllerFactory::class,
        ],
    ],
    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
