<?php

/**
 * ResendForm class.
 * ResendForm is the data structure for keeping
 * user resend form data. It is used by the 'resend' action of 'SignupController'.
 */
class ResendForm extends AuthFormModel
{
	public $username;

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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Username or Email',
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
			if($this->_user->getIsActive())
				$this->addError('username','Your account has been activated.');
		}
	}

	/**
	 * Re-sends the user activation code using the given username in the model.
	 * @return boolean whether resending is successful
	 */
	public function resend()
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
