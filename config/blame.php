<?php

use Dbt\Blame\Observer;

return [
    /*
     * The observer that listens for model events. If you want to swap out the
     * observer implementation, you can replace this reference.
     */
    'observer' => Observer::class,

    /*
     * Add each model you want observed to this array. The service provider will
     * automatically register the observer for you.
     */
    'models' => [
        'Model references go here.',
    ],

    /*
     * If you need to change the column names, you can do that here. This
     * associative array lists $eventName => $columnName.
     */
    'columns' => [
        'creating' => 'created_at',
        'updating' => 'updated_at',
        'deleting' => 'deleted_at',
    ]
];
