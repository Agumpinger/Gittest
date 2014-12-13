<?php
namespace Users\Form;

use Zend\Form\Form;

class RegisterForm extends Form 
{
	public function __construct($name = null) 
	{
		parent::__construct ( 'Register' );
		$this->setAttribute ( 'method', 'post' );
		$this->setAttribute ( 'enctype', 'multipart/form-data' );
		
		$this->add ( array ('name' => 'name','attributes' => array ('type' => 'text' ),'options' => array ('label' => 'Name' ) ) );
		$this->add ( array ('name' => 'surname','attributes' => array ('type' => 'text' ),'options' => array ('label' => 'First Name' ) ) );
		$this->add ( array ('name' => 'email','attributes' => array ('type' => 'email' ),'options' => array ('label' => 'Email' ),) );
		$this->add ( array ('name' => 'password','attributes' => array ('type' => 'password' ),'options' => array ('label' => 'Password' ),) );
		$this->add ( array ('name' => 'confirm_password','attributes' => array ('type' => 'password' ),'options' => array ('label' => 'Confirm Password' ),) );
		$this->add ( array ('name' => 'roles_ID','type' => 'Zend\Form\Element\Select','attributes' =>  array('options' => array('1' => 'Athlet','2' => 'Veranstalter',),),'options' => array('label' => 'Registrieren als',),));
		$this->add ( array ('name' => 'submit','attributes' => array ('type' => 'submit','value' => 'Register', ),));
	}
}