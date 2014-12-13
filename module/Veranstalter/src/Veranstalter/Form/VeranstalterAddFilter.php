<?php

namespace Veranstalter\Form;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;
use Zend\Validator;

class VeranstalterAddFilter extends InputFilter
{	
	public function __construct()
	{
		$company = new Input('company');
		$company->isRequired();
		$company->getValidatorChain()->addValidator(new Validator\StringLength(1));

	
		$address = new Input('street_address');
		$address->isRequired();
		$address->getValidatorChain()->addValidator(new Validator\StringLength(1));
	
		$number= new Input('house_number');
		$number->isRequired();
		$number->getValidatorChain()->addValidator(new Validator\StringLength(1));
	
		$this->add($company);
		$this->add($address);
		$this->add($number);
		
		
	}
}