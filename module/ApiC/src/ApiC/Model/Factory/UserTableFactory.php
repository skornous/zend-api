<?php

	namespace ApiC\Model\Factory;

	use ApiC\Model\UserTable;
	use Zend\ServiceManager\FactoryInterface;
	use Zend\ServiceManager\ServiceLocatorInterface;

	class UserTableFactory implements FactoryInterface {

		public function createService(ServiceLocatorInterface $sm) {

			$tableGateway = $sm->get('user-table-gateway');
			$table = new UserTable($tableGateway);

			return $table;
		}
	}