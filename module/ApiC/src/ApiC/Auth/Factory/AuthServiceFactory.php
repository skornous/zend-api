<?php

	namespace ApiC\Auth\Factory;

	use Zend\Authentication\Adapter\DbTable\CredentialTreatmentAdapter;
	use Zend\Authentication\AuthenticationService;
	use Zend\ServiceManager\FactoryInterface;
	use Zend\ServiceManager\ServiceLocatorInterface;

	class AuthServiceFactory implements FactoryInterface {

		public function createService(ServiceLocatorInterface $sm) {

			$dbAdapter = $sm->get('db-adapter');
			$dbTableAuthAdapter = new CredentialTreatmentAdapter($dbAdapter, "user", "email", "password", 'SHA1(?)');
			$authService = new AuthenticationService(null, $dbTableAuthAdapter);

//		$authService->setAdapter($dbTableAuthAdapter);

			return $authService;
		}
	}