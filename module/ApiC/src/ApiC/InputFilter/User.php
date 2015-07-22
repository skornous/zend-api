<?php

	namespace ApiC\InputFilter;

	use Zend\InputFilter\InputFilter;

	class User extends InputFilter {

		function __construct() {

			// filtrage et validation pour l'email
			$this->add([
				           "name"       => "email",
				           "filters"    => [
					           ["name" => "StringTrim"],
					           ["name" => "StripTags"],
				           ],
				           "validators" => [
					           ["name" => "EmailAddress"],
				           ],
			           ]);

			// filtrage et validation pour le password
			$this->add([
				           "name"       => "password",
				           "validators" => [
					           [
						           "name"    => "StringLength",
						           "options" => [
							           "min" => 2,
						           ],
					           ],
				           ],
			           ]);

			// filtrage et validation pour le password_confirm
			$this->add([
				           "name"       => "password_confirm",
				           "validators" => [
					           [
						           "name"    => "Identical",
						           "options" => [
							           "token" => "password",
						           ],
					           ],
				           ],
			           ]);
		}
	}