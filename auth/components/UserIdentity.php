<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_model;
	private $_id;

	/**
	 * Constructor.
	 * @param IUser $model the model finder instance (e.g. <code>User::model()</code>).
	 * @param string $username username
	 * @param string $password password
	 */
	public function __construct($model,$username,$password)
	{
		$this->_model=$model;
		parent::__construct($username,$password);
	}

	/**
	 * Authenticates a user.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
		$username=$email=strtolower($this->username);
		$user=$this->_model->findByUsername($username);
		if($user===null)
			$this->errorCode=self::ERROR_USERNAME_INVALID;
		else if(!$user->validatePassword($this->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
		else if(!$user->getIsActive())
			$this->errorCode=self::ERROR_UNKNOWN_IDENTITY;
		else
		{
			$this->_id=$user->id;
			$this->username=$user->username;
			$this->errorCode=self::ERROR_NONE;
		}
		return $this->errorCode==self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId()
	{
		return $this->_id;
	}
}