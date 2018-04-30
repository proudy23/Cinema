<?php

$router = $di->getRouter();


// Define a route
$router->add(
    '/allusers',
    [
        'controller' => 'user',
        'action'     => 'search',
    ]
);

$router->handle();

$router->add(
    '/alltickets',
    [
        'controller' => 'Ticket',
        'action'     => 'search',
    ]
);