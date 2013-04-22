<?php

/**
 * ActivateForm class.
 * ActivateForm is the data structure for keeping
 * user activate form data. It is used by the 'activate' action of 'SignupController'.
 */
class ActivateForm extends AuthFormModel
{
	public $username;
	public $activationCode;

	private $_user;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username, activationCode', 'required'),
			array('activationCode', 'validateActivationKey'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'username' => 'Username or Email',
			'activationCode' => 'Activation Code',
		);
	}

	/**
	 * Validates the activation code.
	 * This is the 'validateActivationKey' validator as declared in rules().
	 */
	public function validateActivationKey($attribute,$params)
	{
		if(!$this->hasErrors())
		{
			$this->_user=$this->model->findByUsername($this->username);
			if(!$this->_user->validateActivationKey($this->activationCode))
				$this->addError('activationCode','Incorrect username or activation code.');
		}
	}

	/**
	 * Activates the user using the given username and activation code in the model.
	 * @return boolean whether activation is successful
	 */
	public function activate()
	{
		if($this->_user===null)
			$this->_user=$this->model->findByUsername($this->username);
		if($this->_user->validateActivationKey($this->activationCode))
		{
			$this->_user->activate();
			return true;
		}
		else
			return false;
	}
}
