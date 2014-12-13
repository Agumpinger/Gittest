<?php

namespace Users\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Users\Form\LoginForm;
use Users\Form\LoginFilter;
use Users\Form\RegisterForm;
use Users\Model\Users;
use Users\Form\RegisterFilter;
use Users\Model\UserTable;
use Zend\Db\Adapter\Adapter;
use \Zend\Db\ResultSet;
use Users\Form\AddForm;
use Zend\Session\Container;
use Veranstalter\Model\Veranstalter;
use Zend\Version\Version;

class UsersController extends AbstractActionController {
	public function indexAction() {
		$session = new Container ( 'userSession' );
		
		$view = new ViewModel ( array (
				'session' => $session 
		) );
		return $view;
	}
	public function registerAction() {
		if (! $this->request->isPost ()) {
			$form = new RegisterForm ();
			$view = new ViewModel ( array (
					'form' => $form 
			) );
			return $view;
		} else {
			
			$post = $this->request->getPost (); // nur um Aufwand zu verkürzen
			
			$form = new RegisterForm ();
			$inputFilter = new RegisterFilter ();
			$form->setInputFilter ( $inputFilter );
			$form->setData ( $post );
			
			if (! $form->isValid ()) // prüft die Eingaben auf Korrektheit!
{
				$model = new ViewModel ( array (
						'error' => true,
						'form' => $form 
				) );
				$model->setTemplate ( 'users/users/register' );
				return $model;
			} else {
				$request = $form->getData ();
				$person = new Users ();
				$person->createUser ( $this->getServiceLocator (), $request );
				$person->loadUser ( $this->getServiceLocator (), $request ['email'] );
				
				$session = new Container ( 'userSession' );
				$session->offsetSet ( 'user', $person );
				if ($person->getRoles () == 2) {
					$this->redirect ()->toRoute ( 'veranstalter', array (
							'action' => 'add' 
					) );
				}
				$view = new ViewModel ( array (
						'persons' => $person 
				) );
				$view->setTemplate ( 'users/users/confirm' );
				return $view;
			}
		}
	}
	public function loginAction() {
		if ($this->request->isPost ()) {
			$post = $this->request->getPost (); // nur um Aufwand zu verkürzen
			
			$form = new LoginForm ();
			$inputFilter = new LoginFilter ();
			$form->setInputFilter ( $inputFilter );
			$form->setData ( $post );
			
			if (! $form->isValid ()) // prüft die Eingaben auf Korrektheit!
{
				$model = new ViewModel ( array (
						'error' => true,
						'form' => $form 
				) );
				$model->setTemplate ( 'users/users/login' );
				return $model;
			} else {
				
				$user = new Users ();
				$data = array ();
				
				if ($user->login ( $this->getServiceLocator (), $this->request->getPost ( 'email' ), $this->request->getPost ( 'password' ) )) {
					// hey felix, hab mal provisorisch noch ein Veranstalter Objekt in die Session gelegt, weil 
					// ich des f�r meine Event Listen brauche. Kannst gerne noch verfeinern ;)
					
					$userSession = new Container ( 'userSession' );
					
						$userSession->offsetSet ( 'user', $user );
						if ($user->getRoles() == 2) {
							$organizer = new Veranstalter();
							$organizer->setOrganizer_ID($user->getId());
							$userSession->offsetSet('organizer', $organizer);
						}
					
					$view = new ViewModel ( array (
							'user' => $user 
					) );
					$view->setTemplate ( 'users/users/logged' );
					return $view;
				} else
					throw new \Exception ( "Password and Email do not match!" );
			}
		}
		$form = new LoginForm ();
		$view = new ViewModel ( array (
				'form' => $form 
		) );
		return $view;
	}
	public function logoutAction() {
		unset ( $_SESSION ['userSession'] );
		unset ( $_SESSION ['eventSession'] );
		return $this->redirect ()->toRoute ( 'home' );
	}
}