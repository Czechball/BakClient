<?php

class Session
{
	public $username;
	public $password;
	public $name;
	
	public $hiddenMarks;
	public $addedMarks;
	
	public function __construct($username = NULL, $password = NULL)
	{
		session_start();
		
		if($username != NULL || $password != NULL)
		{
			$_SESSION['username'] = $username;
			$_SESSION['password'] = $password;
			$_SESSION['hiddenMarks'] = Array();
			$_SESSION['addedMarks'] = Array();
		}
		$this -> username = $_SESSION['username'];
		$this -> password = $_SESSION['password'];
		$this -> hiddenMarks = $_SESSION['hiddenMarks'];
		$this -> addedMarks = $_SESSION['addedMarks'];
	}
	
	public function __destruct()
	{
		if($_SESSION['username'] == "")
		{
			unset($_SESSION['username']);
			unset($_SESSION['password']);
			unset($_SESSION['hiddenMarks']);
			unset($_SESSION['addedMarks']);
		}
	}
	
	public static function logout()
	{
		unset($_SESSION['username']);
		unset($_SESSION['password']);
		unset($_SESSION['hiddenMarks']);
		unset($_SESSION['addedMarks']);
	}
	
	public static function kick()
	{
		echo "<script>frame_logout_kick();</script>";
	}
	
	public function setName($name){
		if(strpos($name, 'Object moved') !== false)
		{
			self :: logout();
			self :: kick();
		}
		else
		{
			$this -> name = $name;
		}
	}
}

?>