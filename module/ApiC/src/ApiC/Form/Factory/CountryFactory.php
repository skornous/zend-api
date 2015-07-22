<?php

	namespace ApiC\Form\Factory;


	use ApiC\Form\Country as CountryForm;
	use ApiC\InputFilter\Country as CountryFilter;
	use Zend\ServiceManager\FactoryInterface;
	use Zend\ServiceManager\ServiceLocatorInterface;

	class CountryFactory implements FactoryInterface {

		public function createService(ServiceLocatorInterface $sm) {

			$form = new CountryForm;
			$form->setInputFilter(new CountryFilter);

			return $form;
		}
	}