<?php

	namespace ApiC\Form;

	use Zend\Form\Form;
	use Zend\Form\Element;


	class Login extends Form {

		function __construct($name = null) {

			parent::__construct("Login");

			$this->setAttribute('method', 'post');
			$this->setAttribute('enctype', 'multipart/form-data');
			// email
			$this->add([
				           'name'       => 'email',
				           'attributes' => [
					           'type'     => 'email',
					           'required' => 'required',
				           ],
				           'options'    => [
					           'label' => 'Email',
				           ],
			           ]);

			// password
			$this->add([
				           'name'       => 'password',
				           'attributes' => [
					           'type'     => 'password',
					           'required' => 'required',
				           ],
				           'options'    => [
					           'label' => 'Password',
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
					           'value' => 'Connect',
				           ],
			           ]);
		}
	}