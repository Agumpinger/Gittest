<?php
namespace Veranstalter\Model;

use Veranstalter\Model\OrganizerTable;
use Zend\Session\Container;
class Veranstalter
{
	private $organizer_ID;
	private $user_ID;
	private $postcode_ID;
	private $bank_ID;
	private $street_address;
	private $company;
	private $house_number;

	public function __construct()
	{
		;
	}	

	public function setOrganizer_ID($id)
	{
		$this->organizer_ID=$id;
	}
	
	public function getOrganizer_ID()
	{
		return $this->organizer_ID;
	}
	
	public function setUser_ID($id)
	{
		$this->user_ID=$id;
	}
	
	public function getUser_ID()
	{
		return $this->user_ID;
	}

	public function setPostcode_ID($id)
	{
		$this->postcode_ID=$id;
	}
	
	public function getPostcode_ID()
	{
		return $this->postcode_ID;
	}

	public function setBank_ID($id)
	{
		$this->bank_ID=$id;
	}
	
	public function getBank_ID()
	{
		return $this->bank_ID;
	}

	public function setStreet_address($address)
	{
		$this->street_address=$address;
	}
	
	public function getStreet_address()
	{
		return $this->street_address;
	}
	
	
	public function setCompany($comp)
	{
		$this->company=$comp;
	}
	
	public function getCompany()
	{
		return $this->company;
	}

	public function setHouse_number($nr)
	{
		$this->house_number=$nr;
	}
	
	public function getHouse_number()
	{
		return $this->house_number;
	}
	
	public function createVeranstalter($serviceLocator, array $data)
	{
		$sm = $serviceLocator;
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new\Veranstalter\Model\Veranstalter);
		
		$tableGateway = new \Zend\Db\TableGateway\TableGateway('organizer',$dbAdapter, null, $resultSetPrototype);
			
		$this->exchangeArray($data);
		$this->debug_to_console($this->user_ID);
		$veranstalterTable= new OrganizerTable($tableGateway);
		if($veranstalterTable->checkOrganizer($_SESSION['userSession']['user']->getId()))
		{
			$veranstalterTable->saveOrganizer($this);
			return $message;
		}
		else{
			$message="OrganizerDaten bereits angelegt. Änderung per Edit";
			return $message;
		}
	}
	
	public function exchangeArray($data)
	{	$session = new Container('userSession');
		$this->organizer_ID= (isset($data['organizer_ID'])) ?$data['organizer_ID'] : null;
		$this->user_ID = $session->offsetGet('user')->getId();
		$this->postcode_ID = (isset($data['postcode_ID'])) ?$data['postcode_ID'] : null;
		$this->bank_ID = (isset($data['bank_ID'])) ? $data['bank_ID'] : null;
		$this->street_address= (isset($data['street_address'])) ?$data['street_address'] : null;
		$this->house_number = (isset($data['house_number'])) ?$data['house_number'] : null;
		$this->company = (isset($data['company'])) ?$data['company'] : null;
	}
	
	public function debug_to_console( $data ) {
	
		if ( is_array( $data ) )
			$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
		else
			$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
	
		echo $output;
	}
}
