<?php

	namespace ApiC\Model;

	use Zend\Db\Sql\Select;
	use Zend\Db\TableGateway\TableGateway;


	class CountryTable {

		protected $tableGateway;

		function __construct(TableGateway $tableGateway) {

			$this->tableGateway = $tableGateway;
		}

		function getCountry($id) {

			$id = (int)$id;
			$select = new Select($this->tableGateway->getTable());
			$select->columns(['id', 'code', 'alpha2', 'alpha3', 'nom_en_gb', 'nom_fr_fr', 'devise', 'taux_tva'])->where(['id' => $id]);
			$rowSet = $this->tableGateway->selectWith($select);
			$row = $rowSet->current();

			if (!$row) {
				throw new \Exception("could not find row $id");
			}

			return $row;
		}

		function saveCountry(Country $country) {

			$data = [
				"code"      => $country->getCode(),
				"alpha2"    => $country->getAlpha2(),
				"alpha3"    => $country->getAlpha3(),
				"nom_en_gb" => $country->getNomEnGb(),
				"nom_fr_fr" => $country->getNomFrFr(),
				"devise"    => $country->getDevise(),
				"taux_tva"  => $country->getTauxTva(),
			];
			$id = (int)$country->getId();

			if ($id === 0) {
				$this->tableGateway->insert($data);
			} else {
				if ($this->getCountry($id)) {
					$this->tableGateway->update($data, ["id" => $id]);
				} else {
					throw new \Exception("Country ID does not exists");
				}
			}
		}

		function fetchAll($beginning, $limit) {

			$select = new Select($this->tableGateway->getTable());
			$select->limit($limit)->offset($beginning);
			$rowSet = $this->tableGateway->selectWith($select);

			return $rowSet;
		}

		function getCountryByISO3166($iso3166) {

			$finder = $this->getFinder($iso3166);

			if (!is_null($finder)) {
				$rowSet = $this->tableGateway->select([$finder => $iso3166]);
				$row = $rowSet->current();

				if (!$row) {
					throw new \Exception("could not find row $iso3166", 0);
				}

				return $row;
			} else {
				throw new \Exception("Can't look up with this code", 1);
			}
		}

		function deleteCountry($iso3166) {

			$finder = $this->getFinder($iso3166);

			if (!is_null($finder)) {
				$this->tableGateway->delete([$finder => $iso3166]);
			} else {
				throw new \Exception("Can't delete with this code", 1);
			}

		}

		private function getFinder($iso3166) {

			if (is_numeric($iso3166)) {
				return "code";
			} else {
				$iso3166_len = strlen($iso3166); // store the value to avoid doing 3 time the same calculation
				if ($iso3166_len == 2 || $iso3166_len == 3) {
					return "alpha" . $iso3166_len;
				}
			}

			return null;
		}

	}