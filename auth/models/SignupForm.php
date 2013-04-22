<?php

/**
 * SignupForm class.
 * SignupForm is the data structure for keeping
 * user signup form data. It is used by the 'index' action of 'SignupController'.
 */
class SignupForm extends AuthFormModel
{
	public $username;
	public $email;
	public $password;

	private $_user;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, email, password', 'required'),
			array('username', 'length', 'min'=>3, 'max'=>20),
			array('password', 'length', 'min'=>5),
			array('email', 'email'),
			array('username, email', 'unique', 'className'=>'User'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Username',
			'email' => 'Email',
			'password' => 'Password',
		);
	}

	/**
	 * Signs up the user using the given username, email and password in the model.
	 * @return boolean whether signup is successful
	 */
	public function signup()
	{
		$this->_user=new $this->modelClass;
		$this->_user->attributes=$this->attributes;
		if($this->_user->save())
			return true;
		else
			return false;
	}

	/**
	 * @return IUser active record model instance.
	 */
	public function getUser()
	{
		return $this->_user;
	}
}
