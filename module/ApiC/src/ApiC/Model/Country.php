<?php

	namespace ApiC\Model;


	class Country {

		private $id;
		private $code;
		private $alpha2;
		private $alpha3;
		private $nom_en_gb;
		private $nom_fr_fr;
		private $devise;
		private $taux_tva;

		public function exchangeArray($data) {

			if (is_array($data)) {
				$this->id = (isset($data["id"])) ? $data["id"] : null;
				$this->code = (isset($data["code"])) ? $data["code"] : null;
				$this->alpha2 = (isset($data["alpha2"])) ? $data["alpha2"] : null;
				$this->alpha3 = (isset($data["alpha3"])) ? $data["alpha3"] : null;
				$this->nom_en_gb = (isset($data["nom_en_gb"])) ? $data["nom_en_gb"] : null;
				$this->nom_fr_fr = (isset($data["nom_fr_fr"])) ? $data["nom_fr_fr"] : null;
				$this->devise = (isset($data["devise"])) ? $data["devise"] : null;
				$this->taux_tva = (isset($data["taux_tva"])) ? $data["taux_tva"] : null;
			} else {
				if (is_object($data)) {
					$this->id = (isset($data->id)) ? $data->id : null;
					$this->code = (isset($data->code)) ? $data->code : null;
					$this->alpha2 = (isset($data->alpha2)) ? $data->alpha2 : null;
					$this->alpha3 = (isset($data->alpha3)) ? $data->alpha3 : null;
					$this->nom_en_gb = (isset($data->nom_en_gb)) ? $data->nom_en_gb : null;
					$this->nom_fr_fr = (isset($data->nom_fr_fr)) ? $data->nom_fr_fr : null;
					$this->devise = (isset($data->devise)) ? $data->devise : null;
					$this->taux_tva = (isset($data->taux_tva)) ? $data->taux_tva : null;
				}
			}
		}

		public function getArrayCopy() {

			return [
				'id'        => (int)$this->id,
				'code'      => $this->code,
				'alpha2'    => $this->alpha2,
				'alpha3'    => $this->alpha3,
				'nom_en_gb' => $this->nom_en_gb,
				'nom_fr_fr' => $this->nom_fr_fr,
				'devise'    => $this->devise,
				'taux_tva'  => $this->taux_tva,
			];
		}

		/**
		 * @return mixed
		 */
		public function getId() {

			return $this->id;
		}

		/**
		 * @param mixed $id
		 */
		public function setId($id) {

			$this->id = $id;
		}

		/**
		 * @return mixed
		 */
		public function getCode() {

			return $this->code;
		}

		/**
		 * @param mixed $code
		 */
		public function setCode($code) {

			$this->code = $code;
		}

		/**
		 * @return mixed
		 */
		public function getAlpha2() {

			return $this->alpha2;
		}

		/**
		 * @param mixed $alpha2
		 */
		public function setAlpha2($alpha2) {

			$this->alpha2 = $alpha2;
		}

		/**
		 * @return mixed
		 */
		public function getAlpha3() {

			return $this->alpha3;
		}

		/**
		 * @param mixed $alpha3
		 */
		public function setAlpha3($alpha3) {

			$this->alpha3 = $alpha3;
		}

		/**
		 * @return mixed
		 */
		public function getNomEnGb() {

			return $this->nom_en_gb;
		}

		/**
		 * @param mixed $nom_en_gb
		 */
		public function setNomEnGb($nom_en_gb) {

			$this->nom_en_gb = $nom_en_gb;
		}

		/**
		 * @return mixed
		 */
		public function getNomFrFr() {

			return $this->nom_fr_fr;
		}

		/**
		 * @param mixed $nom_fr_fr
		 */
		public function setNomFrFr($nom_fr_fr) {

			$this->nom_fr_fr = $nom_fr_fr;
		}

		/**
		 * @return mixed
		 */
		public function getDevise() {

			return $this->devise;
		}

		/**
		 * @param mixed $devise
		 */
		public function setDevise($devise) {

			$this->devise = $devise;
		}

		/**
		 * @return mixed
		 */
		public function getTauxTva() {

			return $this->taux_tva;
		}

		/**
		 * @param mixed $taux_tva
		 */
		public function setTauxTva($taux_tva) {

			$this->taux_tva = $taux_tva;
		}

	}