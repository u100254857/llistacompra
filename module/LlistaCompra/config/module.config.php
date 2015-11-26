<?php
return array(
		'router' => array(
							'routes' => array(
											'llistacompra' => array(
															'type'    => 'Segment',
															'options' => array(
																				'route'    => '/:controller/:action[/:id]',
																				'constraints' => array(
																										'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																										'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
																										'id'		 => '[0-9]*'
																								),
																				'defaults' => array(
																									'__NAMESPACE__' => 'LlistaCompra\Controller',
																							),
																		)
															)
										)
				),																			
		'service_manager' => array(
								'abstract_factories' => array(
									'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
									'Zend\Log\LoggerAbstractServiceFactory',
								)
   						),

	'controllers' => array(
							'invokables' => array(
									'LlistaCompra\Controller\CatalegProductes' => 'LlistaCompra\Controller\CatalegProductesController',
									'LlistaCompra\Controller\Seguretat' => 'LlistaCompra\Controller\SeguretatController',
									'LlistaCompra\Controller\Supers' => 'LlistaCompra\Controller\SupersController',
									'LlistaCompra\Controller\Cistella' => 'LlistaCompra\Controller\CistellaController'
							)
					)		 		
);