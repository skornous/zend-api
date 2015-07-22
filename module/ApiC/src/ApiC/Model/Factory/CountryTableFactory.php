<?php

	namespace ApiC\Model\Factory;

	use ApiC\Model\CountryTable;
	use Zend\ServiceManager\FactoryInterface;
	use Zend\ServiceManager\ServiceLocatorInterface;


	class CountryTableFactory implements FactoryInterface {

		public function createService(ServiceLocatorInterface $sm) {
			$tableGateway = $sm->get('country-table-gateway');
			$table = new CountryTable($tableGateway);

			return $table;
		}
	}