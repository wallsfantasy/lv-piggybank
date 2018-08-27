<?php

declare(strict_types=1);
/**
 * prooph (http://getprooph.org/)
 *
 * @see       https://github.com/prooph/laravel-package for the canonical source repository
 * @copyright Copyright (c) 2016 prooph software GmbH (http://prooph-software.com/)
 * @license   https://github.com/prooph/laravel-package/blob/master/LICENSE.md New BSD License
 */
// default example configuration for prooph components, see http://getprooph.org/
return [
    'event_store' => [
        'adapter' => [
            'type' => \Prooph\EventStore\Pdo\MySqlEventStore::class,
            'options' => [
                'connection_alias' => 'laravel.connections.pdo',
            ],
        ],
        'plugins' => [
            \Prooph\EventStoreBusBridge\EventPublisher::class,
            \Prooph\EventStoreBusBridge\TransactionManager::class,
        ],
        // list of aggregate repositories
        'default' => [
            'connection' => \Prooph\EventStore\Pdo\MySqlEventStore::class,
            'persistence_strategy' => \Prooph\EventStore\Pdo\PersistenceStrategy\MySqlSingleStreamStrategy::class,
            'event_store' => \Prooph\EventStore\Pdo\MySqlEventStore::class,
            'repository_class' => \App\Modules\User\EventStore\UserEventStore::class,
            'aggregate_type' => \App\Modules\User\User::class,
            'aggregate_translator' => \Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator::class,
            //'snapshot_store' => \Prooph\EventStore\Snapshot\SnapshotStore::class,
            'one_stream_per_aggregate' => false,
            'stream_name' => 'user_stream',
        ],
    ],
    'service_bus' => [
        'command_bus' => [
            'router' => [
                'routes' => [
                    // list of commands with corresponding command handler
                    \App\Modules\User\Command\RegisterUserCommand::NAME => \App\Modules\User\Command\RegisterUserHandler::class,
                ],
            ],
        ],
        'event_bus' => [
            'plugins' => [
                \Prooph\ServiceBus\Plugin\InvokeStrategy\OnEventStrategy::class,
            ],
            'router' => [
                'routes' => [
                    // list of events with a list of projectors
                    \App\Modules\User\Event\UserRegisteredEvent::class => [
                        \App\Modules\User\Projection\UserProjection::class
                    ]
                ],
            ],
        ],
    ],
    'snapshot_store' => [
        'adapter' => [
            'type' => \Prooph\SnapshotStore\Pdo\PdoSnapshotStore::class,
            'options' => [
                'connection_alias' => 'laravel.connections.pdo',
                'snapshot_table_map' => [
                    // list of aggregate root => table (default is snapshot)
                ],
            ],
        ],
    ],
    'snapshotter' => [
        'version_step' => 5, // every 5 events a snapshot
        'aggregate_repositories' => [
            // list of aggregate root => aggregate repositories
        ],
    ],
];
