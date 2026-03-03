<?php

use Doctrine\DBAL\Driver\PDO\MySQL\Driver;

return [

    'doctrine' => [

        'migrations_configuration' => [
            'orm_default' => [
                'table_storage' => [
                    'table_name' => 'DoctrineMigrationVersions',
                    'version_column_name' => 'version',
                    'version_column_length' => 1024,
                    'executed_at_column_name' => 'executedAt',
                    'execution_time_column_name' => 'executionTime',
                ],
                'migrations_paths' => [
                    'Migrations' => 'data/Migrations',
                ], // an array of namespace => path
                'migrations' => [], // an array of fully qualified migrations
                'all_or_nothing' => false,
                'check_database_platform' => true,
                'organize_migrations' => 'year_and_month', // year or year_and_month
                'custom_template' => null,
            ],
        ],

        'connection' => [
            'orm_default' => [

                // 'params' => [
                //     'url' => "mysql://ezekiel:Oluwaseun1@@localhost:8889/rpm"
                // ]
                'driverClass'   => Driver::class,
                'eventmanager'  => 'orm_default',
                'configuration' => 'orm_default',
                'params'        => [
                    'host'     => 'localhost',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => 'Oluwaseun123@#',
                    'dbname'   => 'rpm',
                    'driverOptions' => [
                        1002 => 'SET NAMES utf8',
                    ],
                ],
            ],
        ],
    ]
];