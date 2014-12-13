<?php

namespace Veranstalter\Form;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;

class EditFilter  {
	private $inputsArray;
	
	public function __construct() {
		$eventName = new Input('name');
		$eventName->getValidatorChain()
		->addValidator(new Validator\NotEmpty());
		
		$sport = new Input('sport');
		$sport->getValidatorChain()->addValidator(new Validator\NotEmpty ());
		
		$restriction = new Input ('restriction');
		$restriction->getValidatorChain()->addValidator(new Validator\NotEmpty());
		
	}
	
	public function verifyInput() {
		return $inputsArray;
	}
	
	private function getInputs() {
		return $this->inputsArray;
	}
}