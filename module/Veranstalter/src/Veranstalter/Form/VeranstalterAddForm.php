<?php


namespace Veranstalter\Form;

use Zend\Form\Form;
use Zend\Form\Element;


class VeranstalterAddForm extends Form {

	public function __construct($name = null) {
		parent::__construct('Add');
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'enctype', 'multipart/form-data' );

		$company= new Element\Text ( 'company' );
		$company->setLabel ( 'Firma' );
		$company->setAttributes(array('size'  => '140',));
		
		$address= new Element\Text ( 'street_address' );
		$address->setLabel ( 'Adresse' );
		$address->setAttributes(array('size'  => '140',));
		
		$number= new Element\Text ( 'house_number' );
		$number->setLabel ( 'Hausnummer' );
		$number->setAttributes(array('size'  => '140',));
		
		$submit= new Element\Submit ('submit');
		$submit->setValue('weiter>>');
		

		$this->add($company);
		$this->add($address);
		$this->add($number);
		$this->add($submit);
		
		


	}
}