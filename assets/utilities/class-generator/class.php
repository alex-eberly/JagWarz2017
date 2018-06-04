<?php
class User
{
	var $userid;
	var $firstname;
	var $lastname;
	
	function setUserId($userid)
	{
		$this->userid = $userid;
	}
	function getUserId()
	{
		return $this->userid;
	}
	
	function setFirstname ($firstname)
	{
		$this->firstname = $firstname;
	}
	function getFirstname()
	{
		return $this->firstname;
	}
	
	function setLastname($lastname)
	{
		$this->lastname = $lastname;
	}
	function getLastname()
	{
		return $this->lastname;
	}
}
class UserFactory
{
	function GetOne($userid)
	{
		$user = new User();
		$user->userid = 1;
		$user->firstname = "Mitch";
		$user->lastname = "Lindle";
		return $user;
	}
	function GetAll()
	{
		$userArray = Array();
		$user = new User();
		$user->userid = 1;
		$user->firstname = "Mitch";
		$user->lastname = "Lindle";
		$userArray[] = $user;
		$user2 = new User();
		$user2->userid = 2;
		$user2->firstname = "Bob";
		$user2->lastname = "Rombie";
		$userArray[] = $user2;
		return $userArray;
	}
}
?>