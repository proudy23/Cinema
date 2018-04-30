<?php

$router = $di->getRouter();


// Define a route
$router->add(
    '/allUsers',
    [
        'controller' => 'user',
        'action'     => 'search',
    ]
);

$router->handle();

$router->add(
    '/allBookings',
    [
        'controller' => 'Booking',
        'action'     => 'search',
    ]
);