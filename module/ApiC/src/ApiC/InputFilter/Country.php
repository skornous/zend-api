<?php

	namespace ApiC\InputFilter;


	use Zend\InputFilter\InputFilter;

	class Country extends InputFilter {

		public function __construct() {

			$this->add([
				           "name"       => "code",
				           "validators" => [
					           ["name" => "Digits"],
				           ],
			           ]);

			$this->add([
				           "name"       => "alpha2",
				           "filters" => [
					           ['name' => 'StringTrim'],
					           ['name' => 'StripTags'],
				           ],
				           "validators" => [
					           [
						           "name"    => "StringLength",
						           "options" => [
							           "min" => 2,
							           "max" => 2,
						           ],
					           ],
				           ],
			           ]);

			$this->add([
				           "name"       => "alpha3",
				           "filters" => [
					           ['name' => 'StringTrim'],
					           ['name' => 'StripTags'],
				           ],
				           "validators" => [
					           [
						           "name"    => "StringLength",
						           "options" => [
							           "min" => 3,
							           "max" => 3,
						           ],
					           ],
				           ],
			           ]);

			$this->add([
				           "name"    => "nom_en_gb",
				           "filters" => [
					           ["name" => "StringTrim"],
					           ["name" => "StripTags"],
				           ],
			           ]);

			$this->add([
				           "name"    => "nom_fr_fr",
				           "filters" => [
					           ["name" => "StringTrim"],
					           ["name" => "StripTags"],
				           ],
			           ]);

			$this->add([
				           "name"       => "devise",
				           "filters" => [
					           ["name" => "StringTrim"],
					           ["name" => "StripTags"],
				           ],
				           "validators" => [
					           [
						           "name"    => "StringLength",
						           "options" => [
							           "min" => 2,
							           "max" => 4,
						           ],
					           ],
				           ],
			           ]);

			$this->add([
				           "name"       => "taux_tva",
				           "validators" => [
					           ["name" => "Digits",],
				           ],
			           ]);

		}
	}