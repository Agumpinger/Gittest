<?php

namespace Veranstalter\Form;

use Zend\Form\Form;
use Veranstalter\Model\Event;
use Zend\Form\Element;

class RestrictionsEditForm extends Form {
	public function __construct($restrictionsArray, $name = null) {
		parent::__construct ( 'restrictions' );
		$r = $restrictionsArray;
		
		$selectArray = array (
				"muss noch gemacht werden" 
		);
		
		$ageClass = new Element\Select ( 'select' );
		$ageClass->setLabel ( 'Altersklassen' );
		$ageClass->setValueOptions ( $selectArray );
		
		$age = new Element\Text ( 'age' );
		$age->setLabel ( "keine Ahnung as age sein soll" );
		$age->setValue ( $r ["age"] );
		
		$male = new Element\Checkbox ( 'male' );
		$male->setLabel ( "Maennerlauf" );
		$r ["gendermale"] ? $male->setChecked ( true ) : $male->setChecked ( false );
		
		$female = new Element\Checkbox ( 'female' );
		$female->setLabel ( "Frauenlauf" );
		$r ["genderfemale"] ? $female->setChecked ( true ) : $female->setChecked ( false );
		
		$championship = new Element\Checkbox ( 'championship' );
		$championship->setLabel ( "Meisterschaft" );
		$r ["championship"] ? $championship->setChecked ( true ) : $championship->setChecked ( false );
		
		$company = new Element\Checkbox ( 'company' );
		$company->setLabel ( "Firmenlauf" );
		$r ["company"] ? $company->setChecked ( true ) : $company->setChecked ( false );
		
		$submit = new Element\Submit ( 'submit' );
		$submit->setValue ( "Next Action" );
		
		$this->add ( $ageClass );
		$this->add ( $age );
		$this->add ( $male );
		$this->add ( $female );
		$this->add ( $championship );
		$this->add ( $company );
		$this->add ( $submit );
	}
}