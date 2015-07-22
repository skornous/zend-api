<?php

	namespace ApiC\Form;


	use Zend\Form\Form;
	use Zend\Form\Element;

	class Country extends Form {

		function __construct($name = null) {
			parent::__construct("Country");
			$this->setAttribute('method', 'post');
			$this->setAttribute('enctype', 'multipart/form-data');

			// code
			$this->add([
				           'name'       => 'code',
				           'attributes' => [
					           'type'     => 'number',
					           'required' => 'required',
				           ],
				           'options'    => [
					           'label' => 'Code',
				           ],
			           ]);

			// alpha2
			$this->add([
				           'name'       => 'alpha2',
				           'attributes' => [
					           'type'     => 'text',
					           'required' => 'required',
				           ],
				           'options'    => [
					           'label' => 'Alpha2',
				           ],
			           ]);

			// alpha3
			$this->add([
				           'name'       => 'alpha3',
				           'attributes' => [
					           'type'     => 'text',
					           'required' => 'required',
				           ],
				           'options'    => [
					           'label' => 'Alpha3',
				           ],
			           ]);

			// nomEN
			$this->add([
				           'name'       => 'nom_en_gb',
				           'attributes' => [
					           'type'     => 'text',
					           'required' => 'required',
				           ],
				           'options'    => [
					           'label' => 'Nom EN',
				           ],
			           ]);

			// nomFR
			$this->add([
				           'name'       => 'nom_fr_fr',
				           'attributes' => [
					           'type'     => 'text',
					           'required' => 'required',
				           ],
				           'options'    => [
					           'label' => 'Nom FR',
				           ],
			           ]);

			// devise
			$this->add([
				           'name'       => 'devise',
				           'attributes' => [
					           'type'     => 'text',
				           ],
				           'options'    => [
					           'label' => 'Devise',
				           ],
			           ]);

			// taux
			$this->add([
				           'name'       => 'taux_tva',
				           'attributes' => [
					           'type'     => 'number',
				           ],
				           'options'    => [
					           'label' => 'Taux TVA',
				           ],
			           ]);

			// token CSRF
			$csrf = new Element\Csrf("security");
			$this->add($csrf);

			// validate button
			$this->add([
				           'name'       => 'connect',
				           'attributes' => [
					           'type'  => 'submit',
					           'value' => 'Submit',
				           ],
			           ]);
		}

	}