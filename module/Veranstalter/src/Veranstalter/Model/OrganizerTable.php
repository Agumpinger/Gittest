<?php
namespace Veranstalter\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Session\Container;
use Veranstalter\Model\Veranstalter;


class OrganizerTable
{
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function saveOrganizer(Veranstalter $veranstaler)
	{
		
		$this->debug_to_console($veranstaler->getCompany());
		$this->debug_to_console($veranstaler->getHouse_number());
		$this->debug_to_console($veranstaler->getStreet_address());
	
		$data = array(
				'user_ID' => $veranstaler->getUser_ID(),
				'company'  => $veranstaler->getCompany(),
				'street_address'  => $veranstaler->getStreet_address(),
				'house_number' => $veranstaler->getHouse_number(),
				
				);
		
		$nr=$this->tableGateway->insert($data);
		$this->debug_to_console($nr);
		if($nr==1)return true;
		else throw new \Exception("Could not insert into Organizer");
	}
	
	public function checkOrganizer($user_ID)
	{
		$rowset= $this->tableGateway->select(array('user_ID'=> $user_ID));
		$row= $rowset->current();
		if(!$row){
			return true;
		}
		return false;		
	}
	
	public function loadOrganizer($user_ID)
	{
		$rowset= $this->tableGateway->select(array('userID'=> $user_ID));
		$row= $rowset->current();
		if(!$row){
			throw new \Exception("No Organizer with UserId $user_ID");
		}
		return $row;
	}
	
	function debug_to_console( $data ) {
	
		if ( is_array( $data ) )
			$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
		else
			$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
	
		echo $output;
	}
}