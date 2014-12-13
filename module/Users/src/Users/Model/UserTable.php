<?php
namespace Users\Model;
use Zend\Db\Adapter\Adapter;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;


class UserTable

{
	protected $tableGateway;
	
	public function __construct(TableGateway $tableGateway)
	{
		$this->tableGateway = $tableGateway;
	}
	
	public function saveUser(Users $user)
	{
		$data = array(
				'email' => $user->getEmail(),
				'name'  => $user->getName(),
				'surname' => $user->getSurname(),
				'password'  => $user->getPassword(),
				'roles_ID' => $user->getRoles(),	
				
				
		);
		
		
		
		if ($this->checkUser($user->getEmail())==0) 
		{
			$this->tableGateway->insert($data);
		} 
		else 
		{
			//$this->tableGateway->update($data, array('email' => $email));
		}
			
	}
		
		
		public function checkUser($email)
		{
			$row = $this->tableGateway->select(array('email'=> $email));
			return $row->count();
		}
		
		public function getUserByEmail($email)
		{
			$rowset= $this->tableGateway->select(array('email'=> $email));
			$row= $rowset->current();
			if(!$row){
				throw new \Exception("Kein Benutzer mit Email $email vorhanden");
			}
			 return $row;
		}	
				
}

	
