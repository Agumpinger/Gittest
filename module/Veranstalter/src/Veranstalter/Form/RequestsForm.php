<?php

namespace Veranstalter\Form;

use Zend\Form\Form;
use Veranstalter\Model\Event;
use Zend\Form\Element;

class RequestsForm extends Form {
	
	public function __construct($eventObjArray, $name = null) {
		parent::__construct('Select');
		$namesArr = array();
		
		if (empty($eventObjArray))
			return;
			
		foreach ($eventObjArray as $event) {
			//array_push($namesArr, $event->getName());
			$namesArr[$event->getEventID()] = $event->getName();
		}
		
		$select = new Element\Select ( 'select' );
		$select->setLabel ( 'Event Names' );
		$select->setValueOptions ( $namesArr );		
		
		$submit = new Element\Submit('submit');
		$submit->setValue('Next Action');		
		
		$this->add($select);
		$this->add($submit);
	}
}