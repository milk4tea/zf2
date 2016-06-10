<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Angular\Controller\User' => 'Angular\Controller\UserController',
         ),
     ),
    // The following section is new` and should be added to your file
    'router' => array(
        'routes' => array(
            'album-rest' => array(
                'type'    => 'Segment',
                'options' => array(
                    'route'    => '/user[/:id]',
                    'constraints' => array(
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Angular\Controller\User',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
 );

