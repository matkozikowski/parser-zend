<?php

namespace Mkparser;

 return array(
     'controllers' => array(
         'invokables' => array(
             'Mkparser\Controller\Mkparser' => 'Mkparser\Controller\MkparserController',
         ),
     ),

    'router' => array(
        'routes' => array(
            'mkparser' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/mkparser[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Mkparser\Controller\Mkparser',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'mkparser' => __DIR__ . '/../view',
        ),
        'strategies' => array(
            'ViewJsonStrategy'
        )
    ),
 );
