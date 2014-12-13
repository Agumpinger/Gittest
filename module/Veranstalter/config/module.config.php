<?php

 return array(
     'controllers' => array(
         'invokables' => array(
             'Veranstalter\Controller\Veranstalter' => 'Veranstalter\Controller\VeranstalterController',
         	 'Veranstalter\Controller\Event' => 'Veranstalter\Controller\EventController',  //bei jedem neuen Controller hinzufügen

         ),
     ),

     // hier sind zwei controller im VeranstalterModul geroutet : VeranstalterController und EventController
 		'router' => array(
 				'routes' => array(
 						'veranstalter' => array(		//einmal hier ändern
 								'type'    => 'segment',
 								'options' => array(
 										'route'    => '/veranstalter[/:action][/:id]',  //hier ändern
 										'constraints' => array(
 												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
 												'id'     => '[0-9]+',
 										),
 										'defaults' => array(
 												'controller' => 'Veranstalter\Controller\Veranstalter',		//defaults ändern
 												'action'     => 'index',
 										),
 								),
 						),
 						'event' => array(						//neuer controller event --> ändern
 								'type'    => 'segment',
 								'options' => array(
 										'route'    => '/event[/:action][/:id]', // ändern
 										'constraints' => array(
 												'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
 												'id'     => '[0-9]+',
 										),
 										'defaults' => array(
 												'controller' => 'Veranstalter\Controller\Event',  //defaults ändern
 												'action'     => 'index',
 										),
 								),
 						),
 				),
 		),
 		

     'view_manager' => array(
         'template_path_stack' => array(
             'veranstalter' => __DIR__ . '/../view',   // das ist die default route der views also module/veranstalter/view/veranstalter
         ),
     ),
 );