<?php

	namespace ApiC\Form\Factory;

	use ApiC\Form\CountryEdit;
	use ApiC\InputFilter\Country as CountryFilter;
	use Zend\ServiceManager\FactoryInterface;
	use Zend\ServiceManager\ServiceLocatorInterface;

	class EditCountryFactory implements FactoryInterface {

		public function createService(ServiceLocatorInterface $sm) {

			$form = new CountryEdit;
			$form->setInputFilter(new CountryFilter);

			return $form;
		}
	}