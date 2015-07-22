<?php

	namespace ApiC\Controller;

	use ApiC\Model\Country as CountryModel;
	use ApiC\Model\CountryList;
	use ApiC\Model\CountryTable;
	use Zend\Mvc\Controller\AbstractActionController;
	use Zend\View\Model\ViewModel;

	class AdminController extends AbstractActionController {

		public function indexAction() {

			$authService = $this->getServiceLocator()->get('auth-service');

			if (!$authService->hasIdentity()) { // not connected
				$this->redirect()->toRoute('apic-admin/default', [ // redirect to child route
				                                                   'controller' => 'login',
				                                                   'action'     => 'index',
				]);
			} else {
				$countryTable = new CountryTable($this->getServiceLocator()->get('country-table-gateway'));
				$data = $countryTable->fetchAll(0, 30);
				$countryList = new CountryList;
				$countryList->exchangeArray($data);

				$viewContent = compact('countryList');

				//TODO add alert message and type from redirection
				return new ViewModel($viewContent);
			}
		}

		public function addAction() {

			$authService = $this->getServiceLocator()->get('auth-service');

			if (!$authService->hasIdentity()) { // not connected
				$this->redirect()->toRoute('apic-admin/default', [ // redirect to child route
				                                                   'controller' => 'login',
				                                                   'action'     => 'index',
				]);
			} else {
				return new ViewModel(['countryForm' => $this->getServiceLocator()->get('addCountry-form')]);
			}
		}

		public function processAddAction() {

			$authService = $this->getServiceLocator()->get('auth-service');

			if (!$authService->hasIdentity()) { // not connected
				$this->redirect()->toRoute('apic-admin/default', [ // redirect to child route
				                                                   'controller' => 'login',
				                                                   'action'     => 'index',
				]);
			} else {
				if ($this->request->isPost() === false) {
					return $this->redirect()->toRoute(null, [
						'action' => 'add',
					]);
				}
				$post = $this->request->getPost();
				$form = $this->getServiceLocator()->get('addCountry-form');
				$form->setData($post);

				if ($form->isValid() === false) {
					$view = new ViewModel([
						                      "error"       => true,
						                      "countryForm" => $form,
					                      ]);
					$view->setTemplate("api-c/admin/add");

					return $view;
				}
				$cleanData = $form->getData(); // "data" is now clean
				if ($this->createCountry($cleanData)) { // saving user with clean data
					return $this->redirect()->toRoute(null, [ //redirect to confirm
					                                          "controller" => "admin",
					                                          "action"     => "index",
					]);
				} else {
					$view = new ViewModel([
						                      "alert"       => [
							                      'type'    => 'danger',
							                      'content' => 'Des erreurs sont intervenues durant la valiation du formulaire',
						                      ],
						                      "countryForm" => $form,
					                      ]);
					$view->setTemplate("api-c/admin/add");

					return $view;
				}
			}
		}

		public function editAction() {

			$authService = $this->getServiceLocator()->get('auth-service');

			if (!$authService->hasIdentity()) { // not connected
				$this->redirect()->toRoute('apic-admin/default', [ // redirect to child route
				                                                   'controller' => 'login',
				                                                   'action'     => 'index',
				]);
			} else {
				$countryTable = new CountryTable($this->getServiceLocator()->get('country-table-gateway'));
				try {
					$data = $countryTable->getCountryByISO3166($this->params()->fromRoute('id'));
					$country = new CountryModel;
					$country->exchangeArray($data);
					$countryForm = $this->getServiceLocator()->get('editCountry-form');
//					var_dump("n");
					$countryForm->bind($country);

					return new ViewModel([
						                     'countryForm' => $countryForm,
					                     ]);
				} catch (\Exception $e) {
					return $this->redirect()->toRoute(null, [ //redirect to confirm
					                                          "controller" => "admin",
					                                          "action"     => "index",
					]);
				}
			}
		}

		public function processEditAction() {

			$authService = $this->getServiceLocator()->get('auth-service');

			if (!$authService->hasIdentity()) { // not connected
				$this->redirect()->toRoute('apic-admin/default', [ // redirect to child route
				                                                   'controller' => 'login',
				                                                   'action'     => 'index',
				]);
			} else {
				if ($this->request->isPost() === false) {
					return $this->redirect()->toRoute(null, [
						'action' => 'edit',
					]);
				}
				$post = $this->request->getPost();
				$countryTable = $this->getServiceLocator()->get('country-table');
				$country = $countryTable->getCountry($post->id);

				$form = $this->getServiceLocator()->get('editCountry-form');
				$form->bind($country);
				$form->setData($post);

				if ($form->isValid() !== false){
					$countryTable->saveCountry($country);
				}

				return $this->redirect()->toRoute(null, ['controller' => 'admin', 'action' => 'index']);

			}
		}

		public function deleteAction() {

			$authService = $this->getServiceLocator()->get('auth-service');

			if (!$authService->hasIdentity()) { // not connected
				$this->redirect()->toRoute('apic-admin/default', [ // redirect to child route
				                                                   'controller' => 'login',
				                                                   'action'     => 'index',
				]);
			} else {
				$id = (int)$this->params()->fromRoute('id');
				$countryTable = new CountryTable($this->getServiceLocator()->get('country-table-gateway'));
				try {
					$countryTable->deleteCountry($id);
					$alert = [
						'content' => 'Suppression effectuée',
						'type'    => 'success',
					];
				} catch (\Exception $e) {
					$alert = [
						'content' => 'Suppression impossible',
						'type'    => 'danger',
					];
				}

				$this->redirect()->toRoute('apic-admin', [
					'alert' => $alert,
				]);
			}
		}

		protected function createCountry(array $data) {

			$country = new CountryModel;
			$country->exchangeArray($data);
			$countryTable = $this->getServiceLocator()->get('country-table');
			try {
				$countryTable->saveCountry($country);

				return true;
			} catch (\Exception $e) {
				return false;
			}
		}

	}

