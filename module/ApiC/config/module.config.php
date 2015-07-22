<?php
	return [
		'controllers'     => [
			'invokables' => [
				'ApiC\Controller\Country' => 'ApiC\Controller\CountryController',
				'ApiC\Controller\Login'   => 'ApiC\Controller\LoginController',
				'ApiC\Controller\Admin'   => 'ApiC\Controller\AdminController',
			],
		],
		'router'          => [
			'routes' => [
				'apic'       => [
					'type'          => 'Literal',
					'options'       => [
						'route'    => '/apic/country',
						'defaults' => [
							'__NAMESPACE__' => 'ApiC\Controller',
							'controller'    => 'Country',
							'action'        => 'index',
						],
					],
					'may_terminate' => true,
					'child_routes'  => [
						'country' => [
							'type'    => 'Segment',
							'options' => [
								'route'      => '[/:iso3166]',
								'constraint' => [
									'iso3166' => '[A-Z0-9]+',
								],
								'defaults'   => [
									'action' => 'iso3166',
								],
							],
						],
					],
				],
				'apic-admin' => [
					'type'          => 'Literal',
					'options'       => [
						'route'    => '/admin/apic',
						'defaults' => [
							'__NAMESPACE__' => 'ApiC\Controller',
							'controller'    => 'Admin',
							'action'        => 'index',
						],
					],
					'may_terminate' => true,
					'child_routes'  => [
						'default' => [
							'type'    => 'Segment',
							'options' => [
								'route'      => '/[:action[/:id]]',
								'constraint' => [
									'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
									'id'     => '[0-9]*',
								],
								'defaults'   => [
								],
							],
						],
					],
				],
			],
		],
		'service_manager' => [
			'abstract_factories' => [],
			'factories'          => [
				'country-table'         => '\ApiC\Model\Factory\CountryTableFactory',
				'country-table-gateway' => '\ApiC\Model\Factory\CountryTableGatewayFactory',
				'auth-service'          => '\ApiC\Auth\Factory\AuthServiceFactory',
				'user-table'            => '\ApiC\Model\Factory\UserTableFactory',
				'user-table-gateway'    => '\ApiC\Model\Factory\UserTableGatewayFactory',
				'login-form'            => '\ApiC\Form\Factory\LoginFactory',
				'addCountry-form'       => '\ApiC\Form\Factory\CountryFactory',
				'editCountry-form'       => '\ApiC\Form\Factory\EditCountryFactory',
			],
			'aliases'            => [
				'db-adapter' => 'Zend\Db\Adapter\Adapter',
			],
			'invokables'         => [],
			'services'           => [],
			'shared'             => [],
		],
		'translator'      => [
			'locale'                    => 'en_US',
			'translation_file_patterns' => [
				[
					'type'     => 'gettext',
					'base_dir' => __DIR__ . '/../language',
					'pattern'  => '%s.mo',
				],
			],
		],
		'view_manager'    => [
			'display_not_found_reason' => true,
			'display_exceptions'       => true,
			'doctype'                  => 'HTML5',
			'template_path_stack'      => [
				'apic' => __DIR__ . '/../view',
			],
			'strategies'               => [
				'ViewJsonStrategy',
			],
		],
	];
