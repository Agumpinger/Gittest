<?php

namespace Veranstalter\Form;

use Zend\Form\Form;
use Veranstalter\Model\Event;
use Zend\Form\Element;
/*
 * private	$eventID;
 * private $organizerID;
 * private $sportsID;
 * private $restrictionID;
 * private $uploadeventID;
 * private $labelID;
 * private $cashbackID;
 * private $previouseventID;
 * private $postcodeID;
 * private $name;
 * private $adress;
 * private $houseNumber; // ????
 * private $entryfee;
 * private $description;
 * private $limitation;
 * private $ratingID;
 * private $status;
 */
class EventEditForm extends Form {
	public function __construct($event = null, $name = null) {
		parent::__construct ( 'Select' );
		
		if ($event == null)
			return;
			// $event->getSportFromSportsID ()
			// etc.
			
		// Nur um schreibaufwand zu minimieren
		$b = new Event ();
	
		/*
		$organizerID = new Element\Text ( "oid" );
		$organizerID->setLabel('OrganizerID');
		$organizerID->setValue ( $event->getOrganizerID () );
		*/
		$name = new Element\Text ("name");
		$name->setLabel("Event Name");
		$name->setValue($event->getName());		

		$sportsID = new Element\Text ( 'sport' );
		$sportsID->setLabel ( 'Sportart' );
		$sportsID->setValue ( $event->getSportsID () );
		
		$restrictionID = new Element\Text ( "resid" );
		$restrictionID->setLabel('Restriction');
		$restrictionID->setValue ( $event->getRestrictionID () );
		
		$uploadeventID = new Element\Text ( "upid" );
		$uploadeventID->setLabel('uploadeventid ???');
		$uploadeventID->setValue ( $event->getUploadeventID () );
		
		$labelID = new Element\Text ( "labid" );
		$labelID->setLabel('Label');
		$labelID->setValue ( $event->getLabelID () );
		/*
		$cashbackID = new Element\Text ( "cashid" );
		$cashbackID->setLabel('CashbackID');
		$cashbackID->setValue ( $event->getCashbackID () );
		*/
		$previouseventID = new Element\Text ( "previd" );
		$previouseventID->setLabel('PreviousEvent');
		$previouseventID->setValue ( $event->getPreviouseventID () );
		
		$postcodeID = new Element\Text ( "postid" );
		$postcodeID->setLabel('Postal Code');
		$postcodeID->setValue ( $event->getPostcodeID () );
		
		$adress = new Element\Text ( "adr" );
		$adress->setLabel('Adresse');
		$adress->setValue ( $event->getAdress () );
		
		$houseNumber = new Element\Text ( "hounr" ); // ????
		$houseNumber->setLabel('House Number');
		$houseNumber->setValue ( $event->getHouseNumber () );
		
		$entryfee = new Element\Text ( "fee" );
		$entryfee->setLabel('Entryfee');
		$entryfee->setValue ( $event->getEntryfee () );
		
		$description = new Element\Text ( "descr" );
		$description->setLabel('Description');
		$description->setValue ( $event->getDescription () );
		
		$limitation = new Element\Text ( "lim" );
		$limitation->setLabel('Limitatoin');
		$limitation->setValue ( $event->getLimitation () );
		/*
		$ratingID = new Element\Text ( "ratid" );
		$ratingID->setLabel('rating');
		$ratingID->setValue ( $event->getRatingID () );
		*/
		// NUR wenn Betreiber sich die Form ansieht $status = new Element\Text("");
		$submit = new Element\Submit("submit");
		$submit->setValue("Next Action");
		
		$this->add ($name);
		$this->add($sportsID);
		$this->add($restrictionID);
		$this->add($uploadeventID);
		$this->add($labelID);
		$this->add($previouseventID);
		$this->add($postcodeID);
		$this->add($adress);
		$this->add($houseNumber);
		$this->add($entryfee);
		$this->add($description);
		$this->add($limitation);
		$this->add($submit);
		
	}
}