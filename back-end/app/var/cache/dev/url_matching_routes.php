<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/test' => [[['_route' => 'api_test', '_controller' => 'App\\Controller\\ApiTestController::test'], null, null, null, false, false, null]],
        '/api/auth/login' => [[['_route' => 'api_login', '_controller' => 'App\\Controller\\AuthController::login'], null, ['POST' => 0], null, false, false, null]],
        '/api/auth/me' => [[['_route' => 'api_me', '_controller' => 'App\\Controller\\AuthController::me'], null, ['GET' => 0], null, false, false, null]],
        '/api/car/add' => [[['_route' => 'add_car', '_controller' => 'App\\Controller\\CarController::add'], null, ['POST' => 0], null, false, false, null]],
        '/api/car/list' => [[['_route' => 'my_cars', '_controller' => 'App\\Controller\\CarController::myCars'], null, ['GET' => 0], null, false, false, null]],
        '/api/trip/add' => [[['_route' => 'publish_trip', '_controller' => 'App\\Controller\\PublishTripController::add'], null, ['POST' => 0], null, false, false, null]],
        '/api/trip/all' => [[['_route' => 'trip_all', '_controller' => 'App\\Controller\\TripController::all'], null, ['GET' => 0], null, false, false, null]],
        '/api/trip/search' => [[['_route' => 'trip_search', '_controller' => 'App\\Controller\\TripController::search'], null, ['GET' => 0], null, false, false, null]],
        '/api/trip/reservation/list' => [[['_route' => 'trip_reservation_list', '_controller' => 'App\\Controller\\TripController::reservationList'], null, ['GET' => 0], null, false, false, null]],
        '/api/user' => [
            [['_route' => 'create_user', '_controller' => 'App\\Controller\\UserController::create'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'get_users', '_controller' => 'App\\Controller\\UserController::list'], null, ['GET' => 0], null, false, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_error/(\\d+)(?:\\.([^/]++))?(*:35)'
                .'|/api/(?'
                    .'|car/delete/([^/]++)(*:69)'
                    .'|trip/(?'
                        .'|delete/([^/]++)(*:99)'
                        .'|([^/]++)(*:114)'
                        .'|reservation/(?'
                            .'|([^/]++)(*:145)'
                            .'|cancel/([^/]++)(*:168)'
                            .'|list(*:180)'
                        .')'
                        .'|([^/]++)/reviews(?'
                            .'|(*:208)'
                        .')'
                    .')'
                    .'|user/([^/]++)(?'
                        .'|(*:234)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        35 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        69 => [[['_route' => 'delete_car', '_controller' => 'App\\Controller\\CarController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        99 => [[['_route' => 'delete_trip', '_controller' => 'App\\Controller\\PublishTripController::delete'], ['id'], ['DELETE' => 0], null, false, true, null]],
        114 => [[['_route' => 'trip_details', '_controller' => 'App\\Controller\\TripController::details'], ['id'], ['GET' => 0], null, false, true, null]],
        145 => [[['_route' => 'reserve_trip', '_controller' => 'App\\Controller\\TripReservationController::reserve'], ['tripId'], ['POST' => 0], null, false, true, null]],
        168 => [[['_route' => 'cancel_reservation', '_controller' => 'App\\Controller\\TripReservationController::cancel'], ['tripId'], ['POST' => 0], null, false, true, null]],
        180 => [[['_route' => 'list', '_controller' => 'App\\Controller\\TripReservationController::list'], [], ['GET' => 0], null, false, false, null]],
        208 => [
            [['_route' => 'trip_review_add', '_controller' => 'App\\Controller\\TripReviewController::add'], ['tripId'], ['POST' => 0], null, false, false, null],
            [['_route' => 'trip_review_list', '_controller' => 'App\\Controller\\TripReviewController::getReviews'], ['tripId'], ['GET' => 0], null, false, false, null],
        ],
        234 => [
            [['_route' => 'get_user', '_controller' => 'App\\Controller\\UserController::show'], ['id'], ['GET' => 0], null, false, true, null],
            [['_route' => 'update_user', '_controller' => 'App\\Controller\\UserController::update'], ['id'], ['POST' => 0, 'PUT' => 1], null, false, true, null],
            [['_route' => 'delete_user', '_controller' => 'App\\Controller\\UserController::delete'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
