<?php

	namespace ApiC\Controller;

	use ApiC\Model\Country;
	use ApiC\Model\CountryList;
	use ApiC\Model\CountryTable;
	use Zend\Config\Writer\Xml;
	use Zend\Http\Response;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\View\Model\JsonModel;

	class CountryController extends AbstractActionController {

		//TODO correct the "/" 404 error. More info on : http://zend-api.localhost/apic/country/

		private $code = Response::STATUS_CODE_200;
		private $data = null;

		public function indexAction() {

			if ($this->getRequest()->isGet()) { // get
				$countryTable = new CountryTable($this->getServiceLocator()->get('country-table-gateway'));
				$data = $countryTable->fetchAll(0, 30);
				$this->data = new CountryList;
				$this->data->exchangeArray($data);
			} else {
				if ($this->getRequest()->isPost()) { // post
					// check if POST message is a JSON object
					if ($this->getRequest()->getHeader('Content-Type')->getFieldValue() === "application/json") {
						$countryTable = new CountryTable($this->getServiceLocator()->get('country-table-gateway'));
						$newCountry = new Country;
						$newCountry->exchangeArray(json_decode($this->getRequest()->getContent()));
						try {
							$countryTable->saveCountry($newCountry);
						} catch (\Exception $e) {
							$this->code = Response::STATUS_CODE_409; // conflict : duplicate data
						}
					} else {
						$this->code = Response::STATUS_CODE_406; // Only accept JSON object
					}
				} else {
					$this->code = Response::STATUS_CODE_405; // 405
				}
			}

			return $this->parseResponse();
		}

		public function iso3166Action() {

			if ($this->getRequest()->isGet()) { // get
				$countryTable = new CountryTable($this->getServiceLocator()->get('country-table-gateway'));
				try {
					$data = $countryTable->getCountryByISO3166($this->params()->fromRoute('iso3166'));
					$this->data = new Country;
					$this->data->exchangeArray($data);
				} catch (\Exception $e) {
					if ($e->getCode() === 0) { // row not found
						$this->code = Response::STATUS_CODE_404;
					} else {
						if ($e->getCode() === 1) { // wrong finder (wrong request)
							$this->code = Response::STATUS_CODE_405;
						} else { // undefined error
							$this->code = Response::STATUS_CODE_400;
						}
					}
				}
			} else {
				if ($this->getRequest()->isPatch()) { // patch
					// check if PATCH message is a JSON object
					if ($this->getRequest()->getHeader('Content-Type')->getFieldValue() === "application/json") {
						$countryTable = new CountryTable($this->getServiceLocator()->get('country-table-gateway'));
						$newCountry = new Country;
						$newCountry->exchangeArray(json_decode($this->getRequest()->getContent()));
						try {
							$countryTable->saveCountry($newCountry);
						} catch (\Exception $e) {
							$this->code = Response::STATUS_CODE_404; // ID not found
						}
					} else {
						$this->code = Response::STATUS_CODE_406; // Only accept JSON object
					}
				} else {
					if ($this->getRequest()->isDelete()) { // delete
						$countryTable = new CountryTable($this->getServiceLocator()->get('country-table-gateway'));
						try {
							$countryTable->deleteCountry($this->params()->fromRoute('iso3166'));
						} catch (\Exception $e) {
							$this->code = Response::STATUS_CODE_404; // iso3166 not found
						}
					} else {
						if ($this->getRequest()->isPut()) { // put -> forbidden
							$this->code = Response::STATUS_CODE_403;
						} else {
							$this->code = Response::STATUS_CODE_405; // 405
						}
					}
				}
			}

			return $this->parseResponse();
		}

		// -- Private functions -- //

		private function parseResponse() {

			$content = ["code" => $this->code];
			if (!is_null($this->data)) {
				$content["data"] = $this->data->getArrayCopy();
			}
			if ($this->getRequest()->getHeader('Accept')->hasMediaType('application/json')) {
				return new JsonModel($content);
			} else {
				if ($this->getRequest()->getHeader('Accept')->hasMediaType('application/xml')) {
					$xmlWriter = new Xml(); // get an xml writer
					// generate the response
					$response = new Response;
					$response->setStatusCode($this->code);
					$response->getHeaders()->addHeaderLine('Content-Type', 'text/xml; charset=utf-8');
					$response->setContent($xmlWriter->toString($content));

					return $response;
				} else {
					$response = new Response;
					$response->setStatusCode(Response::STATUS_CODE_406);

					return $response;
				}
			}
		}

	}

