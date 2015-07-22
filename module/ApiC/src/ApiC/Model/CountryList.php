<?php

	namespace ApiC\Model;


	class CountryList {

		private $countries = [];

		public function exchangeArray($data) {

			$this->setCountries($data);
		}

		public function getArrayCopy() {

			return [
				'countries' => $this->toArray(),
			];
		}

		public function getCountries() {

			return $this->countries;
		}

		public function setCountries($countries) {
			foreach($countries as $country) {
				$this->countries[] = $country;
			}
//			$this->countries = $countries;
		}

		private function toArray() {

			$countries = [];
			foreach ($this->countries as $country) {
				$countries[] = $country->getArrayCopy();
			}

			return $countries;
		}

	}