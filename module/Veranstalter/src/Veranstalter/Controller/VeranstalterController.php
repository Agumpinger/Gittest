<?php


namespace Veranstalter\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Veranstalter\Model\Veranstalter;
use Veranstalter\Model\Event;
use Veranstalter\Form\RequestsForm;
use Zend\Session\Container;
use Veranstalter\Form\VeranstalterAddForm;
use Veranstalter\Form\VeranstalterAddFilter;

class VeranstalterController extends AbstractActionController
{
    public function indexAction()
    {
    	$session = new Container('userSession');
    	if($session->offsetExists('user') && $session->offsetGet('user')->getRoles() == '2')return new ViewModel(array('session'=> $session));
    	else return $this->redirect()->toRoute('users', array('action'=>'login'));
    }
    
    public function addAction()
    {	
    	if(!$this->request->isPost())
    
		{
			$form = new VeranstalterAddForm();
			$view = new ViewModel(array('form' =>$form));
			return $view;
			
		}
		else{
			$post = $this->request->getPost();   //nur um Aufwand zu verkürzen
		
				
			$form = new VeranstalterAddForm();
			$inputFilter = new VeranstalterAddFilter();
			$form->setInputFilter($inputFilter);
			$form->setData($post);
			
			if (!$form->isValid())  //prüft die Eingaben auf Korrektheit!
			{
				$model = new ViewModel(array('error' => true,'form'  => $form,));
				$model->setTemplate('veranstalter/veranstalter/add');
				return $model;
			}
			else{
				$veranstalter= new Veranstalter();
				$message=$veranstalter->createVeranstalter($this->getServiceLocator(), $form->getData($post));
				if(empty($message))
				{	
					$message="Veranstalterdaten erfolgreich gespeicher!";
					$view= new ViewModel(array('message'=>$message));
					$view->setTemplate('veranstalter/veranstalter/edit');
					return $view;
				}else return new ViewModel(array('form'=>$form, 'message'=>$message));
				
			}
		}
		
    }
    
    public function editAction()
    {
    	return new ViewModel();
    }
    
    public function requestsAction () {    	
    	$eventObjArray = Event::getAllOrganizerEvents($this->getServiceLocator()); 
    	
    	$form = new RequestsForm($eventObjArray);
 
    	/*
    	if( $event->loadEvent($this->getServiceLocator(), 1 ))
    		$model = new ViewModel(array ('event' => $event));*/

    	// $event->getAllOrganizerEvents($this->getServiceLocator(), 1);
    	$model = new ViewModel (array ('events' => $eventObjArray, 'form' => $form ));
    	
    	
    	$model->setTemplate("veranstalter/veranstalter/requests");
    	return $model;
    }
    
    
    
    public function requestSendAction () {
    	
    	// Session Objekt Event->save(); UND update vorher
    	
    	$session = new Container('eventSession');
    	$event = $session->offsetGet('event');    	
    	
    	$event->updateRestrictions($this->getServiceLocator(), $_REQUEST);
    	
    	//$event->updateAllValues($_REQUEST);
    	//$err = $event->saveEvent($this->getServiceLocator());
    	$model = new ViewModel(array('event' => $err, 'req' => $_REQUEST));
    	$model->setTemplate("veranstalter/veranstalter/requestSuccess");
    	return $model;
    }
}
