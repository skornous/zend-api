<?php

	namespace ApiC\Model\Factory;

	use ApiC\Model\Country;
	use Zend\Db\ResultSet\ResultSet;
	use Zend\Db\TableGateway\TableGateway;
	use Zend\ServiceManager\FactoryInterface;
	use Zend\ServiceManager\ServiceLocatorInterface;


	class CountryTableGatewayFactory implements FactoryInterface {

		public function createService(ServiceLocatorInterface $sm) {
			$dbAdapter = $sm->get('db-adapter');
			$resultSetPrototype = new ResultSet;
			$resultSetPrototype->setArrayObjectPrototype(new Country);
			return new TableGateway("pays", $dbAdapter, null, $resultSetPrototype);
		}
	}