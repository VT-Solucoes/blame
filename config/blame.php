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
        // Model references go here, eg User::class
    ],

    /*
     * If you need to change the column names, you can do that here. This
     * associative array lists $eventName => $columnName.
     */
    'columns' => [
        'creating' => 'created_by',
        'updating' => 'updated_by',
        'deleting' => 'deleted_by',
    ]
];
