<?php
namespace Users\Model;

class Users
{
	private $id;
	private $name;
	private $surname;
	private $email;
	private $password;
	private $roles;
	
	
	public function __construct()
	{
		;
	}
	
	public function setId($id)
	{
		$this->id=$id;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function setName($name)
	{
		$this->name=$name;
	}
	
	public function getName()
	{
		return $this->name;
	}
	
	public function setEmail($email)
	{
		$this->email=$email;
	}
	
	public function getEmail()
	{
		return $this->email;
	}
	
	public function setPassword($clear_password)
	{
		$this->password = md5($clear_password);
	}
	
	public function getPassword()
	{
		return $this->password;
	}
	
	public function setSurname($surname)
	{
		$this->surname=$surname;
	}
	
	public function getSurname()
	{
		return $this->surname;
	}
	
	public function setRoles($roles)
	{
		$this->roles=$roles;
	}
	
	public function getRoles()
	{
		return $this->roles;
	}

	public function createUser($serviceLocator, array $data)
	{
		$sm = $serviceLocator;
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new\Users\Model\Users);
	
		$tableGateway = new \Zend\Db\TableGateway\TableGateway('user',$dbAdapter, null, $resultSetPrototype);
		 
		
		$this->exchangeArray($data);
		$userTable = new UserTable($tableGateway);
		$userTable->saveUser($this);
		
		return true;
	}
	
	public function loadUser($serviceLocator, $email)
	{
		$sm = $serviceLocator;
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new\Users\Model\Users);
		
		$tableGateway = new \Zend\Db\TableGateway\TableGateway('user',$dbAdapter, null, $resultSetPrototype);
		$userTable = new UserTable($tableGateway);
		
		$data =array();
		
		$data= $userTable->getUserByEmail($email);
		
		if(!empty($data))
		{
			$this->id= $data->getId();
			$this->name= $data->getName();
			$this->email= $data->getEmail();
			$this->surname=$data->getSurname();
			$this->roles=$data->getRoles();
			$this->password= $data->getPassword();
			return true;
		}else throw new \Exception("UserLoad failed");
		
		$this->exchangeArray($data);
	}
	
	public function login($serviceLocator, $email, $password)
	{
		$sm = $serviceLocator;
		$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
		$resultSetPrototype = new \Zend\Db\ResultSet\ResultSet();
		$resultSetPrototype->setArrayObjectPrototype(new\Users\Model\Users);
		$tableGateway = new \Zend\Db\TableGateway\TableGateway('user',$dbAdapter, null, $resultSetPrototype);
		$userTable = new UserTable($tableGateway);
		
		$data =array();
		
		$data= $userTable->getUserByEmail($email);
		
		if(!empty($data))
		{
			$this->id= $data->getId();
			$this->name= $data->getName();
			$this->email= $data->getEmail();
			$this->surname=$data->getSurname();
			$this->roles=$data->getRoles();
			$this->password= $data->getPassword();
			if($data->getPassword()== md5(md5($password))) return true;
		}
		else throw new \Exception("Password and Email do not match!");
	}
	
	
	public function exchangeArray($data)
	{
		$this->id = (isset($data['user_ID'])) ?$data['user_ID'] : null;
		$this->name = (isset($data['name'])) ?$data['name'] : null;
		$this->surname = (isset($data['surname'])) ?$data['surname'] : null;
		$this->email = (isset($data['email'])) ?$data['email'] : null;
		$this->roles = (isset($data['roles_ID'])) ?$data['roles_ID'] : null;
		
		if (isset($data["password"]))
		{
			$this->setPassword($data["password"]);
		}
	}
	
	function debug_to_console( $data ) {
	
		if ( is_array( $data ) )
			$output = "<script>console.log( 'Debug Objects: " . implode( ',', $data) . "' );</script>";
		else
			$output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
	
		echo $output;
	}
	
}