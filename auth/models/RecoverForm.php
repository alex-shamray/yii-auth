<?php

/**
 * RecoverForm class.
 * RecoverForm is the data structure for keeping
 * user recover form data. It is used by the 'index' action of 'RecoverController'.
 */
class RecoverForm extends AuthFormModel
{
	public $username;
	public $verifyCode;

	private $_user;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username', 'required'),
			array('username', 'exist'),
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements()),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Username or Email',
			'verifyCode' => 'Verification Code',
		);
	}

	/**
	 * Validates that the username value exists in a table.
	 * This is the 'exist' validator as declared in rules().
	 */
	public function exist($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_user=$this->model->findByUsername($this->username);
			if($this->_user===null)
				$this->addError('username','Incorrect username or email.');
		}
	}

	/**
	 * Recovers the user's password using the given username in the model.
	 * @return boolean whether recovery is successful
	 */
	public function recover()
	{
		if($this->_user===null)
			$this->_user=$this->model->findByUsername($this->username);
		if($this->_user!==null)
		{
			$this->_user->updateActivationKey();
			return true;
		}
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
