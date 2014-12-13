<?php
namespace Veranstalter\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Veranstalter\Model\Veranstalter;
use Veranstalter\Model\EventTable;
use Veranstalter\Form\EventEditForm;
use Veranstalter\Model\Event;
use Veranstalter\Model\Allocation;
use Zend\Session\Container;
use Veranstalter\Form\RestrictionsEditForm;
/*
 * TO-DO:
 *  - alle ageClasses in die Select laden
 *  - eventSession nach Beendigung des Edits unseten
 *  - Edit InputFilter anlegen
 *  - Im Allocation Table Update Funktionen anlegen
 *  - leck mir doch die Bretter 
 *  - ageClassID bei update Restrictions noch mit select feld abaendern
 */
class EventController extends AbstractActionController
{
	public function indexAction()
	{
		$view= new ViewModel();
		$view->setTemplate('veranstalter/event/index');
	}


	public function addAction()
	{
		return new ViewModel();
	}
	
	public function choiceAction () {
		$model = new ViewModel();
		$eventSession = new Container('eventSession');
		$event = new Event();
		$eventID = $_REQUEST["select"];
		// Hier noch die max EventID abfragen
		if ($eventID < 0 || $eventID > 100)
			return new ViewModel();
		
		$event->loadEvent($this->getServiceLocator(), $eventID);
		
		$eventSession->offsetSet('event', $event);
		
		$model->setTemplate("/veranstalter/event/requestChoice");
		return $model;
	}

	public function editAction() {
		$choice = $_REQUEST["choice"];
		
		$session = new Container('eventSession');
		$event = $session->offsetGet('event');	
		$alloc = new Allocation ($this->getServiceLocator());
		
		if ($choice == "label") {
			$labelStandards = Allocation::getLabelStandards();
			
			$eventLabels = $alloc->loadEventLabels();
			$existingLabels = array();
			$notExistingLabels = array();
			
			$counter = 0;
			foreach ($eventLabels as $element) {
				if ($element)
					array_push($existingLabels, $labelStandards[$counter++]);
				else 
					array_push($notExistingLabels, $labelStandards[$counter++]);
			}
			$model = new ViewModel(array('ex' => $existingLabels, 'noEx' => $notExistingLabels));
			$model->setTemplate('/veranstalter/event/labelEdit');
		} else if ($choice == "restrictions") {			
			$res = $alloc->loadEventRestrictions();
		
			$model->setTemplate('/veranstalter/event/restrictionsEdit');
		} else if ($choice == "data") {
			$form = new EventEditForm($event);
			$model = new ViewModel(array('form' => $form));
		} else {
			return "Keine Uebereinstimmung";
		}		
		
		return $model;
	}
}
